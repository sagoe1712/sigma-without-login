<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @if(isset($product->data->product_name))
    <title>Experience - {{$product->data->product_name}} {{config('app.name')}}</title>
    @else
        <title>Experience - {{config('app.name')}}</title>
        @endif
        <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{{asset('assets/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-techmarket.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/blue.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/flatpickr.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/color-three.css')}}">
    <link rel="stylesheet" href="{{asset('css/intlTelInput.min.css')}}">
    <style>
        .iti-flag {background-image: url({{asset('img/flags.png')}});}
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .iti-flag {background-image: url({{asset('img/flags.png')}})}
        }
    </style>

    {{--<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>--}}
    <script src="{{asset('assets//newtemplate/vendor/html5shiv.js')}}"></script>
    <script src="{{asset('assets//newtemplate/vendor/respond.js')}}"></script>
    <style>
        .woocommerce-breadcrumb {
            display: block;
        }
    .product-images-wrapper {
                order: 0 !important;
            }
        input.date {
            font-family: FontAwesome;
            font-style: normal;
            font-weight: normal;
            text-decoration: inherit;
        }
        .intl-tel-input{
            width: 100%
        }
    </style>
</head>

<body class="woocommerce-active single-product full-width normal">
@if($errors->any())
    @include('partials.notify', ['text' => $errors->first()])
