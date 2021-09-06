<div class="modal fade" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="booking_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header custom_bg_color_2">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;color: #fff"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <div class="experience_modal_details">
                    <div class="image">
                    </div>
                    <div class="details">
                        <h4 class="text-left">
                            @if(isset($product->data->name))
                                {{$product->data->name}}
                            @endif
                        </h4>
                        <p class="text-left">
                            <span><strong>Start time:</strong></span> <span class="start_time"></span>
                        </p>
                        <p class="text-left">
                            <span><strong>End time:</strong></span> <span class="end_time"></span>
                        </p>
                    </div>
                </div>
                <div class="experience_modal_price_options">
                    <div class="form1">
                        <h4>Price options</h4>
                        <div class="price_options">

                        </div>
                    </div>
                    <div class="row form2 noshow">
                        <div class="loader form2_loader off"></div>
                        <div class="sendformdiv noshow row">
                            <h4>Fill the forms below to complete booking.</h4>

                            <div class="panel-group forms_container col-sm-6" id="accordion" role="tablist" aria-multiselectable="true">

                            </div>

                            <div class="col-sm-6 other_forms">
                                <div class='panel panel-default'>
                                    <div class='panel-heading'>
                                        <h5 class='panel-title text-left'>Booking details (Required)</h5>
                                    </div>
                                    <div class="per_booking_form panel-body row">

                                    </div>
                                </div>
                                <div class='panel panel-default'>
                                    <div class='panel-heading'>
                                        <h5 class='panel-title text-left'>Customer details (Required)</h5>
                                    </div>
                                    <div class="customer_details_form panel-body row">
                                        <div class="form-group col-sm-6">
                                            <span class='label label-danger off'>Required</span>
                                            <label for="customer_firstname">First Name (Required)</label>
                                            <input type="text" class="form-control" name="customer_firstname">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <span class='label label-danger off'>Required</span>
                                            <label for="customer_lastname">Last Name (Required)</label>
                                            <input type="text" class="form-control" name="customer_lastname">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <span class='label label-danger off'>Required</span>
                                            <label for="customer_email">Email (Required)</label>
                                            <input type="email" class="form-control" name="customer_email">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <span class='label label-danger off'>Required</span>
                                            <label for="customer_phone_no">Phone (Required)</label>
                                            <input type="email" class="form-control" name="customer_phone_no">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="booking_actions_container">
                            <button type="button" class="btn btn-large btn-primary prevform custom_button_color">
                                Back
                            </button>
                            <button type="button"
                                    class="btn btn-large btn-primary custom_button_color"
                                    id="bookexp"
                            >
                                <i class="fa fa-spinner fa-spin off redeem_process_indicator"></i> Redeem
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>