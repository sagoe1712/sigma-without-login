<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Bills  - {{config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <div id="content" class="site-content">
        @include('partials.bills.slider')
        <div class="col-full" id="shop">
            <div class="row">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">
                        {{--Products Section--}}
                        <section class="full-width section-products-carousel-tabs section-product-carousel-with-featured-product carousel-with-featured-1">
                            @if(isset($categories))
                                @if($categories->status == 1)
                                    <header class="section-header mt-4">
                                        <h4 class="section-title custom_page_title custom_color">Choose your Service Provider</h4>
                                        </ul>
                                    </header>
                                    <div class="container">
                                        <div class="row">
                                            @foreach($categories->data[0]->child_menu as $item)
                                                <div class="col-sm-6
                                                    ">
                                                    <a href="{{url('')}}">
                                                        <div class="providers_list position-relative"
                                                             style="
                                                                     background-color: #271249;
                                                                     background: url({{asset('assets/images/dstv.png')}});
                                                                     background-size: cover;
                                                                     background-position: center center;
                                                                     background-repeat: no-repeat;
                                                                     text-align: center;
                                                                     padding: 50px 10px;
                                                                     min-height: 200px;
                                                                     ">
                                                            <h4 style="color:#fff">{{$item->name}}</h4>
                                                            @foreach($item->category as $sub_item)
                                                            <a href="{{url('bills', ['id' => $sub_item->id])}}"><span class="font-weight-bold text-white">{{$sub_item->name}}</span> <i class="fa fa-chevron-right" aria-hidden="true" style="font-size: 14px; color: #fff;"></i></a>
                                                            @endforeach
                                                        </div>
                                                    </a>
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
            @include('partials.banner', ['page' => 'bills'])
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
</script>
</body>

</html>