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

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div iv class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                </div>
                <div class="modal-body">
                    <div class="tt-modal-quickview desctope view-discount-container">
                    <div class="row">
                        <div class="col-12 col-md-5 col-lg-5">
                            <img src="{{$products->image}}" width="80%" alt="preview" />
                        </div>
                        <div class="col-12 col-md-5 col-lg-5">
                            <div class="tt-product-single-info">
                                <div class="modal-form-container">
                        <h4 class="modal_category_title text-left"></h4>

                            <div class="form1">
                                <p class="modal_category_price sigma-price text-left" style="margin-bottom: 35px;"></p>
                                <div class="">
                                    <div class="form-group">
                                    <input type="text" name="customer_id_text" placeholder="" style="width: 100%" class="form-control"
                                           required>
                                </div>
                                </div>
                            </div>

                            <div class="row form2 noshow" style="display: block;">

                                <h4>Order Summary</h4>
                                <div class="">
                                    <div class="form-group form_productname">
                                    <label for="productname">Product</label>
                                    <input type="text" style="width: 100%" name="productname" id="productname" placeholder=""
                                           disabled class="form-control" required>
                                </div>
                                </div>

                                <div class="">
                                    <div class="form-group">
                                    <label for="deviceno">Device no</label>
                                    <input type="text" style="width: 100%" name="deviceno" id="deviceno" placeholder="" class="form-control"
                                           disabled required>
                                </div>
                                </div>

                                <div class="">
                                    <div class="form-group form_fullname">
                                    <label for="fullname">Full name</label>
                                    <input type="text" style="width: 100%" name="fullname" id="fullname" placeholder="" class="form-control"
                                           disabled required>
                                </div>
                                </div>

                                <div class="">
                                    <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="text" style="width: 100%" name="email" id="email" placeholder="" class="form-control"
                                           required>
                                </div>
                                </div>

                                <div class="">
                                    <div class="form-group">
                                    <label for="phone_no">Phone</label>
                                    <input type="tel" style="width: 100%" name="phone_no" id="phone_no" placeholder="" class="form-control"
                                           required>
                                </div>
                                </div>

                                <p class="modal_category_price sigma-price text-left" style="margin-bottom: 35px;"></p>

                            </div>

                            <button type="button"
                                    class="btn btn-large btn-block btn-primary nextform custom_button_color">
                                <i class="fa fa-spinner fa-spin off validate_process_indicator"></i>
                                Validate
                            </button>

                            <div class="sendformdiv noshow">
                                <button type="button" class="btn btn-large btn-primary prevform custom_button_color">
                                    Back
                                </button>
                                <button type="button"
                                        class="btn btn-large btn-primary pay_bills_btn custom_button_color">
                                    <i class="fa fa-spinner fa-spin off redeem_process_indicator"></i> Redeem
                                </button>
                            </div>

                            </div>
                            </div>
                        </div>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
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
                    <h4 class="order_response">Order confirmed!</h4>
                    <br><br>
                    <div class="row" role="group" aria-label="">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="col-sm-6" role="group">
                                <a type="button" data-dismiss="modal" aria-label="Close" class="btn btn-large custom_button_color" style="width: 100%; height: 40px;">
                                    <span>Continue Shopping</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="col-sm-6" role="group">
                                <a href="{{route('ordercomplete', ['id' => ''])}}" id="order_receipt" class="btn btn-large custom_button_color_2"  style="width: 100%; height: 40px;">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>View Receipt</span>
                                </a>
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
                <h3>
                    {{ucwords($products->category)}}
                </h3>
            </div>
            <img src="{{asset('images/slides/bg.png')}}" width="100%" />
        </div>

    </div>

    <!-- View Experience -->
    <div class="view-experience-container view-bills-container mb30">
        <div id="tt-pageContent">
            <div class="container-indent">
                <div class="container container-fluid-custom-mobile-padding">
                    <div class="colored-icons">
                        <a href="{{url()->previous()}}">
                            <i class="fa fa-arrow-left" aria-hidden="true">
                                <span>Back</span>
                            </i>
                        </a>
                    </div>

                    @if(isset($products))
                        @if($products->status == 1)
                    <div class="row tt-layout-product-item">

                        @foreach($products->data as $item)
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="tt-product thumbprod-center">
                                    <a href="#">
                                        <img src="{{$products->image}}" width="100%" alt="{{$products->category}}" />
                                    </a>
                                </div>
                                <div class="product-description">
                                    <h5>{{ucwords(strtolower($item->product_name))}}</h5>
                                    <button class="btn btn-xs custom_button_color no-height">
                                        <a href="#"
                                           class="subscribe_bills_btn text-white btn btn-md btn-block no-height"
                                           data-signature="{{$item->signature}}"
                                           data-price="{{$item->price}}"
                                           data-price_name="{{$cs->is_currency_fixed == '1' ? '&#8358;'.transform_product_price($item->price, 1) : transform_product_price($item->price, $cs->rate ) .' '. $cs->currency }}"
                                           data-customerfield="{{$item->customer_id_text}}"
                                           data-packagename="{{$products->category}} - {{$item->product_name}}"
                                           style="color: #fff"
                                        >
                                            <span class="font-weight-bold">Redeem</span></a>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                        @endif
                        @endif
                </div>






            </div>
        </div>
    </div>

