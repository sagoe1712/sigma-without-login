@extends('layouts.main')
@section('content')

    <div ng-app="food_app" ng-controller="filterController">
    <div class="take-out-container">
        <div class="meal-slider-container">
            <div class="centered">
                <h2>
                    Redeem Delicious Meal Today And Get Them Delivered To Your Doorstep
                </h2>
            </div>
            <img src="{{asset('images/meal-images/takeoutbanner.png')}}" width="100%" />
        </div>
        <div class="search-restaurant-container">
            <div class="row">
                <div class="col-6 col-md-5 modal-form-container">
                    <div class="">

                        <select name="filter_state"  class="form-control" ng-init="loadStates()" ng-model="restaurant_state" ng-change="findCities()">
                            <option value="" selected="selected">Select State</option>
                            <option ng-repeat="(index, state) in states" value="@{{ state._id }}" ng-selected="@{{$first == 1}}">
                                @{{ state.name }}
                            </option>
                        </select>
                        <label class="take-out-label" for="filter_state">State:</label>
                    </div>
                </div>
                <div class="col-6 col-md-5 modal-form-container">
                    <div class="">

                        <select class="form-control" name="filter_city" ng-model="city">
                            <option value="" selected="selected">Select City</option>
                            <option ng-repeat="(index, city) in cities" value="@{{ city._id }}" ng-selected="@{{$first == 1}}">
                                @{{ city.name }}
                            </option>
                        </select>
                        <label class="take-out-label" for="filter_city">City:</label>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <button style="width: 100%;" type="button" class="btn btn-primary btn-lg" ng-click="findRestaurant()" ng-disabled="searching_restaurants || searching" id="search_restaurant">
                        <i ng-show="searching_restaurants" class="fa fa-spinner fa-spin process_indicator"></i> Search
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div id="tt-pageContent">
        <div class="five-star-container">
            <h2 ng-show="!loaded_newrestaurants" style="margin-bottom: 3%;">Featured Restaurants</h2>
            <h2 ng-show="loaded_newrestaurants" style="margin-bottom: 3%;">Restaurants</h2>

            <div class="row tt-layout-product-item" ng-show="loading_restaurants">

                <div class="placeholder col-6 col-md-4 col-lg-3">
                    <div class="animated-background"></div>
                </div>

                <div class="placeholder col-6 col-md-4 col-lg-3">
                    <div class="animated-background"></div>
                </div>


                <div class="placeholder col-6 col-md-4 col-lg-3">
                    <div class="animated-background"></div>
                </div>

                <div class="placeholder col-6 col-md-4 col-lg-3">
                    <div class="animated-background"></div>
                </div>

            </div>

            <div class="row tt-layout-product-item ng-cloak"  ng-show="loaded_newrestaurants" id="restaurants">

                <div class="col-6 col-md-4 col-lg-3"  ng-repeat="item in restaurants">
                    <div class="tt-product thumbprod-center">
                        <div class="tt-image-box">
                            <a href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}">
                            <span class="tt-img"><img  src="{{asset('images/loader.svg')}}" data-src="@{{getImage(item.logo)}}" alt=""></span>
{{--                                <span class="tt-img-roll-over"><img src="{{asset('images/loader.svg')}}" data-src="@{{getImage(item.logo)}}" alt=""></span>--}}
                                <span class="tt-img-roll-over"><img src="@{{getImage(item.logo)}}" alt=""></span>
                                <span class="tt-label-location">
                                <span href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}"  data-tooltip="Opening Time">
                                    <div class="estimated-time-div">
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i> Weekdays : <span class="sigma-green">@{{ item.openings.weekdays }}</span></p>
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i> Weekends:  <span class="sigma-green">@{{ item.openings.weekends }}</span></p>
{{--                                         <p>Estimated Delivery Time:</p>--}}
                                        {{--                                           <p class="sigma-green">20-25 Minutes</p>--}}
                                    </div>
                                </span>
                            </span>
                                <!-- <span class="tt-label-location">
                                    <span class="tt-label-our-fatured">Fatured</span>
                                </span> -->
                            </a>
                        </div>
                        <div class="tt-description meal-desc">
                            <div class="tt-row">
                            </div>
                            <h2 class="tt-title"><a href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}">
                                    @{{ item.name }}</a></h2>
                            <p class="low-opacity">
                                @{{ processAddress(item) }}
                            </p>
                            <p class="low-opacity">
                                Cuisines: @{{ processCuisine(item) }}
                            </p>
                            <div class="tt-product-inside-hover">
                                <div class="tt-row-btn">
                                    <!-- <a>HELLO WORLD</a> -->
                                    <a  href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}" style="width: 100%;" class="btn btn-primary btn-sm">
                                        View Menu
                                    </a>
                                    <!-- <a href="#" class="thumbprod-button-bg" data-toggle="modal" data-target="#modalAddToCartProduct">View Menu</a> -->
                                </div>
                                <div class="tt-row-btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row tt-layout-product-item" ng-cloak ng-show="!loaded_newrestaurants" ng-init="loadFeaturedRestaurants()">

                <div class="col-6 col-md-4 col-lg-3" ng-repeat="item in featured_restaurants">
                    <div class="tt-product thumbprod-center">
                        <div class="tt-image-box">
                            <a href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}">
                            <span class="tt-img"><img  src="@{{getImage(item.logo)}}" alt=""></span>
                                <span class="tt-img-roll-over"><img src="@{{getImage(item.logo)}}" alt=""></span>
                                <span class="tt-label-location">
                                <span href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}"  data-tooltip="Opening Time">
                                    <div class="estimated-time-div">
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i> Weekdays : <span class="sigma-green">@{{ item.openings.weekdays }}</span></p>
                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i> Weekends:  <span class="sigma-green">@{{ item.openings.weekends }}</span></p>
{{--                                         <p>Estimated Delivery Time:</p>--}}
{{--                                           <p class="sigma-green">20-25 Minutes</p>--}}
                                    </div>
                                </span>
                            </span>
                                <!-- <span class="tt-label-location">
                                    <span class="tt-label-our-fatured">Fatured</span>
                                </span> -->
                            </a>
                        </div>
                        <div class="tt-description meal-desc">
                            <div class="tt-row">
                            </div>
                            <h2 class="tt-title"><a href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}">@{{ item.name }}</a></h2>
                            <p class="low-opacity">
                                @{{ processAddress(item) }}
                            </p>
                            <p class="low-opacity">
                                Cuisines: @{{ processCuisine(item) }}
                            </p>
                            <div class="tt-product-inside-hover">
                                <div class="tt-row-btn">
                                    <!-- <a>HELLO WORLD</a> -->
                                    <a  href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}" style="width: 100%;" type="button" class="btn btn-primary btn-sm">
                                        View Menu
                                    </a>
                                    <!-- <a href="#" class="thumbprod-button-bg" data-toggle="modal" data-target="#modalAddToCartProduct">View Menu</a> -->
                                </div>
                                <div class="tt-row-btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="text-center" style="padding: 50px;" ng-show="loaded_newrestaurants">
                <button class="custom_button_color btn btn-lg" ng-click="loadMoreRestaurants()" ng-show="show_loadmore"><i class="fa fa-spinner fa-spin process_indicator" ng-show="loading_more_restaurants"></i> Load more</button>
            </div>

        </div>

    </div>
    </div>

