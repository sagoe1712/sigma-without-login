<header>
    <!-- tt-mobile menu -->
    <nav class="panel-menu mobile-main-menu">
        <ul>
            <li>
                <a href="{{url('catalogue')}}">Shop</a>
            </li>
            <li>
                <a href="">Experiences</a>
            </li>
            <li>
                <a href="#">Entertainment</a>
            </li>
            <li>
                <a href="#">Vouchers</a>
            </li>
            <li>
                <a href="#">Airtime</a>
            </li>
            <li>
                <a href="#">Meals</a>
            </li>
            <li>
                <a href="#">Discount</a>
            </li>
            <li><a href="#">Travel</a></li>
        </ul>
        <div class="mm-navbtn-names">
            <div class="mm-closebtn">Close</div>
            <div class="mm-backbtn">Back</div>
        </div>
    </nav>
    <!-- tt-mobile-header -->
    <div class="tt-mobile-header mobile-header-bg">
        <div class="container-fluid">
            <div class="tt-header-row">
                <div class="tt-mobile-parent-menu">
                    <div class="tt-menu-toggle">
                        <i class="icon-03"></i>
                    </div>
                </div>
                <!-- search -->
                <div class="tt-mobile-parent-search tt-parent-box"></div>
                <!-- /search -->
                <!-- cart -->
                <div class="tt-mobile-parent-cart tt-parent-box"></div>
                <!-- /cart -->
                <!-- account -->
                <div class="tt-mobile-parent-account tt-parent-box"></div>
                <!-- /account -->
                <!-- currency -->
                <div class="tt-mobile-parent-multi tt-parent-box"></div>
                <!-- /currency -->
            </div>
        </div>
    </div>
    <!-- tt-desktop-header -->
    <div class="tt-desktop-header login-header-background">
        <div class="container header-container">
            <div class="tt-header-holder">
                <div class="tt-col-obj tt-obj-logo">
                    <!-- logo -->
                    <a class="tt-logo tt-logo-alignment" href="{{url('/')}}"><img class="homelogoimg" src="{{asset('images/home-images/logo white.svg')}}" alt=""></a>
                    <!-- /logo -->
                </div>
                <div class="tt-col-obj tt-obj-menu">
                    <!-- tt-menu -->
                    <div class="tt-desctop-parent-menu tt-parent-box">
                        <div class="tt-desctop-menu">
                            <nav>
                                <ul>
                                    <li class="dropdown tt-megamenu-col-02 selected">
                                        <a class="catalog-nav-link" href="{{url('catalogue')}}">Shop</a>
                                    </li>
                                    <li class="dropdown tt-megamenu-col-01">
                                        <a class="catalog-nav-link" href="{{url('experiences')}}">Experiences</a>
                                    </li>
                                    <li class="dropdown tt-megamenu-col-01">
                                        <a class="catalog-nav-link" href="#">Entertainment <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                        <div class="dropdown-content">
                                            <a href="{{url('cinemas')}}">Cinema</a>
                                            <a href="{{url('events')}}">Events</a>
                                        </div>
                                    </li>
                                    <li class="dropdown tt-megamenu-col-01">
                                        <a class="catalog-nav-link" href="#">Vouchers <i class="fa fa-caret-down" aria-hidden="true"></i></a>
 <div class="dropdown-content">
                                            <a href="{{url('uber_vouchers')}}">Uber Vouchers</a>
                                        </div>
                                    </li>
                                    <li class="dropdown tt-megamenu-col-01">
                                        <a class="catalog-nav-link" href="{{url('bills')}}">Airtime & Bills</a>
                                    </li>

                                    <li class="dropdown tt-megamenu-col-01">
                                        <a class="catalog-nav-link" href="#">Meals <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                             <div class="dropdown-content">
                                        <a href="{{url('meals')}}">Dine In</a>
                                        <a href="{{url('food')}}">Takeout</a>
                                        </div>
                                    </li>
                                    <li class="dropdown tt-megamenu-col-01">
                                        <a class="catalog-nav-link" href="{{url('outdiscount')}}">Discount</a>
                                    </li>
                                    <li class="dropdown tt-megamenu-col-01">
                                        <a class="catalog-nav-link" href="{{url('flight')}}">Travel</a>
                                    </li>
                                    @if (!Auth::guest())
                                        <li class="dropdown tt-megamenu-col-01">
                                            <a class="catalog-nav-link" href="#">More <i class="fa fa-caret-down" aria-hidden="true"></i></a>
{{--                                            <div class="dropdown-menu">--}}
{{--                                                <div class="row tt-col-list">--}}
{{--                                                    <div class="col">--}}
{{--                                                        <ul class="tt-megamenu-submenu">--}}
{{--                                                            <li><a href="{{url('profile')}}">Profile</a></li>--}}
{{--                                                            <li><a href="{{url('statement')}}">Statement</a></li>--}}
{{--                                                            <li><a href="{{url('orders')}}">Orders</a></li>--}}
{{--                                                        </ul>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="dropdown-content">
                                        <a href="{{url('profile')}}">Profile</a>
                                        <a href="{{url('statement')}}">Statement</a>
                                        <a href="{{url('orders')}}">Orders</a>
                                            </div>

                                        <li class="dropdown login-anchor">
                                            <a href="{{url('logout')}}" class="btn btn-default home-login-btn padding20">Log Out</a>

                                        </li>
                                        @else

                                    <li class="dropdown login-anchor">
                                        <a href="{{url('login')}}" class="btn btn-default home-login-btn padding20">Login</a>

                                    </li>
                                        @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- /tt-menu -->
                </div>
            </div>
        </div>

    </div>
    <!-- stuck nav -->
    <div class="tt-stuck-nav struck-background">
        <div class="container">
            <div class="tt-header-row ">
                <div class="tt-stuck-parent-menu"></div>
                <div class="tt-stuck-parent-search tt-parent-box"></div>
                <div class="tt-stuck-parent-cart tt-parent-box"></div>
                <div class="tt-stuck-parent-account tt-parent-box"></div>
                <div class="tt-stuck-parent-multi tt-parent-box"></div>
            </div>
        </div>
    </div>
</header>
