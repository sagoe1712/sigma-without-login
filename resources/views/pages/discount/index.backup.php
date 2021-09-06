@extends('layouts.main')
@section('content')
     <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px;">
                    <h5 class="modal-title modal_category_title">B Natural</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                 <div class="row">
                     <div class="col-sm-10 col-sm-offset-1">
                         <div class="row">
                             <div class="col-sm-4">
                                 <img/>
                             </div>
                             <div class="col-sm-8">
                                 <div class="row">
                                     <b>Location</b>
                                     <ul class="discount-location">
                                         <li>11 Oduduwa Way, Ikeja GRA, Lagos</li>
                                         <li>11 Oduduwa Way, Ikeja GRA, Lagos</li>
                                     </ul>
                                 </div>
                                 <hr>
                                 <div class="row">
                                     <b>Offers</b>
                                     <ul class="discount-offer">
                                         <li>15% off Swedish Massage Classical Facial (Men & Women), Classic MAnicure & Pedicure and Traditional Moroccan Hamman</li>
                                         <li>15% off Swedish Massage Classical Facial (Men & Women), Classic MAnicure & Pedicure and Traditional Moroccan Hamman</li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                    <br><br>
                    {{--<a>--}}
                    {{--<button type="button" class="btn btn-large btn-primary pay_bills_btn custom_button_color"><i class="fa fa-spinner fa-spin off process_indicator"></i> Redeem</button>--}}
                    {{--</a>--}}
                </div>
            </div>
        </div>
    </div>

        <div class="body-content">
            <div class='container'>
                <div class='row'>
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-30">
                        <div class="breadcrumb">
                            <div class="container">
                                <div class="breadcrumb-inner">
                                    <ul class="list-inline list-unstyled">
                                        <li><a href="{{url('/')}}">Home</a></li>
                                        <li class='active'>Discount</li>
                                    </ul>
                                </div>
                                <!-- /.breadcrumb-inner -->
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="container">
                            @include('partials.sigma.banner', ['page' => 'discount'])
                            <div style="background: #fff;
                                    -webkit-border-radius: 10px;
                                     -moz-border-radius: 10px;
                                     border-radius: 10px;
                                     margin-bottom: 40px;
                                        ">
                                <div class="row">

                                    <div class="col-sm-3 col-md-3">
                                        <div class="cinemas_item_container events_item_container discount_container"
                                             id="">
                                            <div class="image_container" style="height: auto;">
                                                <img  alt="" class="movie_img" src="" style="width: 100%; height: auto;">
                                            </div>
                                            <div class="details" style="width: 100%;">
                                                <h4 style="color: #333;font-size: 16px;">{{str_limit(ucfirst(strtolower('hello')), 22 )}}</h4>
                                            </div>
                                        </div>
                                    </div>

                                    {{--                                            @foreach($data->events as $index => $item)--}}
                                    {{--                                            --}}
                                    {{--                                            @endforeach--}}
                                </div>
                            </div>
                        </div>
                    </div>

{{--                    @if(isset($data))--}}
{{--                        @if($data->status == 1)--}}
{{--                            <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                                <div class="container">--}}
{{--                                    @include('partials.sigma.banner', ['page' => 'discount'])--}}
{{--                                    <div style="background: #fff;--}}
{{--                                    -webkit-border-radius: 10px;--}}
{{--                                     -moz-border-radius: 10px;--}}
{{--                                     border-radius: 10px;--}}
{{--                                     margin-bottom: 40px;--}}
{{--                                        ">--}}
{{--                                        <div class="row">--}}

{{--                                            <div class="col-sm-3 col-md-3">--}}
{{--                                                <div class="cinemas_item_container events_item_container discount_container"--}}
{{--                                                 id="">--}}
{{--                                                    <div class="image_container" style="height: auto;">--}}
{{--                                                        <img  alt="" class="movie_img" src="{{$item->banner}}" style="width: 100%; height: auto;">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="details" style="width: 100%;">--}}
{{--                                                        <h4 style="color: #333;font-size: 16px;">{{str_limit(ucfirst(strtolower($item->title)), 22 )}}</h4>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            @foreach($data->events as $index => $item)--}}
{{--                                            --}}
{{--                                            @endforeach--}}
{{--                                    </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    @endif--}}
                </div>
            </div>
        </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('sigma/css/alertui.min.css')}}">
    <style>
        .modal-content{
            overflow: auto;
            height: 700px;
        }
    </style>
@endpush
@push('script')
    <script src="{{asset('sigma/js/alertui.min.js')}}"></script>
    <script src="{{asset('sigma/js/lodash.min.js')}}"></script>

@endpush