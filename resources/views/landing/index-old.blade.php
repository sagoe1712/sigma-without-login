
@extends('layouts.landing')

@section('content')
    <div class="homebackground">
        <!-- Spinner -->
        <div class="spinner-eff">
            <div class="spinner-circle circle-1">

            </div>
            <div class="spinner-circle circle-2">

            </div>
        </div>
        <div class="spinner-eff2">
            <div class="spinner-circle circle-1">

            </div>
            <div class="spinner-circle circle-2">

            </div>
        </div>

        <!-- Spinner End -->
        <div class="home-container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <h1>Welcome to Sigma Prime</h1>
                    <p>You matter to us, that’s
                        why you can start enjoying benefits of having an RSA
                        account with us. Benefit from our wide range of curated products.</p>

                    <div class="start-shopping">
                       <a href="{{url('catalogue')}}">
                        <button type="button" class="btn btn-default search-btn home-btn3">
                            <span>Start Shopping Now <i class="fa fa-arrow-right" aria-hidden="true"></i></span>
                        </button>
                       </a>


                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-12 home-image-column .d-sm-none .d-md-block">
                    <img src="{{asset('images/home-images/image1.png')}}" width="100%" />
                </div>
            </div>
        </div>
    </div>
    <div id="aboutus" class="about-us-container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 about-us-first">
                <h1>About <span class="sigma-green">Sigma Prime.</span></h1>
                <h3>This Is Our Way Of Saying Thank You For Trusting Us With Your Future.</h3>
                <p>We reward you with Sigma Stars for your everyday transactions.
                    You start earning Sigma Stars from the moment you start
                    transacting in the stated way from the day of the program launch.</p>

                <a href="{{url('catalogue')}}">
                    <button type="button" class="btn btn-default search-btn home-btn">Start Redeeming Today</button>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-6 about-us-second">
                <div class="aboutusimg">
                    <img src="{{asset('images/home-images/aboutus.png')}}" width="100%" />
                </div>
                <div class="aboutusimg2">
                    <img src="{{asset('images/home-images/image2.png')}}" width="70%" />
                </div>

            </div>
        </div>
    </div>
    <div class="rewards-container">
        <div class="rewards-content-container">
            <h1>Three Simple Steps To <span class="sigma-blue">Get Rewarded</span></h1>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-12">
                        <div class="rewards-card">
                            <img src="{{asset('images/home-images/1enrol.svg')}}" width="40%" />
                        </div>
                        <div class="rewards-card-contents">
                            <h5>Enrolment</h5>
                            <p>Your RSA balance automatically qualifies you for the Sigma Prime rewards.</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-6 loader-div">
                        <i class="loading"></i>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-12">
                        <div class="rewards-card">
                            <img src="{{asset('images/home-images/2earn.svg')}}" width="40%" />
                        </div>
                        <div class="rewards-card-contents">
                            <h5>Earn Point</h5>
                            <p>Sigma Stars are earned based on your RSA balance.</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-6 loader-div">
                        <i class="loading"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="rewards-card">
                    <img src="{{asset('images/home-images/3redeem.svg')}}" width="40%" />
                </div>
                <div class="rewards-card-contents">
                    <h5>Redeem</h5>
                    <p>
                        You can use your accumulated point to
                        redeem exclusive items on the customer portal catalogue.
                    </p>
                </div>
            </div>
        </div>

    </div>
    <!-- Sigma pension container -->
    <div class="sigma-pension-container">
        <div class="sigma-pen-header">
            <h1>Sigma Prime Loyalty Program is <span class="sigma-deep-blue">one of the leading reward</span> program in Nigeria</h1>
        </div>
        <div class="sigma-pen-cards">
            <div class="row">
                <div class="col-12 col-md-7">
                    <div class="sp-cards">
                        <div class="row">
                            <div class="col-12 col-md-2 center-home-icon-img">
                                <img src="{{asset('images/home-images/1global.svg')}}"/>
                            </div>
                            <div class="col-12 col-md-10">
                                <p>Global Catalogue. <span class="low-opacity"> Sigma Prime offers
                                a wide array of catalog items which ranges
                                from physical products, virtual products, restaurant,
                                experiences, bill payments, cinema tickets and many more.</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="sp-cards">
                        <div class="row">
                            <div class="col-12 col-md-2 center-home-icon-img">
                                <img src="{{asset('images/home-images/2redemption.svg')}}" />
                            </div>
                            <div class="col-12 col-md-10">
                                <p>Easy Redemption.  <span class="low-opacity"> Enjoy seamless redemption processing via delivery and pickup methods.</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12 col-md-5">
                    <div class="sp-cards">
                        <div class="row">
                            <div class="col-12 col-md-2 center-home-icon-img">
                                <img src="{{asset('images/home-images/3notification.svg')}}"/>
                            </div>
                            <div class="col-12 col-md-10">
                                <p>Important Notifications.  <span class="low-opacity">Receive notifications on the go for every important action.</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                    <div class="sp-cards">
                        <div class="row">
                            <div class="col-12 col-md-2 center-home-icon-img">
                                <img class="statement-img" src="{{asset('images/home-images/4transaction.svg')}}" />
                            </div>
                            <div class="col-12 col-md-10">
                                <p>Transaction Statements.<span class="low-opacity"> View your transaction details from the statement tab when you log into your sigma prime account.</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Redemption catalog -->
    <div class="redemption-catalog-session">
        <div class="redemption-contents">
            <h1>Our Redemption Catalog</h1>
        </div>
        <div class="redemption-images-session">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="red-img-div">
                        <a href="{{url('meals')}}">
                            <img src="{{asset('images/home-images/finedine.png')}}" width="100%" />
                        </a>
                        <div class="centered-img-div">
                            <h5>Fine Dining</h5>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div  class="red-img-div">
                        <a href="{{url('catalogue')}}">
                            <img src="{{asset('images/home-images/marchandise.png')}}" width="100%" />
                        </a>
                        <div class="centered-img-div">
                            <h5>Merchandise item</h5>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div  class="red-img-div">
                        <a href="{{url('uber_vouchers')}}">
                            <img src="{{asset('images/home-images/uber.png')}}" width="100%" />
                        </a>
                        <div class="centered-img-div">
                            <h5>Uber Voucher</h5>
                        </div>

                    </div>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="red-img-div">
                        <a href="{{url('cinemas')}}">
                            <img src="{{asset('images/home-images/cinema.png')}}" width="100%" />
                        </a>
                        <div class="centered-img-div">
                            <h5>Cinema</h5>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div  class="red-img-div">
                        <a href="{{url('bills')}}">
                            <img src="{{asset('images/home-images/bill.png')}}" width="100%" />
                        </a>
                        <div class="centered-img-div">
                            <h5>Bills Payment</h5>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div  class="red-img-div">
                        <a href="{{url('events')}}">
                            <img src="{{asset('images/home-images/event.png')}}" width="100%" />
                        </a>
                        <div class="centered-img-div">
                            <h5>Event</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Lower div -->

    <div class="lower-redemption-corner">
        <div class="outer-container">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="rewards-card2">
                                <img src="{{asset('images/home-images/stat1.svg')}}" width="25px" />
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="rewards-text">
                                <h5>1000+</h5>
                                <p>MERCHANDISE ITEMS</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-3">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="rewards-card2">
                                <img src="{{asset('images/home-images/stat2.svg')}}" width="25px" />
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="rewards-text">
                                <h5>5000+</h5>
                                <p>EXPERIENCES</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="rewards-card2">
                                <img src="{{asset('images/home-images/stat3.svg')}}" width="25px" />
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="rewards-text">
                                <h5>1000+</h5>
                                <p>VOUCHERS</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="rewards-card2">
                                <img src="{{asset('images/home-images/stat4.svg')}}" width="25px" />
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="rewards-text">
                                <h5>9000+</h5>
                                <p>MEALS</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- FAQS -->
    <div class="frequently-asked-container" id="faqs">
        <div class="row">
            <div class="col-12 col-md-7 first-faq">
                <div class="faq-header">
                    <h1>Frequently <span class="sigma-green">Asked Questions</span></h1>
                </div>
                <div class="faq-body">
                    <div class="row">
                        <div class="col-2 col-md-1 faq-special-column">
                            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <img class="faqicons" src="{{asset('images/home-images/faqicon.svg')}}" />
                            </a>

                        </div>
                        <div class="col-10 col-md-11 faq-special-column">
                            <h5>What Is The Sigma Pensions “Sigma Prime” Rewards Program?</h5>
                        </div>

                    </div>

                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            The Sigma Prime Rewards Program is our way of thanking you for your continued patronage and for trusting us with your future.
                        </div>
                    </div>

                </div>
                <div class="faq-body">
                    <div class="row">
                        <div class="col-2 col-md-1 faq-special-column">
                            <a data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                                <img class="faqicons" src="{{asset('images/home-images/faqicon.svg')}}" />
                            </a>

                        </div>
                        <div class="col-10 col-md-11 faq-special-column">
                            <h5>Do I Have To Pay Before I Can Participate In The Rewards Program?</h5>
                        </div>

                    </div>

                    <div class="collapse" id="collapseExample3">
                        <div class="card card-body">
                            No, Your Retirement Savings Account automatically qualifies you for the Program.
                        </div>
                    </div>

                </div>
                <div class="faq-body">
                    <div class="row">
                        <div class="col-2 col-md-1 faq-special-column">
                            <a data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                                <img class="faqicons" src="{{asset('images/home-images/faqicon.svg')}}" />
                            </a>

                        </div>
                        <div class="col-10 col-md-11 faq-special-column">
                            <h5>What Are Sigma Stars?</h5>
                        </div>

                    </div>

                    <div class="collapse" id="collapseExample2">
                        <div class="card card-body">
                            Sigma Stars are the Sigma Prime Program currency. Items can be purchased/redeemed from selected vendors with Sigma Stars.
                        </div>
                    </div>

                </div>
                <div class="faq-body">
                    <div class="row">
                        <div class="col-2 col-md-1 faq-special-column">
                            <a data-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
                                <img class="faqicons" src="{{asset('images/home-images/faqicon.svg')}}" />
                            </a>

                        </div>
                        <div class="col-10 col-md-11 faq-special-column">
                            <h5>Do I Have To Be Resident In Nigeria To Benefit From This Program?</h5>
                        </div>

                    </div>

                    <div class="collapse" id="collapseExample4">
                        <div class="card card-body">
                            You can order items from anywhere in the world and have the items delivered to your Nigerian address.
                        </div>
                    </div>

                </div>
{{--                <div class="small-screen-margin">--}}
{{--                    <a href="#">--}}

