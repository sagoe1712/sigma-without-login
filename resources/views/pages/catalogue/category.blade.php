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
        <div class="container-indent white-catalog-background">
            <div class="container container-fluid-custom-mobile-padding">


                <div class="tt-block-title">
                    <h1 class="tt-title">{{$products->category ? ucwords($products->category) : ''}}</h1>
                </div>

                @if(!$products)

                    <div class="row modal-form-container">
                        <div class="col-9 col-md-6 col-lg-6 colored-icons">
                            <a href="{{url()->previous()}}">
                                <i class="fa fa-arrow-left" aria-hidden="true">
                                    <span>Back To Home</span>
                                </i>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 col-lg-3">

                        </div>
                        <div class="col-6 col-md-3 col-lg-3">

                        </div>
                    </div>

                    <div class="row tt-layout-product-item">

                        <h3 class="text-center">No Products available.</h3>

                    </div>

                @endif

                @if(isset($products->status))
                    @if($products->status == 1)
                        <div class="row modal-form-container">
                            <div class="col-9 col-md-6 col-lg-6 colored-icons">
                                <a href="{{url()->previous()}}">
                                    <i class="fa fa-arrow-left" aria-hidden="true">
                                        <span>Back To Home</span>
                                    </i>
                                </a>
                            </div>
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="size">Sort by:</label>
                                    <select class="form-control price_sort_li" id="mysort">
                                        <option value="0" selected>None</option>
                                        <option value="1">Price: Low to High</option>
                                        <option value="2">Price: High to Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="size">Redemption Method:</label>
                                    <select class="form-control delivery_method_li" id="mymethod">
                                        <option value= "0" selected>All</option>
                                        <option value= "1">Pick Up</option>
                                        <option value= "2">Delivery</option>
                                        <option value= "3">Pick Up + Delivery</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row tt-layout-product-item category_products">

                            @if(isset($products->data))
                                @foreach($products->data as $product)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="tt-product thumbprod-center">
                                            <div class="tt-image-box">
                                                <a href="{{url('catalogue/product', [$product->product_code])}}" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>
                                                <a href="#" class="tt-btn-wishlist btnwishlist" data-prdlink="{{url('catalogue/product/'.$product->product_code)}}" data-tooltip="Add to Wishlist" data-tposition="left" data-img="{{$product->image}}" data-product="{{$product->product}}" data-del="1" data-price="{{$product->price}}"></a>
                                                <!-- <a href="#" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a> -->
                                                <a href="{{url('catalogue/product', [$product->product_code])}}">
                                                    <span class="tt-img"><img src="{{asset('images/loader.svg')}}" data-src="{{$product->image}}" alt="{{$product->product}}"></span>
                                                    <span class="tt-img-roll-over"><img src="{{asset('images/loader.svg')}}" data-src="{{$product->image}}" alt="{{$product->product}}"></span>
                                                    <!-- <span class="tt-label-location">
                                                        <span class="tt-label-our-fatured">Fatured</span>
                                                    </span> -->
                                                </a>
                                            </div>
                                            <div class="tt-description">
                                                <div class="tt-row">
                                                    <ul class="tt-add-info">
                                                        <li><a href="#">{{$products->category ? ucwords($products->category) : ''}}</a></li>
                                                    </ul>
                                                    <!-- <div class="tt-rating">
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                    </div> -->
                                                </div>
                                                <h2 class="tt-title" title="{{$product->product}}"><a href="{{url('catalogue/product', [$product->product_code])}}" title="{{$product->product}}">{{str_limit($product->product, 25)}}</a></h2>

                                                @if(!Auth::guest())

                                                    <p class="sigma-price">@if(Auth::check())
                                                        @if(Auth::user()->currency->is_currency_fixed == '1')</span></p>
                                                    <div class="product-price">
                                                        <p class="price">&#8358;{{transform_product_price($product->price, 1) }}</p>
                                                        @if($product->sale == 1)
                                                            <p class="price-before-discount">&#8358; {{transform_product_price($product->old_price, 1)}}</p>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="product-price">
                                                        <p class="price">{{ transform_product_price($product->price, Auth::user()->currency->rate )  }} <span class="green-text">{{Auth::user()->currency->currency }}</span></p>
                                                        @if($product->sale == 1)
                                                            <p class="price-before-discount">{{ transform_product_price($product->old_price, Auth::user()->currency->rate )  }} {{Auth::user()->currency->currency}}</p>
                                                        @endif
                                                    </div>
                                                @endif
                                                @endif

                                                @else

                                                    <p class="sigma-price">

                                                        <div class="product-price">
                                                            <p class="price">{{ transform_product_price($product->price, $cs->rate )  }} <span class="green-text">{{$cs->currency}}</span></p>
                                                            @if($product->sale == 1)
                                                                <p class="price-before-discount">{{ transform_product_price($product->old_price, $cs->rate)  }} {{$cs->currency}}</p>
                                                            @endif
                                                        </div>
                                                @endif


                                            <!-- <div class="tt-option-block">
                               <ul class="tt-options-swatch">
                                   <li class="active"><a class="options-color tt-color-bg-01" href="#"></a></li>
                                   <li><a class="options-color tt-color-bg-02" href="#"></a></li>
                               </ul>
                           </div> -->
                                                <div class="tt-product-inside-hover">
                                                    <div class="tt-row-btn">
                                                        <!-- <a>HELLO WORLD</a> -->
                                                        <a href="{{url('catalogue/product', [$product->product_code])}}" class="tt-btn-addtocart thumbprod-button-bg">VIEW PRODUCT</a>
                                                    </div>
                                                    <div class="tt-row-btn">
                                                        <a href="{{url('catalogue/product', [$product->product_code])}}" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>
                                                        <a href="#" class="tt-btn-wishlist"></a>
                                                        <!-- <a href="#" class="tt-btn-compare"></a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                        </div>

                        @if(isset($products->data))
                            @if($total > 12)
                            <!-- Load more button -->
                                <div class="load-more-btn-container loadmore_container text-center" style="margin-top: 5rem!important;">
                                    <button id="loadmorebtn" class="mt-5 btn btn-continue btn btn-default custom_button_color_2 load-more-btn">
                                        <i class="fa fa-spinner fa-spin off process_indicator"></i> Load more</button>
                                </div>
                            @endif
                        @endif
                    @else
                        <p>No Products available</p>
                    @endif

            </div>

            @endif
            @endif

        </div>
    </div>

