@extends('layouts.main')
@section('content')
    <div class="modal fade modal-md" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px;">
                    <span class="modal-title modal_category_title" style="font-size: 18px">Redeem Fuel Voucher</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <form action="" name="fuel_voucher" id="fuel_voucher_form">
                            <input type="hidden" name="voucher_price">
                                <div class="form-group text-left row">
                                <div class="col-sm-8">
                                <label for="voucher_list">Vouchers</label>
                            <select name="voucher" id="voucher_list" class="form-control">
                            </select>
                                </div>
                         
                                <div class="col-sm-4">
                                <label for="voucher_qty">Quantity</label>
                            <select name="voucher_qty" id="voucher_qty" class="form-control">
                            <option value="1" selected>1</option>
                            </select>
                                </div>

                                </div>
                                <div class="form-group text-left">
                                    <label for="email">Email address</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                           required>
                                </div>

                                <div class="form-group text-left">
                                    <label for="phone_no">Phone</label>
                                    <input type="tel" name="phone_no" id="phone_no"  class="form-control"
                                           required>
                                </div>
                                <hr>
                                <h4 class="price text-center" id="voucher_price"></h4>
                            </form>
                            <br>
                            <div class="text-center">
                                <button type="button" class="btn btn-large btn-primary pay_fuel_voucher_btn custom_button_color"><i class="fa fa-spinner fa-spin off process_indicator_fv"></i> Redeem</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="body-content">
            <div class=''>
                <div class='row'>
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-5">
                        <div class="breadcrumb">
                            <div class="container">
                                <div class="breadcrumb-inner">
                                    <ul class="list-inline list-unstyled">
                                        <li><a href="{{url('/')}}">Home</a></li>
                                        <li class='active'>Fuel Vouchers</li>
                                    </ul>
                                </div>
                                <!-- /.breadcrumb-inner -->
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 10px; margin-bottom: 50px;">
                        <div class="container">
                            @if(isset($stations))
                                @if($stations->status == 1)
                                            <div class="row bills_category" style="padding: 20px;">
                                               <div class="alert alert-info">
                                                   <h4><i class="fa fa-info-circle"></i> Redeem Fuel vouchers</h4>
                                                   <p>Select a Fuel station to load available vouchers for the selected station.</p>
                                               </div>
                                                @foreach($stations->data as $item)
                                                <div class="col-md-4 col-sm-4">
                                                        <div class="station_item">
                                                            <a href="#" data-category="{{$item->id}}" class="view_voucher">
                                                            <img src="{{$item->image}}" alt="">
                                                            </a>
                                                                <div class="p-2 bd-highlight col-12 text-center">
                                                                    <h3><a href="#" data-category="{{$item->id}}" class="view_voucher">{{$item->stationName}}</a></h3>
                                                                    <h5>{{$item->address}}</h5>
                                                                </div>
                                                                <a class="btn btn-md custom_button_color view_voucher"
                                                                   data-category="{{$item->id}}"
                                                                   data-station="{{$item->stationName}}"
                                                                   data-address="{{$item->address}}"
                                                                >View</a>
                                                              </div>
                                                </div>
                                                @endforeach
                                            </div>
                                    @else
                                    <div class="text-center alert alert-primary">No Data Found</div>
                                            @endif
                                            @endif
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @push('style')
            <link rel="stylesheet" type="text/css" href="{{asset('sigma/css/alertui.min.css')}}">
    @endpush