{{--                        View All &nbsp;&nbsp;--}}
{{--                        <i class="fa fa-arrow-right" aria-hidden="true"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}


            </div>
            <div class="col-12 col-md-5 second-faq">
                <div class="faq-img-container">
                    <img src="{{asset('images/home-images/faqimg.png')}}"  width="100%"/>
                </div>

            </div>
        </div>
    </div>
    <!-- Contact Us -->
    <div class="contact-us-container" id="contact">
        <div class="row">
            <div class="col-12 col-md-6 first-contact">
                <h1>Contact Us</h1>
                <p>Let us know how we can help</p>
                <p>Complete the form below and we will be in touch</p>
                <form class="contact-forms">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <!-- <label for="firstname">First Name</label> -->
                                <input type="text" class="form-control"  placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <!-- <label for="lastname">Last Name</label> -->
                                <input type="text" class="form-control" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <!-- <label for="firstname">First Name</label> -->
                                <input type="email" class="form-control"  placeholder="Email Address">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <!-- <label for="lastname">Last Name</label> -->
                                <input type="number" class="form-control" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <!-- <label for="subject">Subject</label> -->
                                <input type="text" class="form-control"  placeholder="Subject">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <!-- <label for="lastname">Last Name</label> -->
                                <textarea type="text" class="form-control" placeholder="Message"></textarea>
                            </div>
                        </div>
                    </div>


                    <button style="border-radius: 0px;" type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
            <div class="col-12 col-md-6 second-contact">
                <div class="contact-us-details">
                    <p>OR CALL US NOW</p>
                    <h4>Landline: 09-4613333</h4>
                    <h4>Phone</h4>
                    <h4>North(07055790298),</h4>
                    <h4>West(09055194351),</h4>
                    <h4>East(09055194359)</h4>
                    <p>Get in touch with us today</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/sigma-animate.css')}}">
@endpush
