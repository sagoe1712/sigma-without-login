@extends('layouts.main')
@section('content')
    {!! csrf_field() !!}

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

        <div class="body-content mt30">
            <div class='container'>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-3 sidebar">
                              {{--<pre>--}}
                                {{--@php--}}
                                    {{--var_dump($meals_products)--}}
                                {{--@endphp--}}
                            {{--</pre>--}}
                            <div class="side-menu animate-dropdown outer-bottom-xs">
                                <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
                                <nav class="yamm megamenu-horizontal">
                                    <ul class="nav">
                                        @if(isset($meals_products->data))
                                            @foreach($meals_products->data->data as $category)
                                                <li class="dropdown menu-item">
                                                    <a title="" href="#{{str_slug($category->category_name)}}" class="meal_cat_link">{{$category->category_name}}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="dropdown menu-item">
                                                <a title="" href="#">Failed to load categories</a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    <div class="col-12 col-sm-12 col-md-9 homebanner-holder" style="margin-bottom: 50px;">
                        <div class="">

                            @if(isset($meals_products->data))
                                    @if(isset($meals_products->data->data))
                                        @foreach($meals_products->data->data as $category)
                                            @php $itemcountid = 0; @endphp
                                            {{--Meals under category--}}
                                            <div class="row meals_branch_food_category" id="{{str_slug($category->category_name)}}">
                                                <div class="col-12 grid" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": 200 }' style="border-bottom: 2px solid #ccc;margin-bottom: 30px;">
                                                        <h3 class="title-tag" style="padding: 10px">{{$category->category_name}}</h3>
                                                </div>
                                                @if(count($category->data) > 0)
                                                    @foreach($category->data as $index => $meal)
                                                        @php $itemcountid++ @endphp
                                                        <div class="col-sm-3 col-12 meal_item grid-item">
                                                            <div class="meal_item_container"
                                                                 data-itemid = "{{$itemcountid}}"
                                                                 data-itemname = "{{$meal->product_name}}"
                                                                 data-itempoints = "{{$meal->price}}"
                                                                 data-itemcode = "{{$meal->signature}}"
                                                                 data-product_image = "{{$meal->image[0]->image_url}}"
                                                            >
                                                                <div class="meal_item_img_container">
                                                                    <img src="{{$meal->image[0]->image_url}}" alt="{{$meal->product_name}}" class="img-responsive meals_item_img">
                                                                </div>
                                                                <div class="meal_item_details"
                                                                     {{--data-itemid = {{$meal->signature}}--}}
                                                                     data-itemid = "{{$itemcountid}}"
                                                                     data-itemname = "{{$meal->product_name}}"
                                                                     data-itempoints = "{{$meal->price}}"
                                                                     data-itemcode = "{{$meal->signature}}"
                                                                     data-product_image = "{{$meal->image[0]->image_url}}"
                                                                >
                                                                    <h5 title="{{$meal->product_name}}">{{str_limit(ucwords($meal->product_name), 20)}}</h5>
                                                                    <div class="meal_item_price_container">
{{--                                                                        @if(Auth::check())--}}
                                                                            @if($cs->is_currency_fixed == '1')
                                                                                <span class="">&#8358;{{ (transform_product_price($meal->price, 1)) }}</span>
                                                                            @else
                                                                                <span class="">@php echo (transform_product_price($meal->price, $cs->rate) ) @endphp {{$cs->currency}}</span>
                                                                            @endif
{{--                                                                        @endif--}}
                                                                    </div>
                                                                    <div class="checkout_options">
                                                                        @if($meal->delivery_type == 2)
                                                                            <div>
                                                                                <input type="radio" value="2" name="delivery" data-signature="{{$meal->signature}}" checked="checked" >Delivery
                                                                            </div>
                                                                            <div>
                                                                                <input type="number" min="1" max="{{$meal->max_quantity}}" value="1" class="form-control" >
                                                                            </div>
                                                                        @elseif($meal->delivery_type == 1)
                                                                            <div>
                                                                                <input type="number" min="1" max="{{$meal->max_quantity}}" value="1" class="form-control">
                                                                            </div>
                                                                            <label>
                                                                                <input type="radio" value="1" name="pickup-{{$meal->signature}}" data-signature="{{$meal->signature}}" checked="checked" >Pickup
                                                                            </label>
                                                                            <input type="hidden" class="p_location" value="{{$meal->branch_details[0]->branch_id}}" >

                                                                        @elseif($meal->delivery_type == 3)
                                                                            <label>
                                                                                <input type="radio" value="2" name="meal_radio" class="meal_delivery" data-id="{{$index}}" data-signature="{{$meal->signature}}" > Delivery
                                                                            </label>
                                                                            <label>
                                                                                <input type="radio" value="1" name="meal_radio" class="meal_pickup" data-id="{{$index}}" data-signature="{{$meal->signature}}"> Pickup
                                                                            </label>
                                                                            <div class="meals_qty_loc">
                                                                                <div>
                                                                                    <select class="form-control" id="{{$index}}">
                                                                                        <optgroup>
                                                                                            <option value="null">Select Location</option>
                                                                                            @foreach ($meal->branch_details as  $detail)
                                                                                                <option value="{{$detail->branch_id}}" >{{$detail->branch_name}}</option>
                                                                                        </optgroup>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div>
                                                                                    <input type="number" min="1" max="{{$meal->max_quantity}}" value="1" class="form-control float-right" >
                                                                                </div>
                                                                        @endif
                                                                    </div>
                                                                        <div>
                                                                            <button class="btn btn-md btn-primary add_to_basket add_to_basket_btn"> <i class="fa fa-spinner fa-spin checkoutbtn off"></i> Add to cart</button>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p class="empty_cat_notification">No items for the category</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif

                                <!-- .products -->
                            @else
                                <p><i class="fa fa-info-circle"> </i>No Products available</p>
                                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
            <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
            <style>
        label{
            padding: 5px 0
        }
        .empty_cat_notification{
            padding: 5px 25px;
        }
        .add_to_basket{
            width: 100%;
        }
        input[type=radio], input[type=checkbox] {
            margin: 4px 5px 0;
        }
    </style>
