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




@yield('content')

<a href="#" class="tt-back-to-top">BACK TO TOP</a>

@include('partials.general.footer')

<div class="modal fade" id="welcome" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="background-color: transparent !important;">
        <div class="modal-content" style="background-color: transparent !important; border: none !important; text-align: right; position:absolute;">

            <div class="modal-body" style="text-align: center; padding-top: 80px; background-color: transparent !important;">

                <br>
                <a href="#"><img src="{{asset('images/welcome.jpg')}}" class="popup-img" style="max-width: 100%;"></a>
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
@if($errors->any())
    @include('partials.notify', ['text' => $errors->first()])


@endif

<script>

    $(window).on('load', function() {
        $('#sigma-preloader').fadeOut();
        $('#preloader').delay(350).fadeOut('slow');
        $('body').delay(350).css({'overflow':'visible'});
    })

    $(".overlay, .close_overlay").click(function(){
        $(this).hide();
    });

    grecaptcha.ready(function() {
        grecaptcha.execute('6Ld3yIwUAAAAAIOLlI-WpMeVFQob8fxWqXWq5cQz', {action: 'sigma'})
            .then(function(token) {
                $('#cpkt').val(token);
            });
    });


    AOS.init();

</script>
@stack('script')
</html>