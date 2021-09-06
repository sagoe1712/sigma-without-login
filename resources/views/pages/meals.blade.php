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
        <div class="new-meals-container">
            <div class="row">
                <div class="col-12 col-md-3 col-lg-3"  id="sidebar">
                    <div class="meals-column-div theiaStickySidebar">
                        <h6 style="font-weight: bold;">Categories</h6>
                        <div class="category-container2">
                            <div id="cat_nav">
                                @if(isset($categories))
                                    @if($categories->status == 1)
                                        @foreach($categories->data as $branch)
                                            <?php $i = 0;?>
                                            <a href="#{{$i}}" class="active">
                                <span class="category-listing-con4">
                                    <p>{{ucwords($branch->name)}}</p>
                                    <img src="{{asset('images/new-meals-images/navigate.svg')}}" />

                                </span>
                                            </a>
                                            <?php $i++; ?>
                                        @endforeach
                                        @endif
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-9 col-lg-9">
                    @if(isset($categories))
                        @if($categories->status == 1)
                            @foreach($categories->data as $branch)

                                <?php $j = 0;?>

                    <h4 id="{{$j}}" style="padding-bottom: 8px;">{{ucwords($branch->name)}}</h4>
                    <hr style="margin: 0px;" />
                                    @foreach($branch->child_menu as $item)
                                        <form action="{{url('meals', ['name' => str_slug($item->name)])}}" method="get">
                                            <input type="hidden" name="branch_id" value="{{$item->id}}"/>
                                            @foreach($item->category as $category)
                                                <input type="hidden" name="categories[]" value="{{$category->id}}"/>
                                            @endforeach
                                               <div class="bher-container">
                        <div class="row">
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="bher-img-div">
                                    <img src="{{$branch->image}}" alt="">
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6 ">
                                <div class="meal-bheer-des">
                                    <h6>{{ucwords($item->name)}}</h6>
                                    <p>No 1 Olubunmi Owa Street, Lekki Phase 1, Lagos.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3 meal-btn-container">
                                <button  onclick="window.location.href = 'view_menu.html';" class="btn search-btn menu-btn">View Menu</button>
                            </div>
                        </div>

                    </div>
                                        </form>
                                    @endforeach

                                <?php $j++; ?>

                            @endforeach
                        @endif
                    @endif
                </div>
            </div>

        </div>

    </div>


@endsection
@push('style')


@endpush
@push('script')
<script>
    $('body').addClass('meal-bg2');
</script>
@endpush
