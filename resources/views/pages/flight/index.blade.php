@extends('layouts.main')
@section('content')

    <div class="take-out-container">
        <div class="meal-slider-container">
            <div class="centered">
                <h2>
                    Search & Book Your Flights Today
                </h2>
            </div>
            <img src="{{asset('images/flight-images/banner.png')}}" width="100%" />
        </div>

        <div class="search-flight-container background-div">
            <div class="tag-list">
                <button id="defaultOpen" onclick="switchTabs(event, 'one_way')" type="button" class="btn btn-primary btn-sm rotate-btn reactive">
                    One Way
                </button>
                <button onclick="switchTabs(event, 'round_trips')" type="button" class="btn btn-primary btn-sm rotate-btn">
                    Round Trips
                </button>
                <button onclick="switchTabs(event, 'multiple_trips')" type="button" class="btn btn-primary btn-sm rotate-btn">
                    Multiple Destinations
                </button>

            </div>
            <div class="background-contents">

                <!-- Beginning of Flight bg -->
                <div class="flight-background">
                    <!-- Beginning of One way -->
                    <div class="contents" id="one_way">
                        <form method="post" action="{{url('flight/search')}}">
                            {{ csrf_field() }}
                            <input name="travel" type="hidden" value="Oneway">
                        <div class="row">
                            <div class= "col-md-3 col-sm-3" name="originairport">
                                <p>Flying from: </p>
                                <input class="form-control txtairport" id="txtFlightOrigin" name="originairport"/>
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Flying to: </p>
                                <input class="form-control txtairport" name="destinationairport" id="txtFlightDestination">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Departing: </p>
                                <input class="form-control" type="date" name="departdate" id="example-date-input">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Ticket Class: </p>
                                <select class="form-control" name="cabinclass" id="drpCabinClass">
                                    <option value=F">First Class Cabin</option>
                                    <option value=C">Business Class Cabin</option>
                                    <option value="M" selected>Economy Cabin</option>
                                    <option value="W">Premium Economy Cabin</option>
                                    <option value="Y">All Economy Cabin</option>
                                </select>
                            </div>
                        </div>
                        <hr class="horizontal-line" />
                        <div class="lower-container">
                            <h5>Travelers</h5>
                            <div class="row">
                                <!-- <div class= "col-md-3 col-sm-3">
                                    <div class="centered-travel">
                                        <h5>Travelers</h5>
                                     </div>
                                </div> -->
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" name="adult" id="adult">
                                        <option value="1">Adult: 1</option>
                                        <option value="2">Adult: 2</option>
                                        <option value="3">Adult: 3</option>
                                        <option value="4">Adult: 4</option>
                                        <option value="5">Adult: 5</option>
                                        <option value="6">Adult: 6</option>
                                    </select>
                                    <span>12+ yrs</span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" name="children" id="children">
                                        <option value="0">Children: 0</option>
                                        <option value="1">Children: 1</option>
                                        <option value="2">Children: 2</option>
                                        <option value="3">Children: 3</option>
                                        <option value="4">Children: 4</option>
                                        <option value="5">Children: 5</option>
                                        <option value="6">Children: 6</option>
                                    </select>
                                    <span>2-11 yrs: </span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" name="infant" id="infant">
                                        <option value="0">Infants: 0</option>
                                        <option value="1">Infants: 1</option>
                                        <option value="2">Infants: 2</option>
                                        <option value="3">Infants: 3</option>
                                        <option value="4">Infants: 4</option>
                                        <option value="5">Infants: 5</option>
                                        <option value="6">Infants: 6</option>
                                    </select>
                                    <span>Below 2 yrs: </span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <div class="tag-list">
                                        <button type="submit" class="btn btn-primary btn-sm flight-btn">
                                            Search
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>
                    <!-- End of One way -->
                    <!-- Beginning of round trip -->
                    <div class="contents" id="round_trips">
                        <form method="post" action="{{url('flight/search')}}">
                            {{ csrf_field() }}
                            <input name="travel" type="hidden" value="Return">
                        <div class="row">
                            <div class= "col-md-2 col-sm-2">
                                <p>Flying from: </p>
                                <input class="form-control txtairport" name="originairport">
                            </div>
                            <div class= "col-md-2 col-sm-2">
                                <p>Flying to: </p>
                                <input class="form-control txtairport" name="destinationairport">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Departing: </p>
                                <input class="form-control" type="date" name="departdate" id="example-date-input">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Returning: </p>
                                <input class="form-control" type="date"  name="returndate" id="example-date-input">
                            </div>
                            <div class= "col-md-2 col-sm-2">
                                <p>Ticket Class: </p>
                                <select class="form-control" name="cabinclass" id="drpCabinClass">
                                    <option value=F">First Class Cabin</option>
                                    <option value=C">Business Class Cabin</option>
                                    <option value="M" selected>Economy Cabin</option>
                                    <option value="W">Premium Economy Cabin</option>
                                    <option value="Y">All Economy Cabin</option>
                                </select>
                            </div>
                        </div>
                        <hr class="horizontal-line" />

                        <div class="lower-container">
                            <h5>Travelers</h5>
                            <div class="row">
                                <!-- <div class= "col-md-3 col-sm-3">
                                    <div class="centered-travel">
                                        <h5>Travelers</h5>
                                     </div>
                                </div> -->
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" name="adult" id="adult">
                                        <option value="1">Adult: 1</option>
                                        <option value="2">Adult: 2</option>
                                        <option value="3">Adult: 3</option>
                                        <option value="4">Adult: 4</option>
                                        <option value="5">Adult: 5</option>
                                        <option value="6">Adult: 6</option>
                                    </select>
                                    <span>12+ yrs</span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" name="children" id="children">
                                        <option value="0">Children: 0</option>
                                        <option value="1">Children: 1</option>
                                        <option value="2">Children: 2</option>
                                        <option value="3">Children: 3</option>
                                        <option value="4">Children: 4</option>
                                        <option value="5">Children: 5</option>
                                        <option value="6">Children: 6</option>
                                    </select>
                                    <span>2-11 yrs: </span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" name="infant" id="infant">
                                        <option value="0">Infants: 0</option>
                                        <option value="1">Infants: 1</option>
                                        <option value="2">Infants: 2</option>
                                        <option value="3">Infants: 3</option>
                                        <option value="4">Infants: 4</option>
                                        <option value="5">Infants: 5</option>
                                        <option value="6">Infants: 6</option>
                                    </select>
                                    <span>Below 2 yrs: </span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <div class="tag-list">
                                        <button type="submit" class="btn btn-primary btn-sm flight-btn">
                                            Search
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>
                    <!-- End of round trips -->

                    <!-- Beginning of multiple trips -->
                    <div class="contents" id="multiple_trips">
                        <form method="post" action="{{url('flight/search')}}">
                            {{ csrf_field() }}
                            <input name="travel" type="hidden" value="Multidestination">
                        <div class="row">
                            <div class= "col-md-3 col-sm-3">
                                <p>Flying from: </p>
                                <input class="form-control txtairport" name="airport1">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Flying to: </p>
                                <input class="form-control txtairport" name="airport2">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Departing: </p>
                                <input class="form-control" type="date" id="date1" name="date1">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Ticket Class: </p>
                                <select class="form-control" name="cabinclass1" id="drpCabinClass">
                                    <option value=F">First Class Cabin</option>
                                    <option value=C">Business Class Cabin</option>
                                    <option value="M" selected>Economy Cabin</option>
                                    <option value="W">Premium Economy Cabin</option>
                                    <option value="Y">All Economy Cabin</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class= "col-md-3 col-sm-3">
                                <p>Flying from: </p>
                                <input class="form-control txtairport" name="airport3">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Flying to: </p>
                                <input class="form-control txtairport" name="airport4">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Departing: </p>
                                <input class="form-control" type="date" name="date2" id="date2">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Ticket Class: </p>
                                <select class="form-control" name="cabinclass2" id="drpCabinClass">
                                    <option value=F">First Class Cabin</option>
                                    <option value=C">Business Class Cabin</option>
                                    <option value="M" selected>Economy Cabin</option>
                                    <option value="W">Premium Economy Cabin</option>
                                    <option value="Y">All Economy Cabin</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class= "col-md-3 col-sm-3">
                                <p>Flying from: </p>
                                <input class="form-control txtairport" name="airport5">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Flying to: </p>
                                <input class="form-control txtairport" name="airport6">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Departing: </p>
                                <input class="form-control" type="date" name="date3" id="date3">
                            </div>
                            <div class= "col-md-3 col-sm-3">
                                <p>Ticket Class: </p>
                                <select class="form-control" name="cabinclass3" id="drpCabinClass">
                                    <option value=F">First Class Cabin</option>
                                    <option value=C">Business Class Cabin</option>
                                    <option value="M" selected>Economy Cabin</option>
                                    <option value="W">Premium Economy Cabin</option>
                                    <option value="Y">All Economy Cabin</option>
                                </select>
                            </div>
                        </div>
                        <div class="icon-blocks">
                            <a href="#"><i class="fa fa-plus-circle"> Add More</i></a>
                            <a href="#"><i class="fa fa-minus-circle"> Remove</i></a>
                        </div>

                        <hr style="margin-top: 4%;" class="horizontal-line" />

                        <div class="lower-container">
                            <h5>Travelers</h5>
                            <div class="row">
                                <!-- <div class= "col-md-3 col-sm-3">
                                    <div class="centered-travel">
                                        <h5>Travelers</h5>
                                     </div>
                                </div> -->
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" id="adult">
                                        <option value="1">Adult: 1</option>
                                        <option value="2">Adult: 2</option>
                                        <option value="3">Adult: 3</option>
                                        <option value="4">Adult: 4</option>
                                        <option value="5">Adult: 5</option>
                                        <option value="6">Adult: 6</option>
                                    </select>
                                    <span>12+ yrs</span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" id="children">
                                        <option value="0">Children: 0</option>
                                        <option value="1">Children: 1</option>
                                        <option value="2">Children: 2</option>
                                        <option value="3">Children: 3</option>
                                        <option value="4">Children: 4</option>
                                        <option value="5">Children: 5</option>
                                        <option value="6">Children: 6</option>
                                    </select>
                                    <span>2-11 yrs: </span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <select class="form-control" id="sel1">
                                        <option value="0">Infants: 0</option>
                                        <option value="1">Infants: 1</option>
                                        <option value="2">Infants: 2</option>
                                        <option value="3">Infants: 3</option>
                                        <option value="4">Infants: 4</option>
                                        <option value="5">Infants: 5</option>
                                        <option value="6">Infants: 6</option>
                                    </select>
                                    <span>Below 2 yrs: </span>
                                </div>
                                <div class= "col-md-3 col-sm-3">
                                    <div class="tag-list">
                                        <button type="submit" class="btn btn-primary btn-sm flight-btn">
                                            Search
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>
                    <!-- End of multiple trips -->

                </div>
                <!-- End of flight bg -->


            </div>
        </div>
    </div>