@endif
<div id="page" class="hfeed site">
    <div id="loader-wrapper">
        <div id="loader"></div>
    </div>
    <div class="html-top-content">
        <div class="theme-top-section">
            @include('partials.newnav')
        </div>
    </div>
    <div class="modal fade show" id="experiencebook" tabindex="-1" role="dialog" aria-labelledby="experiencebook" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <h2>Confirm booking</h2>

                    <br><br>
                    <a id="experiencebook_action">
                        <button type="button" class="btn btn-large btn-primary">Checkout</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @include('partials.notification.ordercomplete')
    <header id="masthead" class="site-header header-v1" style="background-image: none; ">
        <div class="col-full desktop-only">

            <!-- .techmarket-sticky-wrap -->
            <div class="row align-items-center">
                <div id="departments-menu" class="dropdown departments-menu">
                    <button class="btn dropdown-toggle btn-block" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-list" aria-hidden="true"></i>
                        <span>Categories</span>
                    </button>
                    <ul id="menu-departments-menu" class="dropdown-menu yamm departments-menu-dropdown">
                        @if(isset($response))
                            @if($response)
                            @if(isset($response->status))
                            @if($response->status == 1)
                                @foreach($response->data as $category)
                                    <li class="highlight menu-item animate-dropdown">
                                        <a title="{{$category->category}}"  id="{{$category->category_id}}" style="cursor: pointer" href="{{url("experiences",[str_slug($category->category, '-') .'__' . $category->category_id])}}">
                                            {{ucfirst($category->category)}}</a>
                                    </li>
                                @endforeach
                            @endif
                                @endif
                                @endif
                        @else
                            <li class="highlight menu-item animate-dropdown">
                                <a title="" href="javascript:">Failed to load categories</a>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- .departments-menu -->
                <form class="navbar-search" method="get" action="">

                    <!-- .input-group -->
                </form>
                <!-- .navbar-search -->
                <!-- .header-wishlist -->
                <ul id="site-header-cart" class="site-header-cart menu">
                    <li class="animate-dropdown dropdown ">
                        <a class="cart-contents" href="{{url('cart')}}" title="View your shopping cart">
                            <i class="tm tm-shopping-bag"></i>
                            @if(Auth::check())
                                @if(Auth::user()->cartCount()[0])
                                    <span class="count">{{Auth::user()->cartCount()[0]}}</span>
                                @endif
                            @endif
                        </a>
                    </li>
                </ul>
                <!-- .site-header-cart -->
            </div>
            <!-- /.row -->
        </div>
        <!-- .col-full -->
        <div class="col-full handheld-only">
            <div class="handheld-header">
                <!-- /.row -->
                <div class="techmarket-sticky-wrap">
                    <div class="row">
                        <nav id="handheld-navigation" class="handheld-navigation" aria-label="Handheld Navigation">
                            <button class="btn navbar-toggler" type="button">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                <span>Menu</span>
                            </button>
                            <div class="handheld-navigation-menu">
                                <span class="tmhm-close">Close</span>
                                <ul id="menu-departments-menu-1" class="nav">
                                    @if(isset($response))
                                        @if($response->status == 1)
                                            @foreach($response->data as $category)
                                                <li class="highlight menu-item animate-dropdown">
                                                    <a title="{{$category->category}}"  id="{{$category->category_id}}" style="cursor: pointer" href="{{url("catalogue/category",[str_slug($category->category, '-') .'__' . $category->category_id])}}">
                                                        {{ucfirst($category->category)}}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endif
                                </ul>
                            </div>
                            <!-- .handheld-navigation-menu -->
                        </nav>
                        <!-- .handheld-navigation -->
                        <div class="site-search">
                            <div class="widget woocommerce widget_product_search">
                                <form role="search" method="get" class="woocommerce-product-search" action="">
                                </form>
                            </div>
                            <!-- .widget -->
                        </div>
                        <a class="handheld-header-cart-link has-icon" href="{{url('cart')}}" title="View your shopping cart">
                            <i class="tm tm-shopping-bag"></i>
                            @if(Auth::check())
                                @if(Auth::user()->cartCount()[0])
                                    <span class="count">{{Auth::user()->cartCount()[0]}}</span>
                                @endif
                            @endif
                        </a>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- .techmarket-sticky-wrap -->
            </div>
            <!-- .handheld-header -->
        </div>
        <!-- .handheld-only -->
    </header>
    <div id="content" class="site-content">
        <div class="col-full" id="product">
            <div class="row">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">
                        @include('partials.breadcrumb', ['pages' =>
              [
              ['name' =>'Experiences', 'route' =>'experiences'],
              ['name' => $product->data->product_name, 'route' => null ]
              ]
              ])
                        <div class="product product-type-simple mt-4">
                            <div class="single-product-wrapper">
                                <div class="product-images-wrapper thumb-count-4">
                                    <div id="techmarket-single-product-gallery"
                                         class="techmarket-single-product-gallery techmarket-single-product-gallery--with-images techmarket-single-product-gallery--columns-4 images"
                                         data-columns="4">
                                        <div class="techmarket-single-product-gallery-images"
                                             data-ride="tm-slick-carousel"
                                             data-wrap=".woocommerce-product-gallery__wrapper" data-slick="">
                                            <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images"
                                                 data-columns="4">

                                                @if(isset($product->data->image))
                                                <figure class="woocommerce-product-gallery__wrapper ">
                                                    <div class="woocommerce-product-gallery__image single_experience_item">
                                                        @foreach($product->data->image as $image)
                                                        <img width="600" height="600"
                                                             src="{{$image}}"
                                                             class="attachment-shop_single size-shop_single wp-post-image"
                                                             alt="">
                                                        @endforeach
                                                    </div>
                                                </figure>
                                                    @endif
                                            </div><!-- .woocommerce-product-gallery -->
                                        </div><!-- .techmarket-single-product-gallery-images -->


                                    </div><!-- .techmarket-single-product-gallery -->
                                </div>

                                <div class="summary entry-summary single_item_container">
                                    <form name="checkout_experience" method="post">
                                        <div class="single-product-header">
                                            <h1 class="product_title entry-title font-weight-bold">{{$product->data->product_name}}</h1>
                                            @if(isset($product->data->package))
                                                <p class="price">
                                                    <input type="hidden" name="price" value="{{$product->data->package->adult->adult_price}}">
                                                    <input type="hidden" name="signature" value="{{$product->data->signature}}">
                                                    <input type="hidden" name="name" value="{{$product->data->product_name}}">
                                                </p>
                                            @endif
                                            <div class="woocommerce-product-details__short-description">
                                                {!!html_entity_decode($product->data->description)!!}
                                            </div>
                                        </div><!-- .single-product-header -->
                                        <div class="container">
                                            <div class="row mb-5">
                                                <div class="col-md-12">
                                                    @if(isset($product->data->location))
                                                    <div class="quantity mt-3">
                                                        <h4>Locations</h4>
                                                        <div class="woocommerce-checkout-payment" id="payment">
                                                            <ul class="wc_payment_methods payment_methods methods">
                                                                @foreach($product->data->location as $location)
                                                                    <input type="radio" value="{{$location->id}}" name="location" class="input-radio" id="payment_method_bacs">
                                                                      <label for="payment_method_bacs">{{$location->store_name}}, {{$location->exp_address}}, {{$location->city}}</label>
                                                                    <br>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="row">
                                                    @if(isset($product->data->start_date))
                                                    <div class="col-md-4" >
                                                        <div class="date">
                                                            <h4>Experience date</h4>
                                                            <div class="woocommerce-checkout-payment" id="payment">
                                                                <input data-toggle="datepicker" name="exp_date"
                                                                       data-startdate="{{$product->data->start_date}}"
                                                                       placeholder=" Choose date &#xf271"
                                                                       data-enddate="{{$product->data->end_date}}"
                                                                        class="date"
                                                                       style="border-style: hidden;"
                                                                >
                                                    </div>
                                                    </div>
                                                    </div>
                                                            <div class="col-md-4" >
                                                                <div class="day">
                                                                    <h4>Experience time</h4>
                                                                    <div class="woocommerce-checkout-payment" id="payment">
                                                                        <select name="exp_day" id="exp_day">
                                                                            <option value="null" disabled="disabled" selected>Select a day</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    @endif
                                                    </div>
                                                    <div class="row justify-content-center">
                                                    @if(isset($product->data->package))
                                                    <div class="col-md-12" >
                                                        <h4 class="mb-0 mt-3 mb-3">Guests</h4>
                                                        <div class="row">
                                                            @if(isset($product->data->package->adult))
                                                        <div class="woocommerce-checkout-payment col-md-3 range-slider">
                                                            <small>Adults</small>
                                                            <br>
                                                            <input class="range-slider__range adult_qty_range" type="range"
                                                                   name="guests_adults"
                                                                   value="{{$product->data->package->adult->min_adult}}"
                                                                   min="{{$product->data->package->adult->min_adult}}"
                                                                   max="{{$product->data->package->adult->max_adult}}"
                                                                   data-price="{{$product->data->package->adult->adult_price}}"
                                                            >
                                                            <span class="range-slider__value">{{$product->data->package->adult->min_adult}}</span>
                                                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                                                <span class="woocommerce-Price-amount amount">
                                                                    <span class="woocommerce-Price-currencySymbol">&#8358;</span>
                                                                   <span class="pricexqty">
                                                                       {{ transform_product_price( ($product->data->package->adult->adult_price * $product->data->package->adult->min_adult),1)}}
                                                                       </span>
                                                                </span>
                                                            @else
                                                                <span class="woocommerce-Price-amount amount">
                                                           <span class="pricexqty">{{transform_product_price( ($product->data->package->adult->min_adult * $product->data->package->adult->adult_price), Auth::user()->currency->rate)}} </span>  <span class="woocommerce-Price-currencySymbol">{{Auth::user()->currency->currency}}</span>
                                                            </span>
                                                            @endif
                                                        </div>
                                                            @endif
                                                            @if(isset($product->data->package->kids))
                                                        <div class="woocommerce-checkout-payment col-md-3 range-slider">
                                                            <small>Children</small>
                                                            <br>
                                                            <input class="range-slider__range" type="range"
                                                                   name="guests_kids"
                                                                   value="{{$product->data->package->adult->min_adult}}"
                                                                   min="{{$product->data->package->adult->min_adult}}"
                                                                   max="{{$product->data->package->adult->max_adult}}"
                                                                   data-price="{{$product->data->package->adult->adult_price}}"
                                                            >
                                                            <span class="range-slider__value">{{$product->data->package->adult->min_adult}}</span>
                                                        </div>
                                                                @endif
                                                        </div>
                                                    </div>
                                                        @endif
                                                    </div>
                                                    <div class="row mt-4">
                                                        <h4 class="pl-3">Order details</h4>
                                                        <div class="form-row">
                                                            <div class="col">
                                                            <input type="text" class="form-control" name="firstname" placeholder="First name" required>
                                                                <span class="invalid-feedback errorshow" role="alert">
                                                                </span>
                                                            </div>
                                                            <div class="col">
                                                            <input type="text" class="form-control" name="lastname"  placeholder="Last name" required>
                                                                <span class="invalid-feedback errorshow" role="alert">
                                                                 </span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-row">
                                                           <div class="col-6">
                                                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                                                               <span class="invalid-feedback errorshow" role="alert">
                                                                </span>
                                                           </div>
                                                            <div class="col-6">
                                                        <input type="text" id="phone" class="form-control" name="phone_no" placeholder="Phone number (8084438...)" required>
                                                                <input type="hidden" name="country_code">
                                                                <span class="invalid-feedback errorshow" role="alert">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="product-actions-wrapper">
                                            <div class="product-actions row justify-content-center">
                                                <div class="col-sm-6">
                                                    <button class="single_add_to_cart_button button alt custom_button_color"
                                                            value="185"
                                                            id="bookexp"
                                                            type="submit"
                                                            style="color: #fff;margin: 0 auto;"
                                                    >
                                                        <i class="fa fa-spinner fa-spin off process_indicator"></i>
                                                         Book Now
                                                    </button>
                                            </div>
                                            </div>
                                        </div>

                                        <!-- .product-actions -->
                                    </form>

                                </div>

                            </div>
                            @if(isset($product->data->faqs))
                            <div class="row justify-content-center">
                                <div class="col-md-12 pt-3 text-center" style="border-top: 1px solid #ccc;">
                                    <h4>FAQs</h4>
                                </div>

                                <div id="accordion">
                                    @foreach($product->data->faqs as $index => $faq)
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#{{$index}}" aria-expanded="true" aria-controls="{{$index}}">
                                                    {{$faq->question}}
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="{{$index}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                    @php echo $faq->answer; @endphp
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div><!-- .single-product-wrapper -->
                    </main>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
