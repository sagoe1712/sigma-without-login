@extends('layouts.main')
@section('content')

    <?php
    $company_id = env('COMPANY_ID');
    $cs =  DB::table('setting')
        ->where('company_id', '=', $company_id)
        ->first();

    ?>

    @if(!Auth::guest())
        <input type="hidden" class="login-status" value = "1">
    @else
        <input type="hidden" class="login-status" value = "0">
    @endif

    <div ng-app="food_app" ng-controller="mealsController">
        <div class="take-out-container">
            <div class="meal-slider-container">
                <img src="{{$restaurant->data->banner}}" width="100%" />
            </div>
        </div>
        <div class="takeout-check-container">
            <div class="delivery-details-container">
                <div class="row">
                    <div class="col-12 col-md-2">
                        <img style="height: 80px;" src="https://food-server.nairabox.com/uploads/{{$restaurant->data->logo}}" alt="">
                    </div>
                    <div class="col-12 col-md-10">
                        <h5>{{$restaurant->data->name}}</h5>
                        <div class="row">
                            <div class="col-9 col-md-4">
                                <i class="fa fa-map-marker" aria-hidden="true">
                                    <span class="address-span"> {{$restaurant->data->address}}</span>
                                </i>
                            </div>
                            <div class="col-3 col-md-4">
                                <i class="fa fa-clock-o" aria-hidden="true">
                                    <span class="address-span">Weekdays: {{ $restaurant->data->openings->weekdays }}.</span>
                                    <span class="address-span">&nbsp;&nbsp; Weekends: {{ $restaurant->data->openings->weekends }}</span>
                                </i>
                            </div>
                            <div class="col-6 col-md-4">
                                <i class="fa fa-bus" aria-hidden="true">
                                    <span class="address-span">Estimated Delivery Time: {{ $restaurant->data->delivery }} minutes</span>
                                </i>
                            </div>
                            <div class="col-6 col-md-4">
                                <i class="fa fa-cutlery" aria-hidden="true">
                                    <span class="address-span">Cuisine:  @foreach($restaurant->data->cuisines as $index => $cuisine)
                                            <span>{{$cuisine->cuisine->name}}</span>@if($index < count($restaurant->data->cuisines) -1 ), @endif
                                        @endforeach</span>
                                </i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Lower div -->
            <div class="new-meals-container">
                <div class="row" ng-init="loadMeals()">
                    <div class="col-12 col-md-3 col-lg-3"  id="sidebar2" >
                        <div class="meals-column-div theiaStickySidebar">
                            <h6 style="font-weight: bold; color: white;">Categories</h6>
                            <div style="padding-top: 5%;" class="category-container2">
                                <div id="cat_nav">

                                    <a href="#@{{category.slug}}" class="active" ng-repeat="category in state.meals.data">
                                <span class="category-listing-con4">
                                    <p>@{{category.category_name}}</p>
                                    <img src="{{asset('images/new-meals-images/navigate.svg')}}" />
                                </span>
                                    </a>

                                    <a href="#@{{category.slug}}" class="active" ng-if="state.menu_error">
                                <span class="category-listing-con4" ng-if="state.menu_error">
                                    <p>@{{ state.error_message }}</p>
                                    <img src="{{asset('images/new-meals-images/navigate.svg')}}" />
                                </span>
                                    </a>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-5 col-lg-5">
                        <h6 style="color: white;">Menu</h6>

                        <input type="text" class="search_menu form-control" ng-model="search_input" placeholder="Search here...">

                        <div class="popular-products-container2">

                            <div class="">
                            <h5 id="" ng-if="state.menu_error">@{{ state.error_message }}</h5>
                            </div>
                            <div class="" ng-repeat="category in state.meals.data" id="@{{category.slug}}">



                                <h6>@{{category.category_name}}</h6>

                                <div class="p-products-description2" ng-repeat="meal in category.products | filter : search_input">
                                    <div class="row">
                                        <div class="col-4 col-md-3 col-lg-3">
                                            <div class="thumbs-container">
                                                <img src="@{{meal.image}}" alt="@{{meal.name}}">
                                            </div>
                                        </div>
                                        <div class="col-5 col-md-8 col-lg-8">
                                            <p>@{{meal.name}}</p>
                                            <p class="bold-text">@{{  state.appCurrencyFixed == 1 ? "&#8358;"+meal.amount : meal.amount + ' ' +state.appCurrency}}</p>
                                        </div>
                                        <div class="col-1 col-md-1 col-lg-1">
                                            <img class="add-icons-img" src="{{asset('images/new-meals-images/add2.svg')}}" alt="" ng-click="addToCart(meal.id)">
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>
                    <div style=""  id="sidebar" class="col-12 col-md-4 col-lg-4 theiaStickySidebar">
                        <h6 style="color: white;">Your Order</h6>
                        <div style="background-color: #F5FDFF;color:black" class="order-products-container2">
                            <div class="order-dtails-scroll">
                                <div class="order-p-details2" ng-repeat="item in state.cart track by $index">
                                    <div class="row">
                                        <div class="col-6 col-md-10 col-lg-10">
                                            <p class=" ellipses-class" title="@{{ item.name}}">@{{ item.name | limitTo:28 }}</p>

                                        </div>
                                        <div class="col-6 col-md-2 col-lg-2 text-right flexed-container">
{{--                                            <p class="amount">@{{  state.appCurrencyFixed == 1 ? "&#8358;"+item.amount : item.amount + ' ' +state.appCurrency}}</p>--}}
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-1 col-lg-1 flexed-container">
                                            <a href="">
                                                <img src="{{asset('images/new-meals-images/delete.svg')}}" ng-click="popFromCart(item.id)"/>
                                            </a>
                                        </div>
                                        <div class="col-6 col-md-7 col-lg-7">
                                            <p style="margin-left: -10px; font-size: 12px; color: red; cursor: pointer;" class="remove-text4" ng-click="popFromCart(item.id)">Remove</p>

                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4 text-right">
                                            <div class="tt-input-counter my-counter2 style-01">
                                                <span class="minus-btn" ng-click="reduceQty(item.id)"></span>
                                                <input type="text" value="@{{ item.qty }}" class="qty" size="5">
                                                <span class="plus-btn" ng-click="increaseQty(item.id)"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="order-p-details2">
                                <div class="row" ng-show="state.first_hide">
                                    <div class="col-6 col-md-5 col-lg-4">
                                        <p>Total</p>
                                    </div>
                                    <div class="col-6 col-md-8 col-lg-8">
                                        <p class="bold-text text-right costFood" ng-modal="state.delivery_details.cost_display" ng-show="state.first_hide">@{{  state.appCurrencyFixed == 1 ? "&#8358;"+state.cart_total  : state.cart_total  + ' ' +state.appCurrency}}</p>
                                    </div>
                                </div>
                            </div>
                            <hr style="margin-top: 2%; margin-bottom: 2%;">
                            <button data-toggle="modal" data-target="#ModalquickView" style="margin-bottom: 5%;" type="button" class="btn btn-default address-button">
                                CONTINUE

                            </button>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- <button data-toggle="collapse" data-target="#demo">Collapsible</button> -->

        <!-- modal (AddToCartProduct) -->
        <div class="statement-modal-container">
            <div class="modal  fade"  id="ModalquickView" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content edit-profile">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-order-summary">
                                <h6>Your Order Summary</h6>
                                <!-- Table -->
                                <div class="table-responsive-sm">
                                    <table style="text-align: left;"  class="table table-striped">
                                        <thead>
                                        <th>
                                            Product
                                        </th>
                                        <th>
                                            Quantity
                                        </th>
                                        <th>
                                            Price (Unit)
                                        </th>
                                        <th>
                                            Price (Total)
                                        </th>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="item in state.cart track by $index">
                                            <td>@{{ item.name}}</td>
                                            <td>@{{ item.qty }}</td>
                                            <td>@{{  state.appCurrencyFixed == 1 ? "&#8358;"+item.amount : item.amount }} <span class="sigma-green">@{{ state.appCurrency }}</span></td>
                                            <td>@{{  state.appCurrencyFixed == 1 ? "&#8358;"+item.amount : item.amount * item.qty}} <span class="sigma-green">@{{ state.appCurrency }}</span></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <!-- takeout delivery address -->
                                <div style="text-align: left;" class="takeout-address">
                                    <p>Enter your delivery address</p>
                                    <div class="edit-profile">
                                        <div class="row">

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="takeout-labels" for="firstname">First name:</label>
                                                    <input type="text" class="form-control" name="first_name" ng-model="state.delivery_details.first_name" ng-disabled="state.redeeming">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="lastname">Last name:</label>
                                                    <input type="email" class="form-control" name="last_name" ng-model="state.delivery_details.last_name" ng-disabled="state.redeeming">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="firstname">Phone Number:</label>
                                                    <input type="text" class="form-control" name="phone" ng-model="state.delivery_details.phone" ng-disabled="state.redeeming">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="lastname">Address:</label>
                                                    <input type="text" class="form-control" name="address" ng-model="state.delivery_details.address" ng-disabled="state.redeeming">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="firstname">Email Address:</label>
                                                    <input type="email" class="form-control" name="email" ng-model="state.delivery_details.email" ng-disabled="state.redeeming">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <label for="firstname">Delivery Note:</label>
                                                    <input type="text" class="form-control" name="instructions" ng-model="state.delivery_details.note" ng-disabled="state.redeeming">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">

                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <button ng-show="!state.ready_to_pay" class="btn btn-default address-button" ng-click="redeem()" style="margin-bottom: 5%;" title="Process delivery"> <i class="fa fa-spinner fa-spin process_indicator" ng-show="state.redeeming"></i> Process delivery</button>


                                            </div>
                                        </div>
                                        <hr style="margin: 0px;" />


                                        <div class="loaded-delivery-address">
                                            <p class="bold-text">Delivery address: </p>
                                            <p ng-modal="state.delivery_details.address_display" ng-show="state.costing">@{{ state.address }}</p>
                                        </div>
                                        <hr style="margin: 0px;" />
                                        <div class="takeout-grand-total">
                                            <div class="row">
                                                <div class="col-6 col-md-6 col-lg-6">
                                                    <p class="costFood" ng-modal="state.delivery_details.cost_display" ng-show="state.costing">Subtotal</p>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-6 text-right">
                                                    <p>@{{ state.costFood }}</p>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-6">
                                                    <p class="costDelivery" ng-modal="state.delivery_details.delivery_display" ng-show="state.costing">Delivery Price</p>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-6 text-right">
                                                    <p>@{{ state.costDelivery }}</p>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-6">
                                                    <h5 class="totalCost" ng-modal="state.delivery_details.total_display" ng-show="state.costing">Grand Total</h5>
                                                </div>
                                                <div class="col-6 col-md-6 col-lg-6 text-right">
                                                    <h5>@{{ state.totalCost }}</h5>
                                                </div>
                                            </div>
                                            <div class="button-container">
                                                <input type="hidden" name="costfood" ng-model="state.delivery_details.costfood" value="@{{ state.realcostFood }}">
                                                <input type="hidden" name="costdelivery" ng-model="state.delivery_details.cost_display" value="@{{ state.realcostDelivery }}" >
                                                <input type="hidden" name="totalcost" ng-model="state.delivery_details.delivery_display" value="@{{ state.realtotalCost }}">
                                                <input type="hidden" name="signature" ng-model="state.delivery_details.signature_display" value="@{{ state.signature }}">
                                                <input type="hidden" name="restaurant_name" ng-model="state.delivery_details.restaurant_name" id="restaurant_name" value="{{$restaurant->data->name}}">

                                                <button ng-show="state.ready_to_pay" class="btn" ng-click="placeOrder()" style="width: 95%; margin: 10px" title="Place Order"> <i class="fa fa-spinner fa-spin off process_indicator" ng-show="state.placeOrder"></i> Confirm Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('bootstrap')
    <link rel="stylesheet" href="{{asset('css/bootstrap3.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
