@extends('layouts.main')

@section('content')

    <div class="take-out-container">
        <div class="meal-slider-container">
            <div class="centered">
                <h2>
                    Experience Amazing Places and Events
                </h2>
            </div>
            <img src="{{asset('images/experience-images/topbg.png')}}" width="100%" />
        </div>
        <div class="search-restaurant-container">
            <p>Book your Activities and Tours now.</p>
            <form class="" method="get" action="{{url('experiences_search')}}">
            <div class="row">
                <div class="col-6 col-md-5 modal-form-container">
                    <div class="">

                        <select name="exp_country" id="exp_country" class="form-control product_input" required>
                            {{--<option value="" selected="selected" disabled="disabled" required>Select Country</option>--}}
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                        <label class="take-out-label" for="exp_country">Country:</label>
                    </div>
                </div>
                <div class="col-6 col-md-5 modal-form-container">
                    <div class="">

                        <select name="exp_city" id="exp_city" class="product_input form-control">
                            <option value="" selected="selected">Select City</option>
                        </select>
                        <label class="take-out-label" for="exp_city">City:</label>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <button style="width: 100%;" type="submit"  class="btn btn-primary btn-lg">
                        Search
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>


    <div style="padding-left: 10%; padding-right: 10%;" id="tt-pageContent top-destination-container">
        <div class="container-indent0">
            <div class="container-fluid">
                <div class="top-destination-title">
                    <h3>TOP DESTINATION</h3>
                    <p>Discover tours, attractions and activities for your next adventure</p>
                </div>
                @include('pages.experience._popular_cities')
            </div>
        </div>

    </div>
    <!-- Popular Activiies -->
    <div class="container-indent popular-activities-container">
        <div class="container container-fluid-custom-mobile-padding">
            @if(!empty($activities))
            <div class="tt-block-title text-left">
                <h2 class="tt-title-small">Popular Activities</h2>
                <!-- <h2 class="tt-title-large">Genesis Maryland</h2> -->
            </div>
            <div class="tt-carousel-products row arrow-location-right-top tt-alignment-img tt-layout-product-item slick-animated-show-js">
                @foreach($activities->data->data as $act)
                <div class="col-2 col-md-4 col-lg-3">
                    <div class="tt-product thumbprod-center">
                        <a href="#">
                            <img src="http://www.{{$act->image}}" width="100%" alt="experience" />
                        </a>


                    </div>
                    <div class="product-description">
                        <p>{{$act->name}}</p>
                        <p class="sigma-price">{{$act->price}} <span>Sigma Stars</span></p>
                    </div>
                </div>
                @endforeach
            </div>
      @endif
        </div>
    </div>


@endsection

@push('script')
    {{--<script src="{{asset('sigma/js/bootstrap-select.min.js')}}"></script>--}}
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            // $('#exp_country').selectpicker();

            //Load cities on page ready
            $.ajax({
                type:"GET",
                url:"{{url('api/getcities')}}"+"/"+$("#exp_country").val(),
                headers:{token:1200},
                dataType:"json",
                success: function(res){
                    $('#exp_city').empty();
                    disableItem($('#exp_city'), false);
                    disableItem($(".search_exp_btn"), false)
                    if (res.status == 200 ){

                        $.each(res.data, function(key,value)
                        {
                            var city = value.name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                return letter.toUpperCase();
                            });
                            $('#exp_city').append('<option value="'+value.id+'" data-cityname="'+value.name+'">'+city+'</option>');
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
            disableItem($(".search_exp_btn"), true)
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
                                var city = value.name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                    return letter.toUpperCase();
                                });
                                $('#exp_city').append('<option value="'+value.id+'" data-cityname="'+value.name+'">'+city+'</option>');
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

            });
        })
    </script>
    @endpush