@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
@endpush

@push('script')
    <script src="{{asset('js/alertui.min.js')}}"></script>


    <script>
        var baseUrl = "<?php echo config('app.base_url')?>";

            var conversionRate = "<?php echo $cs->rate ;?>"
            var appCurrency = "<?php echo $cs->currency ;?>"
            var appCurrencyFixed = "<?php echo $cs->is_currency_fixed ;?>"



        var total =  "<?php echo $total; ?>";
        var productid =  "<?php echo $productid; ?>";
        var pages = total / 12,
            currentPage = 1,
            maxPage = function (){
                if(pages % 1 != 0){
                    return  Math.floor(total / 12) + 1;
                }else{
                    return  Math.floor(total / 12);
                }
            }
        nextPage = function(){
            if(currentPage == maxPage){
                return currentPage;
            }else if(currentPage > maxPage) {
                return false;
            }
            else
            {
                return currentPage + 1;
            }
        }

    </script>
    <script>
        var sortval, filterval;
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

        function loadProducts(items){
            $.each(items.data, function (i, item) {
                if(appCurrencyFixed == 1){
                    //Currency fixed
                    var old_price = null;
                    if(item.sale == 1){
                        old_price = new Intl.NumberFormat('en-GB').format(item.old_price)
                        old_price = "&#8358;"+old_price
                    }
                    var price = new Intl.NumberFormat('en-GB').format(item.price);
                    price = "&#8358;"+price
                }else{
                    var old_price = null;
                    if(item.sale == 1){
                        old_price = new Intl.NumberFormat('en-GB').format(Math.ceil(item.old_price * conversionRate))
                        old_price += " <span>" +appCurrency+"</span>"
                    }
                    var price = new Intl.NumberFormat('en-GB').format(Math.ceil(item.price * conversionRate));
                    price += " <span class='green-text'>" +appCurrency+"</span>"
                }



                var product = '<div class="col-6 col-md-4 col-lg-3">';
                product += ' <div class="tt-product thumbprod-center">';
                product += '<div class="tt-image-box">';
                product += '<a href="<?php echo url('catalogue/product'); ?>/'+item.product_code +'" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left" >';
                product += '<a href="#" class="tt-btn-wishlist btnwishlist" data-prdlink="<?php echo url('catalogue/product'); ?>/'+item.product_code +'" data-tooltip="Add to Wishlist" data-tposition="left" data-img="'+item.image+'" data-product="'+item.product+'" data-del="1" data-price="'+price+'"></a>';
                product += '<a href="<?php echo url('catalogue/product'); ?>/'+item.product_code +'">';
                product += '<span class="tt-img"><img src="'+item.image+'" alt="'+item.product+'"></span>';
                product += '<span class="tt-img-roll-over"><img src="'+item.image+'" alt="'+item.product+'"></span>';
                product += '</a>';
                product += '</div>';
                product += '<div class="tt-description">';
                product += ' <div class="tt-row">';
                product += '<ul class="tt-add-info">';
                product += '<li><a href="#">'+items.category+'</a></li>';
                product += '</ul>';
                product += ' </div>';
                product += '<h2 class="tt-title" title="'+item.product+'"><a href="<?php echo url('catalogue/product'); ?>/'+item.product_code +'" title="'+item.product+'">'+text_truncate(item.product, 12)+'</a></h2>';
                product += '<p class="sigma-price"><span>';
               product += '</span></p>';
                product += '<div class="product-price">';
                product += '<p class="price">'+price+'</p>';
                if(old_price) {
                    product += ' <p class="price-before-discount">'+old_price+'</p>';
                }
                    product += '</div>';
                product += ' <div class="tt-product-inside-hover">';
                product += ' <div class="tt-row-btn">';
                product += '<a href="<?php echo url('catalogue/product'); ?>/'+item.product_code +'" class="tt-btn-addtocart thumbprod-button-bg">VIEW PRODUCT</a>';
                product += '</div>';
                product += ' <div class="tt-row-btn">';
                product += ' <a href="<?php echo url('catalogue/product'); ?>/'+item.product_code +'" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>';
                product += ' <a href="#" class="tt-btn-wishlist"></a>';
                product += '</div>';
                product += ' </div>';
                product += '</div>';
                product += '</div>';
                product += '</div>';


                $(".category_products").append(product)
            })
        }

        function sortProductsView(items){
            $(".category_products").html('')
            if(!items){
                $(".products").html("<h5 style='margin: 0 auto'>No data available</h5>");
                return false;
            }
            $.each(items, function (i, item) {
                if(appCurrencyFixed == 1){
                    //Currency fixed
                    var price = new Intl.NumberFormat('en-GB').format(item.price);
                    price = "&#8358;"+price
                }else{
                    var price = new Intl.NumberFormat('en-GB').format(Math.ceil(item.price * conversionRate));
                    // price += " " +appCurrency
                }

                var product = '<div class="col-6 col-md-4 col-lg-3">';
                product += '<div class="tt-product thumbprod-center">';
                product += '<div class="tt-image-box">';
                //product += '<a href="<?php echo url("catalogue/product"); ?>'+item.product_code+'" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>';
                    product += '<a href="#" class="tt-btn-wishlist btnwishlist" data-prdlink="<?php echo url("catalogue/product"); ?>/'+item.product_code+'" data-tooltip="Add to Wishlist" data-tposition="left" data-img="'+item.image+'" data-product="'+item.product+'" data-del="1" data-price="'+price+'"></a>';
                product += '<a href="<?php echo url("catalogue/product"); ?>/'+item.product_code+'">';
                product += '<span class="tt-img"><img src="'+item.image+'" data-src="'+item.image+'" alt="'+item.product+'"></span>';
                product += '<span class="tt-img-roll-over"><img src="'+item.image+'" data-src="'+item.image+'" alt="'+item.product+'"></span>';
                product += '</a>';
                product += '</div>';
                product += '<div class="tt-description">';
                product += '<div class="tt-row">';
                product += '<ul class="tt-add-info">';
                // product += '<li><a href="#">'+res.data.category+'</a></li>';
                product += '</ul>';
                product += '</div>';
                product += '<h2 class="tt-title"><a href="<?php echo url("catalogue/product"); ?>/'+item.product_code+'">'+item.product+'</a></h2>';
                product += '<p class="sigma-price"></p>';
                product += '<div class="product-price">';
               // if(old_price) {
               //     product += '<span class="price-before-discount">&#8358; '+old_price+'</span>';
               //  }
                product += '</div>';

                product += ' <div class="product-price">';
                product += '<span class="price">'+price+' <span class="green-text">Sigma Stars</span></span>';
                product += '</div>';

                product += '<div class="tt-product-inside-hover">';
                product += '<div class="tt-row-btn">';
                product += '<a href="#" class="tt-btn-addtocart thumbprod-button-bg" data-toggle="modal" data-target="#modalAddToCartProduct">VIEW PRODUCT</a>';
                product += '</div>';
                product += '<div class="tt-row-btn">';
                product += ' <a href="<?php echo url("catalogue/product"); ?>/'+item.product_code+'" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>';
                product += '<a href="#" class="tt-btn-wishlist"></a>';
                product += '</div>';
                product += '</div>';
                product += '</div>';
                product += '</div>';
                product += '</div>';


                $(".category_products").append(product)
            })
        }

        function sortFilterProducts(sortval, filterval) {
            //alert('load');
            alertui.load('Sorting products...',

                function(loadClose, loadEl) {
                    $.ajax({
                            url: "{{url('api/sort_filter_catalogue_items')}}",
                            data: {'sort':sortval, 'filterval':filterval, 'productid': productid},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type:'POST'
                        }
                    )
                        .done(function (res) {
                            currentPage = 1
                            $('#loadmorebtn').show();
                            loadClose();
                            $(".process_indicator").addClass('off');
                            disableItem($("#loadmorebtn"), false)
                            // handle success
                            if (!res) {
                                alertui.notify('error', 'Failed to retrieve more items');
                                swal("",'Failed to retrieve more items', "error");
                                return false;
                            }
                            if (res.status == 400) {
                                alertui.notify('error', res.data);
                                swal("",res.data, "error");

                                return false;
                            } else {
                                if(res.data.status == 0){
                                    $('#loadmorebtn').hide();
                                }
                                sortProductsView(res.data.data);
                                if(currentPage == maxPage()){
                                    $('#loadmorebtn').hide();
                                }
                                alertui.notify('success', 'Products sorted')

                            }

                        })
                        .fail(function (response) {
                            loadClose();
                            // handle error
                            disableItem($("#loadmorebtn"), false)
                            $(".process_indicator").addClass('off');
                            if(response.status == 500){
                                swal("",'An Error Occurred. Please try again.', "error");
                                alertui.notify('error', 'An Error Occurred. Please try again.')
                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                                swal("",response.responseJSON.data, "error");

                            }
                        })
                })
        }

        function sortProducts(sortval) {
            alertui.load('Sorting products...',
                function(loadClose, loadEl) {
                    $.ajax({
                            url: "{{url('api/sort_catalogue_items')}}",
                            data: {'sort':sortval, 'productid': productid},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type:'POST'
                        }
                    )
                        .done(function (res) {
                            currentPage = 1
                            $('#loadmorebtn').show();
                            loadClose();
                            $(".process_indicator").addClass('off');
                            disableItem($("#loadmorebtn"), false)
                            // handle success
                            if (!res) {
                                alertui.notify('error', 'Failed to retrieve more items');
                                swal("",'Failed to retrieve more items', "error");
                                return false;
                            }
                            if (res.status == 400) {
                                alertui.notify('error', res.data);
                                swal("",res.data, "error");

                                return false;
                            } else {
                                if(res.data.status == 0){
                                    $('#loadmorebtn').hide();
                                }
                                sortProductsView(res.data.data);
                                if(currentPage == maxPage()){
                                    $('#loadmorebtn').hide();
                                }
                                alertui.notify('success', 'Products sorted')

                            }

                        })
                        .fail(function (response) {
                            loadClose();
                            // handle error
                            disableItem($("#loadmorebtn"), false)
                            $(".process_indicator").addClass('off');
                            if(response.status == 500){
                                swal("",'An Error Occurred. Please try again.', "error");
                                alertui.notify('error', 'An Error Occurred. Please try again.')
                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                                swal("",response.responseJSON.data, "error");

                            }
                        })
                })
        }

        function filterProducts(filterval) {
            alertui.load('Filtering products...',
                function(loadClose, loadEl) {
                    $.ajax({
                            url: "{{url('api/sort_catalogue_items_delivery')}}",
                            data: {'filterval':filterval, 'productid': productid},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type:'POST'
                        }
                    )
                        .done(function (res) {
                            currentPage = 1
                            $('#loadmorebtn').show();
                            loadClose();
                            $(".process_indicator").addClass('off');
                            disableItem($("#loadmorebtn"), false)
                            // handle success
                            if (!res) {
                                alertui.notify('error', 'Failed to retrieve more items');
                                swal("",'Failed to retrieve more items', "error");
                                return false;
                            }
                            if (res.status == 400) {
                                alertui.notify('error', res.data);
                                swal("",res.data, "error");
                                return false;
                            } else {
                                if(res.data.status == 0){
                                    $('#loadmorebtn').hide();
                                }
                                sortProductsView(res.data.data);
                                if(currentPage == maxPage()){
                                    $('#loadmorebtn').hide();
                                }
                                alertui.notify('success', 'Products filtered')
                                swal("",'Products filtered', "success");

                            }

                        })
                        .fail(function (response) {
                            loadClose();
                            // handle error
                            disableItem($("#loadmorebtn"), false)
                            $(".process_indicator").addClass('off');
                            if(response.status == 500){
                                alertui.notify('error', 'An Error Occurred. Please try again.')
                                swal("",'An Error Occurred. Please try again.', "error");

                            }
                            else{
                                alertui.notify('info', response.responseJSON.data)
                                swal("",response.responseJSON.data, "error");
                            }
                        })
                })
        }

        $(document).ready(function () {

            $('#loadmorebtn').click(function () {
                if (currentPage == maxPage()) {
                    $('#loadmorebtn').hide();
                    alertui.notify('info', "That's all for now")
                    swal("","That's all for now", "info");
                    return false;
                }
                $(".process_indicator").removeClass('off');
                disableItem($("#loadmorebtn"), true);

                $.ajax({
                        url: "{{url('api/load_more_catalogue_items')}}",
                        data: {'nextPage': nextPage, 'productid': productid, sortval:sort_id,filterval: method_id },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST'
                    }
                )
                    .done(function (res) {
                        $(".process_indicator").addClass('off');
                        disableItem($("#loadmorebtn"), false)
                        // handle success
                        if (!res) {
                            alertui.notify('error', 'Failed to retrieve more items');
                            swal("",'Failed to retrieve more items', "error");
                            return false;
                        }
                        if (res.status == 400) {
                            alertui.notify('error', res.data);
                            swal("",res.data, "error");
                            return false;
                        } else {
                            if(res.data.status == 0){
                                $('#loadmorebtn').hide();
                            }
                            currentPage++;
                            loadProducts(res.data);
                            if (currentPage == maxPage()) {
                                $('#loadmorebtn').attr('display', 'none');
                                $('#loadmorebtn').attr('display', 'block');
                            }
                            alertui.notify('success', 'Products loaded')
                        }

                    })
                    .fail(function (response) {

                        // handle error
                        disableItem($("#loadmorebtn"), false)
                        $(".process_indicator").addClass('off');
                        if (response.status == 500) {
                            alertui.notify('error', 'An Error Occurred. Please try again.')
                            swal("",'An Error Occurred. Please try again.', "info");

                        }
                        else {
                            alertui.notify('info', response.responseJSON.data)
                            swal("",response.responseJSON.data, "info");

                        }
                    });
            })

            //Event for Price sort
            //Create custom event
            var $price_sort_li = $('.price_sort_li');
            $price_sort_li.on('price_sort_li_click',function (e) {
                sortval = $(this).attr('id');
                sortProducts($(this).attr('id'));
            });

            //trigger custom event
            var sort_id;
            var method_id;
            //$('ul a.price_sort_li').click(function (e){
            $('#mysort').change(function(){
                 sort_id = $(this).val();
                //alert(sort_id);

                 method_id = $( "#mymethod option:selected" ).val();
                //alert(method_id);
                sortFilterProducts(sort_id,method_id);
                //$(this).trigger('price_sort_li_click')
            });

            $('#mymethod').change(function(){
                 method_id = $(this).val();


                 sort_id = $( "#mysort option:selected" ).val();

                sortFilterProducts(sort_id,method_id);

            });

            //Event for Delivery method filter
            //Create custom event
            var $delivery_method_li = $('.delivery_method_li');
            $delivery_method_li.on('delivery_method_li',function (e) {
                filterval = $(this).attr('id');
                filterProducts($(this).attr('id'));
            });

            //trigger custom event
            $('ul a.delivery_method_li').click(function (e){
                    $(this).trigger('delivery_method_li')
                }

            );

        })

        $('.btnwishlist').click(function(){

            // console.log(product_attribute);
            // return false;
            var formdata = {};

            formdata['product_name'] = $(this).attr('data-product');
            formdata['image'] = $(this).attr('data-img');;
            formdata['delivery_type'] = $(this).attr('data-del');
            formdata['price'] = $(this).attr('data-price');
            // formdata['product_code'] = $(location).attr('href');
            formdata['product_code'] = $(this).attr('data-prdlink');


            $.post("{{url('api/add_wishlist_item')}}", {formdata})
                .done(function (res) {
                    $(".process_indicator").addClass('off');
                    disableItem($(".btnwishlist"), false)
                    // handle success
                    if (!res) {
                        alertui.notify('error', 'Failed to add item to Wishlist');
                        swal("",'Failed to add item to Wishlist.', "error");
                        return false;
                    }
                    if (res.status == 400) {
                        alertui.notify('error', res.message);
                        swal("",res.message, "error");
                        return false;
                    } else {
                        // $('#wishlistnotify').modal('show');
                        // $('#wishlistnotify').on('shown.bs.modal', function (e) {
                        //     $(".wishlist_response").html(res.message);
                        $('.wishlist-count').html(res.count);
                        swal("Wishlist",res.message, "success");
                        // });
                    }

                })
                .fail(function (response) {
                    // handle error
                    disableItem($(".btnwishlist"), false)
                    $(".process_indicator").addClass('off');
                    if(response.status == 500){
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                        swal("Wishlist",'An Error Occurred. Please try again.', "error");
                    }
                    else{
                        alertui.notify('info', 'Failed to add to Wishlist. Please try again.')
                        swal("Wishlist",'Failed to add to Wishlist. Please try again.', "error");

                    }
                })
        });
    </script>
@endpush
