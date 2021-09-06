@extends('layouts.landing')
@section('content')
    <div class="page-content">
        <div class='container' style="margin-top: 100px;">
            <div class="row justify-content-center">
                <div class="col-sm-10">
                    <section class="z-index-1" id="faqs">
                        <div class="container">
                            <div class="row text-center">
                                <div class="col-lg-8 col-md-12 ml-auto mr-auto">
                                    <div class="section-title">
                                        <div class="title-effect">
                                            <div class="bar bar-top"></div>
                                            <div class="bar bar-right"></div>
                                            <div class="bar bar-bottom"></div>
                                            <div class="bar bar-left"></div>
                                        </div>
                                        <h6>FAQs</h6>
                                        <h2 class="title">Frequently asked questions</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ml-auto">
                                    <div id="accordion" class="accordion style-1">
                                        <div class="card active">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true">What is the Sigma Pensions “Sigma Prime” Rewards Program?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse1" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">The Sigma Prime Rewards Program is our way of thanking you for your continued patronage and for trusting us with your future.</div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Do I have to pay before I can participate in the rewards program?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse2" class="collapse" data-parent="#accordion">
                                                <div class="card-body">No, Your Retirement Savings Account automatically qualifies you for the Program.</div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">What are Sigma Stars?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse3" class="collapse" data-parent="#accordion">
                                                <div class="card-body">Sigma Stars are the Sigma Prime Program currency. Items can be purchased/redeemed from selected vendors with Sigma Stars.</div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Do I have to be resident in Nigeria to benefit from this program?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse4" class="collapse" data-parent="#accordion">
                                                <div class="card-body">You can order items from anywhere in the world and have the items delivered to your Nigerian address.</div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">What is the process for accumulating Sigma Stars?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse5" class="collapse" data-parent="#accordion">
                                                <div class="card-body">Sigma Stars are assigned based on your RSA balance. Stars accumulate as your RSA balance increases.</div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">How do I redeem my Sigma Stars?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse6" class="collapse" data-parent="#accordion">
                                                <div class="card-body">Visit any of the specified vendors (online and offline) to enjoy benefit of choice.</div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse7">How do I receive the item selected from SIGMA PRIME?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse7" class="collapse" data-parent="#accordion">
                                                <div class="card-body">You can receive your item(s) in two ways:
                                                    <ol>
                                                        <li>Pick up from the partner location</li>
                                                        <li>Delivery to your preferred location</li>
                                                    </ol>
                                                    <div>
                                                        <p>
                                                            To pick up at a partner location: After confirmation of your selected item, you would be issued an E-voucher containing a unique code, and instructions on how and where to pick up your item. At the partner location, your voucher would be verified, and once verified, the item will be handed to you. *E-vouchers are valid for only 15 days.
                                                        </p>
                                                        <p>
                                                            To have it delivered: You can provide details of a current mailing address where the selected item would be delivered. The selected item would be delivered to your specified address within 15 working days.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse8">Can I change the username and password given to me?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse8" class="collapse" data-parent="#accordion">
                                                <div class="card-body"><p>Yes, you can change your Password and Username.</p>
                                                    <div class="alert-danger p-1">Please do not disclose your Username and Password to anyone.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse9">What do I do if I forget my password?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse9" class="collapse" data-parent="#accordion">
                                                <div class="card-body"><p>You fill out our online <a href="{{url('resetpassword')}}">“forgot password”</a> help form, and your Password and Username will be sent to you via email.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse10">How would I know my Sigma Star Points balance?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse10" class="collapse" data-parent="#accordion">
                                                <div class="card-body">You can view your Sigma star Points balance from the account statement in your Sigma Prime account.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse11">Can my spouse also register?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse11" class="collapse" data-parent="#accordion">
                                                <div class="card-body">No, the Program is only restricted to Sigma Pensions customers.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse12">How long can I keep my Sigma star Points?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse12" class="collapse" data-parent="#accordion">
                                                <div class="card-body">Your Sigma stars are valid for the period of 1 year, points cannot be rolled over from previous year. New points are allocated annually based on the growth of your RSA balance.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse13">What is the Naira value of Sigma Star Points?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse13" class="collapse" data-parent="#accordion">
                                                <div class="card-body">Sigma Stars cannot be converted to naira; they can only be redeemed for benefits listed on the Sigma Prime platform.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse14">Can I exchange Sigma Star Points for cash?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse14" class="collapse" data-parent="#accordion">
                                                <div class="card-body">No, Sigma Stars cannot be exchanged for cash.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse15">When can I start redeeming?</a>
                                                </h6>
                                            </div>
                                            <div id="collapse15" class="collapse" data-parent="#accordion">
                                                <div class="card-body">You can start redeeming your Sigma Points and enjoy benefits once your Sigma Prime account is activated.</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
@endsection