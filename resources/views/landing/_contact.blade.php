<section class="contact-1" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 mr-auto">
                <div class="section-title">
                    <div class="title-effect">
                        <div class="bar bar-top"></div>
                        <div class="bar bar-right"></div>
                        <div class="bar bar-bottom"></div>
                        <div class="bar bar-left"></div>
                    </div>
                    <h6>Get In Touch</h6>

                    <h2>Contact Us</h2>
                    <p>Let us know how we can help. <br>Complete the form below and we’ll be in touch.</p>
                    @if(session()->has('success'))
                        <div class="alert alert-success mt-4">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="alert alert-danger mt-4">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="contact-form" method="post" action="{{url('contact')}}">
                    {!! @csrf_field() !!}
                    <input type="hidden" id="cpkt" name="cpkt">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input id="form_name" type="text" name="firstname" class="form-control" placeholder="First name" required="required" data-error="Firstname is required.">
                                <div class="help-block with-errors">
                                    <span class="firstname"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input id="form_lastname" type="text" name="lastname" class="form-control" placeholder="Last name" required="required" data-error="Lastname is required.">
                                <div class="help-block with-errors">
                                    <span class="lastname"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input id="form_email" type="email" name="email" class="form-control" placeholder="Email" required="required" data-error="A Valid email is required.">
                                <div class="help-block with-errors">
                                    <span class="email"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Phone number" required="required" data-error="Phone is required">
                                <div class="help-block with-errors">
                                    <span class="phone"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" name="subject" class="form-control" placeholder="Subject" required="required" data-error="Subject is required">
                                <div class="help-block with-errors">
                                    <span class="subject"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Message</label>
                                <textarea id="form_message" name="message" class="form-control" placeholder="Type Message" rows="4" required="required" data-error="Please,leave us a message."></textarea>
                                <div class="help-block with-errors">
                                    <span class="message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <button class="btn btn-theme btn-circle" data-text="Send Message"><span>S</span><span>e</span><span>n</span><span>d</span>
                                <span> </span><span>M</span><span>e</span><span>s</span><span>s</span><span>a</span><span>g</span><span>e</span>
                            </button>
                            <p id="contact_notification" class="off"><i class="fa fa-spinner fa-spin process_indicator"></i> Sending...</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>