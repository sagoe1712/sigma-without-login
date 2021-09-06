@extends('layouts.main')
@section('content')
    <div id="tt-pageContent">
        <div class="meal-slider-container">
            <div class="centered bills-and-airtime">
                <h2>
                    Pay for your Airtime & Bills
                </h2>
                <p>Select a Bill or Airtime Vendor to load available vouchers for the selected vendor</p>
            </div>
            <img src="{{asset('images/bill-images/bill_banner.png')}}" width="100%" />
        </div>
        <div class="cinema-container">

            @if(isset($categories))
                @if($categories->status == 1)

                    @foreach($categories->data[0]->child_menu as $item)
            <div class="new-bills-container">
                <h4>{{ucwords(strtolower($item->name))}}</h4>
                <hr style="margin-top: 0px !important; margin-bottom: 20px !important;" />
                <div class="row">
                    @foreach($item->category as $sub_item)
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="bill-image-container">
                            <a href="{{url('bills', ['id' => $sub_item->id])}}">
                                <img src="{{$sub_item->image}}" width="100%" alt="{{$sub_item->name}}" />
                            </a>
                        </div>

                        <p>{{ucwords($sub_item->name)}}</p>
                    </div>
                    @endforeach

                </div>
            </div>
                    @endforeach

                @endif
            @endif





        </div>

    </div>

@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
  <style>

    </style>
@endpush
@push('script')
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>
@endpush
