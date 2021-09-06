@extends('layouts.main')
@section('content')

    <div id="tt-pageContent">
        <div class="wish-list-bg">
            <div class="centered">
                <h5>PROFILE</h5>
            </div>
            <img class="wish-list-img" src="{{asset('images/profile-images/profiletopbg.png')}}" width="100%" />
        </div>
        <!-- Profile Div -->
        <div class="sigma-profile">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="profilebgImg">
                        <div>
                            <h5 class="profile-text">MY PROFILE</h5>
                            <h5>Hi {{ucwords(Auth::user()->firstname)}},</h5>
                            <p>Member ID: {{Auth::user()->member_id}}</p>
                            <div class="middle-contents">
                                <p>Current Balance:</p>
                                <h3 class="bold-text">{{ number_format( Auth::user()->currency->rate * (isset(Auth::user()->point->point) ? Auth::user()->point->point : 0 ) ) }}</h3>
                                <h5>{{Auth::user()->currency->currency}}</h5>
                            </div>
                            <a href="{{url('statement')}}">
                                <p>View My Statement &nbsp; <i class="fa fa-arrow-right" aria-hidden="true"></i></p>
                            </a>



                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <form  novalidate="novalidate" action="{{route('update_member_profile')}}" method="post">
                        {{csrf_field()}}
                    <div class="edit-profile-container">
                        <h4 class="bold-text">Edit Profile</h4>
                        <p class="black-text">You can view and edit your biodata here</p>
                        <div class="edit-profile">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">First name:</label>
                                        <input type="text" class="form-control" value="{{ucwords(Auth::user()->firstname)}}" name="firstname">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">Last name:</label>
                                        <input type="text" class="form-control" value="{{ucwords(Auth::user()->lastname)}}" name="lastname">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">Phone Number:</label>
                                        <input type="number" class="form-control" id="usr" value="{{Auth::user()->phone}}" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname">Email:</label>
                                        <input type="email" class="form-control" id="usr" value="{{Auth::user()->email}}" name="email" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="firstname">Address:</label>
                                        <textarea class="form-control" id="usr" name="address">@php echo trim(Auth::user()->address); @endphp</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit" class="btn btn-default address-button">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="profile-security-container">
                        <h5 class="bold-text">Security</h5>
                        <p class="black-text">Manage your security and privacy settings here.</p>
                        <div>
                            <img src="{{asset('images/profile-images/lock.png')}}" width="60%" />
                        </div>
                        <p class="black-text bold-text">Update your password</p>
                        <p class="black-text" >Ensure you know your current password before attemption to change
                            to a new password
                        </p>
                        <a href="{{url('security/change_password')}}" class="btn btn-default login-btn modal-cart-btn">
                            Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Load more button -->






    </div>



    @endsection