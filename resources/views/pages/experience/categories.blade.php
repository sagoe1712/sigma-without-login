@extends('layouts.main')
@section('content')
    <div class="take-out-container">
        <div class="meal-slider-container">
            <div class="centered">
                <h3>
                    {{$current_title}} ({{count($products->data)}})
                </h3>
            </div>
            <img src="{{asset('images/slides/bg.png')}}" width="100%" />
        </div>

    </div>

    <!-- View Experience -->
    <div class="view-experience-container">
        <div id="tt-pageContent">
            <div class="container-indent">
                <div class="container container-fluid-custom-mobile-padding">
                    <div class="colored-icons">
                        <a href="{{url('experiences')}}">
                            <i class="fa fa-arrow-left" aria-hidden="true">
                                <span>Back To Experiences</span>
                            </i>
                        </a>
                    </div>
                    @if($products)
                        @if(isset($products->data))
                            @if(count($products->data))
                                @if(isset($products->status))
                                    @if($products->status == 1)
                    <div class="row tt-layout-product-item">
                        @foreach($products->data as $product)
                        <div class="col-6 col-md-3 col-lg-3">

                            <div class="tt-product thumbprod-center">
                                <a href="{{url('experience', [$product->product."___".$product->product_code])}}" title="{{$product->product}}">
                                    <img src="{{$product->image}}" width="100%" alt="{{$product->product}}" />
                                </a>


                            </div>
                            <div class="product-description">
                                <p>{{str_limit($product->product, 30)}}</p>
                                @if(Auth::check())
                                    @if(Auth::user()->currency->is_currency_fixed == '1')
                                        <p class="sigma-price"> <span class="price">&#8358;{{transform_product_price($product->price, 1) }}</span> </p>
                                    @else
                                        <p class="sigma-price"> <span class="price">{{ transform_product_price($product->price, Auth::user()->currency->rate )  }} {{Auth::user()->currency->currency }}</span> </p>
                                    @endif
                                @endif

                            </div>

                        </div>
                        @endforeach
                    </div>

                @if($products->total > 20)

                    <div class="loadmore_container text-center" style="margin-top: 5rem!important;">
                        <button id="loadmorebtn" class="mt-5 btn btn-continue custom_button_color_2 load-more btn-default load-more-btn" data-next="2" data-city = "{{$city_id}}">
                            <i class="fa fa-spinner fa-spin off process_indicator"></i> Load more</button>
                    </div>


                @endif
                @else
                    <p>No Experience available</p>
                @endif
                @endif
                @endif
                @endif
            @endif
                </div>





            </div>
        </div>
    </div>



@endsection
@push('style')

    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
    <style>
        .product-price{
            margin-top: -10px;
        }
        .product-image .image {
            height: 210px;
        }
    </style>
