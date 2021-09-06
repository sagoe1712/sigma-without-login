
@extends('layouts.landing')

@section('content')
    <div class="main-login-bg">

        <div class="main">
            <div class="account-login container">
                <!--page-title-->
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="login-img">
                            <img class="login-img" src="{{asset('images/login-images/img.png')}}" alt="login" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="login-card">
                            <div class="flex-container">
                                <img src="{{asset('images/login-images/logo_color.svg')}}" width="40%" alt="logo" />
                            </div>
                            <br/>
                           @if ($errors->has('email'))
                                <div class="alert alert-danger">
                                    @if($errors->first('email') == "Sorry, that password isn't right")

                                        {{ $errors->first('email') }}. <a href="{{url('password/reset')}}">Click  here to reset password</a>

                                    @else
                                        {{ $errors->first('email') }}. <a href="{{url('username/reset')}}">Click here to retrieve username</a>
                                    @endif

                                    {{--                                    {{ $errors->first('email') }}--}}
                                </div>
                            @endif
                            @if ($errors->has('password'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif

                            <form class="form-horizontal marginal-top" method="POST" action="{{ url('/login') }}">
                                {{ csrf_field() }}
                                <input type="text" name="company_id" value="{{config('app.id')}}" hidden>
                                <input type="text" name="status" value="1" hidden>

                                <div class="messages"></div>

                                <div class="form-group">
                                    <div class="">
                                        <input type="text" class="form-control" name="email" placeholder="Email address" required="required" data-error="Email is required." value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="">
                                        <input id="password-field" type="password"
                                               placeholder="Password"
                                               class="form-control" name="password" class="form-control" placeholder="Password" required="required" data-error="Password is required.">
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-5 text-left">Remember me</div>
                                        <div class="col-2 text-left">
                                            <span class="text-left"><input type="checkbox" class="form-control" name="remember"  value="true"></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="login-contents">
                                    <p><a href="{{ url('/password/reset') }}">
                                            Forgot Password?
                                        </a></p>
                                    <button type="submit" class="btn btn-default login-btn">Sign In</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>


            </div> <!--account-login-->

        </div><!--main-container-->

    </div>


    @endsection
