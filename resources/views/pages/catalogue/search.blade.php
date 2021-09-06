@extends('layouts.main')
@push('catalogue-nav')
    @include('partials.general.catalogue-nav')
@endpush

@section('content')

    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container container-fluid-custom-mobile-padding">


                <div class="tt-block-title">
                    <h1 class="tt-title">Search</h1>
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


                @if(isset($products))
                    @if($products)
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
                                    <select class="form-control" id="mysort">
                                        <option value="0" selected>None</option>
                                        <option value="1">Price: Low to High</option>
                                        <option value="2">Price: High to Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="size">Redemption Method:</label>
                                    <select class="form-control" id="mymethod">
                                        <option value= "0" selected>All</option>
                                        <option value= "1">Pick Up</option>
                                        <option value= "2">Delivery</option>
                                        <option value= "3">Pick Up + Delivery</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row tt-layout-product-item category_products">
                            @if(isset($products))
                                @foreach($products as $product)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="tt-product thumbprod-center">
                                            <div class="tt-image-box">
                                                <a href="{{url('catalogue/product', [$product->product_code])}}" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>
                                                <a href="#" class="tt-btn-wishlist" data-tooltip="Add to Wishlist" data-tposition="left"></a>
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
{{--                                                    <ul class="tt-add-info">--}}
{{--                                                        <li><a href="#">{{$products->category ? ucwords($products->category) : ''}}</a></li>--}}
{{--                                                    </ul>--}}
                                                    <!-- <div class="tt-rating">
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                        <i class="icon-star"></i>
                                                    </div> -->
                                                </div>
                                                <h2 class="tt-title"><a href="{{url('catalogue/product', [$product->product_code])}}">{{str_limit($product->product, 12)}}</a></h2>
                                                <p class="sigma-price">@if(Auth::check())
                                                    @if(Auth::user()->currency->is_currency_fixed == '1')</span></p>
                                                <div class="product-price">
                                                    <span class="price">&#8358;{{transform_product_price($product->price, 1) }}</span>
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
        var conversionRate = "<?php echo Auth::user()->currency->rate ;?>"
        var appCurrency = "<?php echo Auth::user()->currency->currency ;?>"
        var appCurrencyFixed = "<?php echo Auth::user()->currency->is_currency_fixed ;?>"

        var total =  "<?php echo $total; ?>";
        var search =  "<?php echo $search; ?>";
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


        function sortProductsView(items){
            console.log(items)
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
                    var price = new Intl.NumberFormat('en-GB').format(item.price * conversionRate);
                    price += " <span class='green-text'>" +appCurrency+"</span>"
                }


                var product = '<div class="col-6 col-md-4 col-lg-3">';
                product += '<div class="tt-product thumbprod-center">';
                product += '<div class="tt-image-box">';
                //product += '<a href="<?php echo url("catalogue/product/"); ?>'+item.product_code+'" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>';
                product += '<a href="#" class="tt-btn-wishlist btnwishlist" data-prdlink="<?php echo url("catalogue/product/"); ?>'+item.product_code+'" data-tooltip="Add to Wishlist" data-tposition="left" data-img="'+item.image+'" data-product="'+item.product+'" data-del="1" data-price="'+price+'"></a>';
                product += '<a href="<?php echo url("catalogue/product/"); ?>'+item.product_code+'">';
                product += '<span class="tt-img"><img src="'+item.image+'" data-src="'+item.image+'" alt="'+item.product+'"></span>';
                product += '<span class="tt-img-roll-over"><img src="'+item.image+'" data-src="'+item.image+'" alt="'+item.product+'"></span>';
                product += '</a>';
                product += '</div>';
                product += '<div class="tt-description">';
                product += '<div class="tt-row">';
                product += '<ul class="tt-add-info">';
                 product += '<li><a href="#">'+item.category_name+'</a></li>';
                product += '</ul>';
                product += '</div>';
                product += '<h2 class="tt-title"><a href="<?php echo url("catalogue/product/"); ?>'+item.product_code+'" title="'+item.product+'">'+item.product+'</a></h2>';
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
                product += ' <a href="<?php echo url("catalogue/product/"); ?>'+item.product_code+'" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>';
                product += '<a href="#" class="tt-btn-wishlist"></a>';
                product += '</div>';
                product += '</div>';
                product += '</div>';
                product += '</div>';
                product += '</div>';



                $(".category_products").append(product)
            })
        }

        function sortProducts(sortval) {
            alertui.load('Sorting products...',
                function(loadClose, loadEl) {
                    $.ajax({
                            url:baseUrl + 'sort_catalogue_search_items',
                            data: {'sort':sortval, 'search': search},
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
                                swal("","Failed to retrieve more items", "error");
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
                                sortProductsView(res.data);
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
                                alertui.notify('error', 'An Error Occurred. Please try again.')
                                swal("","An Error Occurred. Please try again.", "error");
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
                            url:baseUrl + 'filter_catalogue_search_items',
                            data: {'filterval':filterval, 'search': search},
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
                                swal("","Failed to retrieve more items", "error");

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
                                sortProductsView(res.data);
                                if(currentPage == maxPage()){
                                    $('#loadmorebtn').hide();
                                }
                                alertui.notify('success', 'Products filtered')
                            }

                        })
                        .fail(function (response) {
                            loadClose();
                            // handle error
                            disableItem($("#loadmorebtn"), false)
                            $(".process_indicator").addClass('off');
                            if(response.status == 500){
                                alertui.notify('error', 'An Error Occurred. Please try again.')
                                swal("","An Error Occurred. Please try again.", "error");

                            }
                            else{
                                alertui.notify('info', response.responseJSON.data)
                                swal("",response.responseJSON.data, "error");

                            }
                        })
                })
        }
        
        
        function sortFilterProducts(sortval, filterval) {
            alertui.load('Sorting products...',
                function(loadClose, loadEl) {
                    $.ajax({
                            url:baseUrl + 'sort_catalogue_search_items',
                            data: {'sort':sortval, 'search': search},
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
                                swal("","Failed to retrieve more items", "error");
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
                                sortProductsView(res.data);
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
                                alertui.notify('error', 'An Error Occurred. Please try again.')
                                swal("","An Error Occurred. Please try again.", "error");
                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                                swal("",response.responseJSON.data, "error");
                            }
                        })
                })
        }

        $(document).ready(function () {


            $('#mysort').change(function(){
                    var sort_id = $(this).val();
                    
                    var method_id = $( "#mymethod option:selected" ).val();
                    
                    sortFilterProducts(sort_id,method_id);
                    
            });
            
            
            $('#mymethod').change(function(){
                    var method_id = $(this).val();
                   
                    
                    var sort_id = $( "#mysort option:selected" ).val();
                
                    sortFilterProducts(sort_id,method_id);
            
            });

            //Event for Price sort
            //Create custom event
            var $price_sort_li = $('.price_sort_li');
            $price_sort_li.on('price_sort_li_click',function (e) {
                sortval = $(this).attr('id');
                sortProducts($(this).attr('id'));
            });

            //trigger custom event
            $('ul a.price_sort_li').click(function (e){
                $(this).trigger('price_sort_li_click')
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
        </script>
@endpush