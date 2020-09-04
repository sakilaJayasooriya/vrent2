<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\AdsDataTable;
use App\Models\Ads;
use Validator;
use App\Http\Helpers\Common;

class AdsController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }
    
    public function index(AdsDataTable $dataTable)
    {
        return $dataTable->render('admin.ads.view');
    }
    public function add(Request $request)
    {
        if (! $_POST) {
             return view('admin.ads.add');
        } elseif ($_POST) {
            $rules = array(
                    'name'    => 'required|max:200',
                    'possition'  =>'required',
                    'content'  =>'required',
                    'status'  =>'required'
                    );

            $fieldNames = array(
                        'name'    => 'Advertisment Name',
                        'status'  =>'Status'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);


            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $newAd = new Ads;

                $newAd->name  = $request->name;
                $newAd->possition  = $request->possition;
                $newAd->status=$request->status;
                $newAd->content=htmlspecialchars($request->content);

                $newAd->save();

                $this->helper->one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/ads');
            }
        } else {
            return redirect('admin/settings/ads');
        }
    }
    public function update(Request $request)
    {
        if (! $_POST) {
             $data['result'] = Ads::find($request->id);

             return view('admin.ads.edit', $data);
        } elseif ($_POST) {
            $rules = array(
                'name'    => 'required|max:200',
                'possition'  =>'required',
                'content'  =>'required',
                'status'  =>'required'
                );

            $fieldNames = array(
                'name'    => 'Advertisment Name',
                'status'  =>'Status'
                );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $editAd =Ads::find($request->id);

                $editAd->name  = $request->name;
                $editAd->possition=$request->possition;
                $editAd->status=$request->status;
                $editAd->content=htmlspecialchars($request->content);

                $editAd->save();

                $this->helper->one_time_message('success', 'Updated Successfully');
                return redirect('admin/settings/ads');
            }
        } else {
            return redirect('admin/settings/ads');
        }
    }
    public function delete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            Ads::find($request->id)->delete();
            $this->helper->one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/settings/ads');
    }
}
