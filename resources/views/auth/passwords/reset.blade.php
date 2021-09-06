

@extends('layouts.landing')

@section('content')

    <!--body content start-->

    <div class="forgot-pass-container">

        <div class="main">
            <div class="account-login container">
                <!--page-title-->
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="login-img">
                            <img class="password-img" src="{{asset('images/login-images/img2.png')}}" alt="login" />
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="login-card">
                            <div class="flex-contents">
                                <h4>
                                    Forgot Password?
                                </h4>
                            </div>
                            <form id="reset-form" method="POST" action="{{url('reset_password_with_token')}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="token" value="{{$token}}">
                                <input type="hidden" name="company_id" value="{{config('app.id')}}">
                                <input type="hidden" name="email" value="{{$email}}">


                                <div class="messages">
                                    @if ($errors->has('email'))
                                        <div class="alert alert-warning alert-dismissible fade show">
                                            <strong>{{$errors->first('email')}}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group {{$errors->has('email') ? ' has-error' : ''}}">
                                    <label for="email" class="control-label">E-Mail Address</label>

                                    <div class="">
                                        <input id="email" type="email" class="form-control" name="email" value="{{$email or old('email') }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Password</label>

                                    <div class="">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password-confirm" class="control-label">Confirm Password</label>
                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="">
                                        <button type="submit" class="btn btn-primary btn-block custom_button_color">
                                            <i class="fa fa-btn fa-refresh"></i> Reset Password
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>


            </div> <!--account-login-->

        </div><!--main-container-->

    </div>


@endsection