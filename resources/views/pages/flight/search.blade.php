@extends('layouts.main')
@section('content')
    <div id="tt-pageContent">
        <div class="tickets-container">
            <div class="row">
                <div class= "col-md-9 col-sm-9">
                    <div class="flight-inline">
                    <span>
                            {{$search_parameter['origin']}} to {{$search_parameter['destination']}}
                    </span>
                        <span>
                        {{$search_parameter['depart_date']}} @if($search_parameter['travel'] == "Return") - {{$search_parameter['return_date']}}@endif
                    </span>
                        <span>
                        {{$search_parameter['adults']}} Adult {{$search_parameter['children']}} Child {{$search_parameter['infants']}} Infant
                    </span>
                        <span>
                        {{$search_parameter['cabin']}}
                    </span>
                    </div>
                </div>
                <div class= "col-md-3 col-sm-3">
                    <div class="flight-inline">
                        <a href="{{url('flight')}}" class="btn btn-default flighticket-btn">Change</a>

                    </div>

                </div>
            </div>
        </div>

        <div class="container-indent margin-bottom">
            <div class="container flight-checkout-div">
                <div class="row modal-form-container">
                    <div class="col-9 col-md-6 col-lg-6">
                        <p class="bold-text black-text">Select your flight</p>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="size">Sort by:</label>
                            <select class="form-control" id="sel1">
                                <option>Price Low to High</option>
                                <option>Price High to Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="size">Sort by stop:</label>
                            <select class="form-control" id="sel1">
                                <option>Nonstop</option>
                                <!-- <option>Delivery</option> -->
                                <!-- <option>Pick Up + Delivery</option> -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tickets -->
            <?php if($status == 0){ ?>
            <h5>{{$message}}</h5>
            <?php } ?>
            <?php if($status == 1001){ ?>
            @foreach($flights as $data)
            <form method="POST" action="{{url('flight/details')}}" class="checkout-box">
                {{ csrf_field() }}
                <div class="row">

                    <div class="col-md-9 col-sm-9">
                        <div class="row special-row">
                            <div class="col-md-3 col-sm-3">
                                <div class="arik-images-div">
                                    <img class="arik-images"
                                         src="{{$data->FlightCombination->FlightModels[0]->AirlineLogoUrl}}" alt="{{$data->FlightCombination->FlightModels[0]->AirlineName}}" />
                                </div>

                            </div>
                            <div class="col-md-9 col-sm-9">
                                <div class="ticket-spans">
                              <span>
                                  {{$data->FlightCombination->FlightModels[0]->DepartureCode}} {{date('d-m-Y h:m',strtotime($data->FlightCombination->FlightModels[0]->DepartureTime))}}
                                  &xrarr; &nbsp;</span>
                                    <span>
                                     {{$data->FlightCombination->FlightModels[0]->TripDuration}} &nbsp;| {{$data->FlightCombination->FlightModels[0]->Stops}} Stop(s)
                                      &xrarr;</span>
                                    <span>
                                          {{$data->FlightCombination->FlightModels[0]->ArrivalCode}} {{date('d-m-Y h:m',strtotime($data->FlightCombination->FlightModels[0]->ArrivalTime))}}
                              </span>
                                </div>
                                <div class="lower-div-cont-flight">
                                     <p>Flight arrives</p>
                                    <p>{{$data->FlightCombination->FlightModels[0]->FlightLegs[0]->CabinClassName}}</p>
                                </div>

                            </div>

                        </div>
                        <hr class="lower-horizontal" />
                        @if($search_parameter['travel'] == "Return")
                        <div class="row special-row">
                            <div class="col-md-3 col-sm-3">
                                <div class="arik-images-div">
                                    <img class="arik-images"
                                         src="{{$data->FlightCombination->FlightModels[1]->AirlineLogoUrl}}" alt="{{$data->FlightCombination->FlightModels[1]->AirlineName}}" />
                                </div>

                            </div>
                            <div class="col-md-9 col-sm-9">
                                <div class="ticket-spans">
                              <span>
                                  {{$data->FlightCombination->FlightModels[1]->DepartureCode}} {{date('d-m-Y h:m',strtotime($data->FlightCombination->FlightModels[1]->DepartureTime))}}
                                  &xrarr; &nbsp;</span>
                                    <span>
                                      {{$data->FlightCombination->FlightModels[1]->TripDuration}} &nbsp;| {{$data->FlightCombination->FlightModels[1]->Stops}} Stop(s)
                                      &xrarr;</span>
                                    <span>
                                         {{$data->FlightCombination->FlightModels[1]->ArrivalCode}} {{date('d-m-Y h:m',strtotime($data->FlightCombination->FlightModels[1]->ArrivalTime))}}
                              </span>
                                </div>
                                <div class="lower-div-cont-flight">
                                    <p>Flight arrives</p>
                                    <p>{{$data->FlightCombination->FlightModels[1]->FlightLegs[0]->CabinClassName}}</p>
                                </div>

                            </div>

                        </div>
                            @endif

                    </div>
                    <div class="col-md-3 col-sm-3 special-column">
                        <div class="">
                            <h5>{{$data->FlightCombination->Price}}</h5>
                            <p>Sigma Stars</p>
                            <input type="hidden" name="productcode" value="{{preg_replace('/\s+/', '',$data->product_code)}}">
                          <input type="hidden" name="searchparameter" value="{{json_encode($search_parameter)}}">
                            <a href="#">
                                <button type="submit"  class="btn btn-primary btn-sm flight-btn">
                                    View
                                </button>
                            </a>

                        </div>
                    </div>

                </div>
            </form>
            @endforeach
            <?php } ?>
        </div>
        <!-- Load more button -->
{{--        <div class="load-more-btn-container">--}}
{{--            <button type="button" class="btn btn-default load-more-btn">Load More</button>--}}
{{--        </div>--}}





    </div>

@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/flight.css')}}">
@endpush