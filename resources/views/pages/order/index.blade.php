@extends('layouts.main')
@section('content')
    <div id="tt-pageContent">
        <div class="wish-list-bg">
            <div class="centered">
                <h5>Orders History</h5>
            </div>
            <img class="wish-list-img" src="{{asset('images/profile-images/profiletopbg.png')}}" width="100%" />
        </div>
        <div class="order-history-div table-responsive-sm">
                        <table class="statement_table shop_table_responsive cart table-hover table-striped" style='width: 100%' >
                            <thead>
                            <tr>

                            <th>Order Date</th>
                            <th>Total Amount</th>
                            <th>Delivery Charge</th>
                            {{--<th>Delivery method</th>--}}
                            <th>Order No</th>
                            <th>Successful</th>
                            <th>Failed</th>
                            <th>Items</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accounts as $item)
                                <tr>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        @if($item->is_shipping)

                                            @php if(Auth::user()->currency->is_currency_fixed == '1'){
                                                        echo '&#8358;' . transform_product_price( ($item->sub_total_cost + $item->shipping_cost), 1);
                                                            }
                                                        else{
                                                          echo transform_product_price(($item->sub_total_cost + $item->shipping_cost ),Auth::user()->currency->rate) ." " .Auth::user()->currency->currency;
                                                        }
                                            @endphp

                                        @else

                                            @php if(Auth::user()->currency->is_currency_fixed == '1'){
                                                            echo '&#8358;' . transform_product_price( $item->sub_total_cost, 1 );
                                                            }
                                                        else{
                                                          echo transform_product_price($item->sub_total_cost, Auth::user()->currency->rate) ." ".Auth::user()->currency->currency;
                                                        }
                                            @endphp

                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_shipping)
                                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                                &#8358;{{ transform_product_price($item->shipping_cost,1)}}
                                            @else
                                                {{ transform_product_price($item->shipping_cost, Auth::user()->currency->rate)}} {{Auth::user()->currency->currency}}
                                            @endif
                                        @else
                                            No charge
                                        @endif
                                    </td>
                                    {{--<td>{{$item->is_shipping ? 'Shipping' : 'Pickup'}}</td>--}}
                                    <td>{{$item->order_no}}</td>
                                    <td>@php echo count($item->success) @endphp</td>
                                    <td>@if(isset($item->fail["reference"]))
                                            {{count($item->fail["reference"])}}
                                        @else
                                            {{0}}
                                        @endif
                                    </td>
                                    <td><a href="{{url('ordercomplete/'.$item->id)}}">
                                            <button class="btn btn-default statement-btn">View</button>
                                        </a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
{{--                        {{ $accounts->links() }}--}}
                    </div>
                    <!-- .cart-wrapper -->
        </div>
@endsection
@push('style')
<style>

</style>
@endpush
