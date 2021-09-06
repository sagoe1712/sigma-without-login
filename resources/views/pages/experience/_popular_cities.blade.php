<div class="row tt-layout-promo-box">
    <div class="col-sm-12 col-md-12">
        <div class="row">
            @if($popular)
                @if(isset($popular))
                    @foreach($popular as $item)
                        <div class="col-sm-6 col-md-3">
                            <a href="{{url('experiences_search?exp_city='.$item->city_id)}}" class="tt-promo-box tt-one-child hover-type-2">
                                <img src="{{asset('images/loader.svg')}}" data-src="http://www.{{$item->image}}" alt="">
                                <div class="tt-description">
                                    <div class="tt-description-wrapper">
                                        <div class="tt-background"></div>
                                        <div class="tt-title-small">
                                            <p class="country-name">{{$item->country_name}}</p>
                                            <p class="city-name">{{$item->city_name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>

</div>
