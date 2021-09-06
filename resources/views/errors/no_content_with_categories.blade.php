@extends('layouts.main')
@push('catalogue-nav')
    @include('partials.general.catalogue-nav')
@endpush
@section('content')
    <div class="body-content outer-top-vs" id="top-banner-and-menu">
    <div class="container" style="margin-top: 2em; margin-bottom: 10em; text-align: center;">
            <div class="row" style="text-align: center;">
{{--                @include('partials.sigma.catalogue.sidebar')--}}
                <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
            <img class="text-center" alt="" src="{{asset('images/not_found.png')}}" style="width: 200px;">
            <h3 class="text-center">No content found</h3>
            <h4 class="text-center">We currently do not have content for the selected category. Check again soon.</h4>
        </div>
        </div>

    </div>
    </div>
@endsection

@push('style')

@endpush