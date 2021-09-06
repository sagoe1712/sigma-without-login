@extends('layouts.main')
@section('content')
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="padding: 20px;">
                <div class="modal-header" style="height: 50px;">
                    <h5 class="modal-title modal_category_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-4">
                            @if(isset($data))
                                @if($data->status == 1)
                                    <img src="{{$data->data->artwork}}" alt="" id="event_banner" class="img-responsive" onerror="this.src='http://localhost:8888/laravel/lsl-live/sigma_prime/public/images/no_image.jpg'">
                                @endif
                            @endif
                        </div>
                        <div class="col-sm-8 text-left">
                            <h3 id="event_name" style="line-height: normal; padding-bottom: 0px"></h3>
                            <h5 id="event_date_modal" style="margin-top:-10px"></h5>
                            <h5 id="event_time_modal" style="font-size:14px; margin-top:-10px; margin-bottom:5px"></h5>
                            <p id="event_desc" style="margin: 0px;"></p>
                            <div class="tickets_table m-t-20">
                                <h4 style="padding-bottom: 0px;">Tickets</h4>
                                <table class="table table-hover table-sm">
                                    <thead>
                                    <tr style="border-bottom: 1px solid #ccc">
                                        <th>Person</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody id="event_tickets_list">

                                    </tbody>


                                </table>
                                <form name="event_booking_form">
                                    <div class="row mt-4 mb-4">
                                        <div class="col-sm-12">
                                            <h4>Booking details</h4>
                                        </div>
                                        <div class="col-sm-6 m_b_10">
                                            <label for="event_type_option">Ticket type</label>
                                            <select name="event_type_option" id="event_type_option" class="form-control">
                                            </select>
                                        </div>
                                        <div class="col-sm-6 m_b_10">
                                            <label for="event_order_qty">Quantity</label>
                                            <select name="event_order_qty" id="event_order_qty" class="form-control" disabled="disabled">
                                                <option value="" disabled="disabled">Select quantity</option>
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>

                                        </div>
                                        <div class="col-sm-6 m_b_10">
                                            <label for="user_email">First name*</label>
                                            <input type="text" placeholder="Firstname" class="form-control" id="user_firstname" name="user_firstname" required="">
                                        </div>
                                        <div class="col-sm-6 m_b_10">
                                            <label for="phone_no">Last name*</label>
                                            <input type="text" placeholder="Lastname" class="form-control" id="user_lastname" name="user_lastname" required></div>
                                        <div class="col-sm-12">
                                        </div>    <div class="col-sm-6 m_b_10">
                                            <label for="user_email">Email*</label>
                                            <input type="email" placeholder="Email" class="form-control" id="user_email" name="user_email" required>
                                        </div>
                                        <div class="col-sm-6 m_b_10">
                                            <label for="phone_no">Phone number*</label>
                                            <input type="phone" placeholder="Phone number" class="form-control" id="phone_no" name="phone_no" required=""></div>
                                        <div class="col-sm-12">
                                            <hr style="margin-top: 10px; margin-bottom: 10px;">
                                        </div>
                                        <div class="col-sm-12" style="font-weight: 700; font-size: 20px;">
                                            <span class="pull-left">Total</span>
                                            @if(Auth::user()->currency->is_currency_fixed == '1')
                                                <span class="pull-right">&#8358;<span class="event_price_realtime">{{ (number_format(0)) }}</span></span>
                                            @else
                                                <span class="pull-right"><span class="event_price_realtime">0</span><span> {{Auth::user()->currency->currency}}</span></span>
                                            @endif
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <hr style="margin-top: 10px; margin-bottom: 10px;">
                                        </div>
                                        <div class="col-sm-6">
                                            <button class="btn btn-md btn-block pay_event_btn" type="button" disabled="disabled">
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
                            top: 10%;"
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

    <div id="tt-pageContent">
        <div class="row" style="margin-bottom: 20px; margin-top: 20px; padding-left: 30px;">
            <a href="{{url()->previous()}}" class="text-white">&#8592; Back to previous page</a>
        </div>
        @if(isset($data))
            @if($data->status == 1)
        <div class="cinema-container">
            <div class="row">
                <div class="col-6 col-md-6">
                    @if(isset($data->data->synopsisImage))
                    <img src="{{$data->data->synopsisImage}}" width="75%" alt="{{$data->data->title}}" />
                    @endif
                </div>
                <div class="col-6 col-md-6 cinemabg-image">

                        <div class="centered">


                    @if(isset($data->data->youtubeid))
                        <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{$data->data->youtubeid}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <p>Watch Trailer</p>
                    @else
                        <p>Trailer Not Available</p>
                    @endif
                        </div>
                </div>
            </div>
            <div class="cinema-show-container">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <h5 class="low-opacity">{{$data->data->cinemas_name}}, {{$data->data->state}}</h5>
                        <h5>{{$data->data->title}}</h5>
                        <p class="white-text">
                            Description:
                        </p>
                        <p>
                            {{$data->data->description}}
                          </p>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="show-time-container">
                            <p class="white-text bold-text added-border">Showtime</p>
                            <hr class="white-horizontal" />
                            <div class="show-time">

                                @if(isset($data->data->showtimes))
                                    @foreach($data->data->showtimes as $index => $item)
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <p class="white-text">
                                            {{Carbon\Carbon::parse($item->date)->format('D d M - y')}}
                                        </p>
                                    </div>

                                    @if(isset($item->times))
                                        <div class="col-6 col-md-8">
                                        @foreach($item->times as $index2 => $subitem)

                                        <button type="button" class="btn btn-primary btn-sm show-btn movie_time" data-parentindex="{{$index}}" data-dateindex="{{$index2}}" id="pills-home-tab" data-toggle="pill" href="#{{$index2}}" role="tab" aria-controls="{{$index2}}" aria-selected="true">
                                            {{ date("h:ia", strtotime(Carbon\Carbon::parse($subitem->date_time)))}}
                                        </button>

                                        @endforeach
                                        </div>
                                        @endif

                                </div>
                                    @endforeach
                                    @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{--            <!-- Ticket session -->--}}
{{--            <div class="ticket-session-container">--}}
{{--                <h5>Ticket</h5>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12 col-md-2">--}}
{{--                        <p>Person</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-4">--}}
{{--                        <p>Price</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-3">--}}
{{--                        <p>Quantity</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-3">--}}
{{--                        <p>Subtotal</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12 col-md-2">--}}
{{--                        <p class="white-text">Adult</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-4">--}}
{{--                        <p class="white-text">198,040 Sigma Stars</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-3 counter-column">--}}
{{--                        <div class="tt-input-counter style-01">--}}
{{--                            <span class="minus-btn"></span>--}}
{{--                            <input type="text" value="1" size="5">--}}
{{--                            <span class="plus-btn"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-3">--}}
{{--                        <p class="white-text">198,040 Sigma Stars</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12 col-md-2">--}}
{{--                        <p class="white-text">Student</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-4">--}}
{{--                        <p class="white-text">198,040 Sigma Stars</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-3 counter-column">--}}
{{--                        <div class="tt-input-counter style-01">--}}
{{--                            <span class="minus-btn"></span>--}}
{{--                            <input type="text" value="1" size="5">--}}
{{--                            <span class="plus-btn"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-3">--}}
{{--                        <p class="white-text">198,040 Sigma Stars</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12 col-md-2">--}}
{{--                        <p class="white-text">Children</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-4">--}}
{{--                        <p class="white-text">198,040 Sigma Stars</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-3 counter-column">--}}
{{--                        <div class="tt-input-counter style-01">--}}
{{--                            <span class="minus-btn"></span>--}}
{{--                            <input type="text" value="1" size="5">--}}
{{--                            <span class="plus-btn"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 col-md-3">--}}
{{--                        <p class="white-text">198,040 Sigma Stars</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <hr class="white-horizontal" />--}}
{{--                <div class="row">--}}
{{--                    <div class="col-6 col-md-6">--}}
{{--                        <div class="view-cinema-cont">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="firstname">First name:</label>--}}
{{--                                <input type="text" class="form-control" id="usr">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-6 col-md-6">--}}
{{--                        <div class="view-cinema-cont">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="firstname">Last name:</label>--}}
{{--                                <input type="text" class="form-control" id="usr">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                    <div class="col-6 col-md-6">--}}
{{--                    </div>--}}
{{--                    <div class="col-6 col-md-6">--}}
{{--                        <button type="button" class="btn btn-primary btn-sm show-btn update-btn">--}}
{{--                            Update--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Ticket GrandTotal session -->--}}
{{--            <div class="grand-total-session">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-6 col-md-6">--}}
{{--                        <h5>Grand Total</h5>--}}
{{--                        <h5>198, 040 <span>Sigma Stars</span></h5>--}}
{{--                    </div>--}}
{{--                    <div class="col-6 col-md-6">--}}
{{--                        <button style="width: 100%;" type="button" class="btn btn-primary btn-lg">--}}
{{--                            ADD TO CART--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>
            @endif
            @endif
        <!-- Explore More -->
    </div>


        @endsection
        @push('style')
            <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
            <style>

                .modal-content{
                    overflow: auto;
                    height: 800px;
                }
                .cinemas_container .details h4{
                    text-align: left;
                    font-size: 16px;
                    color: #fff;
                    font-weight: 700;
                    text-transform: capitalize;
                }

                .cinemas_container .details h5{
                    text-align: left;
                    font-size: 13px;
                    color: #fff;
                    font-weight: 500;
                    text-transform: capitalize;
                }

                .cinemas_container .details{
                    height: 90px;
                    min-height: 90px;
                    max-height: 90px;
                }
                .cinemas_container{
                    background: rgba(000,000,000,0.6);
                    padding: 13px;
                    height: 170px;
                    min-height: 170px;
                    max-height: 170px;
                }
                .cinemas_container a{
                    float: right;
                }
                .nav-pills>li+li {
                    margin-bottom: 20px;
                }

                .my-wishlist table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
                    vertical-align: middle;
                    border: none;
                    padding: 10px;
                }
                .table tr td{
                    text-transform: capitalize;
                }
                .table {
                    width: 100%;
                    max-width: 100%;
                    margin-bottom: 20px;
                    text-align: left;
                }
            </style>
        @endpush
        @push('script')
            <script>
                $('body').addClass('tt-page-product-single cinema-bg');
            </script>
            <script src="{{asset('js/alertui.min.js')}}"></script>
            <script src="{{asset('js/lodash.min.js')}}"></script>
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
                var movieData = <?php echo json_encode($data) ?>;
                var showtimes = movieData.data.showtimes;
                var selectedTickets = null;

                //Declare global variables.
                var conversionRate = "<?php echo Auth::user()->currency->rate ;?>"
                var appCurrency = "<?php echo Auth::user()->currency->currency ;?>"
                var appCurrencyFixed = "<?php echo Auth::user()->currency->is_currency_fixed ;?>"
                var showTime = null;

                $(".overlay").click(function(){
                    $(this).hide();
                });

                $(document).ready( function () {
                    //Setup Modal with Static details
                    $("#event_name").html(movieData.data.title)
                    $("#event_desc").html(movieData.data.description)

                    //Disable submit button
                    $("#user_email,#phone_no").on('keyup keypress', function () {
                        if($("#user_email").val() != '' && $("#phone_no").val() != ''){
                            $(".pay_event_btn").prop('disabled', false)
                        }else{
                            $(".pay_event_btn").prop('disabled', true)
                        }

                    });

                    $(".movie_time").on('click', function (event) {
                        event.preventDefault()
                        var dateindex = $(this).data('dateindex');
                        var parentindex = $(this).data('parentindex');
                        var showTimeData = showtimes[parentindex].times[dateindex];
                        showTime = showtimes[parentindex].times[dateindex];
                        addTicketsToModal(showTimeData.ticket)
                    })


                    $("#event_type_option").on('change', function () {
                        var sign = $(this).find('option:selected').data('signature');
                        var price = $(this).find('option:selected').data('price');
                        $("#event_order_qty").val(1);
                        var qty = $("#event_order_qty").val();

                        var activeTicket = selectedTickets.filter(function(item){
                            return item.signature === sign;
                        });

                        setTicketQuantity(activeTicket)

                        $("#event_order_qty").val(1)
                        if($(this).find('option:selected').data('signature') == null){
                            $("#event_order_qty").prop("disabled", true);
                            $(".event_price_realtime").html("0")
                            return false;
                        }
                        $("#event_order_qty").prop("disabled", false)

                        if(appCurrencyFixed == 1){
                            //Currency fixed
                            if(isNaN(qty)){
                                var quantity = 1;
                            }else{
                                var quantity = parseInt(qty);
                            }

                            var newprice = new Intl.NumberFormat('en-GB').format(price*quantity);

                            $(".event_price_realtime").html(newprice)
                        }else{
                            //Currency not Fixed
                            //Currency is not Naira
                            var cRate = parseFloat(conversionRate);
                            if(isNaN(parseFloat(qty))){
                                var quantity = 1;
                            }else{
                                var quantity = parseInt(qty);
                            }
                            // console.log(cRate, qty, price)
                            var newprice = new Intl.NumberFormat('en-GB').format(price*cRate*quantity);
                            $(".event_price_realtime").html(newprice)
                        }
                    });

                    $("#event_order_qty").on('change keyup', function(){
                        var qty = $(this).val();
                        var sign = $("#event_type_option").find('option:selected').data('signature');
                        var price = $("#event_type_option").find('option:selected').data('price');

                        if(appCurrencyFixed == 1){
                            //Currency fixed
                            var quantity = parseInt(qty);
                            var newprice = new Intl.NumberFormat('en-GB').format(price*quantity);
                            $(".event_price_realtime").html(newprice)
                        }else{
                            //Currency not Fixed
                            //Currency is not Naira
                            var cRate = parseFloat(conversionRate), quantity = parseInt(qty);
                            var newprice = new Intl.NumberFormat('en-GB').format(price*cRate*quantity);
                            $(".event_price_realtime").html(newprice)
                        }
                    })

                    $(".pay_event_btn").on('click', function (e) {
                        e.preventDefault()
                        var data = {
                            signature: $("#event_type_option").find('option:selected').data('signature'),
                            type: $("#event_type_option").find('option:selected').html(),
                            price: $("#event_type_option").find('option:selected').data('price'),
                            qty: $("#event_order_qty").val(),
                            firstname: $("#user_firstname").val(),
                            lastname: $("#user_lastname").val(),
                            email: $("#user_email").val(),
                            phone_no: $("#phone_no").val(),
                            name: movieData.data.title,
                            show_time: showTime['date_time']
                        }

                        if(data.email == '' || data.firstname == '' || data.lastname == '' || data.phone_no == '' || data.qty == 0){
                            alertui.notify('error', 'Please complete the form');
                            swal("",'Please complete the form', "error");
                            return false;
                        }

                        $(".process_indicator").removeClass('off');
                        $(".pay_event_btn").prop('disabled', true)



                        $.post("{{url('api/redeem_movie')}}",data)
                            .done(function (res) {
                                $(".process_indicator").addClass('off');
                                $(".pay_event_btn").prop('disabled', false)
                                // handle success
                                if (!res) {
                                    alertui.notify('error','Failed to complete payment');
                                    swal("",'Failed to complete payment', "error");
                                    return false;
                                }
                                if (res.status == '400') {
                                    alertui.notify('error',res.data);
                                    swal("",res.data, "error");
                                    return false;
                                }
                                if (res.status == 'fail') {
                                    alertui.notify('error',res.data);
                                    swal("",res.data, "error");

                                    return false;
                                }

                                if (res.status == 'validation') {
                                    alertui.notify('info',res.message);
                                    swal("",res.message, "error");

                                    return false;
                                }
                                if (res.status == '200') {
                                    updateAccount(res.account)
                                    $('#modal').modal('hide');
                                    alertui.notify('success', res.message);
                                    swal("",res.message, "success");

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
                            .fail(function (response, status, error) {
                                // handle error
                                $(".process_indicator").addClass('off');
                                $(".pay_event_btn").prop('disabled', false)
                                // console.log(error)
                                if(response.status == 500){
                                    swal("",'A Network Error Occurred. Please check your Email to confirm ticket booking.', "error");

                                    alertui.notify('error', 'A Network Error Occurred. Please check your Email to confirm ticket booking.')
                                }
                                else{
                                    swal("",'A Network Error Occurred. Please check your Email to confirm ticket booking.', "error");

                                    alertui.notify('info', 'A Network Error Occurred. Please check your Email to confirm ticket booking.')
                                }
                            })
                        // $(this).off('click');
                    })
                })

                function addTicketsToModal(tickets){
                    //Reset wuantity counter
                    $("#event_order_qty").val(1)
                    $("#event_order_qty").prop("disabled", true);
                    //Add Tickets
                    var tr;
                    var option = "<option data-signature='null' disabled selected>Select category</option>";
                    $.each(tickets, function(index, item){
                        if(appCurrencyFixed == 1){
                            //Currency fixed
                            var newprice = new Intl.NumberFormat('en-GB').format(item.price);
                            tr += "<tr data-signature="+item.signature +">";
                            tr += "<td class='ticket_title'>" + item.type + "</td>";
                            tr += "<td class='ticket_price' id="+item.price+">" + '&#8358;'+newprice + "</td>";
                        }else{
                            //Currency not Fixed
                            //Currency is not Naira
                            var cRate = parseFloat(conversionRate);
                            var newprice = new Intl.NumberFormat('en-GB').format(item.price*cRate);
                            tr += "<tr data-signature="+item.signature +">";
                            tr += "<td class='ticket_title'>" +item.type + "</td>";
                            tr += "<td class='ticket_price' id="+item.price+">" +newprice +' ' + appCurrency + "</td>";
                        }
                        tr += "</tr>";
                    });

                    selectedTickets = tickets;
                    //Add Person Type
                    $.each(tickets, function(index, item){
                        option += "<option data-signature="+item.signature+" data-price="+item.price+">"
                        option += item.type;
                        tr += "</option>";
                    });


                    $("#event_tickets_list").empty()
                    $("#event_type_option").empty()
                    $("#event_type_option").append(option)
                    $("#event_tickets_list").append(tr)
                    $("#modal").modal('show');
                }

                function setTicketQuantity(ticket){
                    // Add quantity
                    var ticket = _.head(ticket);

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