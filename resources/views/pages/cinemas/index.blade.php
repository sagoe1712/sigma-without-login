@extends('layouts.main')
@section('content')
    <div class="tt-pageContent">
        <div class="cinema-container">
            <div class="row">
                <div class="col-md-6">
                    <div class="redeem-movie">
                        <h1>Redeem Movie ticket today</h1>
                        <p>Experience block buster movies in cinemas near you with Sigma Prime.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="movie-icons">
                        <img src="{{asset('images/cinema-images/icons.png')}}" width="100%" />
                    </div>
                </div>
            </div>
            <div class=''>
                <div class='row'>

                <div class="container" style="margin-bottom: 100px; margin-top: 50px">

                <div class="row">

                    @if(!empty($cinemas))

{{--                        <div class="trending-movies">--}}
{{--                            <h4>TRENDING MOVIES</h4>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-6 col-md-4">--}}
{{--                                    <img src="{{asset('images/cinema-images/main1.png')}}" width="100%" alt="cinema" />--}}
{{--                                </div>--}}
{{--                                <div class="col-6 col-md-4">--}}
{{--                                    <img src="{{asset('images/cinema-images/main2.png')}}" width="100%" alt="cinema" />--}}
{{--                                </div>--}}
{{--                                <div class="col-6 col-md-4">--}}
{{--                                    <img src="{{asset('images/cinema-images/main3.png')}}" width="100%" alt="cinema" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                                @foreach($cinemas as $index => $category)

                            <div class="container container-fluid-custom-mobile-padding">
                                <div class="tt-block-title text-left now-showing-block">
                                    <h2 class="tt-title-small low-opacity">NOW SHOWING</h2>
                                    <h2 class="tt-title-large">{{(ucwords($category->name))}}, {{(ucwords($category->location))}}, {{(ucwords($category->state))}}</h2>
                                </div>
{{--                                <div class="tt-carousel-products row arrow-location-right-top tt-alignment-img tt-layout-product-item slick-animated-show-js">--}}
                                <div class="tt-carousel-products row arrow-location-right-top tt-alignment-img tt-layout-product-item slick-animated-show-js">

                                @foreach($category->tickets as $movies)
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <div class="tt-product thumbprod-center">
                                                <div class="tt-image-box">
                                                   <!-- <a href="#" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a> -->
                                                    <a href="{{url('movie', ['code' => $movies->product_code])}}">
                                                        <span class="tt-img"><img src="{{asset('images/loader.svg')}}" data-src="{{$movies->artwork}}" alt="" onerror=' this.src="{{asset("images/no_image.jpg")}}"' width="100%"></span>
                                                        <span class="tt-img-roll-over"><img src="{{asset('images/loader.svg')}}" data-src="{{$movies->artwork}}" alt="" onerror='this.src="{{asset("images/no_image.jpg")}}"'></span>
                                                        <!-- <span class="tt-label-location">
                                                          <span class="tt-label-our-fatured">Fatured</span>
                                                        </span> -->
                                                    </a>
                                                </div>
                                                <div class="tt-description" style="min-height: 95px;">
                                                    <div class="tt-row">
                                                        <ul class="tt-add-info">
                                                            <li><a href="#">Movies</a></li>
                                                        </ul>
                                                        <!-- <div class="tt-rating">
                                                          <i class="icon-star"></i>
                                                          <i class="icon-star"></i>
                                                          <i class="icon-star"></i>
                                                          <i class="icon-star"></i>
                                                          <i class="icon-star"></i>
                                                        </div> -->
                                                    </div>
                                                    <h2 style="padding-bottom: 5px;" data-tooltip data-tposition="bottom"  class="tt-title productname">
                                                        <a  class="variable-name" href="{{url('movie', ['code' => $movies->product_code])}}">
                                                            {{$movies->title}}
                                                        </a>
                                                    </h2>

{{--                                                    <div class="tt-product-inside-hover">--}}
{{--                                                        <div class="tt-row-btn">--}}
{{--                                                            <!-- <a>HELLO WORLD</a> -->--}}
{{--                                                            <a href="{{url('movie', ['code' => $movies->product_code])}}" class="tt-btn-addtocart thumbprod-button-bg">View Movie</a>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                                    @endforeach
                    @else
                        <h3 style="color: #fff; text-align: center; margin-left: 40%; margin-top:100px;">No Cinemas Available</h3>
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
@endpush
@push('script')
    <script>
        $('body').addClass('tt-page-product-single cinema-bg');
    </script>
    @endpush
