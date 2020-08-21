@extends('template')

@section('main')
<div class="container margin-top30">
  <div class="panel panel-default">
    <div class="panel-body h4">
      <h2>Messages Regarding Your Listings
    </div>
    <div class="panel-footer ">
      @if (0<count($listing_messages))
        <div class="panel-group" id="accordion">
          @php
              $i=0;
          @endphp
          @foreach ($listing_messages as $item)
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $i }}">
                  {{ $item->sender_first_name }} {{ $item->sender_last_name }} | <small><i>{{ $item->lm_created_at }} </i></small></a>
                  <a style="color:red" href="{{ url('listing-message/'.$item->lm_id)}}" >Remove </a>
                </h4>
              </div>
              <div id="collapse{{ $i }}" class="panel-collapse collapse @if($i==0) in @endif">
                <div class="panel-body">
                  <p>Property: <a target="_blank" href="{{ url('/properties/'.$item->lm_property_id)}}" >View</a></p>
                  <p>Message: {{ $item->lm_msg }}</p>
                  <form action="{{ url('listing-message/sendmail')}}" method="post" class="edit_review">
                      <input type="hidden" value="{{ $item->lm_property_id }}" name="property_id" id="property_id">
                      <input type="hidden" value="{{ $item->lm_msg }}" name="chat_receive" id="chat_receive">
                      <input type="hidden" value="{{ $item->lm_sender_id }}" name="sender_id" id="sender_id">
                      <input type="hidden" value="{{ $item->sender_email }}" name="sender_email" id="sender_email">
                      <input type="hidden" value="{{ $item->sender_first_name }}" name="sender_first_name" id="sender_first_name">
                      <textarea rows="5" name="chat_reply" id="chat_reply" class="form-control mb10"></textarea>
                      <button class="btn ex-btn btn-large" type="submit">Send</button>
                  </form>
                </div>
              </div>
            </div>
            @php
                $i++;
            @endphp
          @endforeach
        </div>
      @else
        <p>No messages</p>  
      @endif

    </div>
    <div class="panel-body">
      <div style="float:right">
        <p id="inbox-page-info"></p>
        <ul class="pagination" id="inbox-pagination" style="margin: 5px 0px;">
          {{ $listing_messages->links() }}
        </ul>
      </div>
    </div>
  </div> 
</div>
@stop


