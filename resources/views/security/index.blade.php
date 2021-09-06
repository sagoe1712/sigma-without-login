@extends('layouts.main')
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class='active'>Security</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>
    <div class="body-content">
        <div class="container">
            <div class="sign-in-page" style="margin: 20px auto">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 40px">
                        <h3>Security</h3>
                        <p>Manage your security and privacy settings here.</p>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="panel panel-default">
                                <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <strong>Update your password.</strong> <br>
                                        Ensure you know your current password before attempting to change your current password.
                                    </div>   
                                    <div class="col-md-4 text-center">
                                        <img src="{{asset('images/icon/locked.svg')}}" alt="" width="60px">
                                     </div>
                                </div>
                                 </div>
                            <a href="{{url('security/change_password')}}">
                            <div class="panel-footer">
                                <a href="{{url('security/change_password')}}">Change password</a>
                            </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <strong>Manage your profile data.</strong> <br>
                                        View and update your profile data. Only certain fields are editable. If you have issues here, contact us.
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img src="{{asset('images/icon/user.svg')}}" alt="" width="60px">
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('security/profile')}}">
                            <div class="panel-footer">
                                <a href="{{url('security/profile')}}">Manage profile</a>
                            </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('style')
    <style>
        .panel-footer{
            background: #2772FF;
            color: #fff !important;
            padding: 15px;
        }
        .panel-footer a{
            color: #fff !important;
        }
        .panel-default{
            border-color: #2772FF;
            padding: 20px 0px 0px;
        }
    </style>
    @endpush