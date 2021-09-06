@extends('layouts.main')
@section('content')
    <div class="body-content food_page" ng-app="food_app" ng-controller="mealsController">


        <div class="banner">

            <div class=''>
                <div id="category" class="category-carousel">
                    <div class="item">
                        <div class="image"> <img src="{{$restaurant->data->banner}}" alt="" class="img-responsive"> </div>
                    </div>
                </div>
            </div>

            <div class="container" style="padding-bottom: 10rem;">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                                {{--<pre>--}}
                                        {{--@php(var_dump($restaurant))--}}
                                    {{--</pre>--}}
                            <div class="col-sm-12 restaurant_container">
                                <div class="logo_container">
                                        <img src="https://food-server.nairabox.com/uploads/{{$restaurant->data->logo}}" alt="" class="img-responsive" style="">
                                </div>
                                <div class="content_container">{{$restaurant->data->name}}</h4>
                                    <p class="rt-10"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$restaurant->data->address}}</p>
                                    <p class="rt-10"><i class="fa fa-clock-o" aria-hidden="true"></i>  Weekdays : {{ $restaurant->data->openings->weekdays }} , Weekends:  {{ $restaurant->data->openings->weekends }} </p>
                                    <p class="rt-10"><i class="fa fa-cutlery" aria-hidden="true"></i>  Cuisines:
                                        @foreach($restaurant->data->cuisines as $index => $cuisine)
                                            <span>{{$cuisine->cuisine->name}}</span>@if($index < count($restaurant->data->cuisines) -1 ), @endif
                                            @endforeach
                                    </p>
                                    <p><i class="fa fa-truck" aria-hidden="true"></i>  Estimated Delivery Time : {{ $restaurant->data->delivery }} Minutes</p>
                                </div>
                            </div>
                            </div>

                        <div class="row" ng-init="loadMeals()">
                        <div class="col-sm-4 restaurant_categories sidebar">
                            <div class="side-menu animate-dropdown outer-bottom-xs">
                                <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
                                <nav class="yamm megamenu-horizontal">
                                    <ul class="nav">
                                                    <li class="dropdown menu-item" ng-repeat="category in state.meals.data">
                                                        <a title="" href="#@{{category.slug}}" class="menu_category">@{{category.category_name}}</a>
                                                    </li>

                                                        <li class="dropdown menu-item" ng-if="state.menu_error">
                                            <a title="" href="#"><span ng-if="state.menu_error">@{{ state.error_message }}</span></a>
                                                        </li>
                                        </li>
                                    </ul>
                                    <!-- /.nav -->
                                </nav>
                                <!-- /.megamenu-horizontal -->
                            </div>
                        </div>

                        <div class="col-sm-8 restaurant_menu">
                            <input type="text" class="search_menu" ng-model="search_input" placeholder="Search here...">
                            <div class="restaurant_menu_container">
                            <div class="restaurant_menu_head">
                            menu
                            </div>
                            <div class="restaurant_menu_body">
                                <h5 ng-if="state.menu_error">@{{ state.error_message }}</h5>
                           <div ng-repeat="category in state.meals.data" id="#@{{category.slug}}">
                            <h4 >@{{category.category_name}}</h4>
                                <div class="meal_item mover" ng-repeat="meal in category.products | filter : search_input">
                                    <div>
                                    <h4>@{{meal.name}}</h4>
                                    <p>@{{  state.appCurrencyFixed == 1 ? "&#8358;"+meal.amount : meal.amount + ' ' +state.appCurrency}}</p>
                                    </div>
                                    <div>
                                        <i class="fa fa-plus-circle" aria-hidden="true" ng-click="addToCart(meal.id)"></i>
                                    </div>
                                </div>
                           </div>

                            </div>
                            </div>
                        </div>
                        </div>
                    <div>

                    </div>
                    </div>

                    <div class="col-sm-4 right-sidebar">
                    <div class="cart_container">
                    <div class="cart_header custom_bg_color">
                        Your Order
                    </div>
                        <div class="cart_body">
                            <div class="cart_item mover" ng-repeat="item in state.cart track by $index">
                            <i class="fa fa-trash" ng-click="popFromCart(item.id)"></i>
                                <p title="@{{ item.name}}">@{{ item.name | limitTo:28 }} <span class="qty">x@{{ item.qty }}</span></p>
                                <p class="amount">@{{  state.appCurrencyFixed == 1 ? "&#8358;"+item.amount : item.amount + ' ' +state.appCurrency}}</p>

                            </div>
                        </div>
                        <div class="cart_footer" ng-class="">
                            <span ng-show="state.first_hide">Total: </span>
                            <span ng-show="state.first_hide">@{{  state.appCurrencyFixed == 1 ? "&#8358;"+state.cart_total  : state.cart_total  + ' ' +state.appCurrency}}</span>

                            <div ng-if="state.cart.length">
                                <hr>
                                <div>
                                    <h4 style="text-align: left">Delivery details</h4>
                                    <form action="">
                                        <div class="form-group">
                                        <input type="text" name="first_name" class="form-control" placeholder="First Name" ng-model="state.delivery_details.first_name" ng-disabled="state.redeeming">
                                            <br>
                                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" ng-model="state.delivery_details.last_name" ng-disabled="state.redeeming">
                                            <br>
                                        <input type="text" name="address" class="form-control" placeholder="Delivery address" ng-model="state.delivery_details.address" ng-disabled="state.redeeming">
                                            <br>
                                        <input type="text" name="phone" class="form-control" placeholder="Phone number" ng-model="state.delivery_details.phone" ng-disabled="state.redeeming">
                                            <br>
                                            <input type="email" name="email" class="form-control" placeholder="Email address" ng-model="state.delivery_details.email" ng-disabled="state.redeeming">
                                            <br>
                                        <input type="text" name="instructions" class="form-control" placeholder="Delivery note" ng-model="state.delivery_details.note" ng-disabled="state.redeeming">

                                            <input type="hidden" name="costfood" ng-model="state.delivery_details.costfood" value="@{{ state.realcostFood }}">
                                            <input type="hidden" name="costdelivery" ng-model="state.delivery_details.cost_display" value="@{{ state.realcostDelivery }}" >
                                            <input type="hidden" name="totalcost" ng-model="state.delivery_details.delivery_display" value="@{{ state.realtotalCost }}">
                                            <input type="hidden" name="signature" ng-model="state.delivery_details.signature_display" value="@{{ state.signature }}">
                                            <input type="hidden" name="restaurant_name" ng-model="state.delivery_details.restaurant_name" id="restaurant_name" value="{{$restaurant->data->name}}">

                                        </div>
                                        <div class="foodCartSummary">
                                            <h5 class="costFood" ng-modal="state.delivery_details.cost_display" ng-show="state.costing" style="text-align: left">Total Food Cost:<b style="float: right">@{{ state.costFood }}</b></h5>
                                            <h5 class="costDelivery" ng-modal="state.delivery_details.delivery_display" ng-show="state.costing" style="text-align: left">Total Delivery Fee:<b style="float: right">@{{ state.costDelivery }}</b></h5>

                                            <p ng-modal="state.delivery_details.address_display" ng-show="state.costing"><i>Delivery Address: </i>@{{ state.address }}</p>
                                            <h2 class="totalCost" ng-modal="state.delivery_details.total_display" ng-show="state.costing" style="text-align: left">Total:<b style="float: right">@{{ state.totalCost }}</b></h2>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <button ng-show="!state.ready_to_pay" class="btn custom_button_color pd_btn btn_food" ng-click="redeem()" style="width: 95%; margin: 10px" title="Process delivery"> <i class="fa fa-spinner fa-spin process_indicator" ng-show="state.redeeming"></i> Process delivery</button>

                        <button ng-show="state.ready_to_pay" class="btn custom_button_color pd_btn btn_food" ng-click="placeOrder()" style="width: 95%; margin: 10px" title="Place Order"> <i class="fa fa-spinner fa-spin off process_indicator" ng-show="state.placeOrder"></i> Confirm Order</button>
                    </div>
                    </div>
                </div>
            </div>
    </div>
    </div>