</div>
</div>
<script src="{{asset('assets/js/vendor/jquery-1.12.0.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/flatpickr.js')}}"></script>

<script src="{{asset('js/landing.js')}}"></script>
<script src="{{asset('assets/js/theia-sticky-sidebar.js')}}"></script>
<script src="{{asset('assets/js/slick.min.js')}}"></script>
<script src="{{asset('js/intlTelInput.min.js')}}"></script>
<script>
    $(".overlay").click(function(){
        $(this).hide();
    });
    //Configure Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //International Tel plugin setup
    var tel = document.querySelector("#phone");
    var phonenumber = window.intlTelInput(tel, {initialCountry: "ng", separateDialCode: true});
    var countryData = phonenumber.getSelectedCountryData();

    Date.prototype.getDayOfWeek = function(){
        return ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][ this.getDay() ];
    };
    var startdate = new Date($("input[name='exp_date']").data("startdate"));
    var price = $("input[name='price']").val();
    var enddate = new Date($("input[name='exp_date']").data("enddate"));
    var currentdate = new Date();
    var daySlots = <?php echo $dayslots ?>;
    //Declare global variables.
    var conversionRate = "<?php echo Auth::user()->currency->rate ;?>"
    var appCurrencyFixed = "<?php echo Auth::user()->currency->is_currency_fixed ;?>"
    var baseUrl = "<?php echo config('app.base_url')?>";


    //FlatPicker Setup
    var options = {
        enable: [
            {
                from: startdate,
                to: enddate
            }],
        altInput: true,
        altFormat: "F j, Y",
        enableTime: false,
        dateFormat: "Y-m-d",
        // onChange: function(selectedDates, dateStr, instance) {
        //     var selectedDay = new Date(dateStr).getDay();
        //     var selectedDaySlot = daySlots.filter(function (elem, i) {
        //         return i === selectedDay
        //     });
        //     $("#exp_day").empty();
        //     if(selectedDaySlot.length == 0){
        //         $("#exp_day").append("<option value='null' disabled selected>No Time Slot</option>");
        //         return false;
        //     }
        //     selectedDaySlot.map(function(elem, i){
        //         $("#exp_day").prepend(
        //             "<option value="+elem.start_time+">"+elem.start_time + " " + elem.start_time_period + " - " + elem.end_time+ " " + elem.end_time_period +"</option>"
        //         );
        //     })
        // }
    }

    flatpickr(".date", options);
    //End Flatpickr setup

    $(document).ready(function () {
        //Load dates

        $(".single_experience_item").slick({
            dots: true,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            autoplay: true
        });

        $("input").on('keyup', function () {
            $("input[name='country_code']").val(countryData.dialCode)
            $("span.errorshow").fadeOut()
            $("span.errorshow").html("")
        });

        $("#bookexp").click(function(e){
            e.preventDefault();
            var dateField = $("input[name='exp_date']").val();
            if (!$("input[name='location']:checked").val()) {
                alertui.notify('error', 'Please choose a Location.');
                swal("Booking Error","Please choose a Location.", "error");

                return false;
            }

            if (!$("select[name='exp_day']").val()) {
                alertui.notify('error', 'Please select a Time slot.');
                swal("Booking Error","Please select a Time slot.", "error");
                return false;
            }
            if ($("input[name='firstname']").val() === '' || $("input[name='lastname']").val() === '' || $("input[name='phone_no']").val() === '' || $("input[name='email']").val() === '') {
                alertui.notify('error', 'Please complete the order form');
                return false;
            }
            if(dateField.length < 1){
                alertui.notify('error', 'Please choose a date.');
                swal("Booking Error","Please choose a date", "error");
                return false;
            }
            $(".process_indicator").removeClass('off');

            var formData = $("form[name='checkout_experience']").serialize()
                disableItem($("#bookexp"), true)
            $.post(baseUrl+'checkout_experience',formData )
                .done(function (res) {
                    $(".process_indicator").addClass('off');
                    disableItem($("#bookexp"), false)
                    // handle success
                    if (!res) {
                        alertui.notify('error','Failed to complete booking');
                        swal("Booking Error","Failed to complete booking", "error");
                        return false;
                    }
                    if (res.status == '400') {
                        alertui.notify('error',res.data);
                        return false;
                    }
                    if (res.status == 'fail') {
                        alertui.notify('info',' Sorry! No experience available for the selected date.');
                        swal("Booking Error",' Sorry! No experience available for the selected date.', "error");
                        return false;
                    }
                    if (res.status == 'validation') {
                        $.each(res.data, function (key, item) {
                            $("input[name="+key+"] + span.errorshow").html(item[0])
                            $("input[name="+key+"] + span.errorshow").slideDown("slow")
                        });
                        return false;
                    }
                    if (res.status == '200') {
                        updateAccount(res.account)
                        $('#modal').modal('hide');
                        $('#modal').on('hidden.bs.modal', function (e) {
                            $('#ordernotify').modal('show');
                        });
                        var oldlink = $("#order_receipt").prop('href');
                        $('#ordernotify').on('shown.bs.modal', function (e) {
                            $("#order_receipt").prop('href', '');
                            $("#order_receipt").prop('href', "{{url('ordercomplete')}}"+'/'+res.data);
                        });
                    }
                })
                .fail(function (response, status, error) {
                    // handle error
                    $(".process_indicator").addClass('off');
                    disableItem($("#bookexp"), false)
                    if(response.status == 500){
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                        swal("Booking Error",'An Error Occurred. Please try again.', "error");

                    }
                    else{
                        alertui.notify('error', response.responseJSON.data)
                        swal("Booking Error",response.responseJSON.data, "error");
                    }
                })


        });

        $("input.adult_qty_range").change(function () {
            updatePrice(parseInt($(this).val()))
        })

    });

    function updateRangeInput(elem) {
        // $(elem).next().find("span").text($(elem).val());
        updatePrice(parseInt($(elem).val()))
    }

    function updateKidsRangeInput(elem) {
        $(elem).next().find("span").text($(elem).val());
    }

    function updatePrice(quantity){
        if(appCurrencyFixed == 1){
            //Currency fixed
            var newprice = new Intl.NumberFormat('en-GB').format(price*quantity);
            $(".pricexqty").html(newprice)
        }else{
            //Currency not Fixed
            //Currency is not Naira
            var cRate = parseInt(conversionRate);
            // console.log(cRate, qty, price)
            var newprice = new Intl.NumberFormat('en-GB').format(cRate*(price*quantity));
            $(".pricexqty").html(newprice)
        }
    }

</script>
<script>
    $('.product-images-wrapper').theiaStickySidebar({
        // Settings
        additionalMarginTop: 30
    });
    var rangeSlider = function(){
        var slider = $('.range-slider'),
            range = $('.range-slider__range'),
            value = $('.range-slider__value');

        slider.each(function(){

            value.each(function(){
                var value = $(this).prev().attr('value');
                $(this).html(value);
            });

            range.on('input', function(){
                $(this).next(value).html(this.value);
            });
        });
    };

    rangeSlider();
</script>
</body>

</html>