@endsection
@push('script')
    <script src="{{asset('js/angular.min.js')}}"></script>
    <script src="{{asset('js/angular-resource.min.js')}}"></script>
    <script src="{{asset('js/angular-animate.min.js')}}"></script>
    <script src="{{asset('js/angular-scroll.min.js')}}"></script>
    <script src="{{asset('js/alertui.min.js')}}"></script>



    <script>
        var baseUrl = "<?php echo config('app.base_url')?>";

        var food_app = angular.module('food_app', ['ngAnimate', 'duScroll']);

        food_app.controller('filterController', ['$scope', '$log','$http', '$location', '$anchorScroll', function($scope, $log, $http, $location, $anchorScroll){
            $scope.restaurant_state = '';
            $scope.city = '';
            $scope.cities = [];
            $scope.states = [];
            $scope.featured_restaurants = [];
            $scope.searching_restaurants = false;
            $scope.searching_cities = false;
            $scope.searching_states = true;
            $scope.loaded_newrestaurants = false;
            $scope.loading_featured_restaurants = true;
            $scope.loading_more_restaurants = false;
            $scope.restaurants_data = [];
            $scope.restaurants = [];
            $scope.restaurants_page = 0;
            $scope.show_loadmore = true;
            $scope.loading_restaurants = true;


            $scope.getNextRestaurants = function(start, length){
                $scope.restaurants_page += 1;
                return $scope.restaurants_data.slice(start, length);
            }

            $scope.loadMoreRestaurants = function(){
                $scope.loading_more_restaurants = true;
                $scope.restaurants_page = $scope.restaurants.length + 1;

                var new_data = $scope.restaurants_data.slice($scope.restaurants_page, $scope.restaurants_page+10);
                Array.prototype.push.apply($scope.restaurants, new_data);
                // angular.forEach(new_Data, function(value, key) {
                //     $scope.restaurants.push(value);
                // });
                $scope.loading_more_restaurants = false;

                if($scope.restaurants.length == $scope.restaurants_data.length - 1){
                    $scope.show_loadmore = false;
                }
            }


            $scope.getImage = function(image){
                return 'https://food-server.nairabox.com/uploads/'+image
            }
            $scope.removeChars = function(item){
                return item.replace(/[^A-Z0-9]+/ig, '-')
            }
            $scope.processAddress = function(item){
                var address = '';
                address += item.address + ', ' + item.location.name + ', ' + item.city.name;
                return address
            }

            $scope.processCuisine = function(item){
                var cuisine = '';

                angular.forEach(item.cuisines, function(value, key) {
                    cuisine += value.cuisine.name + ', '
                });

                return cuisine
            }

            $scope.findCities = function(){
                $scope.searching_cities = true;
                $scope.searching_restaurants = false;
                $scope.cities = [];
                $http.get("{!! url('api/food/state/cities') !!}"+"/"+$scope.restaurant_state)
                    .then(function (res) {
                            $scope.searching_cities = false;
                            $scope.cities = res.data.data;
                            alertui.notify('success', 'Cities loaded')
                        },
                        function (res) {
                            $scope.searching_cities = false;
                            alertui.notify('error', 'Sorry! No content for selected State')
                            swal("",'Sorry! No content for selected State', "error");
                        })
            }

            $scope.findRestaurant = function(){
                $scope.searching_restaurants = true;
                $scope.loading_restaurants = true;
                $scope.restaurants_page = 0;
                $scope.restaurants = [];
                if($scope.city == ''){
                    alertui.notify('error', 'Please select a City');
                    return false;
                }
                $http.get(baseUrl+'food/restaurants/'+$scope.city)
                    .then(function (res) {
                            $scope.loading_restaurants = false;
                            $scope.searching_restaurants = false;
                            $scope.loaded_newrestaurants = true;
                            $scope.show_loadmore = true;
                            $scope.restaurants_data = res.data.data;
                            $scope.restaurants = $scope.getNextRestaurants(0, 10);
                            alertui.notify('success', 'Restaurants loaded');

                            $location.hash('restaurants');
                            $anchorScroll();

                        },
                        function (res) {
                            $scope.searching_restaurants = false;
                            $scope.loading_restaurants = false;
                            alertui.notify('error', 'Sorry! No content for selected State and City')
                            swal("",'Sorry! No content for selected State and City', "error");
                        })
            }

            $scope.loadStates = function(){
                $scope.states = [];
                $http.get(baseUrl+'food/states')
                    .then(function (res) {

                            $scope.searching_states = false;
                            $scope.states = res.data.data;
                            alertui.notify('success', 'States loaded')
                        },
                        function (res) {
                            $scope.searching_states = false;
                            alertui.notify('error', 'Sorry! Failed to load States')
                            swal("",'Sorry! Failed to load States', "error");

                        })
            }


            $scope.loadFeaturedRestaurants = function () {
                $scope.loading_restaurants = true;
                $http.get(baseUrl+'food/restaurants/featured')
                    .then(function (res) {
                            $scope.loading_restaurants = false;
                            $scope.loading_featured_restaurants = false;
                            $scope.featured_restaurants = res.data.data;
                        },
                        function (res) {
                            $scope.loading_restaurants = false;
                            $scope.loading_featured_restaurants = false;
                            alertui.notify('error', 'We couldn\'t load featured restaurants.')
                            swal("",'We couldn\'t load featured restaurants.', "error");

                        })
            }

        }]);
        $('body').addClass('tt-page-product-single meal-bg');
    </script>
    @endpush

@push('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/alertui.min.css')}}">

@endpush