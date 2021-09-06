<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Bills  - {{config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{{asset('assets/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-techmarket.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
</head>

<body class="woocommerce-active page-template-template-homepage-v1 can-uppercase">
@if($errors->any())
    @include('partials.notify', ['text' => $errors->first()])
@endif
<div id="page" class="hfeed site">
@include('partials.nav_general')
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title modal_category_title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body text-center">
                    <h2>Enter details</h2>
                    <div class="row justify-content-center">
                    <div class="col-sm-6">

                    <div class="form-group">
                    <input type="text" name="email" placeholder="Email address" class="form-control" required>
                    </div>

                    <div class="form-group">
                    <input type="tel" name="phone_no" placeholder="Phone" class="form-control" required>
                    </div>

                        <div class="form-group">
                    <input type="tel" name="customer_id_text" placeholder="" class="form-control" required>
                    </div>

                    </div>
                    </div>
                    <br><br>
                    <a>
                        <button type="button" class="btn btn-large btn-primary pay_bills_btn custom_button_color"><i class="fa fa-spinner fa-spin off process_indicator"></i> Redeem</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <h2>Order Complete</h2>
                    <br><br>
                    <img src="{{asset('assets/images/check.png')}}" alt="" style="margin: 0 auto;">
                    <br><br>
                    <a href="{{route('ordercomplete', ['id' => ''])}}" id="order_receipt">
                        <button type="button" class="btn btn-large btn-primary custom_button_color">View receipt</button>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div id="content" class="site-content">
        @include('partials.bills.slider')
        <div class="col-full" id="shop">
            <div class="row">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">
                        <section class="full-width section-products-carousel-tabs section-product-carousel-with-featured-product carousel-with-featured-1">
                            @if(isset($products))
                                @if($products->status == 1)
                                    <header class="section-header mt-4">
                                        <h4 class="section-title custom_page_title custom_color"
                                            >Available Packages</h4>
                                        </ul>
                                    </header>
                                    <div class="container">
                                        <div class="row">
                                            @foreach($products->data as $item)
                                                <div class="col-sm-6">
                                                        @if(strtolower($item->product_name) == 'family')
                                                        <div class="providers_list position-relative"
                                                        style="
                                                                background-color: #271249;
                                                                background: url({{asset('assets/images/dstv/family.jpg')}});
                                                                background-size: cover;
                                                                background-position: center center;
                                                                background-repeat: no-repeat;
                                                                text-align: center;
                                                                padding: 50px 10px;
                                                                min-height: 200px;
                                                            "
                                                        >

                                                            @elseif(strtolower($item->product_name) == 'compact')
                                                                <div class="providers_list position-relative"
                                                                     style="
                                                                             background-color: #271249;
                                                                             background: url({{asset('assets/images/dstv/compact.jpg')}});
                                                                             background-size: cover;
                                                                             background-position: center center;
                                                                             background-repeat: no-repeat;
                                                                             text-align: center;
                                                                             padding: 50px 10px;
                                                                             min-height: 200px;
                                                                             "
                                                                >
                                                                    @elseif(strtolower($item->product_name) == 'access')
                                                                        <div class="providers_list position-relative"
                                                                             style="
                                                                                     background-color: #271249;
                                                                                     background: url({{asset('assets/images/dstv/access.jpg')}});
                                                                                     background-size: cover;
                                                                                     background-position: center center;
                                                                                     background-repeat: no-repeat;
                                                                                     text-align: center;
                                                                                     padding: 50px 10px;
                                                                                     min-height: 200px;
                                                                                     "
                                                                        >
                                                                            @elseif(strtolower($item->product_name) == 'premium')
                                                                                <div class="providers_list position-relative"
                                                                                     style="
                                                                                             background-color: #271249;
                                                                                             background: url({{asset('assets/images/dstv/premium.jpg')}});
                                                                                             background-size: cover;
                                                                                             background-position: center center;
                                                                                             background-repeat: no-repeat;
                                                                                             text-align: center;
                                                                                             padding: 50px 10px;
                                                                                             min-height: 200px;
                                                                                             "
                                                                                >
                                                                @endif
                                                            <div style="
                                                            color: #fff;
                                                            font-weight: 600;
                                                            font-size: 1.8em;
                                                            position:absolute;
                                                            bottom: 0;
                                                            left: 0;
                                                            padding: 10px 20px;
                                                            width:100%;
                                                            ">
                                                                <div class="row">
                                                                    <div class="col-xs-6 col-sm-6 text-center">

                                                            @if(Auth::check())
                                                                @if(Auth::user()->currency->is_currency_fixed == '1')
                                                                    <span style="color: #fff; font-size:14px">&#8358;{{ (number_format( $item->price)) }}</span>
                                                                @else
                                                                    <span style="color: #fff; font-size:14px">{{ (number_format( Auth::user()->currency->rate * $item->price)) }} {{Auth::user()->currency->currency}}</span>
                                                                @endif
                                                            @endif
                                                                    </div>
                                                                    <div class="col-xs-6 col-sm-6">
                                                                    <button class="btn btn-outline-info btn-md btn-block">
                                                                        <a href="#" class="subscribe_bills_btn text-white"
                                                                           data-signature="{{$item->signature}}"
                                                                           data-price="{{$item->price}}"
                                                                           data-customerfield="{{$item->customer_id_text}}"
                                                                           data-packagename = "{{$products->category}} {{$item->product_name}}"
                                                                        >
                                                                            <span class="font-weight-bold">Subscribe</span></a>
                                                                    </button>
                                                                    </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </section>
                    </main>
                </div>
            </div>
            @include('partials.banner', ['page' => 'catalogue'])
        </div>
    </div>

    @include('partials.newfooter')
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script>
    $(".overlay").click(function(){
        $(this).hide();
    });
    var signature, price, email, phone_no, customer_id, packagename

    var baseUrl = "<?php echo config('app.base_url')?>";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        //Checkout button event
        $(".subscribe_bills_btn").on('click', function (event) {
            event.preventDefault();
            signature = $(this).data('signature');
            price = $(this).data('price');
            packagename = $(this).data('packagename');
            $("input[name='customer_id_text']").prop('placeholder', $(this).data('customerfield'));
            $(".modal_category_title").html(packagename);
            $("#modal").modal('show')


                $(".pay_bills_btn").click(function () {
                    email = $("input[name='email']").val();
                    phone_no = $("input[name='phone_no']").val();
                    customer_id = $("input[name='customer_id_text']").val();

                    if(email == ''){
                        alertui.notify('error', 'Email is required')
                    }
                    if(phone_no == ''){
                        alertui.notify('error', 'Phone number is required')
                    }
                    $(".process_indicator").removeClass('off');
                    $.post(baseUrl+'redeem_bill',{
                        signature: signature,
                        price: price,
                        email: email,
                        phone_no: phone_no,
                        customer_id: customer_id,
                        packagename: packagename
                    })
                        .done(function (res) {
                            $(".process_indicator").addClass('off');
                            // handle success
                            if (!res) {
                                alertui.notify('success','Failed to complete payment');
                                return false;
                            }
                            if (res.status == '400') {
                                alertui.notify('error',res.data.message);
                                return false;
                            }
                            if (res.status == 'fail') {
                                alertui.notify('error',res.data);
                                return false;
                            }
                            if (res.status == '200') {
                                $('#modal').modal('hide');
                                $('#modal').on('hidden.bs.modal', function (e) {
                                    $('#ordernotify').modal('show');
                                });
                                var oldlink = $("#order_receipt").prop('href');
                                $('#ordernotify').on('shown.bs.modal', function (e) {
                                    $("#order_receipt").prop('href', '');
                                    $("#order_receipt").prop('href', "{{url('ordercomplete')}}"+'/'+res.data);
                                });
                            }
                        })
                        .fail(function (error) {
                            // handle error
                            $(".process_indicator").addClass('off');
                            $(".orderloader").hide();
                            console.log(error)
                            alertui.notify('error', 'Please complete the order form');
                        })
                })
            })

    })

</script>
</body>

</html>