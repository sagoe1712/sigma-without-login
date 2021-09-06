<link rel="stylesheet" type="text/css" href="{{asset('sigma/css/sigma_style.css')}}">
<section id="about" class="pos-r bg-contain bg-pos-l py-10">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="height: 50px;">
                    <h5 class="modal-title modal_category_title">Loading</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="div-loading">
                        <img src="{{asset('sigma/images/loading.gif')}}" class="modal-loading">
                    </div>
                    <div class="row" id="modal-discount-content">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="row">
                                <div class="col-sm-4 div-discount-img">

                                </div>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <h4>Location</h4>
                                        <ul class="discount-location">
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <b>Offers</b>
                                        <ul class="discount-offer">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br><br>
                    {{--<a>--}}
                    {{--<button type="button" class="btn btn-large btn-primary pay_bills_btn custom_button_color"><i class="fa fa-spinner fa-spin off process_indicator"></i> Redeem</button>--}}
                    {{--</a>--}}
                </div>
            </div>
        </div>
    </div>


            <div class='row'>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="">

                        @if(isset($categories))

                            @if($categories->status == 1)
                                @include('partials.sigma.banner', ['page' => 'discount'])
                                <div style="background: #fff;
                                    -webkit-border-radius: 10px;
                                     -moz-border-radius: 10px;
                                     border-radius: 10px;
                                     margin-bottom: 40px;
                                        ">
                                    <div class="row">

                                        <!-- /.col -->
                                        <div class="col col-sm-12 hidden-sm">
                                            <div class="col col-sm-9 col-md-9 col-lg-9 no-padding text-right">

                                                <!-- /.lbl-cnt -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col col-sm-3 col-md-3 col-lg-3 no-padding text-left hidden-sm">
                                                <div class="lbl-cnt">
                                                    <div class="fld inline">
                                                        <br/>
                                                        <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                                            <select data-toggle="dropdown" id="drp-state" class="btn dropdown-toggle"> <option value="all">All States</option>
                                                                @foreach($state->data as $list)
                                                                    <option value="{{$list->state_id}}">{{ucwords(strtolower($list->state_name))}}</option>
                                                                @endforeach

                                                            </select>

                                                        </div>
                                                    </div>
                                                    <!-- /.fld -->
                                                </div>
                                                <!-- /.lbl-cnt -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <div class="row" id="display-partners">

                                        @foreach($categories->data as $item)
                                            <div class="col-sm-3 col-md-3">
                                                <div class="cinemas_item_container events_item_container discount_container"
                                                     id="{{$item->partner_id}}">
                                                    <div class="image_container" style="height: auto;">
                                                        <img  alt="{{$item->partner_name}}" class="movie_img" src="{{$item->image_url}}" style="width: 100%; height: auto;">
                                                    </div>
                                                    <div class="details" style="width: 100%;">
                                                        <h4 style="color: #333;font-size: 16px;">{{str_limit(ucwords(strtolower($item->partner_name)), 22 )}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach



                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>

                {{--                    @if(isset($data))--}}
                {{--                        @if($data->status == 1)--}}
                {{--                            <div class="col-xs-12 col-sm-12 col-md-12">--}}
                {{--                                <div class="container">--}}
                {{--                                    @include('partials.sigma.banner', ['page' => 'discount'])--}}
                {{--                                    <div style="background: #fff;--}}
                {{--                                    -webkit-border-radius: 10px;--}}
                {{--                                     -moz-border-radius: 10px;--}}
                {{--                                     border-radius: 10px;--}}
                {{--                                     margin-bottom: 40px;--}}
                {{--                                        ">--}}
                {{--                                        <div class="row">--}}

                {{--                                            <div class="col-sm-3 col-md-3">--}}
                {{--                                                <div class="cinemas_item_container events_item_container discount_container"--}}
                {{--                                                 id="">--}}
                {{--                                                    <div class="image_container" style="height: auto;">--}}
                {{--                                                        <img  alt="" class="movie_img" src="{{$item->banner}}" style="width: 100%; height: auto;">--}}
                {{--                                                    </div>--}}
                {{--                                                    <div class="details" style="width: 100%;">--}}
                {{--                                                        <h4 style="color: #333;font-size: 16px;">{{str_limit(ucfirst(strtolower($item->title)), 22 )}}</h4>--}}
                {{--                                                    </div>--}}
                {{--                                                </div>--}}
                {{--                                            </div>--}}

                {{--                                            @foreach($data->events as $index => $item)--}}
                {{--                                            --}}
                {{--                                            @endforeach--}}
                {{--                                    </div>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        @endif--}}
                {{--                    @endif--}}
            </div>

</section>

<script src="{{asset('sigma/js/alertui.min.js')}}"></script>
<script src="{{asset('sigma/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('sigma/js/lodash.min.js')}}"></script>
<script src="{{asset('sigma/js/bootstrap.min.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('sigma/css/alertui.min.css')}}">
<style>
    .modal-content{
        overflow: auto;
    }
    .modal-header .close {
        margin-top: -20px !important;
    }

    .img-responsive{
        max-width: 100% !important;
    }
</style>

<script>

    $(document).on('click', '.discount_container', function (event) {
        var partnerid = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "{{url('api/odiscountoffer')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{partner_id: partnerid},
            dataType: "json",
            success: function (res) {

                $('#modal').modal('show');
                $('#modal-discount-content').hide()
                $('#div-loading').show();
                // handle success
                if (!res) {
                    $('#modal').modal('hide');
                    $('#modal-discount-content').show()
                    $('#div-loading').hide();
                    alertui.notify('success', 'Failed to Load Discount Offers');
                    return false;
                }
                if (res.status == '400') {
                    $('#modal').modal('hide');
                    $('#modal-discount-content').show()
                    $('#div-loading').hide();
                    alertui.notify('error', res.data.message);
                    return false;
                }
                if (res.status == '200') {
                    alertui.notify('success', res.data.partner_name + ' offers are loaded')

                    $('#div-loading').hide();
                    $('#modal-discount-content').show()


                    $('.div-discount-img').html('<img src="' + res.data.image_url + '" class="discount-partner-img"/>');
                    $('.modal_category_title').html(res.data.partner_name);

                    var listbranch = "";

                    $.each(res.data.branch, function (key, value) {
                        listbranch += "<li>" + value.branch_name + ": " + value.branch_address + ", " + value.state_name.toLowerCase() + "</li>";
                    })

                    $('.discount-location').html(listbranch);
                    //console.log(res.data.img_url);

                    var listdiscount = "";
                    $.each(res.data.discount, function (key, value) {
                        listdiscount += "<li>" + value.discount_rate + "% " + value.discount_name + "</li>";
                    })

                    $('.discount-offer').html(listdiscount);


                }
            }
        });
    })





    $('#drp-state').change(function () {
        var state_id = $(this).val();

        var state_url = "";

        if (state_id == "all"){
            state_url = "{{url('api/odiscountstate')}}";
        }else{
            state_url = "{{url('api/odiscountstate')}}"+"/"+state_id
        }

        //alert(state_id);
        $.ajax({
            type:"GET",
            url: state_url,
            //headers:{token:1200},

            dataType:"json",
            success: function(res){
                $('#display-partners').html('');

                if (res.status == 200 ){

                    var display_partner = "";
                    $.each(res.data, function(key,value)
                    {
                        display_partner+='<div class="col-sm-3 col-md-3">';
                        display_partner+='<div class="cinemas_item_container events_item_container discount_container" id="'+value.partner_id+'">';
                        display_partner+='<div class="image_container" style="height: auto;">';
                        display_partner+='<img  alt="'+value.partner_name+'" class="movie_img" src="'+value.image_url+'" style="width: 100%; height: auto;">';
                        display_partner+='</div>';
                        display_partner+='<div class="details" style="width: 100%;">';
                        display_partner+='<h4 style="color: #333;font-size: 16px;">'+value.partner_name+'</h4>';
                        display_partner+=' </div>';
                        display_partner+=' </div>';
                        display_partner+='</div>';
                    });
                    $('#display-partners').html(display_partner);


                }
            }
        });


    })





</script>

