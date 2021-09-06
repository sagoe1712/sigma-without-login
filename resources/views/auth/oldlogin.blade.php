@extends('layout.master')

@section('content')


    <!-- Body main wrapper start -->
    <div class="wrapper fixed__footer">
        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">

        @include('partials.searchpopup')
        @include('partials.offsetmenu')
        @include('partials.cart')
        <!-- Start Cart Panel -->
        @include('partials.side-shopping-cart')
        <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->

        <!-- End Bradcaump area -->
        <!-- Start Login Register Area -->
        <div class="htc__login__register bg__white ptb--130" style="background: rgba(0, 0, 0, 0) url({{asset('assets/images/bg/5.jpg')}}) no-repeat scroll center center / cover ;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <ul class="login__register__menu" role="tablist">
                            <li role="presentation" class="login active"><a href="#login" role="tab" data-toggle="tab">Login</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Start Login Register Content -->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="htc__login__register__wrap">
                            <!-- Start Single Content -->
                            <div id="login" role="tabpanel" class="single__tabs__panel tab-pane fade in active">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <form class="login" role="form" method="POST" action="{{ url('/login') }}">
                                    {{ csrf_field() }}
                                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">
                                    <input type="password" placeholder="Password*" name="password">
                                    <input type="text" name="company_id" value="{{config('app.id')}}" hidden>

                                    <div class="tabs__checkbox pull-left">
                                        <input type="checkbox" name="remember">
                                        <span> Remember me</span>
                                        <span class="forget"><a href="{{ url('/password/reset') }}">Forget Pasword?</a></span>
                                    </div>

                                    <div class="contact-btn htc__login__btn">
                                        <button type="submit" class="fv-btn">LOGIN</button>
                                    </div>
                                </form>
                            </div>
                            <!-- End Single Content -->
                        </div>
                    </div>
                </div>
                <!-- End Login Register Content -->
            </div>
        </div>
        <!-- End Login Register Area -->
        <!-- Start Footer Area -->
    @include('partials.footer')
    <!-- End Footer Area -->
    </div>
    <!-- Body main wrapper end -->
    <!-- QUICKVIEW PRODUCT -->
    <div id="quickview-wrapper">
        <!-- Modal -->
    @include('partials.modal')
    <!-- END Modal -->
    </div>
@endsection