@endpush
@push('script')
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script src="{{asset('js/angular-resource.min.js')}}"></script>
    <script src="{{asset('js/angular-animate.min.js')}}"></script>
    <script src="{{asset('js/alertui.min.js')}}"></script>
    <script src="{{asset('js/theia-sticky-sidebar.js')}}"></script>

    <script  src="{{asset('js/cat_nav_mobile.js')}}"></script>
    <script>$('#cat_nav').mobileMenu();</script>

    <script>
        jQuery('#sidebar').theiaStickySidebar({
            additionalMarginTop: 80
        });

        jQuery('#sidebar2').theiaStickySidebar({
            additionalMarginTop: 80
        });
    </script>
    <script>
        $(document).on('click', '#cat_nav a[href^="#"]', function (e) {
            console.log('catnav works')
            e.preventDefault();
            var target = this.hash;
            var $target = $(target);
            $('html, body').stop().animate({
                'scrollTop': $target.offset().top - 70
            }, 900, 'swing', function () {
                window.location.hash = target;
            });
        });
    </script>

    <script>

        $('body').addClass('tt-page-product-single meal-bg');

        $(document).ready(function() {
            $('.right-sidebar, .sidebar').theiaStickySidebar({
                // Settings
                additionalMarginTop: 50
            });
               // Smooth scroll
            var scrollLink = $('.menu_category');
            // console.log($(scrollLink[0].hash))
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
        var conversionRate = "<?php echo $cs->rate ;?>"
        var appCurrency = "<?php echo $cs->currency ;?>"
        var appCurrencyFixed = "<?php echo $cs->is_currency_fixed ;?>"

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

            $scope.increaseQty = function (id) {
                var exists = false;
                angular.forEach($scope.state.cart, function (product) {
                    if(product.id == id){
                        product.qty += 1;
                        $scope.state.cart_total += product.amount;
                        exists = true;
                    }
                });
            }

            $scope.reduceQty = function (id) {
                var exists = false;
                angular.forEach($scope.state.cart, function (product) {
                    if(product.id == id){
                        if(product.qty > 1) {
                            product.qty -= 1;
                            $scope.state.cart_total -= product.amount;
                        }
                        exists = true;
                    }
                });
            }

        $scope.addToCart = function (id) {

            var login = $('.login-status').val();

            if(login == 0){
                location.replace('{{url("login")}}');
                return false;
            }

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
