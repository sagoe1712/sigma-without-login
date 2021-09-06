<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Catalogue - {{config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{{asset('assets/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-techmarket.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/blue.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
</head>
<body class="woocommerce-active left-sidebar  pace-done">
<div id="page" class="hfeed site">
@include('partials.nav_general')
<!-- .top-bar-v1 -->
    <header id="masthead" class="site-header header-v1" style="background-image: none; ">
        <div class="col-full desktop-only">
            <div class="row align-items-center">
                <div id="departments-menu" class="dropdown departments-menu">
                    <button class="btn dropdown-toggle btn-block" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-list" aria-hidden="true"></i>
                        <span>Categories</span>
                    </button>
                    @include('partials.categories_nav_catalogue')
                </div>

                <!-- .departments-menu -->
                <form class="navbar-search" method="get" action="">

                    <!-- .input-group -->
                </form>
                <!-- .navbar-search -->
                <!-- .header-wishlist -->
                <ul id="site-header-cart" class="site-header-cart menu">
                    <li class="animate-dropdown dropdown ">
                        <a class="cart-contents" href="{{url('cart')}}" title="View your shopping cart">
                            <i class="tm tm-shopping-bag"></i>
                            @if(Auth::check())
                                @if(Auth::user()->cartCount()[0])
                                    <span class="count">{{Auth::user()->cartCount()[0]}}</span>
                                @endif
                            @endif
                        </a>
                    </li>
                </ul>
                <!-- .site-header-cart -->
            </div>
            <!-- /.row -->
        </div>
        <!-- .col-full -->
        <div class="col-full handheld-only">
            <div class="handheld-header">
                <!-- /.row -->
                <div class="techmarket-sticky-wrap">
                    <div class="row">
                        <nav id="handheld-navigation" class="handheld-navigation" aria-label="Handheld Navigation">
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
                        <div class="site-search">
                            <div class="widget woocommerce widget_product_search">
                                <form role="search" method="get" class="woocommerce-product-search" action="">
                                </form>
                            </div>
                            <!-- .widget -->
                        </div>
                        <a class="handheld-header-cart-link has-icon" href="{{url('cart')}}" title="View your shopping cart">
                            <i class="tm tm-shopping-bag"></i>
                            @if(Auth::check())
                                @if(Auth::user()->cartCount()[0])
                                    <span class="count">{{Auth::user()->cartCount()[0]}}</span>
                                @endif
                            @endif
                        </a>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- .techmarket-sticky-wrap -->
            </div>
            <!-- .handheld-header -->
        </div>
        <!-- .handheld-only -->
    </header>
    <div id="content" class="site-content" tabindex="-1">
        <div class="col-full">
            <div class="row">
            @include('partials.breadcrumb', ['pages' =>
                [
                ['name' =>'Catalogue', 'route' =>'catalogue'],
                ['name' =>'Category', 'route' => null ]
                ]
                ])
            <!-- .woocommerce-breadcrumb -->
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">
                        <div class="shop-archive-header">
                        @include('partials.catalogue.carousel')
                            <!-- .jumbotron -->
                        </div>
                        <!-- .shop-archive-header -->
                        <!-- .handheld-sidebar-toggle -->
                        <h3 class="font-weight-bold mt-5 mb-3 border-bottom">Products</h3>
                        <!-- .shop-control-bar -->
                        <div class="tab-content">
                            <div id="grid" class="tab-pane active" role="tabpanel">
                                <div class="woocommerce columns-5">
                                    @if(isset($products->data))
                                    <div class="products">
                                        @foreach($products->data as $product)
                                            <div class="product ">
                                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="{{url('catalogue/product', [$product->product_code])}}">
                                                    <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image resize_image_custom" src="{{$product->image}}"
                                                    >
                                                    <span class="price">
                                                    <span class="woocommerce-Price-amount amount">
                                                      @if(Auth::check())
                                                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                                                <span class="woocommerce-Price-currencySymbol">&#8358;{{ (number_format($product->price)) }}</span>
                                                            @else
                                                                <span class="woocommerce-Price-currencySymbol">{{ (number_format( Auth::user()->currency->rate * $product->price)) }} {{Auth::user()->currency->currency }}</span>
                                                            @endif
                                                        @endif
                                                </span>
                                                </span>
                                                    <h2 class="woocommerce-loop-product__title">{{str_limit($product->product, 20)}}</h2>
                                                </a>
                                                <!-- .woocommerce-LoopProduct-link -->
                                                <div class="hover-area">
                                                    <a class="button" href="{{url('catalogue/product', [$product->product_code])}}">View Product</a>
                                                </div>
                                                <!-- .hover-area -->
                                            </div>
                                        @endforeach

                                    </div>
                                    <!-- .products -->
                                        @else
                                        <p>No Products available</p>
                                        @endif
                                </div>
                                <!-- .woocommerce -->
                            </div>

                            <!-- .tab-pane -->
                        </div>
                        <!-- .tab-content -->
                    </main>
                    <!-- #main -->
                </div>
                <!-- #primary -->
                <div id="secondary" class="widget-area shop-sidebar" role="complementary">
                    <div class="widget woocommerce widget_product_categories techmarket_widget_product_categories" id="techmarket_product_categories_widget-2">
                        <ul class="product-categories category-single">
                            <li class="product_cat">
                                <span>Browse Categories</span>
                                @include('partials.categories_nav_catalogue_body')
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- #secondary -->
            </div>
            <!-- .row -->
        </div>
        <!-- .col-full -->
    </div>
    @include('partials.newfooter')
</div>

<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('assets/js/theia-sticky-sidebar.js')}}"></script>
<script>
    $('.shop-sidebar').theiaStickySidebar({
        // Settings
        additionalMarginTop: 30
    });
    $(".overlay").click(function(){
        $(this).hide();
    });
</script>
</body>
</html>