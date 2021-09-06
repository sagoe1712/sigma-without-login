@extends('layouts.main')
@section('content')
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
    <div class="body-content">
        <div class="breadcrumb">
            <div class="container">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{url('orders')}}">Orders</a></li>
                        <li class='active'>Ordered items</li>
                    </ul>
                </div>
                <!-- /.breadcrumb-inner -->
            </div>
        </div>
        <div class="row">
            <div id="printarea" class="col-md-8 col-md-offset-2" style="margin-top: 10px;background: #fff;padding-bottom: 10px;padding-top: 10px;">
                <div class="logo" style="margin-bottom: 3em;">
                    <img src="{{asset('images/logo/sigma_logo.png')}}" alt="logo" style="float: left; " width="80">
                    <img src="{{asset('sigma/images/rbox_logo.png')}}" alt="logo" style="float: right;" width="80">
                </div>
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <h2 class="text-center text-white" style="line-height: 50px;">Order Receipt</h2>
                    </div>
                    @if(isset($order->order_no))
                        <div class="col-sm-12">
                            <div class="col-sm-12" style="padding: 10px 20px;">
                                <span style="margin-bottom: 1px; font-weight: 700;">Order no : {{$order->order_no}}</span>
                                <span style="font-weight: 700; float:right">Date : {{ $order->created_at->format('D, j M, Y / h:i A') }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="cart-wrapper" style="position: relative;">
                    <!--statement table-->
                    <table id="myTable" class="display table table-hover table-sm table-striped" cellspacing="0" width="100%"
                    style="
                        padding: 10px 6px;
                            "
                    >
                        <thead>
                        <th  style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                        font-weight: bold;
                            ">Name</th>
                        <th  style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                        font-weight: bold;
                            ">Quantity</th>
                        <th  style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                        font-weight: bold;
                            ">Redemption method</th>
                        {{--<th  style="--}}
                        {{--border: 1px solid #AAAAAA;--}}
                        {{--padding: 3px 2px;--}}
                        {{--font-weight: bold;--}}
                            {{--">Price (Unit)</th>--}}
                        {{--<th  style="--}}
                        {{--border: 1px solid #AAAAAA;--}}
                        {{--padding: 3px 2px;--}}
                        {{--font-weight: bold;--}}
                            {{--">Price (Total)</th>--}}
                        <th  style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                        font-weight: bold;
                            ">Status</th>
                        <th  style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                        font-weight: bold;
                            ">Voucher</th>
                        {{--<th  style="--}}
                        {{--border: 1px solid #AAAAAA;--}}
                        {{--padding: 3px 2px;--}}
                        {{--font-weight: bold;--}}
                            {{--">Pickup Address</th>--}}
                        </thead>

                        <tbody>
                        @if(isset($data))
                            @foreach($data as $item)
                                @php
                                    $total += ($item->price * $item->qty);
                                @endphp
                                <tr>
                                    <td
                                            style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                            ">
                                        {{$item->name}}
                                        @if($item->value)
                                            ( {{$item->value}} )
                                        @endif
                                    </td>
                                    <td
                                            style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                            ">{{$item->qty}}</td>
                                    <td
                                            style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                            ">
                                        @if($item->delivery_type === 1)
                                            Pickup
                                        @elseif($item->delivery_type === 2)
                                            Shipping
                                        @else
                                            E-Channel
                                        @endif
                                    </td>
                                    {{--<td style="--}}
                        {{--border: 1px solid #AAAAAA;--}}
                        {{--padding: 3px 2px;--}}
                            {{--">--}}
                                        {{--@if(Auth::user()->currency->is_currency_fixed == '1')--}}
                                            {{--&#8358;{{transform_product_price($item->price, 1) }}--}}
                                        {{--@else--}}
                                            {{--{{ transform_product_price($item->price, Auth::user()->currency->rate )}} {{Auth::user()->currency->currency}}--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                    {{--<td style="--}}
                        {{--border: 1px solid #AAAAAA;--}}
                        {{--padding: 3px 2px;--}}
                            {{--">--}}
                                        {{--@if(Auth::user()->currency->is_currency_fixed == '1')--}}
                                            {{--&#8358;{{transform_product_price( ($item->price * $item->qty), 1) }}--}}
                                        {{--@else--}}
                                            {{--{{transform_product_price( ($item->price * $item->qty), Auth::user()->currency->rate )}} {{Auth::user()->currency->currency}}--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                    <td style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                            ">
                                        @if($item->delivery_type != 2 && $item->delivery_type != 1)
                                            Successful
                                        @else
                                            {{ucfirst(array_flip($cartstatus)[$item->status])}}
                                        @endif
                                    </td>
                                    <td style="
                        border: 1px solid #AAAAAA;
                        padding: 3px 2px;
                            ">{{$item->voucher}}</td>
                                    {{--<td>{{$item->pickup_location_name}}</td>--}}


                                    @if($item->delivery_type === 2)
                                        @if(isset($item->address))
                                            <?php $address = $item->address; $is_delivery = true; ?>
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
                                            <?php $sentto  .= $item->lastname ?>
                                        @endif
                                    @endif

                                </tr>
                                    <tr>
                                        @if($item->delivery_type === 1)
                                        <td
                                                colspan="3"
                                                style="
                                        border: 1px solid #AAAAAA;
                                        padding: 3px 2px;
                                            ">
                                            <p style="text-decoration: underline;">Pickup Location</p>
                                            @if(isset($item->pickup_location_name))
                                                {{$item->pickup_location_name}}
                                            @endif
                                        </td>
                                            @elseif($item->delivery_type === 2 || $item->delivery_type === 5)
                                            <td
                                                    colspan="3"
                                                    style="
                                        border: 1px solid #AAAAAA;
                                        padding: 3px 2px;
                                            ">
                                             
                                            </td>
                                        @endif

                                        <td

                                                style="
                                        border: 1px solid #AAAAAA;
                                        padding:2px;
                                            ">
                                            <p style="text-decoration: underline;">Price (Unit)</p>
                                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                                &#8358;{{transform_product_price($item->price, 1) }}
                                            @else
                                                {{ transform_product_price($item->price, Auth::user()->currency->rate )}} {{Auth::user()->currency->currency}}
                                            @endif
                                        </td>

                                        <td
                                                style="
                                        border: 1px solid #AAAAAA;
                                        padding: 2px;
                                            ">
                                            <p style="text-decoration: underline;">Price (Total)</p>
                                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                                &#8358;{{transform_product_price( ($item->price * $item->qty), 1) }}
                                            @else
                                                {{transform_product_price( ($item->price * $item->qty), Auth::user()->currency->rate )}} {{Auth::user()->currency->currency}}
                                            @endif
                                        </td>


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

                    <div style="    height: 40px;
    min-height: 80px;
    max-height: 80px;
    word-break: break-word;">
                        <div class="print_address" style="width: 40%;text-align: left; display: inline-block;">
                            @if($is_delivery)
                                        <p class="font-weight-bold" style="margin-bottom: 5px;text-decoration: underline;">Delivery address</p>
                                        <p class="font-weight-bold"> {{$sentto}}</p>
                                        <p class="font-weight-bold">{{$address}}</p>
                            @endif
                        </div>

                    <div class="print_total" style="width: 40%;text-align: right;float: right; display: inline-block;">
                        <p>Total cost :
                        @if(Auth::user()->currency->is_currency_fixed == '1')
                            &#8358;{{transform_product_price( $total, 1) }}
                        @else
                            {{ transform_product_price( ($total * Auth::user()->currency->rate), 1 )}} {{Auth::user()->currency->currency}}
                        @endif
                        </p>
                        <p>
                        Delivery cost :
                        @if(Auth::user()->currency->is_currency_fixed == '1')
                            &#8358;{{transform_product_price( ceil($delivery_charge), 1) }}
                        @else
                            {{ transform_product_price( ceil($delivery_charge), 1 )}} {{Auth::user()->currency->currency}}
                        @endif
                        </p>
                        <p>
                        <strong>Grand Total :
                        @if(Auth::user()->currency->is_currency_fixed == '1')
                            &#8358;{{transform_product_price( ceil( $total + $delivery_charge ), 1) }}
                        @else
                            {{ transform_product_price( ceil( ($total * Auth::user()->currency->rate) + $delivery_charge) , 1 )}} {{Auth::user()->currency->currency}}
                        @endif
                        </strong>
                        </p>
                        <br>
                    </div>
                    </div>


                    <div style="padding: 10px 20px; background-color: #cccccc; margin-top: 20px;">
                        <p style="margin-bottom: 3px">E-voucher redemptions, your item(s) will be available for pick up at your selected location within the period of 15 days after which your voucher expires.</p>

                        <p style="margin-bottom: 3px">Delivery redemptions, your item(s) will be delivered to your address within 15 days period.</p>

                        <p style="margin-bottom: 3px">An agent will contact you for unavailability of an item.</p>

                        <p style="margin-bottom: 3px">For complaints or enquiries please call 09055194352 or send an email to sigmaprime@sigmapensions.com</p>

                    </div>
                    <p style="text-align: right; position: fixed;bottom: 0;right: 0;font-size: 12px; background-color: #fff;" id="power">Powerd by Loyalty Solutions Limited</p>

                </div>
                <!-- .cart-wrapper -->
            </div>
            <div class="col-md-8 col-md-offset-2  w-100" style="margin-bottom: 40px;background: #fff;padding-bottom: 50px;">
            <a type="button" href="{{ url()->previous() }}" class="btn btn-default btn-lg pull-left custom_button_color2"><i class="fa fa-chevron-left" aria-hidden="true"></i>
                Back</a>

                <button type="button" class="btn btn-primary btn-lg pull-right custom_button_color" onclick="printData()"><i class="fa fa-print" aria-hidden="true"></i>
                Print</button>
            </div>
        </div>
    </div>

@endsection
@push('style')
<style>
.logo, #power{
    display: none;
}

.print_total{
    float: right;
}
@page {
    margin: 1mm
}

@media print {
    .logo, #power{
        display: block;
    }
    table, td, tr{
        font-size: 12px;
    }
    .print_address, .print_total{
        display: inline-block !important;
        width: 30%;
    }
    .print_total{
        float: right;
    }
}
</style>
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
