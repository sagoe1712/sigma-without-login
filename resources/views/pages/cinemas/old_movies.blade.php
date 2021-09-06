@extends('layouts.main')
@section('content')
    <div class="body-content">
        <div class="body-content">
            <div class=''>
                <div class='row'>
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-30">
                        <div class="breadcrumb">
                            <div class="container">
                                <div class="breadcrumb-inner">
                                    <ul class="list-inline list-unstyled">
                                        <li><a href="{{url('/')}}">Home</a></li>
                                        <li><a href="{{url('cinemas')}}">Cinemas</a></li>
                                        <li class='active'>Movies</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container" style="margin-bottom: 100px;background-color: transparent;">
                        <div class="row container">
                            <div class="col-sm-12 no-padding" style="border-bottom: 1px solid #fff;">
                                <h3 style="color: #fff;">{{$movies->name}}</h3></div>
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
                                                <h4 title="{{ucfirst(strtolower($ticket->title))}}">{{str_limit(ucfirst(strtolower($ticket->title)), 20)}}</h4>
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
        @push('style')
            <link rel="stylesheet" type="text/css" href="{{asset('sigma/css/alertui.min.css')}}">
            <style>
                body{
                    background: url("{{asset('sigma/images/bg/cinema_bg.jpg')}}") !important;
                    background-color: #000 !important;
                }
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