@endpush

@push('script')
            <script>
                $('body').addClass('meal-bg');
            </script>

    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
            <script src="{{asset('js/alertui.min.js')}}"></script>
            {{--<script src="{{asset('sigma/js/masonry.pkgd.min.js')}}"></script>--}}
    <script>
        $('.sidebar').theiaStickySidebar({
            // Settings
            additionalMarginTop: 70
        });
        //    Smooth scroll
        var scrollLink = $('.meal_cat_link');
        //Scroll Animation Effect
        scrollLink.on('click', function(e){
            e.preventDefault()
            $('body, html').animate( {scrollTop: $(this.hash).offset().top - 50
            }, 500)
        })
    </script>
    <script>
        'use strict'
        String.prototype.trunc =
            function(n){
                return this.substr(0,n-1)+(this.length>n?'&hellip;':'');
            };

        var cart = [];
        var viewCart = [];
        var item;
        var addtocartbtn;
        var baseUrl = "<?php echo config('app.base_url'); ?>";
        var csrf_token = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function(){

            $(".add_to_basket").on('click', function(){

                var login = $('.login-status').val();

                if(login == 0){
                    location.replace('{{url("login")}}');
                    return false;
                }


                addtocartbtn = $(this);
                var productitem = $(this).parent().parent().parent();


                item = {
                    // itemid: $(this).closest("tr").attr("data-itemid"),
                    name:  $(productitem).data('itemname'),
                    product_image:  $(productitem).data('product_image'),
                    price:  $(productitem).data('itempoints'),
                    signature:  $(productitem).data('itemcode'),
                    delivery_method: $(productitem).find("input[type='radio']:checked").val(),
                    pickup_location: $(productitem).find(".p_location").val(),
                    orderqty: Math.round($(productitem).find("input[type='number']").val()),
                    _token: "<?php echo csrf_token(); ?>",
                };

                if(validate(item)){
                    addToOder(item);
                }

            });

            $(".meal_delivery").on('change', function () {
                var id = $(this).data('id');
                $("select[id="+id+"]").hide();
            });

            $(".meal_pickup").on('change', function () {
                var id = $(this).data('id');
                $("select[id="+id+"]").show();
            });

        });


        function checkout_redeem(cartitem){
            $(addtocartbtn).find('i').removeClass('off');
            var _token = $('input[name="_token"]').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post(baseUrl+'meals/postcart', cartitem)
                .done(function (res) {
                    $(addtocartbtn).find('i').addClass('off');

                    // handle success
                    if (!res) {
                        alertui.notify('error','Failed to complete payment');
                        return false;
                    }
                    if (res.status == '400') {
                        alertui.notify('error',res.data);
                        swal("",res.data, "error");
                        return false;
                    }
                    if (res.status == 'fail') {
                        alertui.notify('error',res.data);
                        swal("",res.data, "error");
                        return false;
                    }
                    if (res.status == '200') {
                        updateCartCount(res.cartqty);
                        alertui.notify('success', res.data)
                        swal("",res.data, "success");
                    }
                })
                .fail(function (error) {
                    // handle error
                    $(addtocartbtn).find('i').addClass('off');
                    alertui.notify('error', error.responseJSON.data);
                    swal("",error.responseJSON.data, "error");
                })
        }

        function validate(item){
            var retval;
            $.each(item, function(index, value){
                if(index == 'deliveryType' && typeof(value) != 'string' && typeof(value) == 'undefined'){
                    swal("",'Please select a Redemption method', "warning");
                    retval = false;
                    return false;
                }else{
                    retval = true;
                }
            });
            return retval;
        }

        function validateOrder(item){
            var retval;
            if(item.orderqty <= 0){
                retval = false
            }else{
                retval = true;
            }
            return retval;
        }

        function validateLocation(item){
            var retval
            if(item.delivery_method == 1 && item.pickup_location == "null"){
                retval = false;
            }else{
                retval = true;
            }
            return retval;
        }

        function addToOder(cartitem){
            if(!validateOrder(cartitem)){
                alertui.notify('info', 'Quantity cannot be less than 1');
                swal("",'Quantity cannot be less than 1', "error");
                return false;
            }
            if(!validateLocation(cartitem)){
                alertui.notify('info','Please select a pickup location');
                swal("",'Please select a pickup location', "error");

                return false;
            }

            checkout_redeem(cartitem)
        }

        function updateCartCount(cartqty){
            $(".incart-counter").html(cartqty);
        }

    </script>
    @endpush
