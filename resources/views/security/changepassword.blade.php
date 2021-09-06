@extends('layouts.main')
@section('content')

    <div class="body-content">
        <div class="container">
            <div class="sign-in-page" style="margin: 60px auto">
                <div class="row">
                    <div class="col-md-4 offset-md-4">
                        <div class="row">
                        <div class="col-md-12 text-center">
                        <h3 class="font-weight-bold">Change password</h3>
                        </div>
                        </div>
                        <div class="contact-form" style="padding: 10px 20px;">
                            <div role="form" class="wpcf7" id="wpcf7-f425-o1" lang="en-US" dir="ltr">
                                <div class="screen-reader-response">
                                   @if(isset($info))

                                       @endif
                                        @if (count($errors) > 0)
                                            <div class="alert alert-info">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                </div>
                                <form class="wpcf7-form" novalidate="novalidate" action="{{route('change_password_action')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label>Current password
                                                <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <br>
                                            <span>
                                                <input type="password" aria-invalid="false" aria-required="true" class="form-control unicase-form-control text-input" size="40" name="old_password">
                                            </span>
                                        </div>
                                        </div>

                                    <div class="form-group row">
                                    <div class="col-md-12">
                                            <label>New password
                                                <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <br>
                                            <span>
                                                <input type="password" aria-invalid="false" aria-required="true" class="form-control unicase-form-control text-input" size="40" name="password">
                                            </span>
                                        </div>
                                        </div>

                                    <div class="form-group row">
                                    <div class="col-md-12">
                                            <label>Confirm New password
                                                <abbr title="required" class="required">*</abbr>
                                            </label>
                                            <br>
                                            <span class="wpcf7-form-control-wrap firstname">
                                                <input type="password" aria-invalid="false" aria-required="true" class="form-control unicase-form-control text-input" size="40" name="password_confirmation">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 w-100">
                                            <input type="submit" value="Update" class="btn btn-primary pull-right form-control custom_button_color">
                                        </div>
                                    </div>
                                </form>
                                <!-- .wpcf7-form -->
                            </div>
                            <!-- .wpcf7 -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection