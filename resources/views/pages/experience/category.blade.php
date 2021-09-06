@extends('layouts.main')
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('experiences')}}">Experiences</a></li>
                    @if(isset($pagename))
                    <li class='active'>{{$pagename}}</li>
                        @endif
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <div class="body-content outer-top-vs">
        <div class="container" style="padding-bottom: 30px;">
            @if($products)
            <div class="row">
                @include('partials.sigma.experience.sidebar')
                <div class="col-xs-12 col-sm-12 col-md-9 rht-col">
                    @if(isset($products->status))
                        @if($products->status == 1)
                            <div class="search-result-container">
                            <div id="myTabContent" class="tab-content category-list" style="border-radius: 10px;">
                                    <div class="clearfix" style="border-bottom: 1px solid #ccc; padding: 10px;margin-top: -20px; margin-bottom: 20px;">
                                        <h3 class="new-product-title pull-left">{{$pagename}}</h3>
                                    </div>
                                <div class="tab-pane active " id="grid-container">
                                    <div class="category-product">
                                        <div class="row category_products">
                                            @if(isset($products->data))
                                                @foreach($products->data as $product)
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="item">
                                                            <div class="products">
                                                                <div class="product">
                                                                    <div class="product-image">
                                                                        <div class="image">
                                                                            <a  href="{{url('experience', [$product->product_code])}}">
                                                                                <img src="{{asset('images/spinnerb.gif')}}" alt="" data-src="{{$product->image}}">
                                                                                {{--<img src="{{asset('assets/images/spinnerb.gif')}}" alt="" class="hover-image">--}}
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-info text-left">
                                                                        <h3 class="name">
                                                                            <a  href="{{url('experience', [$product->product_code])}}">{{str_limit($product->product, 20)}}</a></h3>
                                                                        @if(Auth::check())
                                                                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                                                                <div class="product-price"> <span class="price">&#8358;{{transform_product_price($product->price, 1) }}</span> </div>
                                                                            @else
                                                                                <div class="product-price"> <span class="price">{{ transform_product_price($product->price, Auth::user()->currency->rate )  }} {{Auth::user()->currency->currency }}</span> </div>
                                                                            @endif
                                                                        @endif

                                                                    </div>

                                                                </div>
                                                                <!-- /.product -->

                                                            </div>
                                                            <!-- /.products -->
                                                        </div>
                                                    </div>
                                                @endforeach

                                        </div>

                                        @endif
                                    </div>
                                    <!-- /.category-product -->

                                </div>

                            </div>


                            </div>

                        @endif

                    @endif

                </div>
            </div>
                @else
                <header class="section-header text-center">
                    <h3 class="text-center">No Products available.</h3>
                </header>
            @endif
        </div>
    </div>
@endsection
@push('script')
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
    <script>
        $('.sidebar').theiaStickySidebar({
            // Settings
            additionalMarginTop: 30
        });

    </script>
    <script>
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

        // function loadImage(image){
        //     var src = image.dataset.src;
        //     $.get(src)
        //         .done(function(){
        //             image.src = src;
        //         })
        // }

        function preLoadImage(image){
            var src = image.dataset.src;
            image.src = src;
            // fetchImage(src).then(() => {
            //     image.src = src;
            // })
        }
    </script>
@endpush