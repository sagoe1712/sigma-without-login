@extends('layouts.main')

@section('content')
    <?php
    $company_id = env('COMPANY_ID');
    $cs =  DB::table('setting')
        ->where('company_id', '=', $company_id)
        ->first();

    ?>

    @if(!Auth::guest())
        <input type="hidden" class="login-status" value = "1">
    @else
        <input type="hidden" class="login-status" value = "0">
    @endif
    <div class="modal fade" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header custom_bg_color_2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;color: #fff"><span aria-hidden="true">&times;</span></button>
                    <img
                            src="{{asset('images/check.png')}}"
                            class="text-center" alt="success"
                            style="
                            width: 100px;
                            margin: 0 auto;
                            left: 40%;
                            top: 10%;
                            position: relative;"
                    >
                </div>
                <div class="modal-body text-center">
                    <h2 class="">Great!</h2>
                    <h4 class="order_response"></h4>
                    <br><br>
                    <div class="row" role="group" aria-label="">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="col-sm-6" role="group">
                                <a type="button" data-dismiss="modal" aria-label="Close" class="btn btn-large custom_button_color_2" style="width: 100%; height: 40px;">
                                    <span>Continue Shopping</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="col-sm-6" role="group">
                                <a href="{{url('cart')}}" class="btn btn-large custom_button_color"  style="width: 100%; height: 40px;">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>View Cart</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.experience._modal_booking')
    <div class="body-content outer-top-xs">
        <div class="">
            <div class="container">
                <div class="colored-icons">
                    <a href="{{url()->previous()}}">
                        <i class="fa fa-arrow-left" aria-hidden="true">
                            <span>Back To Experiences</span>
                        </i>
                    </a>
                </div>
                <!-- /.breadcrumb-inner -->
            </div>
        </div>

        <div class='container'>
            <div class='row single-product'>
                <div class='col-xs-12 col-sm-12 col-md-12' style="margin-bottom: 100px;">
                    <div style="padding: 15px;">
                        <div class="row">
                            @if($product)
                                @if($product->status != 0)
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 gallery-holder">
                                        <div class="product-item-holder product-images-wrapper size-big single-product-gallery small-gallery">
                                            <div id="owl-single-product">
                                                @foreach($product->data->images as $image_index => $image)
                                                    <div class="single-product-gallery-item" id="slide{{$image_index}}">
                                                        <a data-lightbox="image-{{$image_index}}" data-title="Gallery" href="{{$image}}">
                                                            <img class="img-responsive" alt="" src="{{asset('sigma/images/blank.gif')}}" data-echo="{{$image}}" />
                                                        </a>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div><!-- /.single-product-gallery -->
                                    </div><!-- /.gallery-holder -->
                                    <div class='col-sm-12 col-md-5 col-lg-5 product-info-block'>
                                        <div class="product-info">
                                            <form name="checkout_experience" method="post">
                                                {{ csrf_field() }}
                                                @if(isset($product->data))
                                                    {{--<input type="hidden" name="price" value="{{$product->data->package->adult->adult_price}}">--}}
                                                    {{--<input type="hidden" name="signature" value="{{$product->data->signature}}">--}}
                                                    {{--<input type="hidden" name="name" value="{{$product->data->product_name}}">--}}

                                                    <h3>{{$product->data->name}}</h3>

                                                    <div class="m-t-10">
                                                        <h4 class="font-weight-bold">Location:</h4>
                                                        <p>{!!($product->data->location)!!}</p>
                                                        <p>{!!($product->data->country)!!}, {!!($product->data->state)!!}, {!!($product->data->city)!!}</p>

                                                    </div>
                                                    <div class=" m-t-20">
                                                        <h4 class="font-weight-bold">Description:</h4>
                                                        <p>{!!($product->data->description)!!}</p>
                                                    </div>
                                                    <div class=" m-t-20">
                                                        <h4 class="font-weight-bold">Details:</h4>
                                                        @if($product->data->duration)
                                                            <p>Duration: {!!($product->data->duration / 60)!!} hrs</p>
                                                        @endif
                                                        @if($product->data->age)
                                                            <p>Age range allowed: {!!($product->data->age)!!}</p>
                                                        @endif
                                                        @if($product->data->gender)
                                                            <p>Gender allowed: {!!($product->data->gender)!!}</p>
                                                        @endif
                                                    </div>
                                                    <div class="m-t-20">
                                                        <h3>{{$price}}</h3>
                                                    </div>

                                            </form>
                                        </div>
                                        @endif
                                    </div>

                                    <div class='col-sm-12 col-md-3 col-lg-3 product-info-block'>

                                        <h4>Availabilities</h4>
                                        <div class="loader"></div>
                                        <div id="datepicker"></div>

                                        <div class="lisiting_avabilities">

                                        </div>
                                    </div>
                                @else
                                    <h4>Experiences unavailable</h4>
                                @endif
                            @else

                                <div class="row experience_page_container"  style="
                                        background: url({{asset('images/bg/experience_unavailable.jpg')}}) no-repeat center center;
                                        -webkit-background-size: cover;
                                        -moz-background-size: cover;
                                        -o-background-size: cover;
                                        background-size: cover;
                                        position: relative;
                                        padding: 100px 60px;">
                                    <div class="col-sm-4">

                                    </div>
                                    <div class="col-sm-8">
                                        <div class="experience_catch">
                                            <h3>
                                                Sorry! Experience is currently
                                                <br>
                                                unavailable for the selected Experience.
                                            </h3>
                                            <p>Search other cities to book your Activities and Tours now.</p>
                                        </div>
                                        <form class="" method="get" action="{{url('experiences/category')}}">

                                            <select name="exp_country" id="exp_country" class="product_input" style="width: 145.64px;" required onchange="fetchCities(this)">
                                                {{--<option value="" selected="selected" disabled="disabled" required>Select Country</option>--}}
                                                @if($countries)
                                                    @if($countries->data)
                                                        @foreach($countries->data as $country)
                                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                            <select name="exp_city" id="exp_city" class="product_input" style="width: 145.64px;" disabled>
                                                <option value="" selected="selected">Select City</option>
                                            </select>

                                            <button type="submit" class="btn btn-primary search_exp_btn custom_button_color">
                                                <span class="">FIND EXPERIENCES</span>
                                            </button>
                                            <!-- .input-group-btn -->

                                            <!-- .input-group -->
                                        </form>
                                    </div>
                                </div>
                            @endif

                        </div><!-- /.row -->
                    </div>
                    <div class="" style="padding-bottom: 1.5em;">
                        <div class="row">
                            <div class="col-sm-12 experience_page_container" style="background: #fff;padding: 0 60px 60px;">
                                <div class="mt-5" style="position:relative;">
                                    <h3 class="exp_glam_title">Most Popular destinations</h3>
                                    <hr>
                                </div>
                                @include('pages.experience._popular_cities')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/intlTelInput.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/flatpickr.min.css')}}">
    @include('pages.experience.styles')
@endpush
@push('script')
    <script src="{{asset('js/flatpickr.js')}}"></script>
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script src="{{asset('js/moment.js')}}"></script>
    @include('pages.experience.scripts')

@endpush
