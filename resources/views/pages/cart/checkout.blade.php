@extends('layouts.main')
@section('content')
    {{--Notification modal--}}
    <div class="modal fade" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header custom_bg_color_2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;color: #fff"><span aria-hidden="true">&times;</span></button>
                    <img
                            src="{{asset('images/check.png')}}"
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


    <div id="tt-pageContent">
        <div class="wish-list-bg">
            <div class="centered">
                <h5>CHECKOUT</h5>
            </div>
            <img class="wish-list-img" src="{{asset('images/slides/bg.png')}}" width="100%" />
        </div>
        <!-- Radio Buttons -->

        <div class="checkout-container">
            <div class="back-to-cart">
                <a href="{{url('cart')}}">
                    <i class="fa fa-arrow-left" aria-hidden="true">
                        <span>Back To Cart Page</span>
                    </i>
                </a>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6">
                    @if(count($pendingcart) > 0)
                    <div class="save-address-container">
                    <span class="address-icons">
                        <i class="fa fa-arrow-circle-o-down" aria-hidden="true">
                            <span class="black-text bold-text">&nbsp;&nbsp; &nbsp; Save address</span>
                          </i>
                        </span>
                        <hr />
                        @if(count($addresses) > 0)
                        <div class="address-div">
                            <form class="register-form" role="form">

                            @foreach($addresses as $i => $item)
                            <div class="row added-margin">
                                <div class="col-md-6 col-sm-6">
                                    <p>{{ $item->firstname . " " . $item->lastname }} - {{$item->phone}}</p>
                                    <p>{{$item->address}}, {{$item->state_name}}, {{$item->city_name}}</p>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" id="guest" type="radio" name="shipaddress" value="{{$item->id}}">Use Address
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <a class="edit-address-btn" id="{{$item->id}}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <a class="dropdown-item delete-address-btn"
                                       style="cursor: pointer;"
                                       id="{{$item->id}}">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                                <hr/>
                            @endforeach
                            </form>
                        </div>
                        @endif
                        <hr />
                        <div class="shipping-address">
                            <h6 class="bold-text">Add Shipping address</h6>
                            <p class="my-paragraph">Please fill the form below to add a shipping address</p>
                            <form class="register-form add_address_form" role="form" action="{{url('add_order_address')}}" method="post">
                                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                <div class="form-container">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="firstname">First name:</label>
                                            <input type="text" class="form-control"  id="billing_first_name" name="firstname" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">Last name:</label>
                                            <input type="text" class="form-control" id="billing_last_name" name="lastname" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="firstname">State:</label>
                                            <select  data-placeholder="" tabindex="-1" aria-hidden="true" class="form-control state_select" name="state_id" required>
                                                @foreach($states as $state)
                                                    <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">City:</label>
                                            <select class="form-control city_select"  data-placeholder=""  name="city_id" required disabled>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="address">Address:</label>
                                            <input type="text" class="form-control"   id="billing_address_1" name="address" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="firstname">Phone Number:</label>
                                            <input type="number" class="form-control"  id="billing_phone" name="phone" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">Email:</label>
                                            <input type="email" class="form-control"  id="email" name="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <!-- <div class="form-group">
                                            <label for="firstname">Phone Number:</label>
                                            <input type="number" class="form-control" id="usr">
                                          </div> -->
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <button type="submit" class="btn btn-default address-button">
                                            Save

                                        </button>
                                    </div>
                                </div>

                            </div>
                            </form>
                        </div>
                    </div>
                        @endif
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="order-details-container">
                        <h6 class="bold-text">Your order details</h6>
                        <div style="margin-bottom: 3%;" class="row">
                            <div class="col-md-9 col-sm-6">
                                <p class="grey-text">Product</p>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <p class="grey-text">Price (Total)</p>
                            </div>
                        </div>
                        <hr class="check-horizontal" />
                        @foreach($pendingcart as $item)
                        <div class="row margin-bottom">
                            <div class="col-md-2 col-sm-2">
                                <img src="{{$item->image}}" width="100%" />
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <p class="cart-paragraph">{{$item->qty}}x {{$item->name}}
                                    @if($item->attrib)
                                        <br/>
                                        ( {{rtrim(trim($item->attrib->value), ",")}} )
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                @if(Auth::check())
                                    @if(Auth::user()->currency->is_currency_fixed == '1')
                                        <p class="woocommerce-Price-currencySymbol">&#8358;</p>{{ transform_product_price($item->price,1)}}
                                    @else
                                        <p> {{ transform_product_price($item->price, Auth::user()->currency->rate)}} <span class="sigmagreen">{{Auth::user()->currency->currency}}</span></p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <hr />
                        @endforeach

                        <div class="row">
                            <div class="col-md-8 col-sm-6">
                                <p class="bold-text black-text">Subtotal</p>
                            </div>
                            <div class="col-md-4 col-sm-6 text-right">
                                @if(Auth::check())
                                    @if(Auth::user()->currency->is_currency_fixed == '1')
                                        <p class="bold-text black-text" id="subtotal_value" data-subtotal="{{(int)$pendingcartsum[0]}}"></p>
                                        <span class="woocommerce-Price-currencySymbol">&#8358;</span>{{number_format($pendingcartsum[0], 0, '.', ',')}}</span>
                                    @else
                                        <p class="bold-text black-text" id="subtotal_value" data-subtotal="{{(int)$pendingcartsum[0] * Auth::user()->currency->rate}}"></p>
                                        <span>{{ transform_product_price($pendingcartsum[0], Auth::user()->currency->rate)}} <span class="green-text">{{Auth::user()->currency->currency}}</span></span>
                                    @endif
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-6">
                                <p class="grey-text">Delivery</p>
                            </div>
                            <div class="col-md-4 col-sm-6 text-right">
                                <p class="bold-text black-text deliveryCharge">__</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-sm-6">
                                <p class="bold-text sigma-price">Grand Total</p>
                            </div>
                            <div class="col-md-5 col-sm-6 text-right">
                              <span class="woocommerce-Price-amount amount">
                                                        @if(Auth::check())
                                      @if(Auth::user()->currency->is_currency_fixed == '1')
                                          <p class="bold-text black-text grand-total">
                                          <span class="woocommerce-Price-currencySymbol">&#8358;</span>
                                          <span class="totalAmount">__</span>
                                          </p>

                                @else
                                          <p class="bold-text black-text grand-total">
                                    <span class="totalAmount bold-text black-text grand-total">__</span>
                                    <span class="currencyName off">{{Auth::user()->currency->currency}}</span>
                                          </p>
                                    @endif
                                    @endif
                                    </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-6">
                                <button type="button" class="btn btn-default login-btn modal-cart-btn checkout_btn" id="checkoutbtn">
                                    <i class="fa fa-spinner fa-spin off process_indicator"></i>    <span class="checkoutbtn">Process Order</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load more button -->






    </div>





    <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="width: 80%; overflow-y: scroll; text-align: left;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header no-height">
                    {{--                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    <h4 class="modal-title" style="color: #000;">Items Update</h4>
                </div>
                <div class="modal-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Status</th>
                            <th>Item</th>
                            <th>Item Name</th>
                            <th>QTY</th>
                            <th></th>
                            {{--                            <th>Old Item Price</th>--}}
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="error-data">

                        </tbody>
                    </table>


                </div>
                <div class="modal-footer modal-center">
                    <button class="btn btn-green btnmodproceed" data-dismiss="modal" onclick="reloadpage()">Proceed</button>
                    <a class="btn btn-green btncontineshopping" style="display: none;" href="{{url('catalogue')}}">Cart is Empty Click to Continue Shopping</a>
                </div>
            </div>

        </div>
    </div>

    @if($table != "")

        <div data-table="{{$table}}" id="error" data-cart="{{$cartqty}}"></div>
    @endif

@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/intlTelInput.min.css')}}">
    <style>

        .table{width:100%;max-width:100%;margin-bottom:1rem;background-color:transparent}.table td,.table th{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table-sm td,.table-sm th{padding:.3rem}.table-bordered{border:1px solid #dee2e6}.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}.table-hover tbody tr:hover{background-color:rgba(0,0,0,.075)}.table-primary,.table-primary>td,.table-primary>th{background-color:#b8daff}.table-hover .table-primary:hover{background-color:#9fcdff}.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{background-color:#9fcdff}.table-secondary,.table-secondary>td,.table-secondary>th{background-color:#d6d8db}.table-hover .table-secondary:hover{background-color:#c8cbcf}.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{background-color:#c8cbcf}.table-success,.table-success>td,.table-success>th{background-color:#c3e6cb}.table-hover .table-success:hover{background-color:#b1dfbb}.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{background-color:#b1dfbb}.table-info,.table-info>td,.table-info>th{background-color:#bee5eb}.table-hover .table-info:hover{background-color:#abdde5}.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{background-color:#abdde5}.table-warning,.table-warning>td,.table-warning>th{background-color:#ffeeba}.table-hover .table-warning:hover{background-color:#ffe8a1}.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{background-color:#ffe8a1}.table-danger,.table-danger>td,.table-danger>th{background-color:#f5c6cb}.table-hover .table-danger:hover{background-color:#f1b0b7}.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{background-color:#f1b0b7}.table-light,.table-light>td,.table-light>th{background-color:#fdfdfe}.table-hover .table-light:hover{background-color:#ececf6}.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{background-color:#ececf6}.table-dark,.table-dark>td,.table-dark>th{background-color:#c6c8ca}.table-hover .table-dark:hover{background-color:#b9bbbe}.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{background-color:#b9bbbe}.table-active,.table-active>td,.table-active>th{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{background-color:rgba(0,0,0,.075)}.table .thead-dark th{color:#fff;background-color:#212529;border-color:#32383e}.table .thead-light th{color:#495057;background-color:#e9ecef;border-color:#dee2e6}.table-dark{color:#fff;background-color:#212529}.table-dark td,.table-dark th,.table-dark thead th{border-color:#32383e}.table-dark.table-bordered{border:0}.table-dark.table-striped tbody tr:nth-of-type(odd){background-color:rgba(255,255,255,.05)}.table-dark.table-hover tbody tr:hover{background-color:rgba(255,255,255,.075)}@media (max-width:575.98px){.table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-sm>.table-bordered{border:0}}@media (max-width:767.98px){.table-responsive-md{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-md>.table-bordered{border:0}}@media (max-width:991.98px){.table-responsive-lg{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-lg>.table-bordered{border:0}}@media (max-width:1199.98px){.table-responsive-xl{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-xl>.table-bordered{border:0}}.table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive>.table-bordered{border:0}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:1rem;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}


        .iti-flag {background-image: url({{asset('images/flags.png')}});}
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .iti-flag {background-image: url({{asset('images/flags.png')}})}
        }
        .intl-tel-input{
            width: 100%
        }
    </style>
@endpush
@push('script')
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script src="{{asset('js/intlTelInput.min.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
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
                    swal("Delivery Address","Please choose an address", "error");

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
                    // console.log(res);
                    if (!res) {
                        alertui.notify('error', 'Failed to calculate delivery price');

                        swal("Delivery Price Processing","Failed to calculate delivery price", "error");
                        $(".orderloader").hide();
                        return false;
                    }
                    if (res.data.status == 0) {
                        // console.log(res);
                        alertui.notify('error', res.data.message);
                        swal("Delivery Price Processing",res.data.message, "error");
                        $(".orderloader").hide();
                        return false;
                    }else if(res.status == 300){
                        alertui.notify('error', res.reason);
                        $('#myModal').modal('toggle');
                        $('#error-data').append(res.table);
                        if(res.cartqty === 0)
                        {
                            $('.btncontineshopping').show();
                            $('.btnmodproceed').hide();
                            $('.btnbackcart').hide();
                        }else{
                            $('.btncontineshopping').hide();
                            $('.btnmodproceed').show();
                            $('.btnbackcart').show();
                        }
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
                            $(".deliveryCharge").html( delivery_price +" <span='green-text'>" + appCurrency+"</span>")
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
                    swal("",response.reason, "error");
                    if(response.status == 500){
                        alertui.notify('error', 'Error calculating delivery charge. Please try again.')
                        swal("","Error calculating delivery charge. Please try again.", "error");
                    } else{
                        alertui.notify('error', response.responseJSON.data)
                        swal("",response.responseJSON.data, "error");
                    }
                })
        }

        function popcartitem(id){

            alertui.confirm('Confirm Remove'
                , 'Do you want to remove this item from your Cart? '
                , function(){
                    $('#'+id+'.remove').html('<img src="{{asset('assets/images/spinnerb.gif')}}" style="width: 60px"/>')
                    $.post("{{url('api/delete_cart_item')}}", {id:id})
                        .done(function (res) {
                            // handle success
                            if (!res) {
                                $('#'+id+'.remove').html('<i class="fa fa-trash-o"></i>');
                                alertui.notify('error', 'Failed to update your cart');
                                return false;
                            }
                            if (res.data.status == '400') {
                                $('#'+id+'.remove').html('<i class="fa fa-trash-o"></i>');
                                alertui.notify('error', res.data.data);
                                swal("Cart Delete",res.data.data, "error");
                                return false;
                            }

                            $("tr[id=" + id + "] ").fadeOut("slow", function () {
                                alertui.notify('success', 'Your cart has been updated');
                            })



                        })
                        .fail(function (error) {
                            // handle error
                            $('#'+id+'.remove').html('<i class="fa fa-trash-o"></i>');
                            alertui.notify('error', 'An Error occurred. Failed to update your cart');
                            swal("Cart Delete",'An Error occurred. Failed to update your cart', "error");
                        })
                },function(){
                    // Notify success callback button default Cancel
                    alertui.notify('info', 'Item is safe in your Cart');
                }
            );
        }

        function popupcartitem(id){

            alertui.confirm('Confirm Remove'
                , 'Do you want to remove this item from your Cart? '
                , function(){
                    $('#'+id+'.remove').html('<img src="{{asset('assets/images/spinnerb.gif')}}" style="width: 60px"/>')
                    $.post("{{url('api/delete_cart_item')}}", {id:id})
                        .done(function (res) {
                            // handle success
                            if (!res) {
                                $('#'+id+'.remove').html('<i class="fa fa-trash-o"></i>');
                                alertui.notify('error', 'Failed to update your cart');
                                swal("Cart Delete",'Failed to update your cart', "error");

                                return false;
                            }
                            if (res.data.status == '400') {
                                $('#'+id+'.remove').html('<i class="fa fa-trash-o"></i>');
                                alertui.notify('error', res.data.data);
                                swal("Cart Delete",res.data.data, "error");
                                return false;
                            }

                            if(res.cartqty === 0)
                            {
                                $('.btncontineshopping').show();
                                $('.btnmodproceed').hide();
                                $('.btnbackcart').hide();
                            }

                            $("#mod" + id).hide();
                            $("tr[id=" + id + "] ").fadeOut("slow", function () {
                                alertui.notify('success', 'Your cart has been updated');
                                // location.reload();
                            })



                        })
                        .fail(function (error) {
                            // handle error
                            $('#'+id+'.remove').html('<i class="fa fa-trash-o"></i>');
                            alertui.notify('error', 'An Error occurred. Failed to update your cart');
                            swal("Cart Delete",'An Error occurred. Failed to update your cart', "error");
                        })
                },function(){
                    // Notify success callback button default Cancel
                    alertui.notify('info', 'Item is safe in your Cart');
                }
            );
        }

        function reloadpage() {
            // location.reload();
            location.replace('cart')
        }

        function refreshpage() {
            location.reload();
            // location.replace('cart')
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
                        swal("Redemption Error",'Failed to complete payment', "error");
                        return false;
                    }
                    if (res.status == 'servererror') {
                        alert(res.data.message);
                        alertui.notify('error',res.data.message);
                        swal("Redemption Error",res.data.message, "error");
                        return false;
                    }
                    if (res.status === '400') {
                        alert(res.data.message);
                        alertui.notify('error',res.data.message);
                        swal("Redemption Error",res.data.message, "error");
                        return false;
                    }
                    if (res.status == '300') {

                        $('#myModal').modal('toggle');
                        $('#error-data').append(res.table);


                        if(res.cartqty === 0)
                        {
                            $('.btncontineshopping').show();
                            $('.btnmodproceed').hide()
                            ;$('.btnbackcart').hide();
                        }else{
                            $('.btncontineshopping').hide();
                            $('.btnmodproceed').show();
                            $('.btnbackcart').show();
                        }

                        return false;
                    }
                    if (res.status === 'fail') {
                        alert(res.data);
                        alertui.notify('error',res.data);
                        swal("Redemption Error",res.data, "error");
                        return false;
                    }
                    if (res.status == 'validation') {
                        alert(res.message);
                        alertui.notify('error',res.message);
                        swal("Redemption Error",res.data, "error");
                        return false;
                    }
                    if (res.status === '200') {
                        updateAccount(res.account)
                        alertui.notify('success', 'Transaction Successful')
                        swal("Redemption","Transaction Successful", "success");
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
                        swal("Redemption Error",'Error completing order.. Please try again.', "error");
                        alertui.notify('error', 'Error completing order.. Please try again.')
                    }
                    else{
                        swal("Redemption Error",'Error completing order.. Please try again.', "error");

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
                                swal("",'Failed to update address', "error");

                                return false;
                            }
                            if (res.status === 'fail') {
                                alertui.notify('default',
                                    'Failed to update address',
                                );
                                swal("",'Failed to update address', "error");

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
                                swal("",'Failed to retrive address data. Try again.', "error");

                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                                swal("",response.responseJSON.data, "error");
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
                        swal("",'Failed to update address', "error");
                        $('#editaddress').modal('hide')
                        return false;
                    }
                    if (res.status === 'fail') {
                        $(".updateAddBtn").hide();
                        alertui.notify('error',
                            'Failed to update address',
                        );
                        swal("",'Failed to update address', "error");
                        $('#editaddress').modal('hide')
                        return false;
                    }
                    if (res.status == 'validation') {
                        alertui.notify('error',res.message);
                        swal("",res.message, "error");

                        return false;
                    }
                    if (res.status === 'complete') {
                        $(".updateAddBtn").hide();
                        alertui.notify('default',
                            'Address updated!',
                        );
                        swal("",'Address Updated', "success");

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
                        swal("","Failed to update address. Please try again.", "error");

                    }
                    else{
                        alertui.notify('error', response.responseJSON.data)
                        swal("",response.responseJSON.data, "error");

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
                                swal("","Error Deleting Address", "error");
                                return false;
                            }
                            if (res.status === 'fail') {
                                alertui.notify('error', 'Error deleting address.');
                                swal("","Error Deleting Address", "error");
                                return false;
                            }
                            if (res.status === 'complete') {
                                alertui.notify('success', 'Address Deleted');
                                swal("","Address Deleted", "success");
                                location.reload();
                            }
                            $(".orderloader").hide();
                        })
                        .fail(function (response) {
                            // handle error
                            if(response.status == 500){
                                alertui.notify('error', 'Error deleting address.. Please try again.')
                                swal("","Error deleting address.. Please try again.", "error");
                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                                swal("",response.responseJSON.data, "error");
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
                        swal("",'Failed to update address', "error");
                        return false;
                    }
                    if (res.status === '400') {
                        alertui.notify('error',
                            'Failed to update address',
                        );
                        swal("",'Failed to update address', "error");
                        return false;
                    }
                    if (res.status === '200') {
                        alertui.notify('default',
                            'Address Saved!',
                        );
                        swal("",'Address Saved!', "success");

                        location.reload();
                        return false;
                    }
                    if (res.status == 'validation') {
                        alertui.notify('info',res.message);
                        swal("",res.message, "warning");

                        return false;
                    }
                })
                .fail(function (response, status, error) {
                    // handle error
                    $(".process_indicator_add_address").addClass('off');
                    disableItem($(".add_address_btn"), false)
                    if(response.status == 500){
                        alertui.notify('error', 'Error completing order.. Please try again.')
                        swal("",'Error completing order.. Please try again.', "error");

                    }
                    else{
                        alertui.notify('error', 'Error completing order.. Please try again.')
                        swal("",'Error completing order.. Please try again.', "error");
                    }
                    return false;
                })
        })


        if($('#error').length) {
            var temptable = $('#error').attr('data-table');
            $('#myModal').modal('toggle');
            $('#error-data').append(temptable);


            var incart = $('#error').attr('data-cart');
            if(incart == 0)
            {
                $('.btncontineshopping').show();
                $('.btnmodproceed').hide();
                $('.btnbackcart').hide();
            }else{
                $('.btnbackcart').show();
                $('.btnmodproceed').show();
                $('.btncontineshopping').hide();
            }

        }
    </script>
@endpush