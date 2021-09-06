@extends('layouts.main')
@section('content')
    <?php $company_id = env('COMPANY_ID');
    $cs =  DB::table('setting')
        ->where('company_id', '=', $company_id)
        ->first();

    ?>

    @if(!Auth::guest())
        <input type="hidden" class="login-status" value = "1">
    @else
        <input type="hidden" class="login-status" value = "0">
    @endif

     <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px;">
                    <h5 class="modal-title modal_category_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
{{--                        <span aria-hidden="true">&times;</span>--}}
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-10 offset-1">
                            <img src="" alt="" id="event_banner" class="img-responsive">
                        </div>
                        <div class="col-8 offset-2 text-left">
                            <h3 id="event_name"></h3>
                            <label>Date and Time</label>
                            <h5  style="margin-top:-3px"><span id="event_date_modal" class="font-weight-bold"></span> - <span id="event_time_modal"></span></h5>
                            <label>Location</label>
                            <p id="event_desc"></p>
                            <div class="tickets_table mt-3">
                                <label>Tickets</label>
                                <table class="table table-hover table-sm">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Venue</th>
                                        <th>Price</th>
                                    </tr>
                                    <tbody id="event_tickets_list">

                                    </tbody>
                                    </thead>

                                </table>
                                <form name="event_booking_form">
                                    <div class="row mt-4 mb-4">
                                        <div class="col-12">
                                            <label>Booking details</label>
                                        </div>
                                        <div class="col-6 m_b_10">
                                            <label for="event_type_option">Category</label>
                                            <select name="event_type_option" id="event_type_option" class="form-control">
                                            </select>
                                        </div>
                                        <div class="col-6 m_b_10">
                                            <label for="event_order_qty">Quantity</label>
                                            <select name="event_order_qty" id="event_order_qty" class="form-control" disabled="disabled">
                                                <option value="" selected disabled="disabled">Select category</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>

                                        </div>
                                        <div class="col-6 m_b_10">
                                            <label for="user_email">Email</label>
                                            <input type="email" placeholder="Email" class="form-control" id="user_email" name="user_email">
                                        </div>
                                        <div class="col-6 m_b_10">
                                            <label for="phone_no">Phone number</label>
                                            <input type="phone" placeholder="Phone number" class="form-control" id="phone_no" name="phone_no">
                                        </div>
                                        <div class="col-12 m_b_10">
                                            <hr>
                                        </div>
                                        <div class="col-12 pr-5 pl-5" style="font-weight: 700; font-size: 20px;">
                                            <span class="pull-left">Total</span>
                                            @if($cs->is_currency_fixed == '1')
                                                <span class="pull-right">&#8358;<span class="event_price_realtime">{{ (number_format(0)) }}</span></span>
                                            @else
                                                <span class="pull-right"><span class="event_price_realtime">0</span><span> {{$cs->currency}}</span></span>
                                            @endif
                                        </div>
                                        <div class="col-6 mt-3">
                                            <hr>
                                            <button class="btn btn-md btn-primary btn-block pay_event_btn" type="button" disabled="disabled">
                                                <i class="fa fa-spinner fa-spin off process_indicator"></i>
                                                Pay</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-5">
                        <img src="" alt="" id="orgarnisers_logo">
                        <h6 class="text-center">Orgarnizers</h6>
                        <h5 id="orgarnisers_name" class="text-center"></h5>
                    </div>
                    <br><br>
                    {{--<a>--}}
                    {{--<button type="button" class="btn btn-large btn-primary pay_bills_btn custom_button_color"><i class="fa fa-spinner fa-spin off process_indicator"></i> Redeem</button>--}}
                    {{--</a>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header custom_bg_color_2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1;color: #fff"><span aria-hidden="true">&times;</span></button>
                    <img
                            src="{{asset('images/check.png')}}"
                            class="text-center" alt="success"
                            style="
                            width: 100px;
                            margin: 0 auto;
                            left: 40%;
                            top: 10%;
                            position: relative;"
                    >
                </div>
                <div class="modal-body text-center">
                    <h2 class="">Great!</h2>
                    <h4 class="order_response">Order confirmed!</h4>
                    <br><br>
                    <div class="row" role="group" aria-label="">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="col-sm-6" role="group">
                                <a type="button" data-dismiss="modal" aria-label="Close" class="btn btn-large custom_button_color" style="width: 100%; height: 40px;">
                                    <span>Continue Shopping</span> <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="col-sm-6" role="group">
                                <a href="{{route('ordercomplete', ['id' => ''])}}" id="order_receipt" class="btn btn-large custom_button_color_2"  style="width: 100%; height: 40px;">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>View Receipt</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="tt-pageContent">
            <div class='cinema-container'>
                <div class="row">
                    <div class="col-md-6">
                        <div class="redeem-event">
                            <h1>Redeem Event ticket today</h1>
                            <p>Explore what is happening, where and when with Sigma Prime.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="movie-icons">
                            <img src="{{asset('images/event-images/icon.png')}}" width="100%" />
                        </div>
                    </div>
                </div>
{{--                <div class="trending-events">--}}
{{--                    <h4 class="low-opacity">SELLING FAST</h4>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-6 col-md-4">--}}
{{--                            <img src="{{asset('images/event-images/main1.png')}}" width="100%" alt="cinema" />--}}
{{--                        </div>--}}
{{--                        <div class="col-6 col-md-4">--}}
{{--                            <img src="{{asset('images/event-images/main2.png')}}" width="100%" alt="cinema" />--}}
{{--                        </div>--}}
{{--                        <div class="col-6 col-md-4">--}}
{{--                            <img src="{{asset('images/event-images/main3.png')}}" width="100%" alt="cinema" />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="">
                    <div class="">
                        <div class="row">
                            <div class="col-6 col-md-9">
                                <h4>All Upcoming Events</h4>
                            </div>
                            <div class="col-6 col-md-3 modal-form-container">
{{--                                <div class="form-group">--}}
{{--                                    <label for="size">Sort by:</label>--}}
{{--                                    <select class="form-control" id="sel1">--}}
{{--                                        <option>Date</option>--}}
{{--                                        <option>Event</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                <div class=''>
                    @if(isset($data))
                        @if($data->status == 1)

                                        <div class="row">
                                            @foreach($data->events as $index => $item)
                                                <div class="col-12 col-md-4">
                                                    <div class="cinemas_item_container events_item_container"
                                                         id="{{$index}}"
                                                         data-event_date1={{Carbon\Carbon::parse($item->date)->day}}
                                                                 data-event_date2={{Carbon\Carbon::parse($item->date)->shortEnglishDayOfWeek}}
                                                                 data-event_date3={{Carbon\Carbon::parse($item->date)->shortEnglishMonth}}
                                                                 data-event_date4={{Carbon\Carbon::parse($item->date)->year}}
                                                                 data-event_time={{ date("h:ia", strtotime(Carbon\Carbon::parse($item->date)))}}

                                                    >
                                                        <div class="image_container" style="height: auto;">
                                                                <img  alt="" class="movie_img" src="{{$item->banner}}" style="width: 100%; height: auto;">
                                                        </div>

                                                        <div class="details" style="width: 100%;">
                                                            <h4 style="color: #333;font-size: 16px;">{{str_limit(ucfirst(strtolower($item->title)), 22 )}}</h4>
                                                            <div class="cinema_badge" style="font-size: 17px;">{{ Carbon\Carbon::parse($item->date)->day}} {{ Carbon\Carbon::parse($item->date)->shortEnglishMonth}}</div>
                                                            {{--<a href="{{url('movie', ['code' => $ticket->product_code])}}" class="btn btn-primary custom_button_color b_shadow" style="padding: 5px 20px;">--}}
                                                                {{--Buy--}}
                                                            {{--</a>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                    </div>

                            @elseif($data->status == 0)
                            <div class="row">
                                <div class="col-12" style="padding-top: 5%;">
                                    <center>
                                    <h2>{{$data->message}}</h2>
                                    </center>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
    <style>
        /*.modal-content{*/
        /*    overflow: auto;*/
        /*    height: 700px;*/
        /*}*/
        .table{
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
        .cinemas_item_container .details h4 {
            margin-top: 10px;
            margin-bottom: 0px;
            color: #fff;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-bottom: 0px !important;
        }
        .cinemas_item_container .cinema_badge {
            /* background: #2772FF; */
            padding: 0px 0px 6px;
            color: #333;
            font-weight: bold;
            font-style: italic;
        }
        .cinemas_item_container{
            margin-bottom: 20px !important;
            cursor: pointer;
        }
    </style>
@endpush
@push('script')
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script src="{{asset('js/lodash.min.js')}}"></script>

    <script>
        $('body').addClass('tt-page-product-single eventbg');
        //Configure Ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".overlay").click(function(){
            $(this).hide();
        });
        var eventData = <?php echo json_encode($data) ?>;
        //Declare global variables.
        var conversionRate = "<?php echo $cs->rate ;?>"
        var appCurrencyFixed = "<?php echo $cs->is_currency_fixed ;?>"
        var selectedTickets = null;
        var showTime = null;
        function nl2br (str, is_xhtml) {
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br/>' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
        }
        function replaceNewLine(myString) {
            var regX = /\r\n|\r|\n/g;
            var replaceString = '<br />';
            return myString.replace(regX, replaceString);
        }
        $(document).ready(function () {

            //Disable submit button
            $("#user_email,#phone_no").on('keyup keypress', function () {
                if($("#user_email").val() != '' && $("#phone_no").val() != ''){
                    $(".pay_event_btn").prop('disabled', false)
                }else{
                    $(".pay_event_btn").prop('disabled', true)
                }

            })

            $(".events_item_container").on('click', function () {

                var login = $('.login-status').val();

                if(login == 0){
                    location.replace('{{url("login")}}');
                    return false;
                }

                $("#event_order_qty").val("1")
                var currentIndex = $(this).attr('id');
                var eventObject = eventData.events.filter(function (item, index) {
                    return index == currentIndex;
                });

                //Set texts
                var modalDate = $(".events_item_container").data('event_date1') + " " + $(".events_item_container").data('event_date2') + " " +$(".events_item_container").data('event_date3')+ ", " + $(".events_item_container").data('event_date4')
                var modalTime = $(".events_item_container").data('event_time');
                var showTime = $(".events_item_container").data('event_time');

                $("#event_name").html(eventObject[0].title)
                $("#orgarnisers_name").html(eventObject[0].organizer)
                $("#event_desc").html((replaceNewLine(eventObject[0].description)))
                // $("#orgarnisers_logo").attr('src',eventObject[0].organizer_logo)
                $("#event_banner").attr('src',eventObject[0].banner)
                $("#event_date_modal").html(modalDate)
                $("#event_time_modal").html(modalTime)

                //Tickets
                var tr;
                var option = "<option data-signature='null' disabled selected>Select category</option>";
                $.each(eventObject[0].tickets, function(index, item){
                    if(appCurrencyFixed == 1){
                        //Currency fixed
                        var newprice = new Intl.NumberFormat('en-GB').format(item.price);
                        tr += "<tr data-signature="+item.signature +">";
                        tr += "<td class='ticket_title'>" + item.title + "</td>";
                        tr += "<td class='ticket_venue'>" + item.venue + "</td>";
                        tr += "<td class='ticket_price' id="+item.price+">" +'&#8358;'+newprice + "</td>";
                    }else{
                        //Currency not Fixed
                        //Currency is not Naira
                        var cRate = parseInt(conversionRate);
                        var newprice = new Intl.NumberFormat('en-GB').format(item.price*cRate);
                        tr += "<tr data-signature="+item.signature +">";
                        tr += "<td class='ticket_title'>" + item.title + "</td>";
                        tr += "<td class='ticket_venue'>" + item.venue + "</td>";
                        tr += "<td class='ticket_price' id="+item.price+">" + newprice + "</td>";
                    }
                    tr += "</tr>";
                });
                $.each(eventObject[0].tickets, function(index, item){
                    option += "<option data-signature="+item.signature+">"
                    option += item.title;
                    tr += "</option>";
                });

                selectedTickets = eventObject[0].tickets;

                $("#event_tickets_list").empty()
                $("#event_type_option").empty()
                $("#event_type_option").append(option)
                $("#event_tickets_list").append(tr)
                $("#modal").modal('show');

                //Event for ticket type change
                $("#event_type_option").on('change', function () {
                    var sign = $(this).find('option:selected').data('signature');
                    $("#event_order_qty").val(1);
                    var qty = $("#event_order_qty").val();

                    // var activeTicket = selectedTickets.filter(function(item){
                    //     return item.signature === sign;
                    // });

                    // setTicketQuantity(activeTicket)


                    if($(this).find('option:selected').data('signature') == null){
                        $("#event_order_qty").prop("disabled", true);
                        $(".event_price_realtime").html("0")
                        return false;
                    }
                    $("#event_order_qty").prop("disabled", false)
                    var price = eventObject[0].tickets.filter(function (item, index) {
                        return item.signature == sign;
                    });
                    if(appCurrencyFixed == 1){
                        //Currency fixed
                        var quantity = parseInt(qty);
                        var newprice = new Intl.NumberFormat('en-GB').format(price[0].price*quantity);
                        $(".event_price_realtime").html(newprice)
                    }else{
                        //Currency not Fixed
                        //Currency is not Naira
                        var cRate = parseInt(conversionRate), quantity = parseInt(qty);
                        // console.log(cRate, qty, price)
                        var newprice = new Intl.NumberFormat('en-GB').format(price[0].price*cRate*quantity);
                        $(".event_price_realtime").html(newprice)
                    }
                })
                $("#event_order_qty").on('change keyup', function(){
                    var qty = $(this).val();
                    var sign = $("#event_type_option").find('option:selected').data('signature');
                    var price = eventObject[0].tickets.filter(function (item, index) {
                        return item.signature == sign;
                    });


                    if(appCurrencyFixed == 1){
                        //Currency fixed
                        var quantity = parseInt(qty);
                        var newprice = new Intl.NumberFormat('en-GB').format(price[0].price*quantity);
                        $(".event_price_realtime").html(newprice)
                    }else{
                        //Currency not Fixed
                        //Currency is not Naira
                        var cRate = parseInt(conversionRate), quantity = parseInt(qty);
                        var newprice = new Intl.NumberFormat('en-GB').format(price[0].price*cRate*quantity);
                        $(".event_price_realtime").html(newprice)
                    }
                })

                $(".pay_event_btn").on('click', function (e) {
                    e.preventDefault()
                    var data = {
                        signature: $("#event_type_option").find('option:selected').data('signature'),
                        qty: $("#event_order_qty").val(),
                        show_time: showTime,
                        email: $("#user_email").val(),
                        phone_no: $("#phone_no").val(),
                        name: eventObject[0].title,
                        type: $("#event_type_option").find('option:selected').text()
                    }
                    var price = eventObject[0].tickets.filter(function (item, index) {
                        return item.signature == data.signature;
                    });
                    data.price = price[0].price

                    if(data.email == '' || data.phone_no == '' || data.qty == 0){
                        alertui.notify('error', 'Please complete the form');
                        swal("Events Booking",'Please complete the form', "error");

                        return false;
                    }

                    $(".process_indicator").removeClass('off');
                    $(".pay_event_btn").prop('disabled', true)
                    $.post("{{url('api/redeem_event')}}",data)
                        .done(function (res) {
                            $(".process_indicator").addClass('off');
                            $(".pay_event_btn").prop('disabled', false)
                            // handle success
                            if (!res) {
                                alertui.notify('error','Failed to complete payment');
                                swal("Events Booking",'Failed to complete payment', "error");
                                return false;
                            }
                            if (res.status == '400') {
                                alertui.notify('error',res.data);
                                swal("Events Booking",res.data, "error");
                                return false;
                            }
                            if (res.status == 'fail') {
                                alertui.notify('error',res.data);
                                swal("Events Booking",res.data, "error");
                                return false;
                            }
                            if (res.status == 'validation') {
                                alertui.notify('info',res.message);
                                swal("Events Booking",res.message, "error");
                                return false;
                            }
                            if (res.status == '200') {
                                updateAccount(res.account);
                                alertui.notify('success', res.message)
                                swal("Events Booking",res.message, "success");
                                $('#modal').modal('hide');
                                window.location.replace("{{url('ordercomplete')}}/"+res.data)
                                {{--$('#modal').on('hidden.bs.modal', function (e) {--}}
                                    {{--$('#ordernotify').modal('show');--}}
                                {{--});--}}
                                {{--var oldlink = $("#order_receipt").prop('href');--}}
                                {{--$('#ordernotify').on('shown.bs.modal', function (e) {--}}
                                    {{--$("#order_receipt").prop('href', '');--}}
                                    {{--$("#order_receipt").prop('href', "{{url('ordercomplete')}}"+'/'+res.data);--}}
                                {{--});--}}
                            }
                        })
                        .fail(function (response) {
                            // handle error
                            $(".process_indicator").addClass('off');
                            $(".pay_event_btn").prop('disabled', false)
                            if(response.status == 500){
                                alertui.notify('error', 'An Error Occurred. Please try again.')
                                swal("Events Booking",'An Error Occurred. Please try again.', "error");
                            }
                            else{
                                alertui.notify('error', response.responseJSON.data)
                                swal("Events Booking",response.responseJSON.data, "error");

                            }
                        })
                })

            })
        })

        function setTicketQuantity(ticket){
            // Add quantity
            var ticket = _.head(ticket);
            console.log($("#event_order_qty"))
            var tr;
            var i = 1;
            var availableQty = "<option selected>Select Quantity</option>";
            while (i < ticket.max_quantity+1) {
                availableQty += "<option value"+i+">"
                availableQty += i;
                tr += "</option>";
                i++;
            }
            $("#event_order_qty").empty()
            $("#event_order_qty").append(availableQty)
            $("#event_order_qty").prop("disabled", true);

        }
    </script>
@endpush
