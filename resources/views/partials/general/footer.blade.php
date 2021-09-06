
<footer>
    <!-- BEGIN INFORMATIVE FOOTER -->
    <div class="footer-inner">
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-column">
                            <h4>Sigma Pension</h4>
                            <p>
                                Sigma Pensions is one of the leading Pension Fund Administrators (PFA)
                                in Nigeria. For over a decade, Sigma Pensions has been
                                dedicated to providing exceptional value to our stakeholders through the delivery of pension administrative services.
                            </p>
                        </div>
                        <div class="social">
                            <ul>
                                <li class="fb"><a href="https://www.facebook.com/sigmapensions" target="_blank"></a></li>
                                <li class="tw"><a  href="https://www.twitter.com/sigmapensions" target="_blank"></a></li>
                                <li class="linkedin"><a href="https://www.linkedin.com/company/sigma-pensions-ltd" target="_blank"></a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="footer-column">
                            <h4>Quick Links</h4>
                            <ul class="links">
                                <li><a href="{{url('home/#aboutus')}}" title="About Us">About Us</a></li>
                                <li><a href="{{url('catalogue')}}" title="Shops">Shop</a></li>
                                <li><a href="{{url('home/#aboutus')}}" title="Features">Features</a></li>
                                @if (!Auth::guest())
                                <li><a href="{{url('terms')}}" title="Privacy Policy">Privacy Policy</a></li>
                                <li><a href="{{url('returns')}}" title="Return Policy">Return Policy</a></li>
                                @endif
                                <li><a href="{{url('home/#faqs')}}" title="FAQS">FAQs</a></li>
                                <li><a href="{{url('home/#contact')}}" title="Contact Us">Contact Us</a></li>
{{--                                <li><a href="#" title="Order Tracking">Language</a></li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="footer-column">
                            <h4>Catalog</h4>
                            <ul class="links">
                                <li><a href="{{url('catalogue')}}" title="">Shop</a></li>
{{--                                <li><a href="#" title="Search Terms">Fuel Vouchers</a></li>--}}
                                <li><a href="{{url('cinemas')}}" title="Cinemas">Cinemas</a></li>
                                <li><a href="{{url('events')}}" title="Events">Events</a></li>
                                <li><a href="{{url('bills')}}" title="Airtime & Bills">Airtime &amp; Bills</a></li>
                                <li><a href="{{url('meals')}}" title="Meals">Meals</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="footer-column">
                            <h4>Contact Us</h4>
                            <p>Address: Ground Floor and 4th Floor, Oakland Centre. <br />48 Aguiyi Ironsi street, Maitama. Abuja</p>
                            <ul class="links">
                                <li>
                                    <a href="mailto:info@sigmapensions.com">
                                        <span><p>Email:</p></span>
                                        sigmaprime@sigmapensions.com</a></li>
                                <li>
                                    <a href="tel:094613333">
                                        <span><p>Landline:</p></span>
                                        09-4613333</a></li>
                                <li>
                                    <a href="tel:+2347055790298">
                                        <span><p>North:</p></span>(07055790298)</a></li>
                                <li>
                                    <a href="tel:+2349055194351">
                                        <span><p>West:</p></span> (09055194351)</a></li>
                                <li>
                                    <a href="tel:+2349055194359">
                                        <span><p>East:</p></span> (09055194359)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--container-->
    </div>
    <!--footer-inner-->

    <!--footer-middle-->
    <div class="footer-top footer-column-small">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 coppyright">
                    <img src="{{asset('images/login-images/logo_color.svg')}}" alt="logo" />
                    <p class="margin-down">
                        © {{date('Y')}} Sigma Prime | All Rights Reserved
                    </p>


                </div>
            </div>
        </div>
    </div>
    <!--footer-bottom-->
    <!-- BEGIN SIMPLE FOOTER -->
</footer>
