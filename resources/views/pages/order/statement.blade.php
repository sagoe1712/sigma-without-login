@extends('layouts.main')
@section('content')

    <div id="tt-pageContent">
        <div class="wish-list-bg">
            <div class="centered">
                <h5>STATEMENT</h5>
            </div>
            <img class="wish-list-img" src="{{asset('images/profile-images/profiletopbg.png')}}" width="100%" />
        </div>

        <!-- Statement Table -->
        <div class="order-history-div table-responsive-sm">
            @if(isset($accounts))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="grey-text">Order Date</th>
                    <th class="grey-text">Transaction No</th>
                    <th class="grey-text">Transaction Description</th>
                    <th class="grey-text">Credit</th>
                    <th class="grey-text">Debit</th>
                    <th class="grey-text">Available Balance</th>
                    <th class="grey-text">Order Number</th>
                    <th class="grey-text">View Details</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $item)
                    <tr>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->trans_no}}</td>
                        <td>
                            @if($item->type == 1)
                                Credit
                            @endif
                            @if($item->type === 0)
                                Redemption
                                @endif
                        </td>
                        <td>
                            @if($item->type == 1)

                        @if(Auth::user()->currency->is_currency_fixed == '1')
                            &#8358;{{number_format($item->point_raw, 0)}}
                        @else
                                    {{number_format($item->point_virtual, 0)}} {{Auth::user()->currency->currency}}
                            @endif
                                    @else
                                    -

                                    @endif
                        </td>
                        <td>
                            @if($item->type != 1)

                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                &#8358;{{number_format($item->point_raw, 0)}}
                            @else
                                {{number_format($item->point_virtual, 0)}} {{Auth::user()->currency->currency}}
                                @endif
                                @else
                                        -
                                @endif
                        </td>
                                <td>



                                        @if(Auth::user()->currency->is_currency_fixed == '1')
                                            &#8358;{{number_format($item->balance_raw, 0)}}
                                        @else
                                            {{number_format($item->balance_virtual, 0)}} {{Auth::user()->currency->currency}}
                                        @endif




                                </td>
                                <td>@if($item->order_id == "")
                                        _
                                    @else
                                        {{$item->order_id}}
                                    @endif</td>
                                <td>
                                    @if($item->order_id != "")
                                       <button data-order="{{$item->order_id}}" data-toggle="modal" data-target="#ModalquickView"
                                               type="button" class="btn btn-default statement-btn">View Order Receipt</button>
                                    @endif
                                </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                {{ $accounts->links() }}
{{--            <nav aria-label="Page navigation example pagination-container">--}}
{{--                <ul class="pagination">--}}
{{--                    <li class="page-item">--}}
{{--                        <a class="page-link" href="#" aria-label="Previous">--}}
{{--                            <span aria-hidden="true">&laquo;</span>--}}
{{--                            <span class="sr-only">Previous</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                    <li class="page-item active"><a class="page-link" href="#">2</a></li>--}}
{{--                    <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                    <li class="page-item">--}}
{{--                        <a class="page-link" href="#" aria-label="Next">--}}
{{--                            <span aria-hidden="true">&raquo;</span>--}}
{{--                            <span class="sr-only">Next</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </nav>--}}
            @else
                <h3>No Data Found</h3>
                @endif
        </div>



        <!-- Test Modal -->


    </div>

    <div class="statement-modal-container">
        <div class="modal fade"  id="ModalquickView" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content ">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                    </div>
                    <div class="modal-body loading-modal">
                        <img src="{{asset('images/loader.svg')}}" style="margin-left: auto; margin-right: auto; display: block;"/>
                    </div>
                    <div class="modal-body order-modal" style="display: none;">
                        <div style="overflow: auto;" class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="grey-text">Image</th>
                                    <th class="grey-text">Name</th>
                                    <th class="grey-text">Qty</th>
                                    <th class="grey-text">Price</th>
                                    <th class="grey-text">Order no</th>
                                    <th class="grey-text">Voucher no</th>
                                    <th class="grey-text">Delivery type</th>
                                    <th class="grey-text">Pickup Location</th>
                                    <th class="grey-text">Delivery Location</th>
                                    <th class="grey-text">Status</th>
                                </tr>
                                </thead>
                                <tbody class="order-table">

                                </tbody>
                            </table>
                        </div>
                        <div class="fluid-statement">
                            <div class="row">
                                <div class="col-12 col-md-7">
                                    <div class="user-statement-checkout2">
                                        <p class="grey-text">E-voucher redemptions, your item(s) will be avialable for pick up at your selected location
                                            within the period of 15 days after which your voucher expires</p>
                                        <p class="grey-text">Delivery redemptions, your items will be delivered
                                            to your address within 15 days period</p>
                                        <p class="grey-text">An agent will contact you for unavailability of an item</p>
                                        <p class="grey-text">For complaints or enquires please call <a href="tel:09055194352">09055194352</a> or send an email to
                                            <a href="mailto:sigmaprime@sigmapensions.com">sigmaprime@sigmapensions.com</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="user-statement-checkout">
                                        <div class="checkout-flexed">
                                            <p class="">Total cost</p>
                                            <p class="bold-text">
                                                <span class="totalcost">198,040</span>
                                                Sigma Stars
                                            </p>
                                        </div>
                                        <div class="checkout-flexed">
                                            <p class="grey-text">Delivery cost</p>
                                            <p class="bold-text">
                                                <span class="deliveryprice">1,040</span> Sigma Stars
                                            </p>
                                        </div>
                                        <div class="checkout-flexed">
                                            <p style="font-size: 16px;" class="grey-text">Grand Total</p>
                                            <p style="font-size: 16px;" class="bold-text">
                                                <span class="totalamount">198,040</span>
                                                <span>Sigma Stars</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-state-btn-container">
                                        <button
                                                type="button" class="btn btn-default modal-state-btn">
                                            Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
        </div>
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
        $('.statement-btn').click(function(){
            var id =  $(this).attr('data-order');
            var formdata = [];
            formdata['id'] = id;
            $.post("{{url('api/get_order')}}", {'id':id})
                .done(function (res) {
                    //disableItem($(".btnwishlist"), false)
                    // handle success
                    if (!res) {
                        alertui.notify('error', 'Failed to load order');
                        return false;
                    }
                    if (res.status == 200) {
                        // alertui.notify('error', res.message);
                        $('.loading-modal').hide();
                        $('.order-modal').show();
                        var item = "";
                        var totalcost = 0;
                        var deliverycost = 0;
                        var totalamount = 0;

                        $.each(res.delivery_details, function(key, value){
                        item += '<tr>';
                           item += '<td>';
                           item += '<img src="'+value.image+'" style="height: 40px"/>';
                            item += '</td>';
                            item += ' <td class="modal-product-des">';
                            item += value.name;
                            item += '</td>';
                            item += '<td>';
                            item += value.qty;
                            item += '</td>';
                            item += '<td>'+Math.ceil(value.price)+' Sigma Stars</td>';
                            var oldtotalcost = totalcost;
                           var temp = value.price;
                            totalcost = parseFloat(totalcost) + parseFloat(temp);
                           // console.log(oldtotalcost);
                            item += '<td>'+res.order.order_no+'</td>';
                            item += '<td>'+value.voucher+'</td>';
                            if(value.delivery_type === 2) {
                                item += '<td>Delivery</td>';
                            }else{
                                item += '<td>Pickup</td>';
                            }
                            item += '<td>';
                            if(value.delivery_type === 1) {
                             item += value.pickup_location_name;
                            }
                                item += '</td>';
                            item += '<td>';
                            if(value.delivery_type === 2) {
                            item += value.address+ ", " + value.state_name;
                            }
                            item +=  '</td>';
                            item += '<td>';
                            if(value.status == 1) {
                                item += "pending";
                            }
                            if(value.status == 2) {
                                item += "shipped";
                            }
                            if(value.status == 3) {
                                item += "delivered";
                            }
                            if(value.status == 4) {
                                item += "processing";
                            }
                            if(value.status == 2) {
                                item += "expired";
                            }
                            item += '</td>';
                            item += '</tr>';
})
                        $('.order-table').append(item);
                        $('.totalcost').html(Math.ceil(totalcost));
                        // console.log("total cost: "+totalcost);

                        if(typeof(res.delivery_charge) != "undefined" && res.delivery_charge !== null){
                            $('.deliveryprice').html(res.delivery_charge);
                            deliverycost = res.delivery_charge;
                        }
                        totalamount = parseFloat(totalcost) + parseFloat(deliverycost);
                        $('.totalamount').html(Math.ceil(totalamount));
                    } else {
                       $('.loading-modal').html("Failed to load order");
                    }

                })
                .fail(function (response) {
                    // handle error
                    disableItem($(".btnwishlist"), false)
                    $(".process_indicator").addClass('off');
                    if(response.status == 500){
                        alertui.notify('error', 'An Error Occurred. Please try again.')
                    }
                    else{
                        alertui.notify('info', 'Failed to add to Wishlist. Please try again.')
                    }
                })
        })
    </script>
    @endpush