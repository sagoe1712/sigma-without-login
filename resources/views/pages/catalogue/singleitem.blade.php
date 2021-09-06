<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @if(isset($product->data->product_name))
        <title>Catalogue - {{$product->data->product_name}} {{config('app.name')}}</title>
    @else
        <title>Catalogue - {{config('app.name')}}</title>
    @endif
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- All css files are included here. -->
    <link rel="stylesheet" href="{{asset('assets/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-techmarket.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/newtemplate/css/color-three.css')}}">
</head>

<body class="woocommerce-active single-product full-width normal">
<div class="modal fade show" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Success!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h4 class="order_response"></h4>
                <br><br>
                <div class="btn-group justify-content-around w-100" role="group" aria-label="">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-large custom_button_color2 btn-primary" style="width: 45%; height: 50px;">
                       <span>Continue Shopping</span>
                    </button>
                    <a href="{{url('cart')}}" class="btn btn-large custom_button_color"  style="width: 45%; height: 50px;">
                         <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="text-white">View Cart</span>

                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="page" class="hfeed site">
    <div id="loader-wrapper">
        <div id="loader"></div>
    </div>
    <div class="html-top-content">
        <div class="theme-top-section">
            @include('partials.newnav')
        </div>
    <header id="masthead" class="site-header header-v1" style="background-image: none; ">
        <div class="col-full desktop-only">
            <!-- .techmarket-sticky-wrap -->
            <div class="row align-items-center">
                <div id="departments-menu" class="dropdown departments-menu">
                    <button class="btn dropdown-toggle btn-block" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-list" aria-hidden="true"></i>
                        <span>Categories</span>
                    </button>
                    @include('partials.categories_nav_catalogue')
                </div>

                <!-- .departments-menu -->
                <form class="navbar-search" method="get" action="#" style="visibility: hidden">

                </form>
            <!-- .header-wishlist -->
                <ul id="site-header-cart" class="site-header-cart menu">
                    <li class="animate-dropdown dropdown ">
                        <a class="cart-contents" href="{{url('cart')}}" title="View your shopping cart">
                            <i class="tm tm-shopping-bag"></i>
                            @if(Auth::check())
                                @if(Auth::user()->cartCount()[0])
                                    <span class="count">{{Auth::user()->cartCount()[0]}}</span>
                                @else
                                    <span class="count">0</span>
                                @endif
                            @endif
                        </a>
                    </li>
                </ul>
                <!-- .site-header-cart -->
            </div>
            <!-- /.row -->
        </div>
        <div class="col-full handheld-only">
            <div class="handheld-header">
                <!-- /.row -->
                <div class="techmarket-sticky-wrap">
                    <div class="row">
                        <nav id="handheld-navigation" class="handheld-navigation" aria-label="Handheld Navigation" style="visibility: hidden">
                            <button class="btn navbar-toggler" type="button">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                <span>Menu</span>
                            </button>
                            <div class="handheld-navigation-menu">
                                <span class="tmhm-close">Close</span>
                                @include('partials.categories_nav_catalogue_mobile')
                            </div>
                            <!-- .handheld-navigation-menu -->
                        </nav>
                        <!-- .handheld-navigation -->
                        <div class="site-search" style="visibility: hidden">
                            <div class="widget woocommerce widget_product_search">
                                <form role="search" method="get" class="woocommerce-product-search" action="#">
                                    <label class="screen-reader-text" for="woocommerce-product-search-field-0">Search for:</label>
                                    <input type="search" id="woocommerce-product-search-field-0" class="search-field" placeholder="Search products&hellip;" value="" name="s" />
                                    <input type="button" value="Search" />
                                    <input type="hidden" name="post_type" value="product" />
                                </form>
                            </div>
                            <!-- .widget -->
                        </div>
                        <a class="handheld-header-cart-link has-icon" href="{{url('cart')}}" title="View your shopping cart">
                            <i class="tm tm-shopping-bag"></i>
                            @if(Auth::check())
                                @if(Auth::user()->cartCount()[0])
                                    <span class="count">{{Auth::user()->cartCount()[0]}}</span>
                                @else
                                    <span class="count"></span>
                                @endif
                            @endif
                        </a>
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </header>
    <div id="content" class="site-content">
        <div class="col-full" id="product">
            <div class="row">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">
                        <div class="product product-type-simple mt-4">
                            <div class="single-product-wrapper">
                                <div class="product-images-wrapper">
                                    <div>
                                        <div class="techmarket-single-product-gallery-images">
                                            <div>
                                                @if(isset($product->data->image))
                                                <figure class="woocommerce-product-gallery__wrapper ">
                                                    <div
                                                         class="woocommerce-product-gallery__image single_experience_item">
                                                            <img width="600" height="600"
                                                                 style="max-width: 70%;"
                                                                 src="{{$product->data->image[0]->image_url}}"
                                                                 class="attachment-shop_single size-shop_single wp-post-image"
                                                                 alt="">
                                                        </a>
                                                    </div>
                                                </figure>
                                                    @endif
                                            </div><!-- .woocommerce-product-gallery -->
                                        </div><!-- .techmarket-single-product-gallery-images -->


                                    </div><!-- .techmarket-single-product-gallery -->
                                </div>

                                <div class="summary entry-summary single_item_container">

                                    <form action="{{route('add_to_cart')}}" method="post" name="add_product_to_cart">
                                        {{ csrf_field() }}
                                        @if(isset($product))
                                    <div class="single-product-header">
                                        <h3 class="product_title font-weight-bold">{{$product->data->product_name}}</h3>
                                        <p class="price">
                                            <input type="hidden" name="price" value="{{$product->data->price}}">
                                            <input type="hidden" name="signature" value="{{$product->data->signature}}">
                                            <input type="hidden" name="name" value="{{$product->data->product_name}}">
                                            <ins>
                                                @if(Auth::user()->currency->is_currency_fixed == '1')
                                                    <span class="woocommerce-Price-amount amount">
                                                       <span class="woocommerce-Price-currencySymbol">&#8358;</span>
                                                       {{transform_product_price($product->data->price, 1) }}
                                                       </span>
                                                @else
                                                    <span class="woocommerce-Price-amount amount">
                                                       {{ transform_product_price($product->data->price, Auth::user()->currency->rate )  }}
                                                         <span class="woocommerce-Price-currencySymbol">{{Auth::user()->currency->currency}}</span>
                                                            </span>
                                                @endif
                                            </ins>
                                        </p>
                                        <div class="woocommerce-product-details__short-description">
                                            {{$product->data->description}}
                                        </div><!-- .woocommerce-product-details__short-description -->
                                    </div><!-- .single-product-header -->
                                    @endif
                                    <div class="product-actions-wrapper">
                                        <div class="product-actions">
                                            {{--//Delivery method start--}}
                                            <div class="container">
                                            <div class="row mb-5">
                                                @if(isset($product->data->max_quantity))
                                                <div class="col-md-3">
                                                    <div class="quantity">
                                                        <h5 style="margin:10px">Quantity</h5>
                                                        <input style="height: 45px;"  class="form-control" value="1" type="number" name="orderqty" id="orderqty" min="1" max="{{$product->data->max_quantity}}" required>

                                                    </div>
                                                </div>
                                                @endif

                                                    @if(isset($product->data->delivery_type))
                                                <div class="col-md-5">
                                                <h5 style="margin:10px;">Delivery method</h5>
                                                    @if($product->data->delivery_type == 1)
                                                        <div>
                                                            <select name="delivery_method" class="delivery_method" required>
                                                                <option disabled value="null" selected>Select</option>
                                                                <option value="1">Pickup</option>
                                                            </select>
                                                        </div>
                                                    @endif

                                                @if($product->data->delivery_type == 3)
                                                        <div>
                                                            <select name="delivery_method"  class="delivery_method" required>
                                                                <option disabled value="null" selected>Select</option>
                                                                <option value="1">Pickup</option>
                                                                <option value="2">Delivery</option>
                                                            </select>
                                                        </div>
                                                       <div>
                                                    </div>
                                            @endif
                                            @if($product->data->delivery_type == 2)
                                                        <div>
                                                            <select name="delivery_method" class="delivery_method" required>
                                                                <option disabled value="null" selected>Select</option>
                                                                <option value="2">Delivery</option>
                                                            </select>
                                                        </div>
                                                @endif
                                                    </div>
                                                    @endif

                                                    @if(isset($product->data->branch_details))
                                                    <div class="col-md-4" id="pickUpLocation">
                                                    <label style="margin:10px">Pickup Location</label>
                                                    <select name="pickup_location" class="pickup_location">
                                                        <option disabled value="null" selected>Select</option>
                                                        @foreach($product->data->branch_details as $location )
                                                            <option value="{{$location->branch_id}}">
                                                                {{$location->branch_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                        @endif
                                            </div>
                                            </div>
                                            {{--Delivery method end--}}
                                            </div>
                                        @if(isset($product->data->is_variant))
                                        @if($product->data->is_variant)
                                            <div class="container">
                                                <div class="row">
                                                    @if(isset($product->data->attributes))
                                                    @foreach($product->data->attributes as $attributes)
                                                    <div class="col">
                                                        <h2 style="margin:10px">{{$attributes.name}}</h2>
                                                        <select style="margin:10px" class="form-control item_variant" :id="item.variant_id" :name="item.variant_name" @change="combo()">
                                                            <option selected value="null">Select </option>
                                                            @foreach($attributes->details as $item)
                                                            <option value="{{$item->variant_id}}">
                                                                {{$item->variant_name}}
                                                            </option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                        @endforeach
                                                        @endif
                                                </div>
                                            </div>
                                        @endif
                                        @endif

                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <button class="single_add_to_cart_button button alt custom_button_color" value="185"
                                                        type="submit"
                                                style="margin: 0 auto"
                                                >
                                                    <i class="fa fa-spinner fa-spin off process_indicator"></i>
                                                    <span>Add to cart</span>
                                                </button>

                                            </div>
                                        </div>
                                        </div>
                                        <!-- .product-actions -->
                                </form>
                                    </div>

                                </div>

                            </div><!-- .single-product-wrapper -->
                    </main>
                </div>
            </div>
        </div>
    </div>
        @include('partials.footer')
</div>
</div>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/landing.js')}}"></script>
<script src="{{asset('assets/js/theia-sticky-sidebar.js')}}"></script>
<script>
    $(".overlay").click(function(){
        $(this).hide();
    })

    var baseUrl = "<?php echo config('app.base_url')?>";
    //Configure Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        $(".delivery_method").on('change', function () {
            if($(this).val() == 1){
                $("#pickUpLocation").show();
            }else{
                $("#pickUpLocation").hide();
            }
        })


        $("form[name='add_product_to_cart']").on('submit', function (event) {
            var branch_name = $(".pickup_location option:selected").text();
            event.preventDefault();
            $(".process_indicator").removeClass('off');
            disableItem($(".single_add_to_cart_button"), true)
            var formdata = {};
            $.map($(this).serializeArray(), function (elem, i) {
                formdata[elem.name] = elem.value;
            })
            formdata['pickup_location_name'] = $.trim(branch_name);

            $.post(baseUrl + 'add_to_cart', {formdata})
                .done(function (res) {
                    $(".process_indicator").addClass('off');
                    disableItem($(".single_add_to_cart_button"), false)
                    // handle success
                    if (!res) {
                        alertui.notify('error', 'Failed to add item to cart');
                        return false;
                    }
                    if (res.status == 400) {
                        alertui.notify('error', res.data);
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
                    if(response.status == 500){
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                    }
                    else{
                        alertui.notify('error', response.responseJSON.data)
                    }
                })
        });

    })

    function updateCartCount(cartqty){
        $("span.count").html(cartqty);
    }
    $('.product-images-wrapper').theiaStickySidebar({
        // Settings
        additionalMarginTop: 30
    });
</script>
</body>

</html>