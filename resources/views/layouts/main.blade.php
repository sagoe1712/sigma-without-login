<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}} @if(isset($title)) - {{$title}}@endif</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon"/>

    <!-- CSS Style -->
    @stack('bootstrap')
    <link rel="stylesheet" href="{{asset('css/theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main_style.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }


    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151439902-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-151439902-1');
    </script>


    @stack('style')

</head>
<body>
<div id="preloader">
    <div id="sigma-preloader">&nbsp;</div>
</div>
</div>
@if(isset($errors))
@if($errors->any())
    @include('partials.notify', ['text' => $errors->first()])
@endif
@endif
    @include('partials.general.inner-header')

                    @yield('content')

@include('partials.general.footer')
<script src="{{asset('external/jquery/jquery.min.js')}}"></script>
<script src="{{asset('external/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('external/slick/slick.min.js')}}"></script>
<script src="{{asset('external/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('external/panelmenu/panelmenu.js')}}"></script>
<script src="{{asset('external/instafeed/instafeed.min.js')}}"></script>
<script src="{{asset('external/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('external/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
<script src="{{asset('external/countdown/jquery.plugin.min.js')}}"></script>
<script src="{{asset('external/countdown/jquery.countdown.min.js')}}"></script>
<script src="{{asset('external/lazyLoad/lazyload.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<!-- form validation and sending to mail -->
<script src="{{asset('external/form/jquery.form.js')}}"></script>
<script src="{{asset('external/form/jquery.validate.min.js')}}"></script>
<script src="{{asset('external/form/jquery.form-init.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('#frmsearch').submit(function(event) {

            event.preventDefault(); //this will prevent the default submit
            if($('.txtsearch').val().length < 3){

                swal("",'Search Character Less than 3 letters', "error");

                return false;

            }else {

                // your code here (But not asynchronous code such as Ajax because it does not wait for response and move to next line.)

                $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
            }
        })


        $(window).on('load', function() {
            $('#sigma-preloader').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
            $('body').delay(350).css({'overflow':'visible'});
        })

        $(".overlay, .close_overlay").click(function(){
            $(this).hide();
        })


        var baseUrl = "<?php echo config('app.base_url')?>";
        //Configure Ajax
        $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
            var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
            }
        });

    </script>
@stack('script')
</body>
</html>