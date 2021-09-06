@extends('layouts.main')
@section('content')

     <div class="modal  fade"  id="modal" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content ">
                 <div class="modal-header">
{{--                     <h5 class="modal-title modal_category_title">Loading</h5>--}}
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                 </div>
                 <div class="modal-body">
                     <div class="tt-modal-quickview desctope view-discount-container">
                         <div class="row">
                             <div class="col-12 col-md-6">
                                 <div class="discount-company-card div-discount-img">

                                       </div>

                             </div>
                             <div class="col-12 col-md-6">
                                 <h4 class="bold-text modal_category_title"></h4>
                                 <h5 class="sigma-green">Location</h5>
                             <div class="discount-location">
                             </div>
                                 <h5 class="sigma-green">Offers</h5>
                                 <ul class="unordered-list-style discount-offer">

                                 </ul>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="container-indent0">
         <div class="container-fluid margin">
             <div class="row tt-layout-promo-box">
                 <!-- Discount Container -->
                 <div class="new-discount-container">
                     <h4>Sigma Prime Discount</h4>
                     <hr style="margin-top: 0px !important; margin-bottom: 20px !important;" />
                     <div class="row" style="margin-top: 20px; margin-bottom: 20px;">

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
                     @if(isset($categories))

                         @if($categories->status == 1)

                     <div class="row">
                         @foreach($categories->data as $item)
                         <div class="col-12 col-md-3 col-lg-3">
                             <div class="bill-image-container discount-card">
                                 <a href="#" id="{{$item->partner_id}}" class="discount_container">
                                     <img data-imgsrc="{{$item->image_url}}" src="{{$item->image_url}}" width="100%" alt="{{$item->partner_name}}" />
                                 </a>
                             </div>

                             <p>{{str_limit(ucwords(strtolower($item->partner_name)), 22 )}}</p>
                         </div>
                         @endforeach
                     </div>
                         @endif
                         @endif
                 </div>
             </div>
         </div>
     </div>




@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">

{{--    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">--}}

@endpush
@push('script')
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script>

        $('body').addClass('tt-page-product-single');

        $(document).on('click', '.discount_container', function (event) {

            var image = $(this).children('img').attr('data-imgsrc');
            // alert(image);
            $(this).children('img').attr("src", "{{asset('images/loader.svg')}}");
            var partnerid = $(this).attr('id');


            $.post("{{url('api/discountoffer')}}", {
                partner_id: partnerid
            })
                .done(function (res) {

                    $('#modal').modal('show');

                    // handle success
                    if (!res) {
                        $('img[data-imgsrc="'+image+'"]').attr("src",image);
                        $('#modal').modal('hide');

                        alertui.notify('success', 'Failed to Load Discount Offers');
                        swal("", 'Failed to Load Discount Offers', "error");
                        return false;
                    }
                    if (res.status == '400') {
                        $('img[data-imgsrc="'+image+'"]').attr("src",image);
                        $('#modal').modal('show');

                        alertui.notify('error', res.data.message);
                        swal("", res.data.message, "error");
                        return false;
                    }
                    if (res.status == '200') {
                        $('img[data-imgsrc="'+image+'"]').attr("src",image);
                        alertui.notify('success', res.data.partner_name + ' offers are loaded')

                        $('#modal').modal('show');


                        $('.div-discount-img').html('<img src="'+res.data.image_url+'" class="discount-partner-img"/>');
                        $('.modal_category_title').html(res.data.partner_name);

                        var listbranch = "";

                        $.each(res.data.branch, function(key, value){
                            listbranch += '<p> <i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp;&nbsp;'+value.branch_name+": "+value.branch_address+", "+value.state_name+"</p><br/>";
                        })

                        $('.discount-location').html(listbranch);
                        //console.log(res.data.img_url);

                        var listdiscount = "";
                        $.each(res.data.discount, function(key, value){
                            listdiscount += "<li>"+value.discount_rate+"% "+value.discount_name+"</li>";
                        })

                        $('.discount-offer').html(listdiscount);



                    }
                })
                .fail(function (response, status, error) {
                    // handle error
                    $(this).children('img').attr("src", ""+image);
                        alertui.notify('info', response.responseJSON.data)
                    swal("", response.responseJSON.data, "error");



                })

        });

$('#drp-state').change(function () {
    var state_id = $(this).val();

    var state_url = "";

    if (state_id == "all"){
        state_url = "{{url('api/discountstate')}}";
    }else{
        state_url = "{{url('api/discountstate')}}"+"/"+state_id
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
                    display_partner+='<div class="col-12 col-md-3 col-lg-3">';
                    display_partner+=' <div class="bill-image-container discount-card">';
                    display_partner+='<a href="#" id="'+value.partner_id+' class="discount_container">';
                    display_partner+='<img src="'+value.image_url+'" width="100%" alt="'+value.partner_name+'" />';
                    display_partner+='</a>';
                    display_partner+='</div>';

                    display_partner+='<p>'+value.partner_name+'</p>';
                    display_partner+='</div>';
                });
                $('#display-partners').html(display_partner);


            }
        }
    });


})





    </script>
@endpush