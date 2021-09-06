<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- All css files are included here. -->
    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-techmarket.css')}}">
    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/color-three.css')}}">

    {{--<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>--}}
    <script src="{{asset('assets//newtemplate/vendor/html5shiv.js')}}"></script>
    <script src="{{asset('assets//newtemplate/vendor/respond.js')}}"></script>
    <style>
        .theme-main-menu{
            z-index: 99999;
        }
        a#navbarDropdownMenuLink.dropdown-toggle::after{
            display: none;
        }
        .account_nav_menu{
        display: block;
        }
        .dropdown-menu {
        left: -70px
        }
    </style>
</head>
<body class="woocommerce-active page-template-template-landingpage-v2 can-uppercase">
@if($errors->any())
    @include('partials.notify', ['text' => $errors->first()])
@endif
<div class="main-page-wrapper">
    <div id="loader-wrapper">
        <div id="loader"></div>
    </div>

    <div class="html-top-content">
        @include('partials.top')
    <div class="our-features-four" id="features">
        <img src="images/shape/27.png" alt="" class="shape">
        <div class="container">
            <div class="theme-title text-center">
                <h2>How LSL rewards works.</h2>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12" data-aos="fade-up" data-aos-duration="900">
                    <div class="single-feature">
                        <div class="icon-box">
                            <img src="{{ asset('images/shape/20.png ') }}" alt="" class="primary-icon">
                        </div>
                        <h3>Enrol</h3>
                        <p> Get enrolled in the LSL Rewards program and gain access to the richness of service.</p>
                        <a href="#"><i class="flaticon-right-thin"></i></a>
                    </div> <!-- /.single-feature -->
                </div> <!-- /.col- -->
                <div class="col-md-4 col-sm-6 col-xs-12" data-aos="fade-up" data-aos-duration="1200">
                    <div class="single-feature">
                        <div class="icon-box">
                            <img src="{{ asset('images/shape/21.png ') }}" alt="" class="primary-icon">
                        </div>
                        <h3>Shop & Earn</h3>
                        <p> You will earn points for every purchase, no matter how you choose to pay. </p>
                        <a href="#"><i class="flaticon-right-thin"></i></a>
                    </div> <!-- /.single-feature -->
                </div> <!-- /.col- -->
                <div class="col-md-4 col-sm-6 col-xs-12" data-aos="fade-up" data-aos-duration="1500">
                    <div class="single-feature">
                        <div class="icon-box">
                            <img src=" {{ asset('images/shape/22.png ') }}" alt="" class="primary-icon">
                        </div>
                        <h3>Redeem</h3>
                        <p>You can use your accumulated point to redeem exclusive items on the customer portal catalogue.</p>
                        <a href="#"><i class="flaticon-right-thin"></i></a>
                    </div> <!-- /.single-feature -->
                </div> <!-- /.col- -->
        </div> <!-- /.container -->
    </div>

        <div class="about-cryto style-two" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 order-lg-last">
                        <div class="theme-title">
                            <div class="upper-heading">WHAT IS LSL REWARDS?
                            </div>
                            <h2>LSL Rewards is Our
                                <br>way of saying Thank You
                                <br>for shopping with us.</h2>
                        </div> <!-- /.theme-title -->
                        <p class="sub-text">We reward you with points for your everyday
                            transactions. </p>
                        <p class="text">You start earning Points from the moment you start transacting in the stated way from the day of the program launch.</p>
                        <a href="{{ url('catalogue') }}" class="learn-more">Start redeeming today.</a>
                        <p class="know-more w-100">Want to learn more about us? <a href="#contact">Contact us</a></p>
                    </div>
                    <div class="col-lg-6 order-lg-first">
                        <div class="icon-data">
                            <div class="single-box" data-aos="fade-right" data-aos-duration="1100">
                                <img src="{{ asset('images/icon/14.png') }}" alt="">
                                <h3>Discount</h3>
                                <p>You will earn points for every N2,000 you spend at at our store, no matter how you choose to pay.</p>
                            </div> <!-- /.single-box -->
                            <div class="single-box" data-aos="fade-down" data-aos-duration="1100">
                                <img src="{{ asset('images/icon/15.png') }}" alt="">
                                <h3>Global catalog</h3>
                                <p>A global catalog of redeemable product, Perks & experiences.</p>
                            </div> <!-- /.single-box -->
                            <div class="single-box" data-aos="fade-up" data-aos-duration="1100">
                                <img src=" {{ asset('images/icon/16.png') }}" alt="">
                                <h3>Privilege</h3>
                                <p>Get benefit on exclusive items from any of our store worldwide.</p>
                            </div> <!-- /.single-box -->
                        </div> <!-- /.icon-data -->
                    </div>
                </div>
            </div> <!-- /.container -->
        </div>

        <div class="our-features-four" id="features">
            <img src="{{ asset('images/shape/27.png ') }}" alt="" class="shape">
            <div class="container">
                <div class="theme-title text-center">
                    <h2>The Catalogue.</h2>
                </div>
                <div class="row">

                    <div class="col-md-4 col-sm-6 col-xs-12 pb-5" data-aos="fade-up" data-aos-duration="900">
                        <div class="single-feature">
                            <div class="icon-box">
                                <a href="{{ url('catalogue') }}">
                                <img src="{{ asset('images/shape/111.png') }}" alt="" class="primary-icon">
                                </a>
                            </div>
                            <h3>Merchandise Item</h3>
                            <p> We have numerous products of variants that can be purchased instantly.</p>
                            <a href="{{ url('catalogue') }}"><i class="flaticon-right-thin"></i></a>
                        </div> <!-- /.single-feature -->
                    </div> <!-- /.col- -->

                    <div class="col-md-4 col-sm-6 col-xs-12 pb-5" data-aos="fade-up" data-aos-duration="1200">
                        <div class="single-feature">
                            <div class="icon-box">
                                <a href="{{ url('experiences') }}">
                                <img src="{{ asset('images/shape/112.png') }}" alt="" class="primary-icon">
                                </a>
                            </div>
                            <h3>Experiences</h3>
                            <p> Enjoy international experiences with your family and pay with your loyalty points. </p>
                            <a href="{{ url('experiences') }}"><i class="flaticon-right-thin"></i></a>
                        </div> <!-- /.single-feature -->
                    </div> <!-- /.col- -->

                    <div class="col-md-4 col-sm-6 col-xs-12 pb-5" data-aos="fade-up" data-aos-duration="1500">
                        <div class="single-feature">
                            <div class="icon-box">
                                <a href="{{ url('meals') }}">
                                <img src="{{ asset('images/shape/113.png') }}" alt="" class="primary-icon">
                                </a>
                            </div>
                            <h3>Meals</h3>
                            <p>Get Access to the finest restaurants and winery all over the world.</p>
                            <a href="{{ url('meals') }}"><i class="flaticon-right-thin"></i></a>
                        </div> <!-- /.single-feature -->
                    </div> <!-- /.col- -->

                    <div class="col-md-4 col-sm-6 col-xs-12 pb-5" data-aos="fade-up" data-aos-duration="900">
                        <div class="single-feature">
                            <div class="icon-box">
                                <a href="{{ url('cinemas') }}">
                                <img src="{{ asset('images/shape/114.png') }}" alt="" class="primary-icon">
                                </a>
                            </div>
                            <h3>Cinemas</h3>
                            <p> Enjoy movies with family and friends and pay with your loyalty points across different cinemas.</p>
                            <a href="{{ url('cinemas') }}"><i class="flaticon-right-thin"></i></a>
                        </div> <!-- /.single-feature -->
                    </div> <!-- /.col- -->

                    <div class="col-md-4 col-sm-6 col-xs-12 pb-5" data-aos="fade-up" data-aos-duration="1200">
                        <div class="single-feature">
                            <div class="icon-box">
                                <a href="{{ url('bills') }}">
                                <img src="{{ asset('images/shape/115.png') }}" alt="" class="primary-icon">
                                </a>
                            </div>
                            <h3>Bills Payment</h3>
                            <p>Instant Airtime and bills payments directly to your mobile or utility/bills payments. </p>
                            <a href="{{ url('bills') }}"><i class="flaticon-right-thin"></i></a>
                        </div> <!-- /.single-feature -->
                    </div> <!-- /.col- -->
                    <div class="col-md-4 col-sm-6 col-xs-12 pb-5" data-aos="fade-up" data-aos-duration="1500">
                        <div class="single-feature">
                            <div class="icon-box">
                                <a href="{{ url('events') }}">
                                <img src="{{ asset('images/shape/116.png') }}" alt="" class="primary-icon">
                                </a>
                            </div>
                            <h3>Events</h3>
                            <p>Get Access to the finest events all over the world.</p>
                            <a href="{{ url('events') }}"><i class="flaticon-right-thin"></i></a>
                        </div> <!-- /.single-feature -->
                    </div> <!-- /.col- -->
                </div> <!-- /.row -->

                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </div>

        <div class="apps-overview color-three" id="apps-review">
            <img src="images/shape/29.png" alt="" class="shape">
            <div class="overlay-bg">
                <div class="container">
                    <div class="inner-wrapper">
                        <img src="images/home/s8.png" alt="" class="s8-mockup" data-aos="fade-down" data-aos-duration="2500">
                        <img src="images/home/x.png" alt="" class="x-mockup" data-aos="fade-up" data-aos-duration="2500">
                        <div class="row">
                            <div class="col-lg-5 offset-lg-7">
                                <div class="text">
                                    <h3>How do I redeem
                                    </h3>
                                    <h2>Redemptions
                                        Just got easier
                                    </h2>
                                    <h6>Collect your redeemed products Via Delivery or pick up
                                    </h6>
                                    <p style="font-size: 15px">To pick up at a partner location: After confirmation of your selected item, you would be issued an E-voucher containing a unique code, and instructions on how and where to pick up your item. At the partner location, your voucher would be verified, and once verified, the item will be handed to you. *E-vouchers are valid for only 5 days.

                                        To have it delivered: You can provide details of a current mailing address where the selected item would be delivered. The selected item would be delivered to your specified address within 10 working days.</p>

                                </div> <!-- /.text -->
                            </div>
                        </div>
                    </div> <!-- /.inner-wrapper -->
                </div>
            </div> <!-- /.overlay-bg -->
        </div>

        <div class="faq-section" style="margin-top: 8.5rem!important;">
            <div class="container">
                <div class="theme-title text-center">
                    <h2>LSL Rewards FAQ’s</h2>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="accordion-one">
                            <div class="panel-group theme-accordion" id="accordion">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                                How soon can I start redeeming?</a>
                                        </h6>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p>  As soon as you have enough points to redeem items from the categories.</p>
                                        </div>
                                    </div>
                                </div> <!-- /panel 1 -->
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                                When will I start earning points?</a>
                                        </h6>
                                    </div>
                                    <div id="collapse2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p>You will start earning Points from the moment you start transacting in the stated way from the day of the program launch.</p>
                                        </div>
                                    </div>
                                </div> <!-- /panel 2 -->
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                                What is the Naira value of my points?</a>
                                        </h6>
                                    </div>
                                    <div id="collapse3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p>The Points given are not nominally valued, they are uniquely valued based on the Rewards available to you.</p>
                                        </div>
                                    </div>
                                </div> <!-- /panel 3 -->

                            </div> <!-- end #accordion -->
                        </div> <!-- End of .accordion-one -->
                    </div>

                    <div class="col-lg-6">
                        <div class="accordion-one">
                            <div class="panel-group theme-accordion" id="accordion-two">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h6 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                                How long can I keep my Points for?</a>
                                        </h6>
                                    </div>
                                    <div id="collapse4" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p> You can keep your Points for 3 years. However, if your Points are not redeemed within the stated period, they expire and will be automatically deducted from your account. Your Point will be forfeited after it is deducted from your account.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <div class="panel-heading active-panel">
                                        <h6 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                                                Who Should I Contact if I Have Any Queries?</a>
                                        </h6>
                                    </div>
                                    <div id="collapse5" class="panel-collapse collapse show">
                                        <div class="panel-body">
                                            <p> You can contact us through the form below or reach us by sending us a message below or calling with the number provided below.
                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- /panel 4 -->

                            </div> <!-- end #accordion-two -->
                        </div> <!-- End of .accordion-one -->
                    </div>
                </div>
            </div>
        </div>

    <div class="contact-us-one bg-color m0" id="contact">
        <img src="images/shape/26.png" alt="" class="shape">
        <img src="images/shape/30.png" alt="" class="shape-two">
        <div class="container">
            <div class="theme-title text-center">
                <h2>Get In Touch</h2>
                      </div>
            <form action="#" class="form-validation" autocomplete="off">
                <div class="row">
                    <div class="col-md-6">
                        <label>First Name*</label>
                        <input type="text" placeholder="First Name" name="firstName" required>
                    </div>
                    <div class="col-md-6">
                        <label>Last Name*</label>
                        <input type="text" placeholder="Last Name" name="lastName" required>
                    </div>
                    <div class="col-md-6">
                        <label>Email*</label>
                        <input type="email" placeholder="Email Address" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" placeholder="Phone Number" name="phone" required>
                    </div>
                    <div class="col-12">
                        <label>I would like to discuss*</label>
                        <input type="text" name="message" required>
                    </div>
                </div>
                <button>Send Message</button>
            </form>
            <!--Contact Form Validation Markup -->
            <!-- Contact alert -->
            <div class="alert-wrapper" id="alert-success">
                <div id="success">
                    <button class="closeAlert"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <div class="wrapper">
                        <p>Your message was sent successfully.</p>
                    </div>
                </div>
            </div> <!-- End of .alert_wrapper -->
            <div class="alert-wrapper" id="alert-error">
                <div id="error">
                    <button class="closeAlert"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <div class="wrapper">
                        <p>Sorry!Something Went Wrong.</p>
                    </div>
                </div>
            </div> <!-- End of .alert_wrapper -->
        </div>
    </div>
    @include('partials.footer')
    </div>
</div>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/landing.js')}}"></script>
</body>
</html>