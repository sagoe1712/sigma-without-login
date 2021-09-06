@extends('layouts.main')
{{--@push('catalogue-nav')--}}
{{--    @include('partials.general.catalogue-nav')--}}
{{--@endpush--}}
@section('content')
{{--{{var_dump($pendingcart)}}--}}
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

<div id="tt-pageContent">
    <div class="wish-list-bg">
        <div class="centered">
            <h5>SHOPPING CART</h5>
        </div>
        <img class="wish-list-img" src="{{asset('images/slides/bg.png')}}" width="100%" />
    </div>

    <div class="shopping-cart-container margin-bottom">
        @if(isset($pendingcart) && count($pendingcart) > 0)
            @php
                $ifdelivery = 1;
            @endphp
        <div class="row">
            <div class="col-2 col-md-2 col-lg-2">
                <p class="grey-text">Item</p>
            </div>
            <div class="col-2 col-md-2 col-lg-2">
                <p class="grey-text">Description</p>
            </div>
            <div class="col-md-2 col-lg-2">
                <p class="grey-text">Redemption Type</p>
            </div>
            <div class="col-md-1 col-lg-1">
                <p class="grey-text">Unit Price</p>
            </div>
            <div class="col-md-2 col-lg-2">
                <p class="grey-text">Quantity</p>
            </div>
            <div class="col-md-1 col-lg-1">
                <p class="grey-text">Subtotal</p>
            </div>
            <div class="col-md-1 col-lg-1">

            </div>

        </div>
        <hr />
            @foreach($pendingcart as $item)
                @php
                    if($item->delivery_type == 2){
                    $ifdelivery = 2;
                    }
                @endphp
        <div class="row" id="{{$item->id}}">
            <div class="col-md-2 col-lg-2">
                <img src="{{$item->image}}" alt="image" width="70%" />
            </div>
            <div class="col-md-2 col-lg-2">
                <p class="bold-text">{{$item->name}}</p>
                @if($item->attrib)
                    <p style="font-weight: bolder;"><b>( {{rtrim(trim($item->attrib->value),",")}} )</b></p>
                @endif
            </div>
            <div class="col-md-2 col-lg-2">
                @if($item->delivery_type == 2)
                    <p class="bold-text" title="Delivery">Delivery</p>
                @else
                    <p class="bold-text" title="Pickup">Pickup</p>
                @endif
            </div>
            <div class="col-md-1 col-lg-1">
                @if(Auth::check())
                    @if(Auth::user()->currency->is_currency_fixed == '1')
                        <p class="cart-sub-total-price bold-text"><span>&#8358;</span>{{transform_product_price($item->price, 1) }}</p>
                    @else
                        <p class="cart-sub-total-price bold-text"><span>{{ transform_product_price($item->price, Auth::user()->currency->rate )  }}</span> {{Auth::user()->currency->currency}}</p>
                    @endif
                @endif
            </div>
            <div class="col-md-2 col-lg-2">
                <div class="tt-input-counter style-01">
                    <span class="minus-btn"></span>
                    <input type="number" min="1" id="{{$item->id}}" name="orderqty" value="{{$item->qty}}" size="5" class="orderqty">
                    <span class="plus-btn"></span>
                </div>
            </div>
            <div class="col-md-1 col-lg-1">
                @if(Auth::user()->currency->is_currency_fixed == '1')
                    <p class="cart-grand-total-price bold-text"> {{transform_product_price(($item->price * $item->qty), 1) }}</p>
                @else
                    <p class="cart-grand-total-price bold-text">{{ transform_product_price(($item->price * $item->qty), Auth::user()->currency->rate ) }}   <span class="green-text">{{Auth::user()->currency->currency}}</span></p>
                @endif
            </div>
            <div class="col-md-1 col-lg-1 romove-item">
            <a href="#" id="{{$item->id}}"  title="cancel" class="tt-btn-close remove">
                <i class="fa fa-trash"></i>
            </a>
            </div>

        </div>
        <hr />
            @endforeach

        <div class="row">
            <div class="col-md-6 colored-icons">
                <a href="{{url('catalogue')}}">
                    <i class="fa fa-arrow-left" aria-hidden="true">
                        <span>Continue Shopping</span>
                    </i>
                </a>


            </div>
            <div class="col-md-3 col-lg-3 colored-icons">
{{--                <a href="{{url('catalogue')}}">--}}
{{--                    <i class="fa fa-trash-o" aria-hidden="true">--}}
{{--                        <span>Continue Shopping</span>--}}
{{--                    </i>--}}
{{--                </a>--}}
            </div>
            <div class="col-md-3 col-lg-3 colored-icons">
                <a href="{{url('cart')}}">
                    <i class="fa fa-refresh" aria-hidden="true">
                        <span>Refresh Shopping Cart</span>
                    </i>
                </a>
            </div>

        </div>
        <div class="shop-checkout-container">
            <div class="whitebg-container">
                <div class="checkout-flexed">
                    <p class="grey-text">Subtotal</p>
                    <p class="bold-text">
                        @if(Auth::check())
                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                <span>&#8358;</span> @php echo $pendingcartsum ? transform_product_price($pendingcartsum[0], 1) : '0' @endphp
                            @else
                                @php echo $pendingcartsum ? transform_product_price($pendingcartsum[0], Auth::user()->currency->rate ). ' <span class="green-text">'. Auth::user()->currency->currency : '0</span>' @endphp
                            @endif
                        @endif
                    </p>
                </div>
                @if($ifdelivery == 1)
                    <button type="button" class="btn btn-lg checkout-btn custom_button_color_2" id="checkoutbtn" style="width: 100%;">
                        <i class="fa fa-spinner fa-spin off process_indicator"></i> <span class="purchase_action_text" style="color:#fff;"> PAY </span></button>
                @elseif($ifdelivery == 2)
                    <a href="{{url('checkout')}}"  class="btn btn-lg checkout-btn custom_button_color" style="width: 100%;">PROCEED TO CHECKOUT</a>
                @endif
            </div>
        </div>
        @else
            <div class="row justify-content-center align-items-center text-center">
                <div class="col">
                    <img src="{{asset('images/cart/shopping-cart-icon.png')}}" alt="" style="margin: 10px auto; width: 10%;">
                    <h3 class="text-center mb-5">Your Cart is empty</h3>
                </div>
            </div>
        @endif
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
<style>
    .table{width:100%;max-width:100%;margin-bottom:1rem;background-color:transparent}.table td,.table th{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table-sm td,.table-sm th{padding:.3rem}.table-bordered{border:1px solid #dee2e6}.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}.table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}.table-hover tbody tr:hover{background-color:rgba(0,0,0,.075)}.table-primary,.table-primary>td,.table-primary>th{background-color:#b8daff}.table-hover .table-primary:hover{background-color:#9fcdff}.table-hover .table-primary:hover>td,.table-hover .table-primary:hover>th{background-color:#9fcdff}.table-secondary,.table-secondary>td,.table-secondary>th{background-color:#d6d8db}.table-hover .table-secondary:hover{background-color:#c8cbcf}.table-hover .table-secondary:hover>td,.table-hover .table-secondary:hover>th{background-color:#c8cbcf}.table-success,.table-success>td,.table-success>th{background-color:#c3e6cb}.table-hover .table-success:hover{background-color:#b1dfbb}.table-hover .table-success:hover>td,.table-hover .table-success:hover>th{background-color:#b1dfbb}.table-info,.table-info>td,.table-info>th{background-color:#bee5eb}.table-hover .table-info:hover{background-color:#abdde5}.table-hover .table-info:hover>td,.table-hover .table-info:hover>th{background-color:#abdde5}.table-warning,.table-warning>td,.table-warning>th{background-color:#ffeeba}.table-hover .table-warning:hover{background-color:#ffe8a1}.table-hover .table-warning:hover>td,.table-hover .table-warning:hover>th{background-color:#ffe8a1}.table-danger,.table-danger>td,.table-danger>th{background-color:#f5c6cb}.table-hover .table-danger:hover{background-color:#f1b0b7}.table-hover .table-danger:hover>td,.table-hover .table-danger:hover>th{background-color:#f1b0b7}.table-light,.table-light>td,.table-light>th{background-color:#fdfdfe}.table-hover .table-light:hover{background-color:#ececf6}.table-hover .table-light:hover>td,.table-hover .table-light:hover>th{background-color:#ececf6}.table-dark,.table-dark>td,.table-dark>th{background-color:#c6c8ca}.table-hover .table-dark:hover{background-color:#b9bbbe}.table-hover .table-dark:hover>td,.table-hover .table-dark:hover>th{background-color:#b9bbbe}.table-active,.table-active>td,.table-active>th{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover{background-color:rgba(0,0,0,.075)}.table-hover .table-active:hover>td,.table-hover .table-active:hover>th{background-color:rgba(0,0,0,.075)}.table .thead-dark th{color:#fff;background-color:#212529;border-color:#32383e}.table .thead-light th{color:#495057;background-color:#e9ecef;border-color:#dee2e6}.table-dark{color:#fff;background-color:#212529}.table-dark td,.table-dark th,.table-dark thead th{border-color:#32383e}.table-dark.table-bordered{border:0}.table-dark.table-striped tbody tr:nth-of-type(odd){background-color:rgba(255,255,255,.05)}.table-dark.table-hover tbody tr:hover{background-color:rgba(255,255,255,.075)}@media (max-width:575.98px){.table-responsive-sm{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-sm>.table-bordered{border:0}}@media (max-width:767.98px){.table-responsive-md{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-md>.table-bordered{border:0}}@media (max-width:991.98px){.table-responsive-lg{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-lg>.table-bordered{border:0}}@media (max-width:1199.98px){.table-responsive-xl{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive-xl>.table-bordered{border:0}}.table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;-ms-overflow-style:-ms-autohiding-scrollbar}.table-responsive>.table-bordered{border:0}.form-control{display:block;width:100%;padding:.375rem .75rem;font-size:1rem;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}
</style>
        @endpush
@push('script')
            <script src="{{asset('js/alertui.min.js')}}"></script>
            <script src="{{ asset('js/lodash.min.js')}}"></script>
            <script>
                var processState = 0;
                var cartItems = [];

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(".overlay").click(function(){
                    $(this).hide();
                })


                var update = function() {

                    var item = {id:$(this).prop('id'), qty:$(this).val() };
                    var cartItems = [];
                    $("input[name='orderqty']").each(function () {
                        var item = {id:$(this).prop('id'), qty:$(this).val() };
                        cartItems.push(item);
                    })
                    $.post("{!! url('update_cart') !!}",{items:cartItems})
                        .done(function (res) {
                            if(!res){
                                alertui.notify('error', 'Failed to update cart');
                                swal("Cart",'Failed to update cart.', "error");

                                return false;
                            }
                            if(res.status == '400'){
                                alertui.notify('error', res.data);
                                swal("Cart",res.data, "error");
                                return false;
                            }
                            alertui.notify('success', 'Success cart updated');
                            swal("Cart",'Success Cart Updated', "success");

                            setTimeout(function () {
                                location.reload()
                            }, 2000);
                        })
                        .fail(function (error) {
                            if(response.status == 500){
                                alertui.notify('error', 'Apologies, an error occurred. Failed update cart');
                                swal("Cart",'Apologies, an error occurred. Failed update cart.', "error");
                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                                swal("Cart",response.responseJSON.data, "error");
                            }
                        })
                };

                $(document).ready(function () {

                    $(".remove").on('click', function () {
                        popcartitem($(this).attr('id'))
                    });


                    $(".orderqty").on({
                        change: _.debounce(update, 2000)
                    });

                    //Checkout button event
                    $("#checkoutbtn").click(function (event) {
                        event.preventDefault();
                        checkout_redeem();
                    });

                    $(".update-button").on('click', function(e) {
                        e.preventDefault();
                        cartItems = [];
                        $("input[name='orderqty']").each(function () {
                            var item = {id:$(this).prop('id'), qty:$(this).val() };
                            cartItems.push(item);
                        })
                        // console.log(cartItems);
                        updatecart()
                    });
                })

                function popcartitem(id) {

                    alertui.confirm('Confirm Remove'
                        , 'Do you want to remove this item from your Cart? '
                        , function () {
                            $('#' + id + '.remove').html('<img src="{{asset('assets/images/spinnerb.gif')}}" style="width: 60px"/>')
                            $.post("{{url('api/delete_cart_item')}}", {id: id})
                                .done(function (res) {
                                    // handle success
                                    if (!res) {
                                        $('#' + id + '.remove').html('<i class="fa fa-trash-o"></i>');
                                        alertui.notify('error', 'Failed to update your cart');
                                        swal("Cart",'Failed to update your cart', "error");
                                        return false;
                                    }
                                    if (res.data.status == '400') {
                                        $('#' + id + '.remove').html('<i class="fa fa-trash-o"></i>');
                                        alertui.notify('error', res.data.data);
                                        swal("Cart",res.data.data, "error");
                                        return false;
                                    }

                                    $("div[id=" + id + "] ").fadeOut("slow", function () {
                                        alertui.notify('success', 'Your cart has been updated');
                                        swal("Cart",'Your cart has been updated', "success");
                                        location.reload();
                                    })
                                    $("div[id=" + id + "] ").fadeOut("slow", function () {
                                        swal("Cart",'Your cart has been updated', "success");
                                        location.reload();
                                    })


                                })
                                .fail(function (error) {
                                    // handle error
                                    $('#' + id + '.remove').html('<i class="fa fa-trash-o"></i>');
                                    alertui.notify('error', 'An Error occurred. Failed to update your cart');
                                    swal("Cart",'An Error occurred. Failed to update your cart', "error");

                                })
                        }, function () {
                            // Notify success callback button default Cancel
                            alertui.notify('info', 'Item is safe in your Cart');
                        }
                    );
                }

                    function popupcartitem(id) {

                        alertui.confirm('Confirm Remove'
                            , 'Do you want to remove this item from your Cart? '
                            , function () {
                                $('#' + id + '.remove').html('<img src="{{asset('assets/images/spinnerb.gif')}}" style="width: 60px"/>')
                                $.post("{{url('api/delete_cart_item')}}", {id: id})
                                    .done(function (res) {
                                        // handle success
                                        if (!res) {
                                            $('#' + id + '.remove').html('<i class="fa fa-trash-o"></i>');
                                            alertui.notify('error', 'Failed to update your cart');
                                            swal("Cart",'Failed to update your cart', "error");

                                            return false;
                                        }
                                        if (res.data.status == '400') {
                                            $('#' + id + '.remove').html('<i class="fa fa-trash-o"></i>');
                                            alertui.notify('error', res.data.data);
                                            swal("Cart",res.data.data, "error");

                                            return false;
                                        }
                                        if(res.cartqty === 0)
                                        {
                                            $('.btncontineshopping').show();
                                            $('.btnmodproceed').hide();
                                        }



                                        $("#mod" + id).hide();
                                        $("div[id=" + id + "] ").fadeOut("slow", function () {
                                            alertui.notify('success', 'Your cart has been updated');
                                            swal("Cart",'Your cart has been updated', "successs");

                                            // location.reload();
                                        })


                                    })
                                    .fail(function (error) {
                                        // handle error
                                        $('#' + id + '.remove').html('<i class="fa fa-trash-o"></i>');
                                        alertui.notify('error', 'An Error occurred. Failed to update your cart');
                                        swal("Cart",'An Error occurred. Failed to update your cart', "error");

                                    })
                            }, function () {
                                // Notify success callback button default Cancel
                                alertui.notify('info', 'Item is safe in your Cart');
                            }
                        );
                    }

                    function reloadpage() {
                        location.reload();
                    }

                    function checkout_redeem() {
                        $(".process_indicator").removeClass('off');
                        disableItem($("#checkoutbtn"), true)
                        $.post("{{url('api/redeem_cart')}}")
                            .done(function (res) {
                                $(".process_indicator").addClass('off');
                                disableItem($("#checkoutbtn"), false)
                                // handle success
                                if (!res) {
                                    alertui.notify('success', 'Failed to complete payment');
                                    swal("Redemption",'Failed to complete payment', "error");

                                    return false;
                                }
                                if (res.status == '400') {
                                    alertui.notify('error', res.data.message);
                                    swal("Redemption",res.data.message, "error");

                                    return false;
                                }
                                if (res.status == '300') {

                                    $('#myModal').modal('toggle');
                                    $('#error-data').append(res.table);
                                    if(res.cartqty === 0)
                                    {
                                        $('.btncontineshopping').show();
                                        $('.btnmodproceed').hide();
                                    }
                                    return false;
                                }
                                if (res.status == 'servererror') {
                                    alertui.notify('error', res.data.message);
                                    swal("Redemption",res.data.message, "error");

                                    return false;
                                }
                                if (res.status == 'fail') {
                                    alertui.notify('error', res.data);
                                    swal("Redemption",res.data, "error");

                                    return false;
                                }
                                if (res.status == '200') {
                                    updateAccount(res.account)
                                    updateCartCount(0);
                                    swal("Redemption",'Transaction Successful', "success");
                                    window.location.replace("{{url('ordercomplete')}}/" + res.data)

                                    {{--$(".cart-wrapper").fadeOut("slow")--}}
                                    {{--$('#ordernotify').modal('show');--}}
                                    {{--var oldlink = $("#order_receipt").prop('href');--}}
                                    {{--$('#ordernotify').on('shown.bs.modal', function (e) {--}}
                                    {{--$("#order_receipt").prop('href', "{{url('ordercomplete')}}"+'/'+res.data);--}}
                                    {{--});--}}
                                }
                            })
                            .fail(function (response, status, error) {
                                // handle error
                                $(".process_indicator").addClass('off');
                                disableItem($("#checkoutbtn"), false)
                                $(".orderloader").hide();
                                if (response.status == 500) {
                                    swal("Redemption",'Error completing order.. Please try again.', "error");

                                    alertui.notify('error', 'Error completing order.. Please try again.')
                                } else {
                                    swal("Redemption",'Error completing order.. Please try again.', "error");

                                    alertui.notify('error', 'Error completing order.. Please try again.')
                                }
                            })
                    }

                    function updatecart() {
                        $.post("{{url('api/update_cart')}}", {items: cartItems})
                            .done(function (res) {
                                if (!res) {
                                    alertui.notify('error', 'Failed to update cart');
                                    swal("Cart",'Failed to update cart', "error");

                                    return false;
                                }
                                if (res.status == '400') {
                                    alertui.notify('error', res.data);
                                    swal("Cart",res.data, "error");

                                    return false;
                                }
                                swal("Cart",'Success Cart Updated', "success");
                                alertui.notify('success', 'Success cart updated');
                                location.reload();
                            })
                            .fail(function (response, status, error) {
                                if (response.status == 500) {
                                    swal("Cart",'Apologies, an error occurred. Failed update cart', "error");
                                    alertui.notify('error', 'Apologies, an error occurred. Failed update cart');
                                } else {
                                    swal("Cart",response.responseJSON.data, "error");

                                    alertui.notify('error', response.responseJSON.data)
                                }
                            })
                    };

                    function updateCartCount(cartqty) {
                        $("span.count").html(cartqty);
                    }

                    if ($('#error').length) {
                        var temptable = $('#error').attr('data-table');
                        $('#myModal').modal('toggle');
                        $('#error-data').append(temptable);

                        var incart = $('#error').attr('data-cart');

                        if(incart == 0)
                        {
                            $('.btncontineshopping').show();
                            $('.btnmodproceed').hide();
                        }else{
                            $('.btncontineshopping').hide();
                            $('.btnmodproceed').show();
                        }
                    }


            </script>
@endpush