@push('script')
    <script src="{{asset('sigma/js/alertui.min.js')}}"></script>

    <script>
    var vouchers = [];
            //Declare global variables.
            var conversionRate = "<?php echo Auth::user()->currency->rate ;?>"
            var currency = "<?php echo Auth::user()->currency->currency ;?>"
        var appCurrencyFixed = "<?php echo Auth::user()->currency->is_currency_fixed ;?>"
        var station = null;
        var address = null;
        $(document).ready(function () {
            $(".view_voucher").on('click', function () {
                station = $(this).data('station');
                address = $(this).data('address');

                $("form[name='fuel_voucher'] select#voucher_list").empty();
                $("form[name='fuel_voucher'] select").prop("disabled", false);
                $("form[name='fuel_voucher'] input").empty();
                $("form[name='fuel_voucher'] input").prop("disabled", false);
                $(".process_indicator_fv").addClass("off");
                var id = $(this).data('category');
                alertui.load('Loading Vouchers...',
                    function(loadClose, loadEl) {
                        $.post("{!! url('get_fuel_vouchers') !!}", {category_id: id})
                            .done(function (data) {
                                vouchers = data.data.data;
                                loadFuelVouchers(data.data.data)
                                $("#modal").modal('show')
                                loadClose();
                            })
                            .fail(function (error) {
                                alertui.notify('error', 'Failed to load Vouchers. Tray again.')
                            })
                    })
            });

            $(".pay_fuel_voucher_btn").on('click', function () {
                // var voucher_data = $("form[name='fuel_voucher']").serialize();
                $(".process_indicator_fv").removeClass("off");
                $("form[name='fuel_voucher'] select").prop("disabled", true);
                $("form[name='fuel_voucher'] input").prop("disabled", true);

                var formData = new FormData();
                // formData.append('fuel_voucher', document.getElementById('fuel_voucher_form'));
                formData.append('email', $("form[name='fuel_voucher']").find("input[name='email']").val());
                formData.append('packagename', $("form[name='fuel_voucher']").find("select[name='voucher']").val());
                formData.append('signature', $("form[name='fuel_voucher']").find("select[name='voucher']").find("option:selected").data('signature'));
                formData.append('phone_no', $("form[name='fuel_voucher']").find("input[name='phone_no']").val());
                formData.append('qty', $("form[name='fuel_voucher']").find("select[name='voucher_qty']").val());
                formData.append('price', $("form[name='fuel_voucher']").find("input[name='voucher_price']").val());
                formData.append('address', address);
                formData.append('station', station);
                alertui.load('Redeeming voucher...',
                    function(loadClose, loadEl) {
                    try {
                        $.ajax({
                            url: "{!! url('redeem_fuel_voucher') !!}",
                            data: formData,
                            contentType: false,
                            processData: false,
                            method:'POST'
                        })
                            .done(function (data) {
                                if (!data) {
                                    alertui.notify('error','Failed to complete payment');
                                    return false;
                                }
                                    loadClose();
                                    $(".process_indicator_fv").addClass("off");
                                    $("form[name='fuel_voucher'] select").prop("disabled", false);
                                    $("form[name='fuel_voucher'] input").prop("disabled", false);
                                    alertui.notify('success', data.message)
                                    $('#modal').modal('hide');
                                window.location.replace("{{url('ordercomplete')}}/"+data.order_id)
                            })
                            .fail(function (error, status, code) {
                                loadClose();
                                $(".process_indicator_fv").addClass("off");
                                $("form[name='fuel_voucher'] select").prop("disabled", false);
                                $("form[name='fuel_voucher'] input").prop("disabled", false);
                                if(error.status == 400){
                                    if(error.responseJSON.message){
                                        alertui.alert('Error', error.responseJSON.message)
                                    }else{
                                        alertui.notify('error', 'A network Error Occurred. Please try again.')
                                    }
                                }else{
                                    alertui.notify('error', 'A network Error Occurred. Please try again.')
                                }
                            })
                    }catch (e) {
                        $(".process_indicator_fv").addClass("off");
                        $("form[name='fuel_voucher'] select").prop("disabled", false);
                        $("form[name='fuel_voucher'] input").prop("disabled", false);
                        loadClose();
                        alertui.notify('error', 'An Error Occurred. Please Try again.')

                    }
                    })
            });


            //Load Fuel vouchers
            function loadFuelVouchers(vouchers){
                if(appCurrencyFixed == 1){
                        //Currency fixed
                        var newprice = new Intl.NumberFormat('en-GB').format(vouchers[0].price);
                        $("#voucher_price").html('&#8358;'+newprice)
                    }else{
                        //Currency not Fixed
                        //Currency is not Naira
                        var cRate = parseFloat(conversionRate);
                        var newprice = new Intl.NumberFormat('en-GB').format(vouchers[0].price*cRate);
                        $("#voucher_price").html(newprice + ' ' +currency)
                    }
                
                $("input[name='voucher_price']").val(vouchers[0].price)
                var option = "";
                $(vouchers).map(function (index, item) {
                    option += "<option data-signature="+item.signature+"  data-price="+item.price+" >"
                    option += item.product_name;
                    option += "</option>";
                })
        
                $("#voucher_list").append(option)
            }

            //Event listener for voucher change
            $("#voucher_list").on('change', function(){
                var signature = $(this).find("option:selected").data('signature')
                var voucher = $.grep(vouchers, function(item){
                    return item.signature == signature
                });

                if(appCurrencyFixed == 1){
                        //Currency fixed
                        var newprice = new Intl.NumberFormat('en-GB').format(voucher[0].price);
                        $("#voucher_price").html('&#8358;'+newprice)
                    }else{
                        //Currency not Fixed
                        //Currency is not Naira
                        var cRate = parseFloat(conversionRate);
                        var newprice = new Intl.NumberFormat('en-GB').format(voucher[0].price*cRate);
                        $("#voucher_price").html(newprice + ' ' +currency)
                    }
                
                $("input[name='voucher_price']").val(voucher[0].price)
                var option = "";
                for(var i = 1; i < voucher[0].max_quantity+1; i++ ){
                    if(i == 1){
                    option += "<option value="+i+" selected>"
                    option += i;
                    option += "</option>";
                    }else{
                    option += "<option value="+i+">"
                    option += i;
                    option += "</option>";
                    }
                }
                
                $("#voucher_qty").html(option)
            });

                        //Event listener for voucher quantity change
              $("#voucher_qty").on('change', function(){
                var signature = $(this).find("option:selected").data('signature')
                var voucher = $.grep(vouchers, function(item){
                    return item.signature == signature
                });

                var option = "";
                for(var i = 1; i < voucher[0].max_quantity+1; i++ ){
                    if(i == 1){
                    option += "<option value="+i+" selected>"
                    option += i;
                    option += "</option>";
                    }else{
                    option += "<option value="+i+">"
                    option += i;
                    option += "</option>";
                    }
                }
                
                $("#voucher_qty").html(option)
            });
        });
    </script>
    @endpush
