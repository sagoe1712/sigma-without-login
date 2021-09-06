<section id="service" class="pos-r o-hidden text-center">

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
                                <div class="col-sm-5 div-discount-img">

                                </div>
                                <div class="col-sm-7">
                                    <div class="row">
                                        <h4>Location</h4>
                                        <ul class="discount-location">
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <b>Offers</b>
                                        <br/>
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

    <div class="bg-animation">
        <img class="zoom-fade" src="{{asset('sigma/images/pattern/03.png')}}" alt="">
    </div>
    <div class="container">

        <div class="row">

            <div class="col-lg-6 col-md-10 ml-auto mr-auto">
                <div class="section-title">
                    <div class="title-effect">
                        <div class="bar bar-top"></div>
                        <div class="bar bar-right"></div>
                        <div class="bar bar-bottom"></div>
                        <div class="bar bar-left"></div>
                    </div>

                    <h6>...</h6>
                    <h2 class="title">Sigma Prime Discount</h2>
                </div>
            </div>
        </div>
        <div class="row">

            @foreach($categories->data as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="featured-item style-4" id="{{$item->partner_id}}">
                            <div class="featured-icon">
                                <a href="#" id="{{$item->partner_id}}"  class="discount_container">
                                    <img class="img-center" src="{{$item->image_url}}" alt="{{$item->partner_name}}">
                                </a>
                            </div>
                            <div class="featured-title">
                                <a href="#" id="{{$item->partner_id}}" class="discount_container"><h5>{{str_limit(ucwords(strtolower($item->partner_name)), 23 )}}</h5></a>
                            </div>
                        </div>
                    </div>
            @endforeach


        </div>
    </div>
</section>

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

    .discount-location li:before{
        content: '';
        background-image: url('{{asset('sigma/images/location-icon.png')}}');
        background-size: contain;
        display: inline-block;
        height: 20px;
        width: 20px;
        background-repeat: no-repeat;

    }

    .discount-location, .discount-offer{
        list-style: none !important;
    }

    .discount-location li{
        text-align: left;
    }

    .discount-partner-img{
        width: 200px;
        margin-top: 20px;
    }

    .discount-offer li:before{
        content: '';
        background-image: url('{{asset('sigma/images/offer-icon.png')}}');
        background-size: contain;
        background-repeat: no-repeat;

        display: inline-block;
        height: 20px;
        width: 20px;
    }

    .discount-offer li{
        text-align: left;
    }

    .featured-item.style-4 {
        margin: 20px auto !important;
    }

</style>

<script src="{{asset('sigma/js/jquery-1.11.1.min.js')}}"></script>
<script src="{{asset('sigma/js/alertui.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('sigma/css/alertui.min.css')}}">

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
                    $('#model-discount-content').html('Failed to Load Discount Offers');
                    alertui.notify('success', 'Failed to Load Discount Offers');
                    return false;
                }
                if (res.status == '400') {
                    $('#modal').modal('hide');
                    $('#modal-discount-content').show()
                    $('#model-discount-content').html('Failed to Load Discount Offers');
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
                        listbranch += "<li>" + value.branch_name + ": " + value.branch_address + ", " + value.state_name + "</li>";
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


</script>