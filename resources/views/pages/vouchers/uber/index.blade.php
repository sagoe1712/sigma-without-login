@extends('layouts.main')
@section('content')

    <?php
    $company_id = env('COMPANY_ID');
    $cs =  DB::table('setting')
        ->where('company_id', '=', $company_id)
        ->first();

    ?>

    @if(!Auth::guest())
        <input type="hidden" class="login-status" value = "1">
    @else
        <input type="hidden" class="login-status" value = "0">
    @endif

    <div class="modal  fade"  id="modal" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                </div>
                <div class="modal-body">
                    <div class="tt-modal-quickview desctope view-discount-container">
                        <div class="row">
                            <div class="col-12 col-md-5 col-lg-5">
                                <img src="{{$response->data[0]->image}}" width="80%" alt="preview" />
                            </div>
                            <div class="col-12 col-md-5 col-lg-5">
                                <div class="tt-product-single-info">
                                    <p class="pro-vouch">VOUCHERS</p>
                                    <div class="form-group text-left form_productname">
{{--                                        <label for="productname">Product</label>--}}
                                        <input type="hidden" name="productname" id="productname" placeholder=""
                                               disabled  required>
                                    </div>
                                    <div class="col-item">
                                        <div class="tt-input-counter style-01">
                                            <span class="minus-btn"></span>
                                            <input name="qantity" id="qantity" placeholder="" min="1" value="1" type="text" value="1" size="5" required>
                                            <span class="plus-btn"></span>
                                        </div>
                                    </div>
                                    <div class="modal-form-container">
                                        <div class="">
                                            <div class="form-group">
                                                <label for="size">Email Address:</label>
                                                <input class="form-control" name="email" type="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="size">Phone Number:</label>
                                                <input class="form-control" name="phone_no" type="tel" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-price">
                                        <p class="sigma-price price_current">198,040 <span>Sigma Stars</span></p>

                                    </div>
                                    <div class="tt-wrapper tt-row-custom-01">
                                        <button type="button" class="btn btn-default pay_bills_btn custom_button_color"><i class="fa fa-spinner fa-spin off redeem_process_indicator"></i> Redeem</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="take-out-container">
        <div class="meal-slider-container">
            <div class="centered">
                <h2>
                    Redeem Uber Voucher today With Sigma Prime
                </h2>
                <button type="button" class="btn btn-default voucher-btn">Uber</button>
            </div>
            <img src="{{asset('images/voucher-images/banner.png')}}" width="100%" />
        </div>
    </div>


    <div style="padding-left: 10%; padding-right: 10%; margin-top: 5%; margin-bottom: 5%;" id="tt-pageContent top-destination-container">

        @if(isset($response->status))
            @if($response->status == 1)

        <div class="container-indent0">
            <div class="container-fluid">
                <div style="margin-bottom: 5%;" class="top-destination-title">
                    <h3>UBER VOUCHERS ({{count($response->data)}})</h3>
                </div>
                <div class="row tt-layout-promo-box">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            @if(isset($response))
                                @if($response->status == 1)
                                    @foreach($response->data as $item)
                            <div class="col-sm-6 col-md-3">
                                <a href="#" class="tt-promo-box tt-one-child hover-type-2 subscribe_bills_btn" data-signature="{{$item->signature}}"
                                   data-price="{{$item->price}}"
                                   data-max_quantity="{{$item->max_quantity}}"
                                   data-packagename="{{$item->product_name}}"
                                   data-price_name="{{$cs->is_currency_fixed == '1' ? '&#8358;'.transform_product_price($item->price, 1) : transform_product_price($item->price, $cs->rate ) .' '. $cs->currency }}">
                                    @if(isset($response->data[0]->image))
                                    <img src="{{asset('images/loader.svg')}}" data-src="{{$response->data[0]->image}}" alt="{{ucwords(strtolower($item->product_name))}}">
                                   @endif
                                    <div class="tt-description">
                                    </div>

                                <p class="uber-voucher-text">{{ucwords(strtolower($item->product_name))}}</p>
                                </a>
                            </div>
                                    @endforeach
                                @endif

                            @else
                                <div class="container" style="margin-top: 10em; margin-bottom: 10em; text-align: center;">
                                    <img class="text-center" alt="" src="{{asset('images/not_found.png')}}" style="width: 200px;">
                                    <h3 class="text-center">No content found</h3>
                                    <h4 class="text-center">We currently do not have content for the selected category. Check again soon.</h4>
                                </div>

                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>

            @endif
        @endif

    </div>







@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
    <style>
        body{
            background: #fff !important;
        }
        .bill_product{
            -webkit-box-shadow: 0px 0px 8px -7px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 8px -7px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 8px -7px rgba(0,0,0,0.75);
            margin-bottom: 20px;
            text-align: left;
            overflow-wrap: break-word;
            height: 120px;
            min-height: 120px;
            max-height: 120px;
            padding: 10px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }
    </style>
