@extends('layouts.main')
@section('content')

    <div id="tt-pageContent">
        <div class="tickets-container">
            <div class="row">
                <div class= "col-md-9 col-sm-9">
                    <div class="flight-inline">
                    <span>
                            {{$search_parameter->origin}} to {{$search_parameter->destination}}
                    </span>
                        <span>
                        {{$search_parameter->depart_date}} @if($search_parameter->travel == "Return") - {{$search_parameter->return_date}}@endif
                    </span>
                        <span>
                        {{$search_parameter->adults}} Adult {{$search_parameter->children}} Child {{$search_parameter->infants}} Infant
                    </span>
                        <span>
                        {{$search_parameter->cabin}}
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

        @if($status == 1001)
        <div class="container-indent margin-bottom">
            <div class="container flight-checkout-div">
                <div class="row modal-form-container">
                    <div class="col-9 col-md-6 col-lg-6">
                        <p class="bold-text black-text">Itenary</p>
                    </div>
                </div>
            </div>
            <!-- Tickets -->
            <div class="checkout-box">
                <div class="row">
                    <div class="col-md-9 col-sm-9">
                        <div class="row special-row">
                            <div class="col-md-3 col-sm-3">
                                <div class="arik-images-div">
                                    <img class="arik-images"
                                         src="{{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->AirlineLogoUrl}}" alt="{{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->AirlineName}}" />
                                </div>

                            </div>
                            <div class="col-md-9 col-sm-9">
                                <div class="ticket-spans">
                              <span>
                                  {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->DepartureCode}} {{date('d-m-Y h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[0]->DepartureTime))}}
                                  &xrarr; &nbsp;</span>
                                    <span>
                                     {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->TripDuration}} | {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->Stops}} Stop(s) <?php $stop = $flight->FlightSummaryModel->FlightCombination->FlightModels[0]->Stops; ?>
                                      &xrarr;</span>
                                    <span>
                                          {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->ArrivalCode}} {{date('d-m-Y h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[0]->ArrivalTime))}}
                              </span>
                                </div>
                                <div class="lower-div-cont-flight">
                                    <p>Flight arrives</p>
                                    <p>{{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->FlightLegs[0]->CabinClassName}}</p>
                                </div>

                            </div>

                        </div>
                        @if(isset($flight->FlightSummaryModel->FlightCombination->FlightModels[1]))
                        <hr class="lower-horizontal" />
                        <div class="row special-row">
                            <div class="col-md-3 col-sm-3">
                                <div class="arik-images-div">
                                    <img class="arik-images"
                                         src="{{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->AirlineLogoUrl}}" alt="{{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->AirlineName}}" />
                                </div>

                            </div>
                            <div class="col-md-9 col-sm-9">
                                <div class="ticket-spans">
                              <span>
                                   {{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->DepartureCode}} {{date('d-m-Y h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[1]->DepartureTime))}}
                                   &xrarr; &nbsp;</span>
                                    <span>
                                     {{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->DepartureCode}} {{date('d-m-Y h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[1]->DepartureTime))}}
                                     &xrarr;</span>
                                    <span>
                                                      {{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->ArrivalCode}} {{date('d-m-Y h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[1]->ArrivalTime))}}
                             </span>
                                </div>
                                <div class="lower-div-cont-flight">
                                    <p>Flight arrives</p>
                                    <p>{{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->FlightLegs[0]->CabinClassName}}</p>
                                </div>

                            </div>

                        </div>
                            @endif

                    </div>
                    <div class="col-md-3 col-sm-3 special-column">
                        <div class="">
                            <h5>{{$flight->FlightSummaryModel->FlightCombination->Price}}</h5>
                            <p>Sigma Stars</p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Section 2 -->

            <div class="section-ticket-container">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <div class="box-whitebg">
                            <div class="padded-contents">
                                <h5>DEPART {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->DepartureCode}} - {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->ArrivalCode}}</h5>
                            </div>
                            <hr />
                            <div class="padded-contents" >
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <p>{{date('d M Y',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[0]->DepartureTime))}}</p>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <img
                                                class="arik-images-width"
                                                src="{{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->AirlineLogoUrl}}" alt="{{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->AirlineName}}"/>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <p>{{date('h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[0]->DepartureTime))}} - {{date('h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[0]->ArrivalTime))}}</p>

                                       @foreach($flight->FlightSummaryModel->FlightCombination->FlightModels[0]->FlightLegs as $data)
                                        <p>
                                           {{$data->DepartureName}} - {{$data->DestinationName}}
                                        </p>
                                        <i>{{date("d/m/y h:m",strtotime($data->StartTime))}} - {{date("d/m/y h:m",strtotime($data->EndTime))}}</i>
                                        <p>Flight Duration: {{$data->Duration}}</p>
                                        <p class="grey-text">Flight Carrier: {{$data->OperatingCarrierName}} {{$data->FlightNumber}} - {{$data->BookingClass}}- class</p>
                                           @if(isset($data->Layover))
                                               <p>Layover: {{$data->Layover}} (Layout Duration: {{date("h:m",strtotime($data->LayoverDuration))}}))</p>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <p class="no-margin-text">
                                            {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->FlightLegs[0]->CabinClassName}}
                                        </p>
                                        <p class="grey-text2">
                                            Flight Duration: {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->TripDuration}}
                                        </p>
                                    </div>
                                </div>
                                <div class="tintedbg">
                                    Baggage Info: {{$flight->FlightSummaryModel->FlightCombination->FlightModels[0]->FreeBaggage->Weight}}kg
                                </div>
                            </div>
                            <!-- second info -->
                            @if(isset($flight->FlightSummaryModel->FlightCombination->FlightModels[1]))
                            <div class="padded-contents">
                                <h5>RETURN {{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->DepartureCode}} - {{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->ArrivalCode}}</h5>
                            </div>
                            <hr />
                            <div class="padded-contents" >
                                <div class="row">
                                    <div class="col-md-3 col-sm-3">
                                        <p>{{date('d M Y',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[1]->DepartureTime))}}</p>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <img
                                                class="arik-images-width"
                                                src="{{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->AirlineLogoUrl}}" alt="{{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->AirlineName}}"/>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <p>{{date('h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[1]->DepartureTime))}} - {{date('h:m',strtotime($flight->FlightSummaryModel->FlightCombination->FlightModels[1]->ArrivalTime))}}</p>
                                        @foreach($flight->FlightSummaryModel->FlightCombination->FlightModels[1]->FlightLegs as $data)
                                            <p>
                                                {{$data->DepartureName}} - {{$data->DestinationName}}
                                            </p>
                                            <i>{{date("d/m/y h:m",strtotime($data->StartTime))}} - {{date("d/m/y h:m",strtotime($data->EndTime))}}</i>
                                            <p>Flight Duration: {{$data->Duration}}</p>
                                            <p class="grey-text">Flight Carrier: {{$data->OperatingCarrierName}} {{$data->FlightNumber}} - {{$data->BookingClass}}- class</p>
                                            @if(isset($data->Layover))
                                                <p>Layover: {{$data->Layover}} (Layout Duration: {{date("h:m",strtotime($data->LayoverDuration))}}))</p>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <p class="no-margin-text">
                                            {{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->FlightLegs[0]->CabinClassName}}
                                        </p>
                                        <p class="grey-text2">
                                           Flight Duration: {{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->TripDuration}}
                                        </p>
                                    </div>
                                </div>
                                <div class="tintedbg">
                                    Baggage Info: {{$flight->FlightSummaryModel->FlightCombination->FlightModels[1]->FreeBaggage->Weight}}kg
                                </div>
                            </div>
                                @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="bg-overlay">
                            <div class="checkoutbox-section">
                                <div class="checkoutbox-contents">
                                    <h5>Fare Summary</h5>
                                    <div class="flexed-contents">
                                        <p>Traveler(s)</p>
                                        <p>{{$flight->FlightSummaryModel->FlightCombination->Price}} Sigma Stars</p>

                                    </div>
                                    <p>Adults (x{{$flight->FlightSummaryModel->FlightCombination->Adults}})</p>
                                    @if($flight->FlightSummaryModel->FlightCombination->Children > 0)
                                    <p>Children (x{{$flight->FlightSummaryModel->FlightCombination->Children}})</p>
                                    @endif
                                    @if($flight->FlightSummaryModel->FlightCombination->Infants > 0)
                                    <p>Infants (x{{$flight->FlightSummaryModel->FlightCombination->Infants}})</p>
                                        @endif
                                </div>
                                <hr style="margin-top: 5px;" />
                                <div class="checkoutbox-contents">
                                    <div class="flexed-contents">
                                        <p>Totals</p>
                                        <p>{{$flight->FlightSummaryModel->FlightCombination->Price}} <span>Sigma Stars</span></p>

                                    </div>
                                    <div class="flexed-container-btn">
                                        <a href="#" class="btn-upper btn btn-primary" data-price="{{$flight->FlightSummaryModel->FlightCombination->Price}}" data-signature="{{$flight->signature}}" data-bookingid="{{$flight->BookingId}}" data-toggle="modal" data-target="#myModal">
                                            BOOK
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        @else
            <div class="checkout-box">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
            <h3 style="text-align: center; margin: 100px auto;">{{$message}}</h3>
                    </div>
                </div>
            </div>
        @endif





    </div>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Flight Ticket Redemption</h4>
                </div>
                <div class="modal-body">
                   <form method="post" action="{{url('redeem_flight')}}">
                       <input type="hidden" name="signature" value="{{$flight->signature}}">
                       <input type="hidden" name="bookingid" value="{{$flight->BookingId}}">
<h3>Booking Details</h3>
                       <div class="row">
                           <div class="col-12 col-md-6">
                               <p>First Name: </p>
                               <input class="form-control txtairport" name="first_name">
                           </div>
                           <div class="col-12 col-md-6">
                               <p>Last Name: </p>
                               <input class="form-control" name="last_name">
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-12 col-md-6">
                               <p>Email Address: </p>
                               <input class="form-control" name="email">
                           </div>
                           <div class="col-12 col-md-6">
                               <p>Phone Number: </p>
                               <input class="form-control" name="phone_no">
                           </div>
                       </div>
                       <h3>Passenger(s) Information</h3>

                       <div class="row booking-field">

                       </div>


                   </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/flight.css')}}">
@endpush