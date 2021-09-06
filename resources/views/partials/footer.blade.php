<footer id="footer" class="footer color-bg">
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="address-block">
                        <div class="module-body">
                            <ul class="toggle-footer" style="">
                                <li class="media">
                                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body">
                                        <p><address> Ground Floor and First Floor, Oakland Centre 48 Aguiyi Ironsi street, Maitama, Abuja.
                                        </address></p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i class="fa fa-mobile fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body">
                                        <p> 09-4613333</p>
                                        <p> 09055194352</p>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i class="fa fa-envelope fa-stack-1x fa-inverse"></i> </span> </div>
                                    <div class="media-body"> <span><a href="{{url('contact')}}">sigmaprime@sigmapensions.com</a></span> </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Quick Links</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first">
                            <a href="{{url('catalogue')}}">Catalogue</a>
                            </li>
                            <li>
                                <a href="{{url('fuel_vouchers')}}">Fuel Vouchers</a>
                            </li>
                            <li>
                                <a href="{{url('cinemas')}}">Cinemas</a>
                            </li>
                            <li>
                                <a href="{{url('events')}}">Events</a>
                            </li>
                            <li>
                                <a href="{{url('bills')}}">Airtime & Bills</a>
                            </li>
                            <li class="last">
                                <a href="{{url('meals')}}">Meals</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Other Links</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first">
                            <a href="{{url('profile')}}" title="profile" alt="profile">Profile</a>
                            </li>
                            <li>
                                <a href="{{url('cart')}}" title="cart" alt="cart">Cart</a>
                            </li>
                            <li>
                                <a href="{{url('orders')}}" title="orders" alt="orders">Orders</a>
                            </li>
                            <li>
                                <a href="{{url('statement')}}" title="transactions" alt="transactions">Statement</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Why Choose Us</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first">
                                <a href="{{url('contact')}}" title="contact" alt="contact">Contact</a>
                            </li>
                            <li>
                                <a href="{{url('/')}}/#about" title="about us" alt="about">About us</a>
                            </li>
                            <li class="last">
                                <a href="{{url('/')}}/#faqs" title="FAQ" alt="FAQ">FAQs</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="container copyright-bar">
    <div class="row" style="padding: 20px 0;text-align: center">
        <div class="col-sm-4 col-xs-12">
            <a href="https://www.facebook.com/sigmapensions" target="_blank"><i class="fa fa-facebook" style="font-size: 20px; color: #3b5998; padding: 10px;"></i></a>
            <a href="https://www.twitter.com/sigmapensions" target="_blank"><i class="fa fa-twitter" style="font-size: 20px; color: #38A1F3; padding: 10px;"></i></a>
            <a href="https://www.linkedin.com/company/sigma-pensions-ltd" target="_blank"><i class="fa fa-linkedin" style="font-size: 20px; color: #007bb5; padding: 10px;"></i></a>
            <a href="https://www.instagram.com/sigmapensions" target="_blank"><i class="fa fa-instagram" style="font-size: 20px; color: #c32aa3; padding: 10px;"></i></a>
        </div>

        <div class="col-sm-4 col-xs-12">

        </div>

        <div class="col-sm-4 col-xs-12"  style="color:#ececec;padding: 10px; text-align: center">
            &copy; 2019 - {{date('Y')}} <a href="{{url('/')}}">{{config('app.name')}}</a> | All Rights Reserved
        </div>
    </div>
    </div>
</footer>