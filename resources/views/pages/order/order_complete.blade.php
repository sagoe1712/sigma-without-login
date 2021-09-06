@extends('layouts.main')
@section('content')
    @if($errors->any())
        @include('partials.notify', ['text' => $errors->first()])
    @endif
    @php
        $cartstatus = [
          'cancelled' => 0,
          'pending' => 1,
          'shipped' => 2,
          'delivered' => 3,
          'processing' => 4,
          'expired' => 5,
          'noncart' => 6,
          'deleted' => 7,
          'pickedup' => 8
       ];
   $total = 0;
   $anydelivery = "";
   $address = "";
   $sentto = "";
   $is_delivery = false;
    @endphp

    <div id="tt-pageContent">
        <div class="wish-list-bg">
            <div class="centered">
                <h5>ORDER RECEIPTS</h5>
            </div>
            <img class="wish-list-img" src="{{asset('images/profile-images/profiletopbg.png')}}" width="100%" />
        </div>

        <!-- Order Receipts Table -->
        <div class="order-history-div table-responsive-sm">

            <div>
                <div class="row">
                    @if(isset($order->order_no))

                            <div class="col-sm-12">
                                <span style="margin-bottom: 1px; font-weight: 700;">Order no : {{$order->order_no}}</span>
                                <span style="font-weight: 700; float:right">Date : {{ $order->created_at->format('D, j M, Y / h:i A') }}</span>
                            </div>

                    @endif
                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="grey-text">Name</th>
                        <th class="grey-text">Quantity</th>
                        <th class="grey-text">Price(Unit)</th>
                        <th class="grey-text">Price(Total)</th>
                        <th class="grey-text">Redemption method</th>
                        <th class="grey-text">Status</th>
                        <th class="grey-text">Voucher no</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($data))
                        @foreach($data as $item)
                            @php
                                $total += ceil($item->price * $item->qty);
                            @endphp
<tr>
                            <td class="modal-product-des">
                                <p>{{$item->name}}</p>
                                @if($item->value)
                                    <p>( {{$item->value}} )</p>
                                @endif

                                @if($item->delivery_type === 1)
                                    <span>
                                        <p style="text-decoration: underline;">Pickup Location</p>
                                        @if(isset($item->pickup_location_name))
                                            {{$item->pickup_location_name}}
                                        @endif
                                    </span>
                                @elseif($item->delivery_type === 2 || $item->delivery_type === 5)
                                    <span>

                                    </span>
                                @endif
                            </td>
                            <td>
                                {{$item->qty}}
                            </td>
                            <td>
                                @if(Auth::user()->currency->is_currency_fixed == '1')
                                    &#8358;{{transform_product_price($item->price, 1) }}
                                @else
                                    {{ transform_product_price($item->price, Auth::user()->currency->rate )}} {{Auth::user()->currency->currency}}
                                @endif
                            </td>
                            <td>
                                @if(Auth::user()->currency->is_currency_fixed == '1')
                                    &#8358;{{transform_product_price( ($item->price * $item->qty), 1) }}
                                @else
                                    {{transform_product_price( ($item->price * $item->qty), Auth::user()->currency->rate )}} {{Auth::user()->currency->currency}}
                                @endif
                            </td>
                            <td> @if($item->delivery_type === 1)
                                    Pickup
                                @elseif($item->delivery_type === 2)
                                    Shipping
                                @else
                                    E-Channel
                                @endif</td>
                            <td>    @if($item->delivery_type != 2 && $item->delivery_type != 1)
                                    Successful
                                @else
                                    {{ucfirst(array_flip($cartstatus)[$item->status])}}
                                @endif</td>
                            <td>{{$item->voucher}}</td>
    @if($item->delivery_type === 2)
        @if(isset($item->address))
            <?php $address = $item->address; $state = $item->state_name; $city = $item->city_name; $is_delivery = true; ?>
        @endif
    @endif

    @if($item->delivery_type === 2)
        @php
            $anydelivery = "( + delivery charge)"
        @endphp
        @if(isset($item->firstname))
            <?php $sentto = $item->firstname ?>
        @endif
        @if(isset($item->lastname))
            <?php $sentto  .= " "; ?>
            <?php $sentto  .= $item->lastname ?>
        @endif
    @endif
