<div class="theme-top-section">
    @include('partials.newnav')

    <!-- ^^^^^^^^^^^^^^^^^ Theme Banner ^^^^^^^^^^^^^^^ -->
    <div id="theme-banner" class="theme-banner-three">
        <img src="{{ asset('images/shape/16.png ') }}" alt="" class="shape-one">
        <img src="{{ asset('images/shape/17.png ') }}" alt="" class="shape-two">
        <img src="{{ asset('images/shape/19.png ') }}" alt="" class="shape-four">
        <div class="container">
            <div class="main-text-wrapper">
                <h1 style="color: #00d0dd;">LSL Rewards.</h1>
                <h1 class="text-white mt-2">The only place to <br> redeem rewards.</h1>
                <p>Collect points from purchases at any of our store <br> and benefit from our wide range of curated items</p>
                <ul class="button-group clearfix mt-4">
                    <li><a href="#">Learn more</a></li>
                    <li>
                        <div class="btn-group">
                            <a href="{{url('catalogue')}}" class="download-button">Start Shopping Now</a>
                        </div>
                    </li>
                </ul>
                <img src="{{ asset('images/shape/18.png') }}" alt="" class="shape-three">
                <img src=" {{ asset('images/icon/3.png') }}" alt="" class="shape-five">
            </div>
        </div>
    </div> <!-- /.theme-banner-three -->
</div>