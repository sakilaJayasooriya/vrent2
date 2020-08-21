<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Common;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ListingMsg;
use App\Models\Properties;
use App\Models\User;
use App\Models\Settings;
use App\Models\Admin;
use App\Models\EmailTemplate;
use Session;
use Auth;
use Config;
use DB;
use DateTime;
use DateTimeZone;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use validator;

class ListingMsgController extends Controller
{
    private $helper;
    
    public function __construct()
    {
        $this->helper = new Common;
    }
    
    public function index()
    {
        $data['user_id']     = Auth::user()->id;
        //$data['user_id']     = Auth::user()->id;
        $data['listing_messages'] = ListingMsg::join('users', 'users.id', '=', 'listing_msg.sender_id')
        ->where('listing_msg.receiver_id', $data['user_id'])
        ->select(
            'listing_msg.id as lm_id',
            'listing_msg.receiver_id as lm_receiver_id',
            'listing_msg.sender_id as lm_sender_id',
            'listing_msg.msg as lm_msg',
            'listing_msg.property_id as lm_property_id',
            'listing_msg.created_at as lm_created_at',
            'users.first_name as sender_first_name',
            'users.last_name as sender_last_name',
            'users.email as sender_email'
            )
        ->orderBy('listing_msg.id', 'desc')->paginate(10);
        
        //return dd($data);
        return view('listingmsg.inbox', $data);
    }
    public function delete(Request $request)
    {
        $lmsg = ListingMsg::find($request->id);
        $lmsg->delete();
        $this->helper->one_time_message('danger', 'Removed');
        return redirect('listing-message');
    }
    public function create(Request $request)
    {
        $newlm                 = new ListingMsg;
        $newlm->receiver_id    = $request->receiver_id;
        $newlm->sender_id      = $request->sender_id;
        $newlm->property_id    = $request->property_id;
        $newlm->msg            = $request->msg;
        $newlm->save();
        $this->helper->one_time_message('success', 'Message Sent');
        return redirect('properties/'.$request->property_id);
    }
    public function sendmail(Request $request)
    {
        $emailSettings   = Settings::where('type','email')->get()->toArray();
        $emailConfig     = $this->helper->key_value('name','value',$emailSettings);

        $adminDetails    = Admin::where('status','active')->first();
        $emailConfig['email_address']= $adminDetails->email;
        $emailConfig['username']     = $adminDetails->username;

        $data['first_name']   = $request->sender_first_name;
        $data['email']        = $request->sender_email;
        $data['url']          = url('/').'/';

        $data['subject']      = "Reply for your message regarding a property";
        $data['view']         = resource_path('views/sendmail/listing_msg_to_guess.blade.php');

        /*$englishTemplate = EmailTemplate::where(['temp_id' => 5, 'lang_id' => '1', 'type' => 'email'])->select('subject', 'body')->first();
        
        $emailTemplatefromDB = EmailTemplate::where([['temp_id',5],['lang', session()->get('language')],['type','email']])->first();
        if (!empty($emailTemplatefromDB->subject) && !empty($emailTemplatefromDB->body))
        {
            $subject_string = $emailTemplatefromDB->subject;
            $body_string    = $emailTemplatefromDB->body;
        }
        else
        {
            $subject_string = $englishTemplate->subject;
            $body_string    = $englishTemplate->body;
        }

        */
        $subject_string = "Reply for your message regarding a property";
        $body_string    = "Hi {first_name},<br><br>Welcome to {site_name}!";
       
        $body_string     = str_replace('{first_name}', $request->sender_first_name,$body_string);
        $body_string     = str_replace('{site_name}', SITE_NAME,$body_string);
        
        
        $data['subject']        =   $subject = $subject_string;
        $data['content']        =   $content = $body_string;
        $data['message_body']   =   $content;

        $data['chat_reply']   =   $request->chat_reply;
        $data['chat_receive']   =   $request->chat_receive;
        
        //Email Template Ends
        
        if(env('APP_MODE', '') != 'test'){
            if($emailConfig['driver']=='smtp' && $emailConfig['email_status']==1){
                @Mail::send('emails.listing_msg_to_guess_template', $data, function($message) use($user) {
                $message->to($request->sender_email, $request->sender_first_name)->subject('Reply for your message regarding a property');
            });
            }else if($emailConfig['driver']=='sendmail'){
              $this->sendPhpEmail($data,$emailConfig);
            }
        }
        $this->helper->one_time_message('success', 'Sent');
        return redirect('listing-message');
    }

}
