
@extends('layouts.main')
@section('content')
    <div id="tt-pageContent">
        <div class="wish-list-bg">
            <div class="centered">
                <h5>MY WISHLIST</h5>
            </div>
            <img class="wish-list-img" src="{{asset('images/slides/bg.png')}}" width="100%" />
        </div>

        <div class="container-indent white-catalog-background margin-bottom">
            <div class="container container-fluid-custom-mobile-padding">
                <div class="row modal-form-container">
                    <div class="col-9 col-md-6 col-lg-6">
                        <p class="bold-text black-text">@if(isset($response_array)){{count($response_array)}} @else 0 @endif Items</p>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
{{--                        <div class="form-group">--}}
{{--                            <label for="size">Sort by:</label>--}}
{{--                            <select class="form-control" id="sel1">--}}
{{--                                <option>Price Low to High</option>--}}
{{--                                <option>Price High to Low</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
{{--                        <div class="form-group">--}}
{{--                            <label for="size">Sort by:</label>--}}
{{--                            <select class="form-control" id="sel1">--}}
{{--                                <option>Pick Up</option>--}}
{{--                                <option>Delivery</option>--}}
{{--                                <option>Pick Up + Delivery</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="row tt-layout-product-item">
                    @if(isset($response_array))
                        @foreach($response_array as $item)
                    <div class="col-6 col-md-4 col-lg-3" id="{{$item->id}}">
                        <div class="tt-product thumbprod-center">
                            <div class="tt-image-box">
                                <a href="{{$item->product_code}}">
                                    <span class="tt-img"><img src="{{asset('images/loader.svg')}}" data-src="{{$item->image}}" alt="{{$item->product_name}}"></span>
                                    <span class="tt-img-roll-over"><img src="{{asset('images/loader.svg')}}" data-src="{{$item->image}}" alt="{{$item->product_name}}"></span>
                                </a>
                                <span class="tt-label-location">
                                <span href="#"  data-tooltip="Remove" class="btn-remove" data-id="{{$item->id}}">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </span>
                            </span>

                            </div>
                            <div class="tt-description">
                                <div class="tt-row">
{{--                                    <ul class="tt-add-info">--}}
{{--                                        <li><a href="#">T-SHIRTS</a></li>--}}
{{--                                    </ul>--}}

                                </div>
                                <h2 class="tt-title"><a href="{{$item->product_code}}">{{$item->product_name}}</a></h2>
                                <p class="sigma-price">{{$item->price}} <span>Sigma Stars</span></p>

{{--                                <div class="tt-product-inside-hover">--}}
{{--                                    <div class="tt-row-btn">--}}

{{--                                        <a href="#" class="tt-btn-addtocart thumbprod-button-bg" data-toggle="modal" data-target="#modalAddToCartProduct">ADD TO CART</a>--}}
{{--                                    </div>--}}
{{--                                    <div class="tt-row-btn">--}}
{{--                                        <a href="women_view.html" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>--}}
{{--                                        <a href="#" class="tt-btn-wishlist"></a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                        @endforeach
                    @else
                        <div class="col-12"><br/><br/><h2>{{$data}}</h2></div>
                    @endif

                </div>
            </div>
        </div>
        <!-- Load more button -->






    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
@endpush
@push('script')
    <script src="{{asset('js/alertui.min.js')}}"></script>

<script>
    $('.btn-remove').click(function(){
        var id = $(this).attr('data-id');
        $(this).html('<img src="{{asset('assets/images/spinnerb.gif')}}" style="width: 60px"/>')
        $.post("{{url('api/delete_wishlist_item')}}", {id: id})
            .done(function (res) {
                if (!res) {
                    $(this).html(' <i class="fa fa-trash-o" aria-hidden="true"></i>');
                    alertui.notify('error', 'Failed to update your wishlist');
                    return false;
                }
                if (res.status == '400') {
                    $(this).html(' <i class="fa fa-trash-o" aria-hidden="true"></i>');
                    alertui.notify('error', res.message);
                    return false;
                }
                $("div[id=" + id + "] ").fadeOut("slow", function () {
                    alertui.notify('success', 'Your wishlist has been updated');
                    $('.wishlist-count').html(res.count);
                    return false;
                    // location.reload();
                })
            })
    })
    </script>
    @endpush