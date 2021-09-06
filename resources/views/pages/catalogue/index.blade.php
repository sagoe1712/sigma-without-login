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
    <div id="tt-pageContent">

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


        @include('partials.general.shop-slider')

{{--        @if(!$products)--}}
{{--            <header class="section-header text-center">--}}
{{--                <h3 class="text-center">No Products available.</h3>--}}
{{--            </header>--}}

{{--        @else--}}

        <div class="container-indent0">
            <div class="container-fluid">
                <div class="row tt-layout-promo-box">
                    <div class="col-sm-12 col-md-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{url('catalogue/trousers-denims-40')}}" class="tt-promo-box tt-one-child hover-type-2">
                                    <img src="images/loader.svg" data-src="images/product/sale.png" alt="">
                                    <div class="tt-description">
                                        <div class="tt-description-wrapper">
                                            <div class="tt-background"></div>
                                            <div class="tt-title-small">JEANS</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{url('catalogue/32-inch-amp-below-127')}}" class="tt-promo-box tt-one-child hover-type-2">
                                    <img src="images/loader.svg" data-src="images/product/tv.png" alt="">
                                    <div class="tt-description">
                                        <div class="tt-description-wrapper">
                                            <div class="tt-background"></div>
                                            <div class="tt-title-small">TELEVISIONS</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{url('catalogue/t-shirts-polos-38')}}" class="tt-promo-box tt-one-child hover-type-2">
                                    <img src="images/loader.svg" data-src="images/product/tshirt.png" alt="">
                                    <div class="tt-description">
                                        <div class="tt-description-wrapper">
                                            <div class="tt-background"></div>
                                            <div class="tt-title-small">TSHIRT & POLOS</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <a href="{{url('catalogue/perfumes-17')}}" class="tt-promo-box tt-one-child hover-type-2">
                                    <img src="images/loader.svg" data-src="images/product/perf.png" alt="">
                                    <div class="tt-description">
                                        <div class="tt-description-wrapper">
                                            <div class="tt-background"></div>
                                            <div class="tt-title-small">PERFUMES</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{url('catalogue/apple-phones-74')}}" class="tt-promo-box tt-one-child hover-type-2">
                                    <img src="images/loader.svg" data-src="images/product/phone.png" alt="">
                                    <div class="tt-description">
                                        <div class="tt-description-wrapper">
                                            <div class="tt-background"></div>
                                            <div class="tt-title-small">PHONES</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-12">
                                <a href="{{url('catalogue/laptops-77')}}" class="tt-promo-box tt-one-child">
                                    <img src="images/loader.svg" data-src="images/product/laptop.png" alt="">
                                    <div class="tt-description">
                                        <div class="tt-description-wrapper">
                                            <div class="tt-background"></div>
                                            <div class="tt-title-small">LAPTOPS</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($trending->data))
        <div class="container-indent white-catalog-background">
            <div class="container container-fluid-custom-mobile-padding">
                <div class="tt-block-title">
                    <h1 class="tt-title">TRENDING</h1>
                    <div class="tt-description">TOP VIEW IN THIS WEEK</div>
                </div>
                <div class="row tt-layout-product-item">

                    <?php $i = 0;?>
                    @foreach ($trending->data as $item)
                    @foreach ($item->data as $item1)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="tt-product thumbprod-center">
                                <div class="tt-image-box">
{{--                                    <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView{{$i}}"	data-tooltip="Quick View" data-tposition="left"></a>--}}
                                    <a href="#" class="tt-btn-wishlist btnwishlist" data-prdlink="{{url('catalogue/product/'.$item1->product_code)}}" data-tooltip="Add to Wishlist" data-tposition="left" data-img="{{$item1->image}}" data-product="{{$item1->product}}" data-del="1" data-price="{{$item1->price}}"></a>
                                    <!-- <a href="#" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a> -->
                                    <a href="{{url('catalogue/product/'.$item1->product_code)}}">
                                        <span class="tt-img"><img src="{{asset('images/loader.svg')}}" data-src="{{$item1->image}}" alt=""></span>
                                        <span class="tt-img-roll-over"><img src="{{asset('images/loader.svg')}}" data-src="{{$item1->image}}" alt=""></span>
                                        <!-- <span class="tt-label-location">
                                            <span class="tt-label-our-fatured">Fatured</span>
                                        </span> -->
                                    </a>
                                </div>
                                <div class="tt-description">
                                    <div class="tt-row">
                                        <ul class="tt-add-info">
                                            <li><a href="#">{{$item->category_name}}</a></li>
                                        </ul>
                                        <!-- <div class="tt-rating">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </div> -->
                                    </div>

                                    <h2 style="padding-bottom: 5px;" data-tooltip="{{$item1->product}}" data-tposition="bottom"  class="tt-title productname">
                                        <a  class="variable-name" href="{{url('catalogue/product/'.$item1->product_code)}}">
                                            {{$item1->product}}
                                        </a>
                                    </h2>
                                    @if(!Auth::guest())
                                    <p style="margin-top: 0px;" class="sigma-price">{{transform_product_price($item1->price, Auth::user()->currency->rate )}} <span>{{Auth::user()->currency->currency}}</span></p>
                                @else

                                        <p style="margin-top: 0px;" class="sigma-price">{{transform_product_price($item1->price, $cs->rate )}} <span>{{$cs->currency}}</span></p>

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
                                            <a href="{{url('catalogue/product/'.$item1->product_code)}}" class="tt-btn-addtocart thumbprod-button-bg">VIEW PRODUCT</a>
                                        </div>
                                        <div class="tt-row-btn">
{{--                                            <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView{{$i}}"></a>--}}
                                            <a href="#" class="tt-btn-wishlist"></a>
                                            {{--                                        <a href="#" class="tt-btn-compare"></a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                <?php $i++; ?>
                                @break($i == 8)

                            @endforeach
                    @endforeach

                </div>
            </div>
        </div>
        @endif
        <div class="container-indent">
            <div class="container-fluid-custom">
                <div class="row tt-layout-promo-box">
                    <div class="col-sm-6 col-md-4">
                        <a href="{{url('catalogue/perishables-147')}}" class="tt-promo-box">
                            <img src="{{asset('images/loader.svg')}}" data-src="{{asset('images/product/groceries.png')}}" alt="">
                            <div class="tt-description">
                                <div class="tt-description-wrapper">
                                    <div class="tt-background"></div>
                                    <div class="tt-title-small grey-text">EXPLORE</div>
                                    <div class="tt-title-small">GROCERIES</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <a href="{{url('catalogue/consoles-video-games-82')}}" class="tt-promo-box">
                            <img src="images/loader.svg" data-src="images/product/game.png" alt="">
                            <div class="tt-description">
                                <div class="tt-description-wrapper">
                                    <div class="tt-background"></div>
                                    <div class="tt-title-small grey-text">EXPLORE</div>
                                    <div class="tt-title-small">Games &amp; Video Games</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <a href="{{url('catalogue/make-up-lips-83')}}" class="tt-promo-box">
                            <img src="images/loader.svg" data-src="images/product/beauty.png" alt="">
                            <div class="tt-description">
                                <div class="tt-background"></div>
                                <div class="tt-description-wrapper">
                                    <div class="tt-background"></div>
                                    <div class="tt-title-small grey-text">EXPLORE</div>
                                    <div class="tt-title-small">BEAUTY</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($bestselling->data))
        <div class="container-indent white-catalog-background">
            <div class="container container-fluid-custom-mobile-padding">
                <div class="tt-block-title">
                    <h2 class="tt-title">BEST SELLER</h2>
                    <div class="tt-description">TOP SALE IN THIS WEEK</div>
                </div>
                <div class="row tt-layout-product-item">
                    <?php $j = 0;?>
                    @foreach ($bestselling->data as $item)
                            @foreach ($item->data as $item2)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="tt-product thumbprod-center">
                                <div class="tt-image-box">
{{--                                    <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#Modal{{($j)}}"	data-tooltip="Quick View" data-tposition="left"></a>--}}
                                    <a href="#" class="tt-btn-wishlist btnwishlist" data-prdlink="{{url('catalogue/product/'.$item2->product_code)}}" data-tooltip="Add to Wishlist" data-tposition="left" data-img="{{$item2->image}}" data-product="{{$item2->product}}" data-del="1" data-price="{{$item2->price}}"></a>
                                    <!-- <a href="#" class="tt-btn-compare" data-tooltip="Add to Compare" data-tposition="left"></a> -->
                                    <a href="{{url('catalogue/product/'.$item2->product_code)}}">
                                        <span class="tt-img"><img src="{{asset('images/loader.svg')}}" data-src="{{$item2->image}}" alt=""></span>
                                        <span class="tt-img-roll-over"><img src="{{asset('images/loader.svg')}}" data-src="{{$item2->image}}" alt=""></span>
                                        <!-- <span class="tt-label-location">
                                            <span class="tt-label-our-fatured">Fatured</span>
                                        </span> -->
                                    </a>
                                </div>
                                <div class="tt-description">
                                    <div class="tt-row">
                                        <ul class="tt-add-info">
                                            <li><a href="#">{{$item->category_name}}</a></li>
                                        </ul>
                                        <!-- <div class="tt-rating">
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                            <i class="icon-star"></i>
                                        </div> -->
                                    </div>


                                    <h2 style="padding-bottom: 5px;" data-tooltip="{{$item2->product}}" data-tposition="bottom"  class="tt-title productname">
                                        <a  class="variable-name" href="{{url('catalogue/product/'.$item2->product_code)}}">
                                            {{$item2->product}}
                                        </a>
                                    </h2>

                                    @if(!Auth::guest())
                                    <p style="margin-top: 0px;" class="sigma-price">{{transform_product_price($item2->price, Auth::user()->currency->rate )  }} <span>{{Auth::user()->currency->currency}}</span></p>
                                @else
                                        <p style="margin-top: 0px;" class="sigma-price">{{transform_product_price($item2->price, $cs->rate )  }} <span>{{$cs->currency}}</span></p>

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
                                            <a href="{{url('catalogue/product/'.$item2->product_code)}}" class="tt-btn-addtocart thumbprod-button-bg">VIEW PRODUCT</a>
                                        </div>
                                        <div class="tt-row-btn">
{{--                                            <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#Modal{{$j}}"></a>--}}
                                            <a href="#" class="tt-btn-wishlist"></a>
                                            {{--                                        <a href="#" class="tt-btn-compare"></a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            @endforeach

                    @endforeach
                </div>
            </div>
        </div>
        @endif

{{--        @endif--}}



    </div>

@endsection

@push('script')


        <script>
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
                        return false;
                    }
                    if (res.status == 400) {
                        alertui.notify('error', res.message);
                        return false;
                    } else {
                        swal("Wishlist",res.message, "success");
                        // $('#wishlistnotify').modal('show');
                        // $('#wishlistnotify').on('shown.bs.modal', function (e) {
                        //     $(".wishlist_response").html(res.message);
                            $('.wishlist-count').html(res.count);

                        // });
                    }

                })
                .fail(function (response) {
                    // handle error
                    disableItem($(".btnwishlist"), false)
                    $(".process_indicator").addClass('off');
                    if(response.status == 500){
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                        swal("Wishlist","An Error Occurred. Please try again", "error");
                    }
                    else{
                        alertui.notify('info', 'Failed to add to Wishlist. Please try again.')
                        swal("Wishlist","Failed to add to Wishlist. Please try again", "error");
                    }
                })
        });
        </script>

@endpush
