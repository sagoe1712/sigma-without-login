@extends('layouts.main')
@section('content')
    {{--Notification modal--}}
    <div class="modal fade" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header custom_bg_color_2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;color: #fff"><span aria-hidden="true">&times;</span></button>
                    <img
                            src="{{asset('sigma/images/check.png')}}"
                            class="text-center" alt="success"
                            style="
                            width: 100px;
                            margin: 0 auto;
                            left: 40%;
                            top: 10%;
                            position: relative;"
                    >
                </div>
                <div class="modal-body text-center">
                    <h2 class="">Great!</h2>
                    <h4 class="order_response"></h4>
                    <br><br>
                    <div class="row" role="group" aria-label="">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="col-sm-6" role="group">
                                <a type="button" href="{{url('catalogue')}}" aria-label="Close" class="btn btn-large custom_button_color_2" style="width: 100%; height: 40px;">
                                    <span>Continue Shopping</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="col-sm-6" role="group">
                                <a href="{{url('cart')}}" class="btn btn-large custom_button_color"  style="width: 100%; height: 40px;">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>View Cart</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Address modal--}}
    <div class="modal fade" id="editaddress" tabindex="-1" role="dialog" aria-labelledby="editaddress" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px;">
                    <span class="modal-title" id="exampleModalLongTitle">Edit Address</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="update-address-form" class="form-horizontal">
                        <div class="container">
                        <div class="row form-group">
                            <div class="col-sm-4" style="padding:20px 5px">
                                <label for="firstname">First name</label>
                                <input type="text" name="firstname" class="form-control">
                            </div>
                            <div class="col-sm-4" style="padding:20px 5px">
                                <label for="lastname">Last name</label>
                                <input type="text" name="lastname" class="form-control">
                            </div>
                            <div class="col-sm-4" style="padding:20px 5px">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                            <div class="col-sm-4" style="padding:20px 5px">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" >
                            </div>
                            <div class="col-sm-4" style="padding:20px 5px">
                                <label for="state">State</label>
                                <select name="state_id" class="modal_state_select form-control">
                                    @foreach($states as $state)
                                        <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4" style="padding:20px 5px">
                                <label for="city">City</label>
                                <select name="city_id" id="city_id" class="modal_city_select form-control" disabled>
                                    @foreach($cities as $city)
                                        <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="clear"></div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control">
                        </textarea>
                        </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary updateModalDataBtn"><i class="fa fa-spinner fa-spin updateAddBtn updateModalNotif off"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('cart')}}">Cart</a></li>
                    <li class='active'>Checkout</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>
    <div class="body-content">
        <div class="container">
            <div class="checkout-box ">
                <div class="row">
                    <div class="col-xs-12 col-sm-7 col-md-7">
                        <div class="panel-group checkout-steps" id="accordion">
                            <!-- checkout-step-01  -->
                            <div class="panel panel-default checkout-step-01">

                                <!-- panel-heading -->
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">
                                        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                            <span><i class="fa fa-location-arrow"></i></span>Checkout Address
                                        </a>
                                    </h4>
                                </div>
                                <!-- panel-heading -->

                                <div id="collapseOne" class="panel-collapse collapse in">

                                    <!-- panel-body  -->
                                    <div class="panel-body">
                                        <div class="row">

                                            <!-- guest-login -->
                                            <div class="col-md-12 col-sm-12 guest-login">
                                                @if(count($pendingcart) > 0)
                                                    <h3>Saved Addresses</h3>
                                                @if(count($addresses) < 1)
                                                    <h5 style="margin-bottom: 50px;">Please add a Shipping address</h5>
                                                @endif
                                                    @if(count($addresses) > 0)
                                                <form class="register-form" role="form">
                                                    <div class="radio radio-checkout-unicase">
                                                        @foreach($addresses as $i => $item)
                                                        <input id="guest" type="radio" name="shipaddress" value="{{$item->id}}" >
                                                        <label class="radio-button guest-check">{{ $item->firstname . " " . $item->lastname }} - {{$item->phone}} </label>
                                                            <div class="btn-group pull-right">
                                                                <button type="button"
                                                                        class="btn btn-primary float-right btn-xs dropdown-toggle custom_button_color_2"
                                                                        data-toggle="dropdown"
                                                                        aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <li><a class="dropdown-item edit-address-btn"
                                                                           style="cursor: pointer;"
                                                                           id="{{$item->id}}">Edit</a></li>
                                                                    <li><a class="dropdown-item delete-address-btn"
                                                                           style="cursor: pointer;"
                                                                           id="{{$item->id}}">Delete</a></li>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        <label class="radio-button guest-check">{{$item->address}}, {{$item->state_name}}, {{$item->city_name}} </label>

                                                        <br>
                                                        <br>
                                                        @endforeach
                                                    </div>
                                                </form>
                                                    @endif
                                                <!-- radio-form  -->
                                                @endif
                                               </div>
                                            <!-- guest-login -->

                                            <!-- already-registered-login -->
                                            <div class="col-md-12 col-sm-12 already-registered-login">
                                                <h3>Add shipping address</h3>
                                                <p class="text title-tag-line">Please fill the form below to add a Shipping address:</p>
                                                <form class="register-form add_address_form" role="form" action="{{url('add_order_address')}}" method="post">
                                                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                                    <div class="form-group row">
                                                        <div class="col-sm-6">
                                                         <label class="info-title" for="billing_first_name">First Name
                                                            <abbr title="required" class="required">*</abbr>
                                                        </label>
                                                            <input type="text" value="" placeholder=""
                                                                   id="billing_first_name" name="firstname"
                                                                   class="form-control unicase-form-control text-input" required>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="info-title" for="billing_last_name">Last Name <span>*</span></label>
                                                            <input type="text" value="" placeholder=""
                                                                   id="billing_last_name" name="lastname"
                                                                   class="form-control unicase-form-control text-input" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-6">
                                                        <label class="info-title" for="billing_state">State <span>*</span></label>
                                                        <select
                                                                data-placeholder=""
                                                                class="state_select form-control"
                                                                name="state_id"
                                                                tabindex="-1" aria-hidden="true" required>
                                                            @foreach($states as $state)
                                                                <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                        <div class="col-sm-6">
                                                        <label class="info-title" for="city_id">City <span>*</span></label>
                                                        <select
                                                                data-placeholder=""
                                                                class="city_select form-control"
                                                                name="city_id"
                                                                tabindex="-1"
                                                                aria-hidden="true"
                                                                disabled
                                                                required
                                                        >
                                                            <option value=""></option>
                                                        </select>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="info-title" for="billing_address_1">Address <span>*</span></label>
                                                        <input type="text" value=""
                                                               placeholder=""
                                                               id="billing_address_1" name="address"
                                                               class="form-control" required>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-6">
                                                        <label class="info-title" for="billing_phone" style="display: block;">Contact phone <span>*</span></label>
                                                        <input type="tel" value="" placeholder=""
                                                               id="billing_phone" name="phone"
                                                               class="form-control" required>
                                                    </div>
                                                        <div class="col-sm-6">
                                                            <label class="info-title" for="email">Email <span>*</span></label>
                                                            <input type="email" value="" placeholder=""
                                                                   id="email" name="email"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn-upper btn btn-primary checkout-page-button custom_button_color_2" style="float:right"> <i class="fa fa-spinner fa-spin off process_indicator_add_address"></i> Save</button>
                                                </form>
                                            </div>
                                            <!-- already-registered-login -->

                                        </div>
                                    </div>
                                    <!-- panel-body  -->

                                </div><!-- row -->
                            </div>

                        </div><!-- /.checkout-steps -->
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-5 checkout_cart">
                        <!-- checkout-progress-sidebar -->
                        <div class="checkout-progress-sidebar ">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">Your order details</h4>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price (Total)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pendingcart as $item)
                                            <tr class="cart_item">
                                                <td class="product-name" style="padding: 8px;">
                                                    <strong class="product-quantity">{{$item->qty}}
                                                        × </strong>{{$item->name}}
                                                    @if($item->attrib)
                                                        ( {{$item->attrib->value}} )
                                                    @endif
                                                </td>
                                                <td class="product-total" style="padding: 8px;">
                                                                        <span class="woocommerce-Price-amount amount font-weight-bold">
                                                                            @if(Auth::check())
                                                                                @if(Auth::user()->currency->is_currency_fixed == '1')
                                                                                    <span class="woocommerce-Price-currencySymbol">&#8358;</span>{{ transform_product_price($item->price,1)}}
                                                                                @else
                                                                                    <span> {{ transform_product_price($item->price, Auth::user()->currency->rate)}} {{Auth::user()->currency->currency}}</span>
                                                                                @endif
                                                                            @endif
                                                                        </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr class="cart-subtotal">
                                            <th style="padding: 8px;">Subtotal</th>
                                            <td style="padding: 8px;">
                                             <span class="woocommerce-Price-amount amount">
                                              @if(Auth::check())
                                              @if(Auth::user()->currency->is_currency_fixed == '1')
                                              <span id="subtotal_value" data-subtotal="{{(int)$pendingcartsum[0]}}"></span>
                                              <span class="woocommerce-Price-currencySymbol">&#8358;</span>{{number_format($pendingcartsum[0], 0, '.', ',')}}</span>
                                                @else
                                                    <span id="subtotal_value" data-subtotal="{{(int)$pendingcartsum[0] * Auth::user()->currency->rate}}"></span>
                                                    <span>{{ transform_product_price($pendingcartsum[0], Auth::user()->currency->rate)}} {{Auth::user()->currency->currency}}</span>
                                                    @endif
                                                    @endif
                                                    </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 8px;">Delivery</th>
                                            <td class="deliveryCharge" style="padding: 8px;">__</td>
                                        </tr>
                                        <tr class="order-total custom_color_2">
                                            <th style="padding: 8px;">Grand Total</th>
                                            <td style="padding: 8px;">
                                                        <span class="woocommerce-Price-amount amount">
                                                        @if(Auth::check())
                                                                @if(Auth::user()->currency->is_currency_fixed == '1')
                                                                    <span class="woocommerce-Price-currencySymbol">&#8358;</span>
                                                                    <span class="totalAmount">__</span>
                                                        </span>
                                                @else
                                                    <span class="totalAmount">__</span>
                                                    <span class="currencyName off">{{Auth::user()->currency->currency}}</span>
                                                    @endif
                                                    @endif
                                                    </span>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <div class="woocommerce-checkout-payment">
                                        <div class="form-row place-order justify-content-around">
                                            <button type="button"
                                                    class="btn btn-md btn-block btn-primary text-center checkout_btn custom_button_color custom_button_color_anim"
                                                    id="checkoutbtn">
                                                <i class="fa fa-spinner fa-spin off process_indicator"></i>
                                                <span class="checkoutbtn">Process order</span>
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- checkout-progress-sidebar -->				</div>
                </div><!-- /.row -->
            </div><!-- /.checkout-box -->
             </div>
             </div>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header no-height">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Items Would Be Removed</h4>
                </div>
                <div class="modal-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Status</th>
                            <th>Item</th>
                            <th>Item Name</th>
                            <th>QTY</th>
                            <th>New Item Price</th>
                            <th>Old Item Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="error-data">

                        </tbody>
                    </table>


                </div>
                <div class="modal-footer modal-center">
                    <button class="btn btn-green" data-dismiss="modal">Done</button>
                </div>
            </div>

        </div>
    </div>
        @endsection

        @push('style')
            <link rel="stylesheet" type="text/css" href="{{asset('sigma/css/alertui.min.css')}}">
            <link rel="stylesheet" href="{{asset('css/intlTelInput.min.css')}}">
            <style>
                .iti-flag {background-image: url({{asset('img/flags.png')}});}
                @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
                    .iti-flag {background-image: url({{asset('img/flags.png')}})}
                }
                .intl-tel-input{
                    width: 100%
                }
            </style>
        @endpush
        @push('script')
            <script src="{{asset('sigma/js/alertui.min.js')}}"></script>
            <script src="{{asset('js/intlTelInput.min.js')}}"></script>
            <script src="{{asset('assets/js/theia-sticky-sidebar.js')}}"></script>
            <script>


                //Declare global variables.
                var conversionRate = "<?php echo Auth::user()->currency->rate ;?>"
                var appCurrency = "<?php echo Auth::user()->currency->currency ;?>"
                var appCurrencyFixed = "<?php echo Auth::user()->currency->is_currency_fixed ;?>"
                var processState = 0;
                var deliveryPrice = null;
                var addressid;
                var stateid;


                //International Tel plugin setup
                var tel = document.querySelector("#billing_phone");
                var phonenumber = window.intlTelInput(tel, {initialCountry: "ng", separateDialCode: true, onlyCountries:['ng']});
                var countryData = phonenumber.getSelectedCountryData();

                Date.prototype.getDayOfWeek = function(){
                    return ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"][ this.getDay() ];
                };

                //Configure Ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //Close overlay event
                $(".overlay").click(function () {
                    $(this).hide();
                })

                $('#editaddress').on('hidden.bs.modal', function (e) {
                    $(".updateAddBtn").hide();
                })

                $(document).ready(function () {
                    $('.checkout_cart').theiaStickySidebar({
                        // Settings
                        additionalMarginTop: 30
                    });
                    $("input").on('keyup', function () {
                        $("input[name='country_code']").val(countryData.dialCode)
                        $("span.errorshow").fadeOut()
                        $("span.errorshow").html("")
                    });
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    //Checkout button event
                    $("#checkoutbtn").click(function () {
                        if (!$("input[name='shipaddress']:checked").val()) {
                            alertui.notify('info', 'Please choose an address.');

                        } else {
                            if (processState == 0) {
                                getdeliveryprice($("input[name='shipaddress']:checked").val())
                            } else {
                                checkout_redeem();
                            }
                        }
                    });

                    //load city

                        stateid = $("select.state_select[name='state_id']").val();
                        $("select.city_select[name='city_id']").empty();
                        $("select.city_select[name='city_id']").append('<option>Loading...</option>');
                        $("select.city_select[name='city_id']").prop('disabled', true);

                        $.post("{{url('api/load_cites')}}",{id: stateid})
                            .done(function(msg) {
                                $("select.city_select[name='city_id']").empty();
                                $("select.city_select[name='city_id']").prop('disabled', false);
                                $.each(msg, function (key, value) {
                                    $("select.city_select[name='city_id']").append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                                });
                            })


                    //Add new address toggle button
                    $(".toggleNewAddress").click(function () {
                        $(".newaddresscontainer").toggle();
                    });

                    //Edit address toggle button
                    $(".edit-address-btn").click(function () {
                        addressid = $(this).prop("id");
                        getAddressData(addressid)
                    });

                    //Commit Modal changes
                    $(".updateModalDataBtn").click(function(){
                        $(".updateAddBtn").show();
                        saveModalChanges()
                    })

                    //Delete address
                    $(".delete-address-btn").click(function(){
                        addressid = $(this).prop("id");
                        deleteAddress()
                    })

                    $('#editaddress').on('shown.bs.modal', function (e) {
                        $("select.modal_state_select[name='state_id']").on('change', function () {
                            stateid = $(this).val();
                            $("select.modal_city_select[name='city_id']").empty();
                            $("select.modal_city_select[name='city_id']").append('<option>Loading...</option>');
                            $("select.modal_city_select[name='city_id']").prop('disabled', true);
                            $.post("{{url('api/load_cites')}}",{id: stateid})
                                .done(function(msg) {
                                    $("select.modal_city_select[name='city_id']").empty();
                                    $("select.modal_city_select[name='city_id']").prop('disabled', false);
                                    $.each(msg, function (key, value) {
                                        $("select.modal_city_select[name='city_id']").append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                                    });
                                })
                        });
                    });

                    $("select.state_select[name='state_id']").on('change', function () {
                        stateid = $(this).val();
                        $("select.city_select[name='city_id']").empty();
                        $("select.city_select[name='city_id']").append('<option>Loading...</option>');
                        $("select.city_select[name='city_id']").prop('disabled', true);
                        $.post("{{url('api/load_cites')}}",{id: stateid})
                            .done(function(msg) {
                                $("select.city_select[name='city_id']").empty();
                                $("select.city_select[name='city_id']").prop('disabled', false);
                                $.each(msg, function (key, value) {
                                    $("select.city_select[name='city_id']").append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                                });
                            })
                    });

                });

                //Get delivery price
                function getdeliveryprice(address_id) {
                    //Show spinning icon
                    $(".process_indicator").removeClass('off');
                    disableItem($("#checkoutbtn"), true)
                    //Send delivery price Ajax request

                    $.post("{{url('api/get_delivery_price')}}", {address_id})
                        .done(function (res) {
                            disableItem($("#checkoutbtn"), false)
                            $(".process_indicator").addClass('off');
                            // handle success
                            $(".currencyName").removeClass('off');
                            if (!res) {
                                alertui.notify('error', 'Failed to calculate delivery price');
                                $(".orderloader").hide();
                                return false;
                            }
                            if (res.data.status == 0) {
                                alertui.notify('error', res.data.message);
                                $(".orderloader").hide();
                                return false;
                            } else {
                            
                                var calcprice;
                                deliveryPrice = res.data.data.price;
                                if(appCurrencyFixed == 1){
                                
                                    //Currency fixed
                                    var delivery_price = new Intl.NumberFormat('en-GB').format(Math.ceil(deliveryPrice));
                                    $(".deliveryCharge").html('&#8358;'+delivery_price)
                                    calcprice = ($("#subtotal_value").data('subtotal') + deliveryPrice);

                                    var newprice = new Intl.NumberFormat('en-GB').format(Math.ceil(calcprice));
                                    $(".totalAmount").html(newprice);
                                    $(".checkout_btn").css({"background-color": "#ff582c", "border-color": "#FF582C"});
                                    $(".checkoutbtn").html("Pay");
                                }else{
                                    //Currency not Fixed
                                    //Currency is not Naira
                                    var delivery_price = new Intl.NumberFormat('en-GB').format(Math.ceil(deliveryPrice * conversionRate));
                                    $(".deliveryCharge").html( delivery_price +" " + appCurrency)
                                    calcprice = $("#subtotal_value").data('subtotal') + (deliveryPrice * conversionRate);
                                    var newprice = new Intl.NumberFormat('en-GB').format(Math.ceil(calcprice));

                                    $(".totalAmount").html(newprice);
                                    $(".checkout_btn").css({"background-color": "#ff582c", "border-color": "#FF582C"});
                                    $(".checkoutbtn").html("Pay");
                                }
                                processState = 1;
                            }

                        })
                        .fail(function (response, status, error) {
                            // handle error
                            disableItem($("#checkoutbtn"), false)
                            $(".process_indicator").addClass('off');
                            // alertui.alert('error', 'Apologies, an error occurred.');
                            alertui.alert('error', response.reason);
                            if(response.status == 500){
                                alertui.notify('error', 'Error calculating delivery charge. Please try again.')
                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                            }
                        })
                }

                function checkout_redeem() {
                    $(".process_indicator").removeClass('off');
                    disableItem($("#checkoutbtn"), true)
                    var address_id = $("input[name='shipaddress']:checked").val();
                    var subtotal_value = $("#subtotal_value").data('subtotal');

                    $.post("{{url('api/redeem_cart')}}", {address_id, deliveryprice: deliveryPrice})
                        .done(function (res) {
                            disableItem($("#checkoutbtn"), false)
                            $(".process_indicator").addClass('off');
                            // handle success
                            if (!res) {
                                alertui.notify('error','Failed to complete payment');
                                return false;
                            }
                            if (res.status == 'servererror') {
                                alert(res.data.message);
                                alertui.notify('error',res.data.message);
                                return false;
                            }
                            if (res.status === '400') {
                                alert(res.data.message);
                                alertui.notify('error',res.data.message);
                                return false;
                            }

                            if (res.status === '300') {
                               $.each(data, function(key, value){
                               <tr>
                                   <td><button class="btn btn-orange">Item Price Change</button></td>
                                   <td><img src="{{asset('images/watch.jpeg')}}" class="img-max"/></td>
                                       <td><p>Apple Smart Watch 2019</p></td>
                                   <td><p>5</p></td>
                                   <td><p>850 Sigma Stars</p></td>
                                   <td><p>800 Sigma Stars</p></td>
                                   <td><button class="btn btn-blue-cart">Keep In cart</button></td>
                                   </tr>
                                   <tr>
                                   <td><button class="btn btn-red">Item Out of Stock</button></td>
                                   <td><img src="{{asset('images/watch.jpeg')}}" class="img-max"/></td>
                                       <td><p>Apple Smart Watch 2019</p></td>
                                   <td><p>5</p></td>
                                   <td><p>850 Sigma Stars</p></td>
                                   <td></td>
                                   <td></td>
                                   </tr>
                               })
                                $('#myModal').modal('toggle');
                                return false;
                            }


                            if (res.status === 'fail') {
                                alert(res.data);
                                alertui.notify('error',res.data);
                                return false;
                            }
                            if (res.status == 'validation') {
                                alert(res.message);
                                alertui.notify('error',res.message);
                                return false;
                            }
                            if (res.status === '200') {
                                updateAccount(res.account)
                                alertui.notify('success', 'Transaction Successful')
                                window.location.replace("{{url('ordercomplete')}}/"+res.data)
                                // window.location.replace(appUrl+"ordercomplete/"+res.data)
                                {{--$('#ordernotify').modal('show');--}}
                                {{--var oldlink = $("#order_receipt").prop('href');--}}
                                {{--$('#ordernotify').on('shown.bs.modal', function (e) {--}}
                                   {{----}}
                                    {{--$("#order_receipt").prop('href', "{{url('ordercomplete')}}"+'/'+res.data);--}}
                                {{--});--}}
                            }

                        })
                        .fail(function (response, status, error) {
                            $(".process_indicator").addClass('off');
                            disableItem($("#checkoutbtn"), false)
                            // handle error
                            if(response.status == 500){
                                alert('Error completing order.. Please try again.');
                                alertui.notify('error', 'Error completing order.. Please try again.')
                            }
                            else{
                                alert('Error completing order.. Please try again.');
                                alertui.notify('error', 'Error completing order.. Please try again.')
                            }
                        })
                }

                function getAddressData(id){
                    alertui.load('Loading...',
                        function(loadClose, loadEl) {
                            $.get("{{url('api/get_order_address')}}/" + id)
                                .done(function (res) {
                                    // handle success
                                    if (!res) {
                                        alertui.notify('default',
                                            'Failed to update address',
                                        );
                                        return false;
                                    }
                                    if (res.status === 'fail') {
                                        alertui.notify('default',
                                            'Failed to update address',
                                        );
                                        return false;
                                    }
                                    if (res.status === 'complete') {
                                        $('#editaddress').modal()
                                        changeModalData(res.data);
                                        loadClose();
                                    }
                                    $(".orderloader").hide();
                                })
                                .fail(function (response, status, error) {
                                    // handle error
                                    if(response.status == 500){
                                        alertui.notify('error', 'Failed to retrive address data. Try again.')
                                    }
                                    else{
                                        alertui.notify('error', response.responseJSON.data)
                                    }
                                    return false;

                                })
                        });
                }

                function changeModalData(data) {
                    $("form[name='update-address-form']").find("input[name='firstname']").val(data.firstname)
                    $("form[name='update-address-form']").find("input[name='lastname']").val(data.lastname)
                    $("form[name='update-address-form']").find("input[name='email']").val(data.email)
                    $("form[name='update-address-form']").find("input[name='phone']").val(data.phone)
                    $("form[name='update-address-form']").find("textarea[name='address']").html(data.address)
                    $("form[name='update-address-form']").find("select[name='city_id']").find($("option")).each(function(i, item){
                        if( $(item).val() == data.city_id) {
                            $(item).prop({'selected': true})
                        }
                    });
                    $("form[name='update-address-form']").find("select[name='state_id']").find($("option")).each(function(i, item){
                        if( $(item).val() == data.state_id) {
                            $(item).prop({'selected': true})
                        }
                    });
                }

                function saveModalChanges(){
                    $(".updateModalNotif").removeClass('off');
                    disableItem($(".updateModalDataBtn"), true)
                    var formData =  $("form[name='update-address-form']").serializeArray();

                    $.post("{{url('api/update_order_address')}}"+'/'+addressid, formData)
                        .done(function (res) {
                            disableItem($(".updateModalDataBtn"), false)
                            $(".updateModalNotif").addClass('off');
                            // handle success
                            if (!res) {
                                $(".updateAddBtn").hide();
                                alertui.notify('error',
                                    'Failed to update address',
                                );
                                $('#editaddress').modal('hide')
                                return false;
                            }
                            if (res.status === 'fail') {
                                $(".updateAddBtn").hide();
                                alertui.notify('error',
                                    'Failed to update address',
                                );
                                $('#editaddress').modal('hide')
                                return false;
                            }
                            if (res.status == 'validation') {
                                alertui.notify('error',res.message);
                                return false;
                            }
                            if (res.status === 'complete') {
                                $(".updateAddBtn").hide();
                                alertui.notify('default',
                                    'Address updated!',
                                );
                                $('#editaddress').modal('hide');
                                location.reload();
                                return false;
                            }
                        })
                        .fail(function (response, status, error) {
                            disableItem($(".updateModalDataBtn"), false);
                            $(".updateModalNotif").addClass('off');
                            // handle error
                            $(".updateAddBtn").hide();
                            $('#editaddress').modal('hide');
                            if(response.status == 500){
                                alertui.notify('error', 'Failed to update address. Please try again.')
                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                            }
                            return false;
                        })
                }

                function deleteAddress(){
                    alertui.confirm('Confirm', 'Do you want to delete this address?',
                        function () {
                            $.post("{{url('api/delete_order_address')}}"+'/' + addressid)
                                .done(function (res) {
                                    // handle success
                                    if (!res) {
                                        alertui.notify('error', 'Error deleting address.');
                                        return false;
                                    }
                                    if (res.status === 'fail') {
                                        alertui.notify('error', 'Error deleting address.');
                                        return false;
                                    }
                                    if (res.status === 'complete') {
                                        alertui.notify('success', 'Address Deleted');
                                        location.reload();
                                    }
                                    $(".orderloader").hide();
                                })
                                .fail(function (response) {
                                    // handle error
                                    if(response.status == 500){
                                        alertui.notify('error', 'Error deleting address.. Please try again.')
                                    }
                                    else{
                                        alertui.notify('error', response.responseJSON.data)
                                    }
                                    return false;

                                })
                        },
                        function () {
                            alertui.notify('default', 'Your data is safe.');
                        }
                    );
                }

                $("form.add_address_form").on('submit', function (e) {
                    e.preventDefault();
                    $(".process_indicator_add_address").removeClass('off');
                    disableItem($(".add_address_btn"), true)
                    var formData = $(this).serialize();

                    $.post("{{url('api/add_order_address')}}"+'', formData)
                        .done(function (res) {
                            // handle success
                            $(".process_indicator_add_address").addClass('off');
                            disableItem($(".add_address_btn"), false)
                            if (!res) {
                                alertui.notify('error',
                                    'Failed to update address',
                                );
                                return false;
                            }
                            if (res.status === '400') {
                                alertui.notify('error',
                                    'Failed to update address',
                                );
                                return false;
                            }
                            if (res.status === '200') {
                                alertui.notify('default',
                                    'Address Saved!',
                                );
                                location.reload();
                                return false;
                            }
                            if (res.status == 'validation') {
                                alertui.notify('info',res.message);
                                return false;
                            }
                        })
                        .fail(function (response, status, error) {
                            // handle error
                            $(".process_indicator_add_address").addClass('off');
                            disableItem($(".add_address_btn"), false)
                            if(response.status == 500){
                                alertui.notify('error', 'Error completing order.. Please try again.')
                            }
                            else{
                                alertui.notify('error', 'Error completing order.. Please try again.')
                            }
                            return false;
                        })
                })

            </script>
        @endpush