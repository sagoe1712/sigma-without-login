
@extends('layouts.landing')

@section('content')

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
                            <form class="form-horizontal marginal-top" method="POST" action="{{ url('reset_password_without_token') }}">
                                {{ csrf_field() }}
                                <input type="text" name="company_id" value="{{config('app.id')}}" hidden>
                                <div class="messages">
                                    @if ($errors->has('email'))
                                        <div class="alert alert-warning alert-dismissible fade show">
                                            <strong>{{ $errors->first('email') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    @if ($errors->has('done'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <strong>{{ $errors->first('done') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="">
                                        <input type="email" name="email" class="form-control" placeholder="Email Address" required="required" data-error="Email Address is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="login-contents">
                                    <button type="submit" class="btn btn-default login-btn">Send Password Link</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>


            </div> <!--account-login-->

        </div><!--main-container-->

    </div>
@endsection