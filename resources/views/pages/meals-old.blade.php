@extends('layouts.main')
@section('content')

    <div class="meal-slider-container">
        <div class="centered">
            <h1>
                Redeem Delicious Meal Today
            </h1>
        </div>
        <img src="{{asset('images/meal-images/mealslider.png')}}" width="100%" />
    </div>

    <div id="tt-pageContent">
        <div class="five-star-container">

            <h2>OUR 5 STAR RESTAURANT</h2>
            <p>Discover delicious meal with sigma pension</p>
            @if(isset($categories))
                @if($categories->status == 1)
                    <div class="row">
                        @foreach($categories->data as $branch)
                            @foreach($branch->child_menu as $item)
                                <div class="col-4 col-md-4 select-restaurant">
{{--                                @foreach($item->category as $category)--}}


{{--                                    <a href="{{url('meals/'.str_slug($item->name).'?branch_id='.$item->id.'&categories%5B%5D='.$category->id)}}">--}}
{{--                                        @if (strpos($item->name, 'Bheerhugz Ikeja') !== false)--}}
{{--                                            <img src="{{asset('images/meal-images/bheerhugz.png')}}" alt="{{$item->name}}">--}}
{{--                                        @elseif (strpos($item->name, 'Bheerhugz Surulere') !== false)--}}
{{--                                            <img src="{{asset('images/meal-images/bheerhugz.png')}}" alt="{{$item->name}}">--}}
{{--                                        @elseif (strpos($item->name, 'the backyard resturant') !== false)--}}
{{--                                                <img src="{{asset('images/meal-images/backyard.png')}}" alt="{{$item->name}}">--}}
{{--                                            @elseif (strpos($item->name, 'Marcopolo Chinese Lekki') !== false)--}}
{{--                                            <img src="{{asset('images/meal-images/marcopolo.png')}}" alt="{{$item->name}}">--}}
{{--                                        @elseif (strpos($item->name, 'Roadchef Lekki') !== false)--}}
{{--                                            <img src="{{asset('images/meal-images/rchef.png')}}" alt="{{$item->name}}">--}}
{{--                                        @elseif (strpos($item->name, 'ofada boy') !== false)--}}
{{--                                            <img src="{{asset('images/meal-images/ofadaboy.png')}}" alt="{{$item->name}}">--}}
{{--                                        @endif--}}
{{--                                    </a>--}}


                                    <form action="{{url('meals', ['name' => str_slug($item->name)])}}" method="get">
                                        <input type="hidden" name="branch_id" value="{{$item->id}}"/>
                                        @foreach($item->category as $category)
                                            <input type="hidden" name="categories[]" value="{{$category->id}}"/>
                                        @endforeach

                                        @if (strpos($item->name, 'Bheerhugz Ikeja') !== false)
                                            <img type="submit"  src="{{asset('images/meal-images/bheerhugz.png')}}" alt="{{$item->name}}">
                                        @elseif (strpos($item->name, 'Bheerhugz Surulere') !== false)
                                            <img src="{{asset('images/meal-images/bheerhugz.png')}}" alt="{{$item->name}}">
                                        @elseif (strpos($item->name, 'the backyard resturant') !== false)
                                                <img src="{{asset('images/meal-images/backyard.png')}}" alt="{{$item->name}}">
                                            @elseif (strpos($item->name, 'Marcopolo Chinese Lekki') !== false)
                                            <img src="{{asset('images/meal-images/marcopolo.png')}}" alt="{{$item->name}}">
                                        @elseif (strpos($item->name, 'Roadchef Lekki') !== false)
                                            <img src="{{asset('images/meal-images/rchef.png')}}" alt="{{$item->name}}">
                                        @elseif (strpos($item->name, 'ofada boy') !== false)
                                            <img src="{{asset('images/meal-images/ofadaboy.png')}}" alt="{{$item->name}}">
                                        @endif
                                    </form>

                                    <p>{{ucwords($item->name)}}</a></p>



{{--                                @endforeach--}}
                                </div>
                        @endforeach
                        @endforeach
                    </div>
                    @endif
            @endif
        </div>

    </div>



@endsection
@push('style')
    <style>
        .select-restaurant{
            cursor: pointer !important;
        }
    </style>

@endpush
@push('script')
    <script>
        $('body').addClass('meal-bg');

        $('.select-restaurant').click(function () {
                $(this).children('form').submit();
        })
    </script>
@endpush