@endpush
@push('script')
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>

    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script>
        $('.sidebar').theiaStickySidebar({
            // Settings
            additionalMarginTop: 30
        });

    </script>
    <script>

        function fetchCities(event){
            exp_country_id = $(event).val();
            $('#exp_city').empty();
            $('#exp_city').append('<option>Loading...</option>');
            disableItem($(".search_exp_btn"), true)
            disableItem($('#exp_city'), true);
            $.ajax({
                type:"GET",
                url:"{{url('api/getcities')}}"+"/"+exp_country_id,
                headers:{token:1200},
                dataType:"json",
                success: function(res){
                    $('#exp_city').empty();
                    disableItem($('#exp_city'), false);
                    disableItem($(".search_exp_btn"), false)
                    if (res.status == 200 ){

                        $.each(res.data, function(key,value)
                        {
                            $('#exp_city').append('<option value="'+value.id+'" data-cityname="'+value.name+'">'+ucFirst(value.name.toLowerCase())+'</option>');
                        });

                    }
                },
                error: function (response, status, error) {
                    $('#exp_city').empty();
                    $('#exp_city').append('<option>Select city</option>');
                    if(response.status == 500){
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                        swal("",'An Error Occurred. Please try again.', "error");

                    }
                    else{
                        alertui.notify('error', response.responseJSON.data)
                        swal("",response.responseJSON.data, "error");

                    }
                }
            });
        }

        {{--$(".category-product").on('click','.load-more', function(){--}}

        {{--//alert("click");--}}
        {{--    var page=$(this).attr("data-next");--}}
        {{--    var city=$(this).attr("data-city");--}}

        {{--    $.ajax({--}}
        {{--        type:"GET",--}}
        {{--        url:"{{url('api/load_more_experience_items')}}"+"/?exp_city="+city+"&page="+page,--}}
        {{--        dataType:"json",--}}
        {{--        success: function(res){--}}

        {{--            if (res.status == 1 ){--}}

        {{--                console.log(res.data)--}}
        {{--                var total = res.total;--}}
        {{--                var current_total = page * 20;--}}
        {{--                var next_page = parseInt(page) + 1;--}}
        {{--                var html="";--}}

        {{--                $.each(function(key, value){--}}

        {{--                    html += '<div class="col-sm-6 col-md-3 col-lg-3">';--}}
        {{--                    html += '<div class="product">';--}}
        {{--                    html += '<div class="product-image">';--}}
        {{--                    html += '<div class="image">';--}}
        {{--                    html += '<a  href="{{url("experience", ['+value->product+'"___"'+value->product_code+'])}}" title="{{'+value->product+'}}">';--}}
        {{--                    html += '<img src="{{asset("assets/images/spinnerb.gif")}}" alt="" data-src="{{'+value->image+'}}" class="hover-image">';--}}
        {{--                    html += '</a>';--}}
        {{--                    html += '</div>';--}}
        {{--                    html += ' </div>';--}}

        {{--                    html += '<div class="product-info text-left">';--}}
        {{--                    html += '<h3 class="name">';--}}
        {{--                    html += '<a  href="{{url("experience", [str_slug('+value->product+')+"___"'+value->product_code+'])}}" title="{{'+value->product+'}}">{{str_limit($product->product, 30)}}</a>';--}}
        {{--                    html += '</h3>';--}}
        {{--                    @if(Auth::check())--}}
        {{--                            @if(Auth::user()->currency->is_currency_fixed == '1')--}}
        {{--                        html += '<div class="product-price"> <span class="price">&#8358;{{transform_product_price($product->price, 1) }}</span> </div>';--}}
        {{--                    @else--}}
        {{--                        html += '<div class="product-price"> <span class="price">{{ transform_product_price($product->price, Auth::user()->currency->rate )  }} {{Auth::user()->currency->currency }}</span> </div>';--}}
        {{--                    @endif--}}
        {{--                            @endif--}}

        {{--                        html += '</div>';--}}
        {{--                    html += '</div>';--}}
        {{--                    html += '</div>';--}}
        {{--                });--}}



        {{--                if(total > current_total){--}}

        {{--                html+='<div class="loadmore_container text-center" style="margin-top: 5rem!important;">';--}}
        {{--                html+='<button id="loadmorebtn" class="mt-5 btn btn-continue custom_button_color_2 load-more" data-next='+next_page+' data-city ='+city+'>';--}}
        {{--                    html+='<i class="fa fa-spinner fa-spin off process_indicator"></i> Load more</button>';--}}
        {{--                    html+='</div>';--}}
        {{--                }--}}
        {{--                console.log(html);--}}
        {{--                alert(city);--}}
        {{--                // $.each(res.data, function(key,value)--}}
        {{--                // {--}}
        {{--                //     $('#exp_city').append('<option value="'+value.id+'" data-cityname="'+value.name+'">'+ucFirst(value.name.toLowerCase())+'</option>');--}}
        {{--                // });--}}

        {{--            }--}}
        {{--        },--}}
        {{--        error: function (response, status, error) {--}}
        {{--           alert("error");--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        $("#exp_country").on('change', function(){
            exp_country_id = $(this).val();
            $('#exp_city').empty();
            $('#exp_city').append('<option>Loading...</option>');
            disableItem($(".search_exp_btn"), true)
            disableItem($('#exp_city'), true);
            $.ajax({
                type:"GET",
                url:"{{url('api/getcities')}}"+"/"+exp_country_id,
                headers:{token:1200},
                dataType:"json",
                success: function(res){
                    $('#exp_city').empty();
                    disableItem($('#exp_city'), false);
                    disableItem($(".search_exp_btn"), false)
                    if (res.status == 200 ){

                        $.each(res.data, function(key,value)
                        {
                            $('#exp_city').append('<option value="'+value.id+'" data-cityname="'+value.name+'">'+ucFirst(value.name.toLowerCase())+'</option>');
                        });

                    }
                },
                error: function (response, status, error) {
                    $('#exp_city').empty();
                    $('#exp_city').append('<option>Select city</option>');
                    if(response.status == 500){
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                        swal("",'An Error Occurred. Please try again.', "error");

                    }
                    else{
                        alertui.notify('error', response.responseJSON.data)
                        swal(" ",response.responseJSON.data, "error");

                    }
                }
            });

        });

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