@endpush
@push('script')
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
    <script>
        $('.sidebar').theiaStickySidebar({
            // Settings
            additionalMarginTop: 30
        });


        var conversionRate = "<?php echo $cs->rate ;?>"
        var appCurrency = "<?php echo $cs->currency ;?>"
        var appCurrencyFixed = "<?php echo $cs->is_currency_fixed ;?>"

        var signature, price, price_name, packagename, max_quantity;
        $(document).ready(function () {

            //Checkout button event
            $(".subscribe_bills_btn").on('click', function (event) {
                // $("div.form_fullname").show();
                // $("div.form_productname").show();

                var login = $('.login-status').val();

                if(login == 0){
                    location.replace('{{url("login")}}');
                    return false;
                }

                event.preventDefault();
                signature = $(this).data('signature');
                price = $(this).data('price');
                price_name = $(this).data('price_name');
                packagename = $(this).data('packagename');
                max_quantity = $(this).data('max_quantity');


                //Check Max quantity
                if(max_quantity == 0){
                    alertui.alert('Alert', 'Voucher unavailable.');
                    swal("","Voucher unavailable.", "error");
                    return false;
                }

                // $("input[name='customer_id_text']").prop('placeholder', customerfield);
                $("input[name='productname']").prop('placeholder', packagename);
                $('.pro-vouch').html(packagename);
                $("input[name='productname']").val(packagename);
                $("input[name='pricename']").prop('placeholder', price_name);
                $(".price_current").html(price_name);
                $("#modal").modal('show')
            })

            $(".pay_bills_btn").click(function () {
                email = $("input[name='email']").val()
                phone_no = $("input[name='phone_no']").val()

                if (email == '') {
                    alertui.notify('error', 'Email is required');
                    swal("",'Email is required', "error");
                    return false;
                }
                if (phone_no == '') {
                    alertui.notify('error', 'Phone number is required');
                    swal("",'Phone number is required', "error");
                    return false;
                }

                $(".redeem_process_indicator").removeClass('off');
                disableItem($(this), true)

                $.post("{{url('api/redeem_uber')}}", {
                    signature: signature,
                    price: price,
                    email: email,
                    phone_no: phone_no,
                    packagename: packagename,
                    qty: 1,
                    max_quantity: max_quantity,
                })
                    .done(function (res) {
                        disableItem($(".pay_bills_btn"), false)
                        $(".redeem_process_indicator").addClass('off');
                        // handle success
                        if (!res) {
                            alertui.notify('success', 'Failed to complete payment');
                            swal("",'Failed to complete payment', "error");
                            return false;
                        }
                        if (res.status == '400') {
                            alertui.notify('error', res.data);
                            swal("",res.data, "error");
                            return false;
                        }
                        if (res.status == 'fail') {
                            alertui.notify('error', res.data);
                            swal("",res.data, "error");
                            return false;
                        }
                        if (res.status == 'validation') {
                            alertui.notify('error', res.message);
                            swal("",res.message, "error");
                            return false;
                        }
                        if (res.status == '200') {
                            updateAccount(res.account)
                            alertui.notify('success', res.message)

                            $('#modal').modal('hide');
                            swal("",res.message, "success");
                            window.location.replace("{{url('ordercomplete')}}/"+res.data)

                            {{--$('#modal').modal('hide');--}}
                            {{--$('#modal').on('hidden.bs.modal', function (e) {--}}
                            {{--$('#ordernotify').modal('show');--}}
                            {{--});--}}
                            {{--var oldlink = $("#order_receipt").prop('href');--}}
                            {{--$('#ordernotify').on('shown.bs.modal', function (e) {--}}
                            {{--$("#order_receipt").prop('href', '');--}}
                            {{--$("#order_receipt").prop('href', "{{url('ordercomplete')}}" + '/' + res.data);--}}
                            {{--});--}}
                        }
                    })
                    .fail(function (response, status, error) {
                        // handle error
                        $(".redeem_process_indicator").addClass('off');
                        disableItem($(".pay_bills_btn"), false)
                        if (response.status == 500) {
                            alertui.notify('error', 'An Error Occurred. Please try again.')
                            swal("",'An Error Occurred. Please try again.', "error");
                        }
                        else {
                            alertui.notify('info', response.responseJSON.data)
                            swal("",response.responseJSON.data, "error");
                        }

                    })
            });

            $("input[name='qantity']").on('change', function (e) {

                var quantity_input = $(this).val();

                    if(quantity_input > max_quantity){
                        alertui.alert('Alert!', 'Sorry! Quantity unavailable for voucher');
                        swal("",'Sorry! Quantity unavailable for voucher', "error");
                        $(this).val(1);
                        return false;
                    }
                    if (appCurrencyFixed == 1) {
                        //Currency fixed
                        var new_price = new Intl.NumberFormat('en-GB').format(Math.ceil(price * quantity_input));
                        new_price = "&#8358;" + new_price;

                        $(".price_current").html(new_price);
                    } else {

                        var new_price = new Intl.NumberFormat('en-GB').format(Math.ceil((price * quantity_input) * conversionRate));
                        new_price += " " + appCurrency

                        $(".price_current").html(new_price);
                    }
            })

        })


        $('#modal').on('hidden.bs.modal', function (e) {
            $(".process_indicator").addClass('off');
        })



    </script>
@endpush