</tr>

                        @endforeach
                        {{--<tr class="font-weight-bold">--}}
                        {{--Total cost : --}}
                        {{--@if(Auth::user()->currency->is_currency_fixed == '1')--}}
                        {{--&#8358;{{transform_product_price( $total, 1) }}--}}
                        {{--@else--}}
                        {{--{{ transform_product_price( ($total * Auth::user()->currency->rate), 1 )}} {{Auth::user()->currency->currency}}--}}
                        {{--@endif--}}
                        {{--<br><br>--}}
                        {{--Delivery cost : --}}
                        {{--@if(Auth::user()->currency->is_currency_fixed == '1')--}}
                        {{--&#8358;{{transform_product_price( $delivery_charge, 1) }}--}}
                        {{--@else--}}
                        {{--{{ transform_product_price( ($delivery_charge * Auth::user()->currency->rate), 1 )}} {{Auth::user()->currency->currency}}--}}
                        {{--@endif--}}
                        {{--<br><br>--}}
                        {{--Grand Total--}}
                        {{--@if(Auth::user()->currency->is_currency_fixed == '1')--}}
                        {{--&#8358;{{transform_product_price( $total + $delivery_charge, 1) }}--}}
                        {{--@else--}}
                        {{--{{ transform_product_price( ($total * Auth::user()->currency->rate) + $delivery_charge, 1 )}} {{Auth::user()->currency->currency}}--}}
                        {{--@endif--}}
                        {{--<br><br>--}}
                        {{--</tr>--}}
                        {{--<tr class="font-weight-bold">--}}

                        {{--</tr>--}}
                    @endif
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 5%;" class="fluid-statement2">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <div class="user-statement-checkout2">
                            <p class="grey-text">E-voucher redemptions, your item(s) will be avialable for pick up at your selected location
                                within the period of 15 days after which your voucher expires</p>
                            <p class="grey-text">Delivery redemptions, your items will be delivered
                                to your address within 15 days period</p>
                            <p class="grey-text">An agent will contact you for unavailability of an item</p>
                            <p class="grey-text">For complaints or enquires please call <a href="tel:+2347055790298">North: (07055790298)</a>, <a href="tel:+2349055194351">West: (09055194351)</a>, <a href="tel:+2349055194359">East: (09055194359)</a> or send an email to
                                <a href="mailto:sigmaprime@sigmapensions.com">sigmaprime@sigmapensions.com</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div style="margin-bottom: 2%;" class="user-statement-checkout">
                            @if($item->delivery_type === 1)
                                <span>
                                    <p style="text-decoration: underline;">Pickup Location</p>
                                    @if(isset($item->pickup_location_name))
                                        {{$item->pickup_location_name}}
                                    @endif
                                </span>
                            @elseif($item->delivery_type === 2 || $item->delivery_type === 5)
                                @elseif($item->delivery_type === 2 || $item->delivery_type === 5)
                                <span>
                                </span>
                            @endif
                                @if($is_delivery)
                                    <p class="font-weight-bold" style="margin-bottom: 5px;text-decoration: underline;">Delivery address</p>
                                    <p class="font-weight-bold"> {{$sentto}}</p>
                                    <p class="font-weight-bold">{{$address}}, {{ucwords(strtolower($city))}}, {{ucwords(strtolower($state))}}, Nigeria</p>
                                @endif
                            </div>
                        <div class="user-statement-checkout">
                            <div class="checkout-flexed">
                                <p class="">Total cost</p>
                                <p class="bold-text">
                                    @if(Auth::user()->currency->is_currency_fixed == '1')
                                        &#8358;{{transform_product_price( ceil($total), 1) }}
                                    @else
                                        {{ transform_product_price( (ceil($total * Auth::user()->currency->rate)), 1 )}} {{Auth::user()->currency->currency}}
                                    @endif
                                </p>
                            </div>
                            <div class="checkout-flexed">
                                <p class="grey-text">Delivery cost</p>
                                <p class="bold-text">
                                    @if(Auth::user()->currency->is_currency_fixed == '1')
                                        &#8358;{{ transform_product_price( ceil($delivery_charge), 1 ) }}
                                    @else
                                        {{ transform_product_price( ceil($delivery_charge), 1 )}} {{Auth::user()->currency->currency}}
                                    @endif
                                </p>
                            </div>
                            <div class="checkout-flexed">
                                <p style="font-size: 16px;" class="grey-text">Grand Total</p>

                               <p class="bold-text"> @if(Auth::user()->currency->is_currency_fixed == '1')
                                    &#8358;{{transform_product_price( ceil($total + $delivery_charge), 1) }}
                                @else
                                    {{ transform_product_price( ceil ( ($total * Auth::user()->currency->rate) + $delivery_charge   ), 1 )}} {{Auth::user()->currency->currency}}
                                @endif
                               </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Test Modal -->


    </div>


@endsection

@push('bootstrap')
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap3.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
@endpush
    @push('style')
    <script src="{{asset('js/alertui.min.js')}}"></script>
@endpush
@push('script')
    <script>
        function printData()
        {
            var divToPrint=document.getElementById("printarea");
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
    </script>
    @endpush
