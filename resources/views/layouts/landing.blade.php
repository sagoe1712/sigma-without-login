<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}} @if(isset($title)) - {{$title}}@endif</title>
    <meta name="author" content="Loyalty Solutions Limited" />
    <meta name="description" content="Sigma Pensions Rewards platform" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Animation Libraries -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />


    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/main_style.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/sigma-animate.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151439902-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-151439902-1');
    </script>
    <style>

    </style>

</head>
<body class="tt-page-product-single">
<div id="preloader">
    <div id="sigma-preloader">&nbsp;</div>
</div>
@if($errors->any())
    @include('partials.notify', ['text' => $errors->first()])
@endif

@include('partials.general.header')


@yield('content')

<a href="#" class="tt-back-to-top">BACK TO TOP</a>

@include('partials.general.footer')

<div class="modal fade" id="welcome" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="background-color: transparent !important;">
        <div class="modal-content" style="background-color: transparent !important; border: none !important; text-align: right; position:absolute;">
            <div class="modal-header no-height">
                <button type="button" class="close" data-dismiss="modal"></button>

            </div>
            <div class="modal-body" style="text-align: center; padding-top: 80px; background-color: transparent !important;">

                <br>
                <a href="#"><img src="{{asset('images/welcome.jpg')}}" class="popup-img" style="max-width: 100%;"></a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="video" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="background-color: transparent !important;">
        <div class="modal-content" style="background-color: transparent !important; border: none !important; text-align: right; position:absolute;">
            <div class="modal-header no-height">
                                    <button type="button" class="close video-close" data-dismiss="modal"></button>

            </div>

            <div class="modal-body" style="text-align: center;  background-color: transparent !important;">

               <!-- <video id="video-content" controls style="width: 100%;"> -->
                   <!-- <source src="{{asset('images/movie.mp4')}}" type="video/mp4"> -->
                <!-- </video> -->

                <a href="{{url('discount')}}">

                <img src="{{asset('images/slider-images/discount.jpg')}}" style="max-width: 100%;"/>
                </a>
         

            </div>
        </div>
    </div>
</div>
</body>


<script src="{{asset('external/jquery/jquery.min.js')}}"></script>
<script src="{{asset('external/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('external/elevatezoom/jquery.elevatezoom.js')}}"></script>
<script src="{{asset('external/slick/slick.min.js')}}"></script>
<script src="{{asset('external/panelmenu/panelmenu.js')}}"></script>
<script src="{{asset('external/countdown/jquery.plugin.min.js')}}"></script>
<script src="{{asset('external/countdown/jquery.countdown.min.js')}}"></script>
<script src="{{asset('external/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('external/lazyLoad/lazyload.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<!-- form validation and sending to mail -->
<script src="{{asset('external/form/jquery.form.js')}}"></script>
<script src="{{asset('external/form/jquery.validate.min.js')}}"></script>
<script src="{{asset('external/form/jquery.form-init.js')}}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src='https://www.google.com/recaptcha/api.js?render={{config('app.google_site_key')}}'></script>

<script>

    $(window).on('load', function() {
        $('#sigma-preloader').fadeOut();
        $('#preloader').delay(350).fadeOut('slow');
        $('body').delay(350).css({'overflow':'visible'});
    })

    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


    $(".overlay, .close_overlay").click(function(){
        $(this).hide();
    });

    grecaptcha.ready(function() {
        grecaptcha.execute('6Ld3yIwUAAAAAIOLlI-WpMeVFQob8fxWqXWq5cQz', {action: 'sigma'})
            .then(function(token) {
                $('#cpkt').val(token);
            });
    });

    function disableContact(){
        $("form#contact-form input[type='text']").prop("disabled", true);
        $("form#contact-form input[type='tel']").prop("disabled", true);
        $("form#contact-form input[type='email']").prop("disabled", true);
        $("form#contact-form textarea").prop("disabled", true);
        $("form#contact-form button").prop("disabled", true);
        $("#contact_notification").removeClass("off");
    }

    function enableContact(){
        $("form#contact-form input[type='text']").prop("disabled", false);
        $("form#contact-form input[type='tel']").prop("disabled", false);
        $("form#contact-form input[type='email']").prop("disabled", false);
        $("form#contact-form textarea").prop("disabled", false);
        $("form#contact-form button").prop("disabled", false);
        $("#contact_notification").addClass("off");
    }

    $(document).ready(function(){
        $("form#contact-form button").on('click', function () {
            $.each($("form#contact-form div.with-errors span"), function (index, item) {
                $(item).empty();
            });

            var data = $("form#contact-form").serializeArray();
            disableContact();

            $.ajax({
                url: "{!! url('contact') !!}",
                method: "POST",
                data: data
            }).done(function (res) {
                enableContact();
                alert(res.message) ;
            }).fail(function (res) {
                enableContact();
                if(res.status == 422){
                    // alert('Error sending message. Missing input fields.')
                    swal("",'Error sending message. Missing input fields.', "error");
                    $.each(res.responseJSON, function (item) {
                        $("span[class="+item+"]").html(res.responseJSON[item][0])
                    })
                }else{
                    // alert('Error sending message. Please try again.')
                    swal("",'Error sending message. Missing input fields.', "error");

                }
            })
        })
    })

    AOS.init();

    $('.video-close').click(function(){
        $('#video-content').get(0).pause();
    })

</script>

@if(!Auth::guest())
@if (Auth::user()->first_login == 0)
    <script>
        $(document).ready(function() {
            $('#welcome').modal('show');
            $('#welcome').show();
        });
    </script>
@endif
    @endif
@stack('style')
@stack('page-trigger')

</html>