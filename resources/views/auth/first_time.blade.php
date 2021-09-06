@extends('layouts.landing-nonav')

@section('content')

    <!--body content start-->

    <header>
        <!-- tt-mobile menu -->
        <nav class="panel-menu mobile-main-menu">
            <ul>
                <li>
                    <a href="{{url('logout')}}">Log Out</a>
                </li>

            </ul>
{{--            <div class="mm-navbtn-names">--}}
{{--                <div class="mm-closebtn">Close</div>--}}
{{--                <div class="mm-backbtn">Back</div>--}}
{{--            </div>--}}
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
        <div class="tt-desktop-header login-header-background4">
            <div class="container header-container">
                <div class="tt-header-holder">
                    <div class="tt-col-obj tt-obj-logo">
                        <!-- logo -->
                        <a class="tt-logo tt-logo-alignment" href="{{url('/')}}"><img class="homelogoimg" src="{{asset('images/home-images/logo_white.svg')}}" alt=""></a>
                        <!-- /logo -->
                    </div>
                    <div class="tt-col-obj tt-obj-menu text-right">
                        <!-- tt-menu -->
                        <div class="tt-desctop-parent-menu tt-parent-box">
                            <div class="tt-desctop-menu">
                                <nav>
                                    <ul>
                                        <li class="dropdown login-anchor">
                                            <a style="padding: 20px 30px;" class="btn btn-default home-login-btn" href="{{url('logout')}}">Log Out</a>

                                        </li>
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
        <div style="visibility: hidden;" class="tt-stuck-nav struck-background">

        </div>
    </header>

    <!-- BEGIN Main Container -->

    <div class="first-login-container">

        <div class="main">
            <div class="account-login container">
                <!--page-title-->
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="login-img">
                            <img class="password-img" src="{{asset('images/login-images/first-time-img.png')}}" alt="login" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div style="padding: 4%;" class="login-card">
                            <div class="flex-contents">
                                <h4>
                                    First Time Login
                                </h4>
                            </div>
                            <form id="frmfirsttime" class="form-horizontal" method="post" action="{{url('firsttimelogin')}}">

                                {!! csrf_field() !!}

                                <div class="form-group">
                                    <div class="">
                                        <input type="email" id="email" class="form-control" name="email" placeholder="Email Address" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="New Password" value="">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="">
                                        <input type="password" class="form-control" name="confirm_password" id="conpassword" placeholder="Confirm Password" value="">

                                    </div>
                                </div>
                                <div>
                                    <p class="terms-text">Kindly indicate your acceptance of the Sigma Prime Terms & Conditions by clicking on the button below</p>
                                </div>
                                <div class="checkbox-container">
                                    <input type="checkbox" id="terms" name="terms" value="terms" />
                                    <label class="check-label" for="vehicle1"> I agree to the Sigma Prime <a class="anchor-blue" href="{{url('blank_terms')}}" target="_blank">TERMS & CONDITIONS</a></label>
                                </div>
                                <div class="login-contents">
                                    <button class="btn btn-default login-btn" id="btn-submit">Continue</button>
                                </div>


                            </form>
                        </div>
                    </div>

                </div>


            </div> <!--account-login-->

        </div><!--main-container-->

    </div> <!--col1-layout-->


    <div class="modal" id="termspopup" role="dialog">
        <div class="modal-dialog" role="document" style="background: transparent;">
            <div class="modal-content" style="background: transparent;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="background: transparent;">
                <img src="{{asset('images/login-images/popup.png')}}" alt="Welcome Message" style="max-width: 100%;"/>
                </div>
                <div class="modal-footer" style="display: block;">
                    <button id="btn-popclose" style="background: #45A6C4; color: #fff; border: none; padding: 15px 25px; border-radius: 5px; position: absolute; margin-left: -45px; margin-top: -19%;">Close</button>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        // alert("jqueery works")
        $('#termspopup').modal('show');
        $(document).on('click','#btn-popclose', function(e) {
            $('#termspopup').modal('hide');
        })
        $(document).on('click','#btn-submit', function(e) {
            e.preventDefault();
            if($('#terms').is(':checked')){
                // $("#frmfirsttime").submit();
                if($('#email').val() == ""){
                    swal("",'Kindly Enter Your Email', "error");
                }else if($('#password').val() == ""){
                    swal("",'Kindly Enter New Password', "error");
                }else if($('#conpassword').val().length < 5){
                    swal("",'Password Cannot be Less Than 6 Characters', "error");
                }else if($('#conpassword').val() == ""){
                    swal("",'Kindly Confirm New Password', "error");
                }else if($('#password').val() != $('#conpassword').val()){
                    swal("",'Confirm Password Mismatch', "error");
                }else{
                    $("#frmfirsttime").submit();
                }

            }else{
                swal("",'Kindly Check The I agree Terms & Conditions Checkbox', "error");
            }
        });
    </script>
@endpush