@extends('template')

@section('main')
    <input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type')}}">
    <div id="mega-slider" class="carousel slide" data-ride="carousel">
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        @php $i = 0 @endphp
          @foreach($banners as $banner)
          <div class="item {{$i==0?'active':''}}">
            <img src="{{ url('public/front/images/banners/'.$banner->image) }}" alt="...">
            <div class="carousel-caption">
              <h2>{{$banner->heading}}</h2>
              <p>{{$banner->subheading}}</p>
            </div>
          </div>
          @php $i = 1 @endphp
        @endforeach
      </div>
      <!-- Controls -->
      <a class="left carousel-control" href="#mega-slider" role="button" data-slide="prev">
      </a>
      <a class="right carousel-control" href="#mega-slider" role="button" data-slide="next">
      </a>
    </div>
    <div class="mg-bn-forms-up">
      <div class="mg-book-now2 mg-book-now">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="mg-bn-forms">
                <form id="front-search-form" method="post" action="{{url('search')}}">
                  <div class="row">
                    <div class="col-sm-6 col-md-4 col-xs-12 input-mb" style="width: 17.8333333%;">
                      <div class="input-group date mg-check-in col-xs-12">
                        <input class="form-control" id="front-search-field" placeholder="{{trans('messages.home.where_want_to_go')}}" autocomplete="off" name="location" type="text" required>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-xs-12 input-mb" style="width: 14.6666666%;">
                      <div class="input-group date mg-check-in">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input class="form-control" name="checkin" id="front-search-checkin" placeholder="{{trans('messages.search.check_in')}}" autocomplete="off" type="text" readonly="readonly" required>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-xs-12 input-mb" style="width: 14.6666666%;">
                      <div class="input-group date mg-check-out">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input class="form-control" name="checkout" id="front-search-checkout" placeholder="{{trans('messages.search.check_out')}}" type="text" readonly="readonly" required>
                      </div>
                    </div>
                    


                    <div class="col-sm-6 col-md-2 col-xs-12" style="width: 14.6666666%;">
                      <div class="input-group date mg-check-out col-xs-12">
                        <select id="front-search-adult" class="form-control black-select" name="adult">
                          <option value=""> {{trans('messages.home.adult')}} (Age &gt; 13)</option>
                          <option value="1">  1 Adults </option>
                          <option value="2">  2 Adults </option>
                          <option value="3">  3 Adults </option>
                          <option value="4">  4 Adults </option>
                          <option value="5">  5 Adults </option>
                          <option value="6">  6 Adults </option>
                          <option value="7">  7 Adults </option>
                          <option value="8">  8 Adults </option>
                          <option value="9">  9 Adults </option>
                          <option value="10">  10 Adults </option>
                          <option value="11">  11 Adults </option>
                          <option value="12">  12 Adults </option>
                          <option value="13">  13 Adults </option>
                          <option value="14">  14 Adults </option>
                          <option value="15">  15 Adults </option>
                          <option value="16">  16+ Guests </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-xs-12" style="width: 14.6666666%;">
                      <div class="input-group date mg-check-out col-xs-12">
                        <select id="front-search-children" class="form-control black-select" name="children">
                          <option value=""> {{trans('messages.home.children')}} (Age 2-12)</option>
                          <option value="0"> 0 Children </option>
                          <option value="1"> 1 Children </option>
                          <option value="2"> 2 Children </option>
                          <option value="3"> 3 Children </option>
                          <option value="4"> 4 Children </option>
                          <option value="5"> 5 Children </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-xs-12" style="width: 14.6666666%;">
                      <div class="input-group date mg-check-out col-xs-12">
                        <select id="front-search-infant" class="form-control black-select" name="infant">
                          <option value=""> {{trans('messages.home.infant')}} (Under 2)</option>
                          <option value="0"> 0 Infants </option>
                          <option value="1"> 1 Infants </option>
                          <option value="2"> 2 Infants </option>
                          <option value="3"> 3 Infants </option>
                          <option value="4"> 4 Infants </option>
                          <option value="5"> 5 Infants </option>
                        </select>
                      </div>
                    </div>


                    <div class="col-md-1 col-xs-12 front-search">
                      <button type="submit" class="btn btn-main btn-block">{{trans('messages.home.search')}}</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
         </div>
      </div>
    </div>
    <div class="container">
      <div class="row margin-top40" >
        @for($i=0;$i<= $city_count-1;$i++)
        <div class="col-md-4" style="margin-bottom:15px;">
          <div class="ex-image-container" style="background-image:url({{ @$starting_cities[$i]->image_url }});">
            <a href="{{URL::to('/')}}/search?location={{$starting_cities[$i]->name}}&source=ds">
              <div class="ex-container">
                <div class="ex-center-content">
                    <div class="h2">
                      <strong>
                       {{$starting_cities[$i]->name}}
                      </strong>
                    </div>
                </div>
              </div>
            </a>
          </div>
        </div>
        @endfor
      </div>
    </div>
    
@stop