@endsection
@push('script')
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script src="{{asset('js/angular-resource.min.js')}}"></script>
    <script src="{{asset('js/angular-animate.min.js')}}"></script>
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>

    <script>

        $('body').addClass('tt-page-product-single meal-bg');

        $(document).ready(function() {
            $('.right-sidebar, .sidebar').theiaStickySidebar({
                // Settings
                additionalMarginTop: 50
            });
               // Smooth scroll
            var scrollLink = $('.menu_category');
            console.log($(scrollLink[0].hash))
            //Scroll Animation Effect
            scrollLink.on('click', function (e) {
                console.log($(this.hash))
                e.preventDefault()
                $('body, html').animate({
                    scrollTop: $(this.hash).offset().top - 50
                }, 500)
            })
        });


        var baseUrl = "<?php echo config('app.base_url')?>";
        var conversionRate = "<?php echo Auth::user()->currency->rate ;?>"
        var appCurrency = "<?php echo Auth::user()->currency->currency ;?>"
        var appCurrencyFixed = "<?php echo Auth::user()->currency->is_currency_fixed ;?>"

        var id = "<?php echo $id ?>";
        var food_app = angular.module('food_app', ['ngAnimate']);

        food_app.controller('mealsController', ['$scope', '$log','$http', function($scope, $log, $http){

        $scope.state = {
            error_message: 'No Menu available',
            menu_error: false,
            meals: [],
            meals_bag: [],
            cart: [],
            cart_total: 0,
            search_input: '',
            conversionRate: conversionRate,
            appCurrency: appCurrency,
            appCurrencyFixed: appCurrencyFixed,
            redeeming: false,
            costing: false,
            first_hide: true,
            ready_to_pay: false,
            costFood: '',
            costDelivery: '',
            totalCost: '',
            realcostFood: '',
            realcostDelivery: '',
            realtotalCost: '',
            signature: '',
            address: '',
            delivery_details: {
                first_name: '',
                last_name: '',
                address: '',
                email: '',
                note: '',
                phone: '',
                signature_display: '',
                address_display: '',
                cost_display: '',
                delivery_display: '',
                total_display: '',
                restaurant_name:''
            }
        }

        $scope.loadMeals = function () {
            $scope.state.menu_error = false;
            $http.get("{{url('api')}}"+'/food/restaurant/'+id+'/food')
                .then(function (res) {
                        $scope.state.menu_error = false;
                        $scope.state.meals_bag = res.data;
                        $scope.state.meals = res.data;
                        alertui.notify('success', 'Meals loaded')

                    },
                    function (res) {
                        $scope.state.menu_error = true;
                        alertui.notify('error', 'Sorry! No menu available for selected restaurant')
                        swal("",'Sorry! No menu available for selected restaurant.', "error");
                    })
        }

        $scope.addToCart = function (id) {
            var exists = false;
            angular.forEach($scope.state.cart, function (product) {
                if(product.id == id){
                    product.qty += 1;
                    $scope.state.cart_total += product.amount;
                    exists = true;
                }
            });


            if(!exists) {
                angular.forEach($scope.state.meals.data, function (item) {
                    angular.forEach(item.products, function (product) {
                        if (product.id == id) {
                            var cart_item = {};
                            cart_item.id = product.id;
                            cart_item.name = product.name;
                            cart_item.amount = product.amount;
                            // cart_item.display_amount = $scope.state.appCurrencyFixed == 1 ? "&#8358;"+product.amount : product.amount + ' ' +$scope.state.appCurrency;
                            cart_item.qty = 1;
                            $scope.state.cart.push(cart_item);
                            $scope.state.cart_total += product.amount;
                        }
                    })
                });
            }

        }

        $scope.popFromCart = function (id) {
            var index;

            angular.forEach($scope.state.cart, function (product, i) {
                if(product.id == id){
                   index = i;
                    $scope.state.cart_total -= product.amount * product.qty;
                }
            });
            $scope.state.cart.splice(index, 1);
        }

        $scope.cartEmpty = function () {
            if($scope.cart.length == 0){
                return true;
            }else{
                return false;
            }
        }


        $scope.redeem = function () {
            var payload = {
                address:$scope.state.delivery_details.address,
                delivery_instruction:$scope.state.delivery_details.note,
                email:$scope.state.delivery_details.email,
                phone_no:$scope.state.delivery_details.phone,
                restaurant_id: id,
                cart:$scope.state.cart
            };

            $scope.state.redeeming = true;
            $http.post("{{url('api')}}"+'/food/price', payload)
                .then(function (res) {

                       // $scope.state.redeeming = false;
                        $scope.state.ready_to_pay = true;
                        $scope.state.costing = true;
                        $scope.state.first_hide = false;


                        $scope.state.costFood =  res.data.data.data.con_sub_total;
                        $scope.state.costDelivery = Math.ceil(res.data.data.data.con_delivery_price);
                        $scope.state.totalCost = Math.ceil(res.data.data.data.con_price);
                    $scope.state.realcostFood =  res.data.data.data.sub_total;
                    $scope.state.realcostDelivery = res.data.data.data.delivery_price;
                    $scope.state.realtotalCost = res.data.data.data.price;
                        $scope.state.address = res.data.data.data.address;
                        $scope.state.signature = res.data.data.data.signature;


                      //  $scope.state.redeeming = false;
                      //  $scope.state.ready_to_pay = true;
                        //alertui.alert('Success', 'Transaction successful');
                    },
                    (err)=>{
                    // console.log(err)
                        swal("",err.data.message, "error");
            $scope.state.redeeming = false;
            $scope.state.ready_to_pay = false;
            $scope.state.costing = false;
            $scope.state.first_hide = true;
            return false;
                    })
                .done(function (res) {

                        if(res.status === 400){
                            if(res.data.status) {
                                if (res.data.status == 'validation') {
                                    $scope.state.redeeming = false;
                                    alertui.alert('Error', res.message);
                                    swal("",res.data.message, "error");
                                    return false;
                                }
                            }
                            alertui.alert('Error', res.data.message);
                            swal("",res.data.message, "error");
                            return false;
                        }

                        $scope.state.redeeming = false;
                        alertui.alert('Error', 'Sorry! Transaction failed. Try again.')
                    swal("",'Sorry! Transaction failed. Try again.', "error");
                    })
        }

            $scope.placeOrder = function () {
                var payload = {

                    first_name:$scope.state.delivery_details.first_name,
                    last_name:$scope.state.delivery_details.last_name,
                    price:$scope.state.realtotalCost,
                    signature:$scope.state.signature,
                    email:$scope.state.delivery_details.email,
                    phone_no:$scope.state.delivery_details.phone,
                    delivery_price:$scope.state.costDelivery,
                    //restaurant_name:$scope.state.delivery_details.restaurant_name
                    restaurant_name:$('#restaurant_name').val()

                };

                $scope.state.redeeming = true;
                $http.post("{{url('api')}}"+'/food/redeem', payload)
                    .then(function(res){
                        $scope.state.redeeming = false;

                        if(res.data.status == 200) {
                            updateAccount(res.data.account)
                            alertui.notify('success', res.data.message);
                            swal("Takeout Redemption",res.data.message, "success");
                            // console.log(res.data.data);
                            window.location.replace("{{url('ordercomplete')}}/"+res.data.data)
                        }else if(res.data.status == 400){
                            if(res.data.status) {
                                if (res.data.status == 'validation') {
                                    alertui.alert('Error', res.data.message);
                                    swal("",res.data.message, "Error");
                                    return false;
                                }
                            }
                            alertui.alert('Error', res.data.message);
                            swal("",res.data.message, "error");
                            return false;
                        }

                    })
                    .done(function (res) {
                            // $scope.state.redeeming = false;
                            // $scope.state.ready_to_pay = true;


                           // alertui.alert('Success', 'Transaction successful <br> Your Voucher Number is ' + res.data.data.voucher_code);

                            // window.location.reload();

                            if(res.data.status == 200) {
                                updateAccount(res.account)
                                alertui.notify('success', res.data);
                                swal("Takeout Redemption",res.data, "success");

                                // console.log(res.data.data);
                              window.location.replace("{{url('ordercomplete')}}/"+res.data.data)
                            }else if(res.status == 400){
                                if(res.data.status) {
                                    if (res.data.status == 'validation') {
                                        alertui.alert('Error', res.data.message);
                                        swal("",res.data.message, "error");
                                        return false;
                                    }
                                }
                                alertui.alert('Error', res.data.message);
                                swal("",res.data.message, "error");
                                return false;
                            }

                        })
            }
        }]);
    </script>
@endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">
    <style>
        .low_light{
            opacity: 0.5;
        }
    .pay_btn{
        width: 100%;
        margin-top: 20px;
    }
    .fa-trash{
        cursor: pointer;
    }
        .restaurant_container{
            height: 207px;
            min-height: 207px;
            max-height: 207px;
            background: #fff;
            margin-bottom: 2rem;
            padding: 20px;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            flex:1;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
        }
        
        .restaurant_menu_container{
            background: #fff;
            -webkit-border-radius: 10px 10px 0 0;
            -moz-border-radius: 10px 10px 0 0;
            border-radius: 10px 10px 0 0;
            margin-top: 1rem;
        }

        .restaurant_menu .restaurant_menu_head{
            background: #45a6c4;
            text-align: left;
            text-transform: uppercase;
            padding: 10px 30px;
            font-size: 22px;
            color: #fff;
            -webkit-border-radius: 10px 10px 0 0;
            -moz-border-radius: 10px 10px 0 0;
            border-radius: 10px 10px 0 0;
            margin-top: 1rem;
        }
        .restaurant_menu_body{
            padding: 20px
        }

        .restaurant_menu_body .meal_item{
            display: flex;
            justify-content: space-between;
        }        
        
        .restaurant_menu_body .meal_item h4{
            color: #45a6c4;
            border-bottom: transparent;
            padding-bottom: 0;
        }
        .restaurant_menu_body .meal_item i{
            color: #45a6c4;
            font-size: 20px;
            cursor: pointer;
        }
        .restaurant_menu_body h4{
            color: #A2C61E;
            border-bottom: 1px solid #f2f3f7;
            padding-bottom: 20px;
        }
        .restaurant_container .logo_container{
            width: 30%;
            height: 150px;
            max-height: 150px;
            /*background: #F2F3F7;*/
        }
        .restaurant_container .logo_container img{
            width: 150px;
            max-width: 150px;
            max-height: 150px;
            /*background: #F2F3F7;*/
        }
        .restaurant_container .content_container{
            width: 70%;
            margin-left: 0.9rem;
        }

        .cart_container{
            min-height: 100px;
            background: #fff;
            margin-bottom: 2rem;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
        }
        .cart_container .cart_header{
            padding: 10px;
            text-align: center;
            font-size: 22px;
            -webkit-border-radius: 10px 10px 0 0;
            -moz-border-radius: 10px 10px 0 0;
            border-radius: 10px 10px 0 0;
        }
        .cart_container .cart_footer{
            padding: 20px;
            text-align: right;
            font-size: 18px;
            border-bottom: 1px solid #ccc;
        }

        .nav{
            padding: 0px;
        }

        h4.ng-binding{
            padding-bottom: 10px !important;
        }
        p{
            margin: 0px;
        }
        .cart_container .cart_body{
            padding: 20px;
            border-bottom: 1px solid #ccc;
            -webkit-transition: all 0.9s;
            -moz-transition: all 0.9s;
            -ms-transition: all 0.9s;
            -o-transition: all 0.9s;
            transition: all 0.9s;
        }

        .cart_container .cart_item{
            padding: 10px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .cart_container .cart_item .qty{
        font-size: 16px;
        }
        .restaurant_menu .search_menu{
            background: #fff;
            padding: 10px 40px;
            height: 50px;
            width: 100%;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            text-indent: 5px;
            border-color: transparent;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;

        } .restaurant_menu .search_menu:focus{
              outline-color: transparent;
              outline-width: 0px;

          }
        .mover{
            -webkit-transition: 400ms cubic-bezier(.42,0,.58,1) all;
            -moz-transition: 400ms cubic-bezier(.42,0,.58,1) all;
            -ms-transition: 400ms cubic-bezier(.42,0,.58,1) all;
            -o-transition: 400ms cubic-bezier(.42,0,.58,1) all;
            transition: 400ms cubic-bezier(.42,0,.58,1) all;
            -moz-transform: translateY(0px);
            -webkit-transform: translateY(0px);
            -o-transform: translateY(0px);
            -ms-transform: translateY(0px);
            transform: translateY(0px);
        }
        .mover.ng-enter.ng-enter-active {
            opacity: 1;
            -moz-transform: translateY(0px);
            -webkit-transform: translateY(0px);
            -o-transform: translateY(0px);
            -ms-transform: translateY(0px);
            transform: translateY(0px);
        }
        .mover.ng-enter {
            opacity: 0;
            -moz-transform: translateY(-7px);
            -webkit-transform: translateY(-7px);
            -o-transform: translateY(-7px);
            -ms-transform: translateY(-7px);
            transform: translateY(-7px);
        }

        .mover.ng-leave.ng-leave-active {
            opacity: 0;
            -moz-transform: translateY(70px);
            -webkit-transform: translateY(70px);
            -o-transform: translateY(70px);
            -ms-transform: translateY(70px);
            transform: translateY(70px);
        }
        .mover.ng-leave {
            opacity: 1;
            -moz-transform: translateY(0px);
            -webkit-transform: translateY(0px);
            -o-transform: translateY(0px);
            -ms-transform: translatey(0px);
            transform: translateY(0px);
        }

        .rt-10{
            margin: 10px 0px;
        }
    </style>
@endpush