@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('sigma/css/alertui.min.css')}}">
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
        var signature, price, email, phone_no, customer_id, packagename, customerfield

        var baseUrl = "<?php echo config('app.base_url')?>";
        var appUrl = "<?php echo config('app.url')?>";

        $(document).ready(function () {
            $(".form2").hide();
            $(".form1").show();
            $(".nextform").show();
            $(".sendformdiv").hide();
            $("input[name='customer_id_text']").val('');

            //Checkout button event
            // $(".tt-pageContent").on('click', ".subscribe_bills_btn", function (event) {
            // $(".subscribe_bills_btn").on('click', function (event) {
            // $(".subscribe_bills_btn").click(function (event) {
            $(".subscribe_bills_btn").click(function(){
                var login = $('.login-status').val();

                if(login == 0){
                    location.replace('{{url("login")}}');
                    return false;
                }

                $("div.form_fullname").show();
                $("div.form_productname").show();
                event.preventDefault();
                signature = $(this).data('signature');
                price = $(this).data('price');
                price_name = $(this).data('price_name');
                packagename = $(this).data('packagename');
                customerfield = $(this).data('customerfield');

               if(packagename == ''){
                   $("div.form_productname").hide();
               }

                $("input[name='customer_id_text']").prop('placeholder', customerfield);
                $("input[name='productname']").prop('placeholder', packagename);
                $(".modal_category_title").html(packagename);
                $(".modal_category_price").html(price_name);
                $("#modal").modal('show')
            })

            $(".pay_bills_btn").click(function () {
                email = $("input[name='email']").val()
                phone_no = $("input[name='phone_no']").val()
                customer_id = $("input[name='customer_id_text']").val();

                if (email == '') {
                    alertui.notify('error', 'Email is required');
                    swal("",'Email is required', "error");

                    return false;
                }
                if (phone_no == '') {
                    alertui.notify('error', 'Phone number is required');
                    swal("",'Phone number is required.', "error");

                    return false;
                }

                $(".redeem_process_indicator").removeClass('off');
                disableItem($(this), true)
                $.post("{{url('api/redeem_bill')}}", {
                    signature: signature,
                    price: price,
                    email: email,
                    phone_no: phone_no,
                    customer_id: customer_id,
                    packagename: packagename,
                    customerfield: customerfield
                })
                    .done(function (res) {
                        disableItem($(".pay_bills_btn"), false)
                        $(".redeem_process_indicator").addClass('off');
                        // handle success
                        if (!res) {
                            alertui.notify('error', 'Failed to complete payment');
                            swal("",'Failed to complete payment.', "error");

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
                        if (res.status == '200') {
                            updateAccount(res.account)
                            alertui.notify('success', res.message)
                            swal("",res.message, "success");

                            $('#modal').modal('hide');
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
                            swal("",'An Error Occurred. Please try again.', "error");

                            alertui.notify('error', 'An Error Occurred. Please try again.')
                        }
                        else {
                            alertui.notify('info', response.responseJSON.data)
                            swal("",response.responseJSON.data, "error");

                        }

                    })
            });


            $(".nextform").click(function (e) {
                $("div.form_fullname").show();
                disableItem($(".nextform"), true)
                $("i.validate_process_indicator").removeClass('off');
                if($("input[name='customer_id_text']").val() == '' || $("input[name='customer_id_text']").val().length < 5){
                    $("i.validate_process_indicator").addClass('off');
                    alertui.notify('info', 'Please enter a valid Customer Code');
                    disableItem($(".nextform"), false)
                    return false;
                }else{
                    $(".nextform .process_indicator").addClass('off');

                    $.post("{{url('api/validate_code')}}", {
                        signature: $('.subscribe_bills_btn').data('signature'),
                        customer_id: $("input[name='customer_id_text']").val()
                    })
                        .done(function (res) {
                            disableItem($(".nextform"), false)
                            $("i.validate_process_indicator").addClass('off');
                            // handle success
                            if (!res) {
                                alertui.notify('error', 'Failed to complete payment');
                                swal("",'Failed to complete payment.', "error");

                                return false;
                            }
                            if (res.status == '400') {
                                alertui.notify('info', res.data);
                                swal("",res.data, "error");

                                return false;
                            }
                            if (res.status == 'fail') {
                                alertui.notify('info', res.data);
                                swal("",res.data, "error");
                                return false;
                            }
                            if (res.status == '200') {
                                $(".form1").hide();
                                $(".form2").show();
                                $(".nextform").hide();
                                $(".sendformdiv").show();
                                $(this).hide();
                                if(res.data.name == ''){
                                    $("div.form_fullname").hide();
                                }else {
                                    $("input[name='fullname']").prop('placeholder', res.data.name);
                                }
                                $("input[name='deviceno']").val($("input[name='customer_id_text']").val());
                            }
                        })
                        .fail(function (response, status, error) {
                            // handle error
                            $("i.validate_process_indicator").addClass('off');
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
                }


            })


        })


        $('#modal').on('hidden.bs.modal', function (e) {
            $(".form2").hide();
            $(".form1").show();
            $(".nextform").show();
            $(".sendformdiv").hide();
            $("input[name='customer_id_text']").val('');
            disableItem($(".nextform"), false)
            $(".process_indicator").addClass('off');
        })

        $(".prevform").click(function (e) {
            $(".form2").hide();
            $(".form1").show();
            $(".nextform").show();
            $(".sendformdiv").hide();
        })

    </script>
    @endpush
