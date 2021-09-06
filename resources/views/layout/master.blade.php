<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Owl Carousel main css -->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="{{asset('assets/css/core.css')}}">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="{{asset('assets/css/shortcode/shortcodes.css')}}">
    <!-- Theme main style -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    <!-- User style -->
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/datatable.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/alertui.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/loading.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/loading-btn.css')}}">
    <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    {{--<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>--}}
    @stack('styles')

    <!-- Modernizr JS -->
    <script src="{{asset('assets/js/vendor/modernizr-2.8.3.min.js')}}"></script>
</head>

<body>
@include('partials.homenav')
@yield('content')
<!-- jquery latest version -->
<script src="{{asset('assets/js/vendor/jquery-1.12.0.min.js')}}"></script>
<!-- Bootstrap framework js -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- All js plugins included in this file. -->
<script src="{{asset('assets/js/plugins.js')}}"></script>
<script src="{{asset('assets/js/slick.min.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>

@stack('scripts')
<!-- Waypoints.min.js. -->
<script src="{{asset('assets/js/waypoints.min.js')}}"></script>

<!-- Main js file that contents all jQuery plugins activation. -->
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>

</body>

</html>