@extends('layouts.main')
@section('content')
    <div class="body-content">
        <div class="body-content">
            <div class=''>
                <div class='row'>

                    <div class="container" style="margin-bottom: 100px;background-color: transparent;">
                        <div class="row" style="margin-bottom: 20px; margin-top: 20px;">
                            <a href="{{url()->previous()}}" class="text-white">&#8592; Back to previous page</a>
                        </div>
                        <div class="row container">
                            <div class="col-sm-12 no-padding" style="border-bottom: 1px solid #fff; margin-bottom: 30px;">
                                <h3 style="color: #fff;">Now Showing @ {{$movies->name}}</h3></div>
                            @foreach($movies->tickets as $ticket)
                                <div class="col-sm-4 col-md-3 ">
                                    <div class="cinemas_item_container">
                                        <div class="image_container" style="text-align: center">
                                            <a href="{{url('movie', ['code' => $ticket->product_code])}}">
                                                <img title="{{ucfirst(strtolower($ticket->title))}}" src="{{$ticket->artwork}}" alt="" onerror='this.src="{{asset("images/no_image.jpg")}}"'  class="movie_img" data-src="{{$ticket->artwork}}">
                                            </a>
                                        </div>

                                        <div class="details text-center" style="width: 100%;">
                                            <a href="{{url('movie', ['code' => $ticket->product_code])}}" style="color: #fff;">
                                                <h4 class="text-white" title="{{ucfirst(strtolower($ticket->title))}}">{{str_limit(ucfirst(strtolower($ticket->title)), 20)}}</h4>
                                            </a>
                                            <p class="text-white" title="{{ucfirst(strtolower($ticket->genre))}}">{{str_limit(ucfirst(strtolower($ticket->genre)),26)}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @push('script')
            <script>
                $('body').addClass('tt-page-product-single cinema-bg');
            </script>
        @endpush
        @push('style')
            <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
            <style>

                .yamm.megamenu-horizontal{
                    background: #333;
                }
                .sidebar .side-menu nav .nav > li > a{
                    color: #fff;
                }
                .cinemas_item_container {
                    min-height: 400px;
                    max-height: 400px;
                }
                .text-white{
                    color: #fff;
                }
            </style>
    @endpush
