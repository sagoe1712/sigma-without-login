<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Events  - {{config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{{asset('assets/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/font-techmarket.css')}}">
    <link rel="stylesheet" href="{{asset('theme/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <style>
        td{
            font-size: 14px;
        }
        body{
            background: url({{asset('assets/images/bg/events.png')}});
            background-position: center center;
        }
    </style>
</head>

<body class="woocommerce-active page-template-template-homepage-v1 can-uppercase">
@if($errors->any())
    @include('partials.notify', ['text' => $errors->first()])
@endif
<div id="page" class="hfeed site">
    @include('partials.nav_general')
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal_category_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            <img src="" alt="" id="event_banner">
                        </div>
                        <div class="col-sm-8">
                            <h3 id="event_name"></h3>
                            <h5 id="event_date_modal" style="margin-top:-10px"></h5>
                            <h5 id="event_time_modal" style="font-size:14px; margin-top:-10px"></h5>
                            <p id="event_desc"></p>
                            <div class="tickets_table mt-3">
                                <h5>Tickets</h5>
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
                                    <div class="col-sm-12">
                                        <h5>Booking details</h5>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <select name="event_type_option" id="event_type_option" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <select name="event_order_qty" id="event_order_qty" class="form-control" disabled="disabled">
                                            <option value="1" selected>1</option>
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
                                    <div class="col-sm-6 mb-2"><input type="email" placeholder="Email" class="form-control" id="user_email" name="user_email"></div>
                                    <div class="col-sm-6 mb-2"><input type="phone" placeholder="Phone number" class="form-control" id="phone_no" name="phone_no"></div>
                                    <div class="col-sm-12 mt-3">
                                        <hr>
                                    </div>
                                    <div class="col-sm-12 pr-5 pl-5">
                                            <span class="pull-left">Total</span>
                                        @if(Auth::user()->currency->is_currency_fixed == '1')
                                            &#8358;<span class="pull-right">{{ (number_format(0)) }}</span>
                                        @else
                                            <span class="pull-right"><span class="event_price_realtime">0</span><span> {{Auth::user()->currency->currency}}</span></span>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 mt-3">
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
    <div class="modal fade show" id="ordernotify" tabindex="-1" role="dialog" aria-labelledby="ordernotify" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <h2>Order Complete</h2>
                    <br><br>
                    <img src="{{asset('assets/images/check.png')}}" alt="" style="margin: 0 auto;">
                    <br><br>
                    <a href="{{route('ordercomplete', ['id' => ''])}}" id="order_receipt">
                        <button type="button" class="btn btn-large btn-primary">View receipt</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="content" class="site-content">
        @include('partials.events.slider')
        <div class="col-full">
            <div class="row">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">
                        {{--Products Section--}}
                        <section class="full-width section-products-carousel-tabs section-product-carousel-with-featured-product carousel-with-featured-1">
                            @if(isset($data))
                                @if($data->status == 1)
                                    <header class="section-header mt-4">
                                        <h4 class="section-title custom_page_title text-white"
                                        >Select an Event</h4>
                                        </ul>
                                    </header>
                                    <div class="container">
                                        <div class="row">
                                            @foreach($data->events as $index => $item)
                                                <div class="col-sm-4
                                                    ">
                                                        <div class="events_item_container position-relative"
                                                             style="background: url({{$item->banner}});"
                                                             id="{{$index}}"
                                                             data-event_date1={{Carbon\Carbon::parse($item->date)->day}}
                                                              data-event_date2={{Carbon\Carbon::parse($item->date)->shortEnglishDayOfWeek}}
                                                              data-event_date3={{Carbon\Carbon::parse($item->date)->shortEnglishMonth}}
                                                              data-event_date4={{Carbon\Carbon::parse($item->date)->year}}
                                                              data-event_time={{ date("h:ia", strtotime(Carbon\Carbon::parse($item->date)))}}

                                                        >
                                                            <div class="cover">
                                                            </div>

                                                            <div class="details">
                                                                <div class="position-relative">
                                                            <div class="row m-0">
                                                                <div class="col-sm-4 date_container">
                                                                    <p>{{ Carbon\Carbon::parse($item->date)->day}}</p>
                                                                    <p>{{ Carbon\Carbon::parse($item->date)->shortEnglishMonth}}</p>
                                                                </div>
                                                                <div class="col-sm-8 event_details"><h4>{{$item->title}}</h4>
                                                                <p>{{$item->tickets[0]->venue}}</p>
                                                                </div>
                                                            </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </section>
                    </main>
                </div>
            </div>
            @include('partials.banner', ['page' => 'events'])
        </div>
    </div>

    @include('partials.newfooter')
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script>
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
    var conversionRate = "<?php echo Auth::user()->currency->rate ;?>"
    var appCurrencyFixed = "<?php echo Auth::user()->currency->is_currency_fixed ;?>"
    var baseUrl = "<?php echo config('app.base_url')?>";

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
            $("#event_order_qty").val("1")
            var currentIndex = $(this).attr('id');
            var eventObject = eventData.events.filter(function (item, index) {
                return index == currentIndex;
            });

            //Set texts
            var modalDate = $(".events_item_container").data('event_date1') + " " + $(".events_item_container").data('event_date2') + " " +$(".events_item_container").data('event_date3')+ ", " + $(".events_item_container").data('event_date4')
            var modalTime = $(".events_item_container").data('event_time');

            $("#event_name").html(eventObject[0].title)
            $("#orgarnisers_name").html(eventObject[0].organizer)
            $("#event_desc").html(eventObject[0].description)
            $("#orgarnisers_logo").attr('src',eventObject[0].organizer_logo)
            $("#event_banner").attr('src',eventObject[0].banner)
            $("#event_date_modal").html(modalDate)
            $("#event_time_modal").html(modalTime)

            //Tickets
            var tr;
            var option = "<option data-signature='null'>Select</option>";
            $.each(eventObject[0].tickets, function(index, item){
                if(appCurrencyFixed == 1){
                    //Currency fixed
                    var newprice = new Intl.NumberFormat('en-GB').format(item.price);
                    tr += "<tr data-signature="+item.signature +">";
                    tr += "<td class='ticket_title'>" + item.title + "</td>";
                    tr += "<td class='ticket_venue'>" + item.venue + "</td>";
                    tr += "<td class='ticket_price' id="+item.price+">" + newprice + "</td>";
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
            $("#event_tickets_list").empty()
            $("#event_type_option").empty()
            $("#event_type_option").append(option)
            $("#event_tickets_list").append(tr)
            $("#modal").modal('show');

            //Event for ticket type change
            $("#event_type_option").on('change', function () {
                var sign = $(this).find('option:selected').data('signature');
                var qty = $("#event_order_qty").val();
                // console.log($("#event_order_qty").val())
                $("#event_order_qty").val(1)
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

            $('#modal').on('shown.bs.modal', function () {
                $(".pay_event_btn").on('click', function (e) {
                    e.preventDefault()
                    var data = {
                        signature: $("#event_type_option").find('option:selected').data('signature'),
                        qty: $("#event_order_qty").val(),
                        email: $("#user_email").val(),
                        phone_no: $("#phone_no").val(),
                        name: eventObject[0].title + " - " +$("#event_type_option").find('option:selected').text()
                    }
                    var price = eventObject[0].tickets.filter(function (item, index) {
                        return item.signature == data.signature;
                    });
                    data.price = price[0].price

                    if(data.email == '' || data.phone_no == '' || data.qty == 0){
                        alertui.notify('error', 'Please complete the form');
                        return false;
                    }

                    $(".process_indicator").removeClass('off');
                    $(".pay_event_btn").prop('disabled', true)
                    $.post(baseUrl+'redeem_event',data)
                        .done(function (res) {
                            $(".process_indicator").addClass('off');
                            $(".pay_event_btn").prop('disabled', false)
                            // handle success
                            if (!res) {
                                alertui.notify('error','Failed to complete payment');
                                return false;
                            }
                            if (res.status == '400') {
                                alertui.notify('error',res.data);
                                return false;
                            }
                            if (res.status == 'fail') {
                                alertui.notify('error',res.data);
                                return false;
                            }
                            if (res.status == '200') {
                                $('#modal').modal('hide');
                                $('#modal').on('hidden.bs.modal', function (e) {
                                    $('#ordernotify').modal('show');
                                });
                                var oldlink = $("#order_receipt").prop('href');
                                $('#ordernotify').on('shown.bs.modal', function (e) {
                                    $("#order_receipt").prop('href', '');
                                    $("#order_receipt").prop('href', "{{url('ordercomplete')}}"+'/'+res.data);
                                });
                            }
                        })
                        .fail(function (error) {
                            // handle error
                            $(".process_indicator").addClass('off');
                            $(".pay_event_btn").prop('disabled', false)
                            // console.log(error)
                            // alertui.notify('error', error.responseJSON.data);
                        })
                })
            })

        })
    })
</script>
</body>

</html>