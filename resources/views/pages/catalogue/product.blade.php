@extends('layouts.main')
@push('catalogue-nav')
    @include('partials.general.catalogue-nav')
@endpush
@section('content')

     <?php $company_id = env('COMPANY_ID');
        $cs =  DB::table('setting')
            ->where('company_id', '=', $company_id)
            ->first();

        ?>

     @if(!Auth::guest())
         <input type="hidden" class="login-status" value = "1">
     @else
         <input type="hidden" class="login-status" value = "0">
         @endif

    <div class="modal fade" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header custom_bg_color_2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;color: #fff"></button>

                </div>
                <div class="modal-body text-center">
                    <img
                            src="{{asset('images/check.png')}}"
                            class="text-center" alt="success"
                            style="
                            width: 100px;
                            z-index: 1;
                            margin: 0 auto;"
                    >
                    <h2 class="">Great!</h2>
                    <h4 class="order_response"></h4>
                    <br><br>
                    <div class="row" role="group" aria-label="">
                        <div class="col-10 offset-1">
                            <div class="row">
                            <div class="col-sm-6" role="group">
                                <a type="button" data-dismiss="modal" aria-label="Close" class="btn btn-large custom_button_color_2" style="width: 100%; height: 40px;">
                                    <span style="color: #fff;">Continue Shopping</span>
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
    </div>

    <div class="modal fade" id="wishlistnotify" tabindex="-1" role="dialog" aria-labelledby="wishlistnotify" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header custom_bg_color_2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;color: #fff"></button>

                </div>
                <div class="modal-body text-center">
                    <img
                            src="{{asset('images/check.png')}}"
                            class="text-center" alt="success"
                            style="width: 100px;"
                    >
                    <h2 class="">Great!</h2>
                    <h4 class="wishlist_response"></h4>
                    <br><br>
                    <div class="row" role="group" aria-label="">
                        {{--                            <div class="col-sm-10 col-sm-offset-1">--}}
                        {{--                                <div class="col-sm-6" role="group">--}}
                        <div class="col-6 offset-3 col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                            <a type="button" data-dismiss="modal" aria-label="Close" class="btn btn-large custom_button_color_2" style="width: 100%; height: 40px; margin: auto;">
                                <span style="color: #fff;">Continue Shopping</span>
                            </a>
                        </div>
                        {{--                                </div>--}}

                        {{--                            </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="tt-pageContent">
        <div class="container-indent">

            <div class="container container-fluid-mobile women-view-container">
                <div class="row">
                    <div class="col-md-6 colored-icons">
                        <a href="{{url()->previous()}}">
                            <i class="fa fa-arrow-left" aria-hidden="true">
                                <span>Back Page</span>
                            </i>
                        </a>


                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="tt-product-vertical-layout">
                            <div class="tt-product-single-img">
                                @foreach($product->data->image as $image_index => $image)
                                    <div>
                                        <!-- <button class="tt-btn-zomm tt-top-right"><i class="icon-f-86"></i></button> -->
                                        <img class="zoom-product" src='{{$image->image_url}}' data-zoom-image="{{$image->image_url}}" alt="{{ucwords(strtolower($product->data->product_name))}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="tt-product-single-info">
                            <form action="{{route('add_to_cart')}}" method="post" name="add_product_to_cart">
                                {{ csrf_field() }}
                                {{--                            <input type="hidden" name="_token" value="{{  csrf_field() }}">--}}
                                @if(isset($product))
                                    <div class="tt-add-info">
                                        {{--                            <input type="hidden" name="_token" value="{!! csrf_field() !!}">--}}
                                        <input type="hidden" name="price" value="{{$product->data->price}}">
                                        <input type="hidden" name="signature" value="{{$product->data->signature}}">
                                        <input type="hidden" name="name" value="{{$product->data->product_name}}">
                                        <input type="hidden" name="product_image" value="{{$product->data->image[0]->image_url}}">

                                    </div>
                                    <h1 class="tt-title">{{ucwords(strtolower($product->data->product_name))}}</h1>

                                    <div class="modal-price">

                                            <span class="sigma-price">

                                            {{ transform_product_price($product->data->price,$cs->rate )  }}
                                            <span class="custom_color_2">{{$cs->currency}}</span>
                                             @if($product->data->sale == 1)
                                                    <p class="product-price-old price-before-discount">
                            {{ transform_product_price($product->data->old_price, $cs->rate )  }} {{$cs->currency}}</p>
                                                @endif
                                        </span>

                                    </div>


                                    <div class="tt-wrapper">
                                        {{$product->data->description}}
                                    </div>
                                    <div class="modal-form-container">
                                        <div class="tt-wrapper">
                                            @if($product->data->is_variant)

                                                @if(isset($product->data->attributes))

                                                    @if($product->data->attributes[0]->type == 6)
                                                        <label for="attribute">{{$product->data->attributes[0]->name}}</label>
                                                        <input
                                                                type="text"
                                                                class="form-control product_input"
                                                                id="attribute"
                                                                name="attribute"
                                                                data-type="{{$product->data->attributes[0]->type}}"
                                                                data-attribute="{{$product->data->attributes[0]->name}}"
                                                                placeholder="{{$product->data->attributes[0]->name}}"
                                                        >
                                                    @endif

                                                        @if($product->data->attributes[0]->type == 7)
                                                    <?php $i = 1; ?>

                                                    @foreach($product->data->attributes as $data1)


                                                        <div class="radio-toolbar row mt30" data-attr-name="{{$data1->name}}"  data-type="{{$data1->type}}"  data-attr-id="{{$data1->id}}">
                                                            {{$data1->name}}:

                                                            <div class="row mt10">

                                                            @foreach($data1->variants as $data2)
                                                                <input type="radio"  class="attribute" data-vattr-id="{{$data1->id}}" data-var-name="{{$data2->name}}" id="{{$i}}" value="{{$data2->id}}"  name="{{$data1->id}}"/>
                                                                <label for="{{$i}}">{{$data2->name}}</label>
                                                                <?php $i++; ?>
                                                            @endforeach
                                                            </div>

                                                        </div>

                                                    @endforeach

                                                            @endif
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-form-container">
                                        <div class="tt-wrapper">
                                            @if(isset($product->data->delivery_type))
                                                <div class="qty-count">
                                                    @if($product->data->delivery_type == 1)
                                                        <div class="form-group">
                                                            <label for="delivery_method">Delivery method:</label>
                                                            <select name="delivery_method" class="delivery_method form-control product_input" required>
                                                                <option disabled value="null" selected>Delivery method</option>
                                                                <option value="1">Pickup</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                    @if($product->data->delivery_type == 3)
                                                        <div class="form-group">
                                                            <label for="delivery_method">Delivery method</label>
                                                            <select name="delivery_method"  class="delivery_method form-control product_input" required>
                                                                <option disabled value="null" selected>Delivery method</option>
                                                                <option value="1">Pickup</option>
                                                                <option value="2">Delivery</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                    @if($product->data->delivery_type == 2)
                                                        <div class="form-group">
                                                            <label for="delivery_method">Delivery method</label>
                                                            <select name="delivery_method" class="delivery_method form-control product_input" required>
                                                                <option disabled value="null" selected>Delivery method</option>
                                                                <option value="2" selected>Delivery</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="qty-count">
                                                    @if(isset($product->data->branch_details) && $product->data->delivery_type != 2)
                                                        <span id="pickUpLocation">
                                                    <label>Pickup Location</label>
                                                    <select name="pickup_location" class="pickup_location form-control product_input" required>
                                                        <option disabled value="null" selected>Pickup Location</option>
                                                        @foreach($product->data->branch_details as $location )
                                                            <option value="{{$location->branch_id}}">
                                                                {{$location->branch_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </span>
                                                    @endif
                                                </div>
                                                <div class="qty-count">

                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tt-wrapper">
                                        <div class="tt-row-custom-01">
                                            <div class="col-item">
                                                @if(isset($product->data->max_quantity))
                                                    <div class="tt-input-counter style-01">
                                                        <span class="minus-btn"></span>
                                                        <input type="text" value="1" size="5" name="orderqty" id="orderqty" max="{{$product->data->max_quantity}}">
                                                        <span class="plus-btn"></span>
                                                    </div>
                                                @endif

                                            </div>

                                            <div class="col-item">
                                                <button type="button" class="btn btn-default load-more-btn2 btnwishlist" data-img="{{$product->data->image[0]->image_url}}" data-product="{{$product->data->product_name}}" data-del="{{$product->data->delivery_type}}" data-price="{{$product->data->price}}">
                                        <span>
                                          <i class="fa fa-heart" aria-hidden="true"></i> &nbsp;  Save for Later
                                        </span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tt-wrapper tt-row-custom-01 add-btn">
                                        <button class="btn btn-lg single_add_to_cart_button btn btn-primary custom_button_color_2"><i class="icon-f-39"></i>ADD TO CART</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--recently view-->

        @if(isset($recent_view))
        <div class="container-indent  women-view-container white-catalog-background">
            <div class="container container-fluid-custom-mobile-padding">
                <div class="tt-block-title text-left">
                    <h3 class="tt-title-small">RECENTLY VIEW PRODUCT(S)</h3>
                </div>
                <div class="tt-carousel-products row arrow-location-right-top tt-alignment-img tt-layout-product-item slick-animated-show-js">
                   @foreach($recent_view as $data)
                    <div class="col-2 col-md-4 col-lg-3">
                        <div class="tt-product thumbprod-center">
                            <div class="tt-image-box">
{{--                               <a href="#" class="tt-btn-wishlist" data-tooltip="Add to Wishlist" data-tposition="left"></a>--}}
                                <!-- <a href="#" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a> -->
                                <a href="{{url('catalogue/product/'.$data->product_code)}}">
                                    <span class="tt-img"><img src="{{asset('images/loader.svg')}}" data-src="{{$data->image}}" alt=""></span>
                                    <span class="tt-img-roll-over"><img src="{{asset('images/loader.svg')}}" data-src="{{$data->image}}" alt=""></span>
                                    <!-- <span class="tt-label-location">
                                        <span class="tt-label-our-fatured">Fatured</span>
                                    </span> -->
                                </a>
                            </div>
                            <div class="tt-description">
                                <div class="tt-row">
{{--                                    <ul class="tt-add-info">--}}
{{--                                        <li><a href="#">T-SHIRTS</a></li>--}}
{{--                                    </ul>--}}
                                    <!-- <div class="tt-rating">
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                    </div> -->
                                </div>
                                <h2 class="tt-title"><a href="{{url('catalogue/product/'.$data->product_code)}}">{{$data->product_name}}</a></h2>
{{--                                <p class="sigma-price">{{$data->price}} <span>Sigma Stars</span></p>--}}
                                <!-- <div class="tt-option-block">
                                    <ul class="tt-options-swatch">
                                        <li class="active"><a class="options-color tt-color-bg-01" href="#"></a></li>
                                        <li><a class="options-color tt-color-bg-02" href="#"></a></li>
                                    </ul>
                                </div> -->
                                <div class="tt-product-inside-hover">
                                    <div class="tt-row-btn">
                                        <!-- <a>HELLO WORLD</a> -->
                                        <a href="{{url('catalogue/product/'.$data->product_code)}}" class="tt-btn-addtocart thumbprod-button-bg">VIEW PRODUCT</a>
                                    </div>
{{--                                    <div class="tt-row-btn">--}}
{{--                                        <a href="women_view.html" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>--}}
{{--                                        <a href="#" class="tt-btn-wishlist"></a>--}}
{{--                                        <!-- <a href="#" class="tt-btn-compare"></a> -->--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
            @endif

    </div>


@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
    <style>
        #pickUpLocation{
            display:none
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
    $(document).ready(function () {
        $(".delivery_method").on('change', function () {

            if($(this).val() == 1){
                $("#pickUpLocation").css('display', 'block');
            }else{
                $("#pickUpLocation").css('display', 'none');
            }
        })

        $("form[name='add_product_to_cart']").on('submit', function (event) {

// console.log($("input[type='radio']:checked").length );

            var branch_name = $(".pickup_location option:selected").text();
            event.preventDefault();
            $(".process_indicator").removeClass('off');
            disableItem($(".single_add_to_cart_button"), true)

            // if($('.login-status').val() == 1){
            var product_attribute = [];

            if ($(".radio-toolbar").length >= 1) {
                $(".radio-toolbar").each(function () {
                    var attribute_id = $(this).attr('data-attr-id');
                    var attribute_name = $(this).attr('data-attr-name');
                    var data_type = $(this).attr('data-type');


                    var variant = $(".radio-toolbar input[type='radio'][data-vattr-id='" + attribute_id + "']:checked").val();
                    var variant_name = $(".radio-toolbar input[type='radio'][data-vattr-id='" + attribute_id + "']:checked").attr('data-var-name');
                    // alert(variant+" "+variant_name);

// console.log(variant);
//check if it has value
                    if (variant == null) {
                        swal("", 'Kindly select ' + attribute_name, "error");
                        $(".process_indicator").addClass('off');
                        disableItem($(".single_add_to_cart_button"), false);
                        return false;
                    } else {

                        product_attribute.push({
                            product_has_attribute: $(".radio-toolbar").length > 0 ? true : false,
                            product_attribute_value: attribute_id,
                            variant_id: variant,
                            variant_name: variant_name,
                            product_attribute: attribute_name,
                            product_attribute_type: data_type
                        });

                    }
                })
            }
            if ($("#attribute").length >= 1) {
                if ($("#attribute").val() != "") {
                    product_attribute.push({
                        product_has_attribute: $("#attribute").length > 0 ? true : false,
                        variant_name: $('#attribute').val(),
                        product_attribute: $('#attribute').attr('data-attribute'),
                        product_attribute_type: $('#attribute').attr('data-type')
                    });
                } else {
                    alert("Kindly Enter Desire " + $('#attribute').attr('data-attribute'));
                    swal("", "Kindly Enter Desire " + $('#attribute').attr('data-attribute'), "error");

                    $(".process_indicator").addClass('off');
                    disableItem($(".single_add_to_cart_button"), false)
                    $('#attribute').focus();
                    return false;
                }
            }


            // console.log(product_attribute);
            // return false;
            var formdata = {};
            $.map($(this).serializeArray(), function (elem, i) {
                formdata[elem.name] = elem.value;
            })
            formdata['pickup_location_name'] = $.trim(branch_name);
            formdata['pickup_attribute'] = product_attribute;


            $.post("{{url('api/add_to_cart')}}", {formdata})
                .done(function (res) {
                    $(".process_indicator").addClass('off');
                    disableItem($(".single_add_to_cart_button"), false)
                    // handle success
                    if (!res) {
                        alertui.notify('error', 'Failed to add item to cart');
                        swal("", 'Failed to add item to cart', "error");
                        return false;
                    }
                    if (res.status == 401) {
                        location.replace('{{url("login")}}');
                        return false;
                    }
                     if (res.status == 400) {
                        alertui.notify('error', res.data);
                        swal("", res.data, "error");
                        return false;
                    } else {
                        updateCartCount(res.cartqty);
                        $('#ordernotify').modal('show');
                        $('#ordernotify').on('shown.bs.modal', function (e) {
                            $(".order_response").html(res.data);
                        });
                    }

                })
                .fail(function (response) {
                    // handle error
                    disableItem($(".single_add_to_cart_button"), false)
                    $(".process_indicator").addClass('off');
                    if (response.status == 401) {
                        location.replace('{{url("login")}}');
                    }
                    else if (response.status == 500) {
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                        swal("", 'An Error Occurred. Please try again.', "error");
                    } else {
                        alertui.notify('info', 'Failed to add to Cart. Please try again.')
                        swal("", 'Failed to add to Cart. Please try again.', "warning");
                    }
                })

                return false;
        // }else{
                // console.log("it is hitting here");
                // var url      = window.location.href;
                // $.session.set("url.intended", url);


                {{--sessionStorage.setItem("url.intended", url);--}}
                {{--location.replace('{{url("login")}}');--}}

            // }

        });

    })

    function updateCartCount(cartqty){
        $(".incart-counter").html(cartqty);
        // $(".header_cart i.count").html(cartqty);
    }

    //INTERSECTION OBSERVER
    //LAZY LOAD IMAGES
    var options = {
        rootMargin: '0px',
        threshold: 0.1
    };
    var images = $('.image img');
    if (!('IntersectionObserver' in window)) {
        Array.from(images).forEach(image => preLoadImage(image));
    } else {
        var observer = new IntersectionObserver(handleIntersection, options);

        $.each(images, function(index, img) {
            observer.observe(img);
        })
    }
    function handleIntersection(entries, observer){

        entries.forEach(entry => {
            if(entry.intersectionRatio > 0) {
                observer.unobserve(entry.target);
                preLoadImage(entry.target)
            }
        })
    }

    function loadImage(image){
        var src = image.dataset.src;
        $.get(src)
            .done(function(){
                image.src = src;
            })
    }

    function preLoadImage(image){
        var src = image.dataset.src;
        image.src = src;
        // fetchImage(src).then(() => {
        //     image.src = src;
        // })
    }


    $('.btnwishlist').click(function(){

        // console.log(product_attribute);
        // return false;
        var formdata = {};

        formdata['product_name'] = $(this).attr('data-product');
        formdata['image'] = $(this).attr('data-img');;
        formdata['delivery_type'] = $(this).attr('data-del');
        formdata['price'] = $(this).attr('data-price');
        formdata['product_code'] = $(location).attr('href');


        $.post("{{url('api/add_wishlist_item')}}", {formdata})
            .done(function (res) {
                $(".process_indicator").addClass('off');
                disableItem($(".btnwishlist"), false)
                // handle success
                if (!res) {
                    alertui.notify('error', 'Failed to add item to Wishlist');
                    swal("",'Failed to add item to Wishlist', "error");
                    return false;
                }
                if (res.status == 400) {
                    alertui.notify('error', res.message);
                    swal("",res.message, "error");
                    return false;
                } else {
                    swal("",res.message, "success");
                    // $('#wishlistnotify').modal('show');
                    // $('#wishlistnotify').on('shown.bs.modal', function (e) {
                        $(".wishlist_response").html(res.message);
                        // $('.wishlist-count').html(res.count);

                    // });
                }

            })
            .fail(function (response) {
                // handle error
                disableItem($(".btnwishlist"), false)
                $(".process_indicator").addClass('off');
                if(response.status == 500){
                    alertui.notify('error', 'An Error Occurred. Please try again.')
                    swal("",'An Error Occurred. Please try again.', "error");
                }
                else{
                    alertui.notify('info', 'Failed to add to Wishlist. Please try again.')
                    swal("",'Failed to add to Wishlist. Please try again.', "error");
                }
            })
    });
</script>
@endpush
