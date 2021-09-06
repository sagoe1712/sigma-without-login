var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        'theme/bootstrap.min.css',
        'theme/bootstrap-grid.min.css',
        'theme/bootstrap-reboot.min.css',
        'theme/slick.css',
        'theme/slick-style.css',
        'theme/animate.min.css',
        'theme/colors/blue.css',
        '../newtemplate/css/style.css',
        '../newtemplate/css/color-three.css',
        '../newtemplate/css/custom-animation.css',
        '../newtemplate/css/responsive.css',
        'alertui.min.css',
        'hover-min.css',
        '../../../node_modules/@chenfengyuan/datepicker/dist/datepicker.min.css'
    ], 'public/assets/css')
        .browserify('app.js')
        .scripts([
        'theme/jquery.min.js',
        'theme/tether.min.js',
        'theme/bootstrap.min.js',
        'theme/jquery-migrate.min.js',
        'theme/jquery-ui.min.js',
        'theme/hidemaxlistitem.min.js',
        'theme/jquery.easing.min.js',
        'theme/scrollup.min.js',
        'alertui.min.js',
        'theme/jquery.waypoints.min.js',
        'theme/waypoints-sticky.min.js',
            '../../../node_modules/@chenfengyuan/datepicker/dist/datepicker.min.js',
        'theme/pace.min.js',
        'theme/slick.min.js',
        'theme/scripts.js',
    ],'public/js/main.js')
        .scripts([
            '../newtemplate/vendor/jquery.2.2.3.min.js',
            '../newtemplate/vendor/popper.js/popper.min.js',
            '../newtemplate/vendor/bootstrap/js/bootstrap.min.js',
            '../newtemplate/vendor/language-switcher/jquery.polyglot.language.switcher.js',
            '../newtemplate/vendor/jquery.appear.js',
            '../newtemplate/vendor/jquery.countTo.js',
            '../newtemplate/vendor/fancybox/dist/jquery.fancybox.min.js',
            '../newtemplate/vendor/owl-carousel/owl.carousel.min.js',
            '../newtemplate/vendor/aos-next/dist/aos.js',
            '../newtemplate/vendor/roadmap/jquery.roadmap.js',
            '../newtemplate/js/theme.js'
        ],'public/js/landing.js');
});