@if(isset($popularlocation))
    <div style="padding-left: 10%; padding-right: 10%; margin-bottom: 30px;" id="tt-pageContent top-destination-container mb-30">
        <div class="container-indent0">
            <div class="container-fluid">
                <div class="top-destination-title">
                    <h3 style="margin-bottom: 5%;">TOP DESTINATION</h3>
                </div>
                <div class="row tt-layout-promo-box">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            @foreach($popularlocation->data as $data)
                            <div class="col-sm-6 col-md-3">
                                <a href="#" class="tt-promo-box tt-one-child hover-type-2 destination-img" data-airport="{{$data->city_name}} - {{$data->name_code}} - {{$data->country_name}}">
                                    <img src="{{asset('images/loader.svg')}}" data-src="{{$data->image}}" alt="">
                                    <div class="tt-description">
                                        <div class="tt-description-wrapper">
                                            <div class="tt-background"></div>
                                            <div class="tt-title-small">
                                                <p class="country-name">{{$data->country_name}}</p>
                                                <p class="city-name">{{$data->city_name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    @endif

@endsection
@push('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @endpush
@push('script')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $('.destination-img').click(function(){
            var airport = $(this).attr('data-airport');
            $('input[name="destinationairport"]').val(airport);
        })
        function switchTabs(evt, contents) {

            var i, tabcontent, tablinks;


            tabcontent = document.getElementsByClassName("contents");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("item2");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            document.getElementById(contents).style.display = "block";
            evt.currentTarget.className += " active";
        }
        //open tab by default
        document.getElementById("defaultOpen").click();



        $(function () {
            $.ajaxSetup({
                headers: { 'token': '{{Auth::user()->company->token}}' }
            });
            var getData = function (request, response) {
                $.getJSON(
                    "{{url('api/airports')}}/" + request.term,
                    function (data) {
                        var i = [];

                        $.each(data,function(key,value){
                            i.push(value.detail_name);
                        })
                        response(i);
                    });
            };

            var selectItem = function (event, ui) {
                $(this).val(ui.item.value);
                // $("#txtFlightOrigin").val(ui.item.value);
                // $("#txtFlightDestination").val(ui.item.value);
                return false;
            }

            $(".txtairport").autocomplete({
                source: getData,
                select: selectItem,
                minLength: 3,
                change: function() {
                    $(this).css("display", 2);
                    // $("#txtFlightOrigin").css("display", 2);
                    // $("#txtFlightOrigin").css("display", 2);
                }
            });
        });

    </script>

@endpush