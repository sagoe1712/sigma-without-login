@extends('layouts.main')
@section('content')

    <div class="body-content food_page" ng-app="food_app" ng-controller="filterController">
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
                    <div>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        <i ng-show="searching_states" class="fa fa-spinner fa-spin process_indicator"></i>
                        <select name="filter_state" class="form-control" placeholder="Select State" ng-init="loadStates()" ng-model="restaurant_state" ng-change="findCities()">
                            <option value="" selected="selected">Select State</option>
                            <option ng-repeat="(index, state) in states" value="@{{ state._id }}" ng-selected="@{{$first == 1}}">
                                @{{ state.name }}
                            </option>
                        </select>
                        <label class="take-out-label" for="filter_state">State:</label>

                    </div>
                </div>
                <div class="col-6 col-md-5 modal-form-container">
                    <div>
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <select name="filter_city" class="form-control" placeholder="Select city" ng-model="city">
                            <option value="" selected="selected">Select City</option>
                            <option ng-repeat="(index, city) in cities" value="@{{ city._id }}" ng-selected="@{{$first == 1}}">
                                @{{ city.name }}
                            </option>
                        </select>
                        <label class="take-out-label" for="filter_city">City:</label>
                        <i ng-show="searching_cities" class="fa fa-spinner fa-spin process_indicator"></i>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <button style="width: 100%;" type="button" class="btn btn-primary btn-lg" ng-click="findRestaurant()" ng-disabled="searching_restaurants || searching" id="search_restaurant">
                        <i ng-show="searching_restaurants" class="fa fa-spinner fa-spin process_indicator"></i> Find restaurant
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div id="tt-pageContent">
        <h3 ng-show="!loaded_newrestaurants" class="text-center white-text">Featured Restaurants</h3>
        <h3 ng-show="loaded_newrestaurants" class="text-center">Restaurants</h3>

        <div class="content-wrapper container row" ng-show="loading_restaurants">
            <div class="placeholder col-sm-3">
                <div class="animated-background"></div>
            </div>
            <div class="placeholder col-sm-3">
                <div class="animated-background"></div>
            </div>
            <div class="placeholder col-sm-3">
                <div class="animated-background"></div>
            </div>
            <div class="placeholder col-sm-3">
                <div class="animated-background"></div>
            </div>
        </div>

        <div class="container-fluid restaurants_box_container ng-cloak row" ng-show="loaded_newrestaurants" id="restaurants">
            <div class="col-sm-6 mover" ng-repeat="item in restaurants">
                <div class="restaurants_item_container">
                    <div class="logo_container">
                        <a href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}">
                            <img src="@{{getImage(item.logo)}}" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="content_container">
                        <a href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}"><h4> @{{ item.name }}</h4></a>
                        <p><i class="fa fa-map-marker" aria-hidden="true"></i> @{{ processAddress(item) }}</p>
                        <p><i class="fa fa-clock-o" aria-hidden="true"></i>  Weekdays : @{{ item.openings.weekdays }} , Weekends:  @{{ item.openings.weekends }}m </p>
                        <p><i class="fa fa-cutlery" aria-hidden="true"></i>  Cuisines: @{{ processCuisine(item) }} </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="container-fluid restaurants_box_container row" ng-cloak ng-show="!loaded_newrestaurants" ng-init="loadFeaturedRestaurants()">
            <div class="col-sm-6 mover" ng-repeat="item in featured_restaurants">
                <div class="restaurants_item_container">
                    <div class="logo_container">
                        <a href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}">
                            <img src="@{{getImage(item.logo)}}" alt="" class="img-responsive">
                        </a>
                    </div>
                    <div class="content_container">
                        <a href="{{url('food/restaurant')}}/@{{ removeChars(item.name) | lowercase }}__@{{ item._id }}"><h4> @{{ item.name }}</h4></a>
                        <p><i class="fa fa-map-marker" aria-hidden="true"></i> @{{ processAddress(item) }}</p>
                        <p><i class="fa fa-clock-o" aria-hidden="true"></i>  Weekdays : @{{ item.openings.weekdays }} , Weekends:  @{{ item.openings.weekends }}m </p>
                        <p><i class="fa fa-cutlery" aria-hidden="true"></i>  Cuisines: @{{ processCuisine(item) }} </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center" style="padding: 50px;" ng-show="loaded_newrestaurants">
            <button class="custom_button_color btn btn-lg" ng-click="loadMoreRestaurants()" ng-show="show_loadmore"><i class="fa fa-spinner fa-spin process_indicator" ng-show="loading_more_restaurants"></i> Load more</button>
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
    <style>

        .placeholder {
            margin: 0 auto;
            padding: 20px;
            min-height: 200px;
        }

        @keyframes placeHolderShimmer{
            0%{
                background-position: -468px 0
            }
            100%{
                background-position: 468px 0
            }
        }

        .animated-background {
            animation-duration: 1.25s;
            animation-fill-mode: forwards;
            animation-iteration-count: infinite;
            animation-name: placeHolderShimmer;
            animation-timing-function: linear;
            background: darkgray;
            background: linear-gradient(to right, #eeeeee 10%, #dddddd 18%, #eeeeee 33%);
            background-size: 800px 104px;
            height: 200px;
            position: relative;
        }

        ::-webkit-input-placeholder {
            color: #333;
        }
        ::-moz-placeholder {
            color: #333;
        }
        :-ms-input-placeholder {
            color: #333;
        }
        ::-moz-placeholder {
            color: #333;
        }
        ::placeholder {
            color: #333;
        }

        .food_page .banner{
            width: 100%;
            height: calc(90vh - 200px);
            background: url({{asset('sigma/images/food/banner.jpg')}});
            background-repeat: no-repeat;
            background-color: #ffffff;
            background-position: center center;
            background-size: cover;
            display: table;
        }
        .filter_box_container{
            padding-top: calc(40vh - 200px);
        }

        .restaurants_box_container{
            transition: all linear 0.5s;
            padding: 4rem 50px 4rem;
            /*display: flex;*/
            /*justify-content: space-around;*/
            /*flex-wrap: wrap;*/
        }
        .restaurants_box_container h3{
            width: 100%;
        }
        .restaurants_box_container .restaurants_item_container{
            height: 300px;
            min-height: 300px;
            max-height: 300px;
            /*width: calc(100% * (1/2));*/
            background: #fff;
            margin-bottom: 2rem;
            padding: 20px;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            flex:1;
            border-radius: 5px;
            -ms-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        .restaurants_box_container .restaurants_item_container .logo_container{
            width: 30%;
            max-width: 160px;
            max-height: 160px;
        }
        .restaurants_box_container .restaurants_item_container .logo_container img{
            max-width: 160px;
            max-height: 160px;
            height: 160px;
        }
        .restaurants_box_container .restaurants_item_container .content_container{
            width: 70%;
            margin-left: 0.9rem;
        }

        .food_page .filter_box{
            padding: 20px;
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .food_page .filter_box div select{
            background: #f5f5f5;
            padding: 10px 40px;
            height: 50px;
            width: 100%;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            text-indent: 5px;
            border: 1px solid #c1c6cc;

        } .food_page .filter_box select:focus{
              outline-color: transparent;
              outline-width: 0px;

          }.food_page .filter_box div:last-of-type select{
               -webkit-border-radius: 0px !important;
               -moz-border-radius: 0px !important;
               border-radius: 0px !important;

           }.food_page .filter_box div:first-of-type select{
                -webkit-border-radius: 10px 0px 0px 10px !important;
                -moz-border-radius: 10px 0px 0px 10px !important;
                border-radius: 10px 0px 0px 10px !important;

            } .food_page .filter_box div:first-of-type{
                  width: 13%;
                  position: relative;
              }
        .food_page .filter_box div:first-of-type i.fa-chevron-down{
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 15px;
            color: gray;
        }

        .food_page .filter_box div:last-of-type i.fa-spinner{
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 15px;
            color: gray;
        }

        .food_page .filter_box div:first-of-type i.fa-spinner{
            position: absolute;
            left: 15px;
            top: 15px;
            font-size: 15px;
            color: gray;
        }

        .food_page .filter_box div:last-of-type{
            height: 50px;
            width: 20%;
            position: relative;
            margin-left: 10px;
        }
        .food_page .filter_box div:last-of-type i.fa-map-marker{
            position: absolute;
            top: 15px;
            font-size: 20px;
            left: 20px;
            color: gray;
        }

        .food_page .filter_box button[id='search_restaurant']{
            background: #45a6c4;
            color: #fff;
            margin-left: 10px;
            -webkit-border-radius: 0px 10px 10px 0px;
            -moz-border-radius: 0px 10px 10px 0px;
            border-radius: 0px 10px 10px 0px;
            border-color: transparent;
            cursor: pointer;
            padding-left: 30px;
            padding-right: 30px;
        }
        .food_page .filter_box button[id='search_restaurant']:focus{
            outline-color: #c1c6cc;
            outline-width: thin;
        }
        @media (max-width: 767px) {
            .food_page .filter_box{
                flex-direction: column;
            }
            .food_page .filter_box > div{
                width: 100% !important;
                margin-bottom: 10px;
            }.food_page .filter_box button[id='search_restaurant']{
                 width: 100% !important;
                 margin: 0px !important;
                 height: 50px;
                 -webkit-border-radius: 0px;
                 -moz-border-radius: 0px;
                 border-radius: 0px;
             }
            .food_page .filter_box div:last-of-type{
                margin-left: 0px;
            }
            .food_page .filter_box div:last-of-type select{
                -webkit-border-radius: 0px !important;
                -moz-border-radius: 0px !important;
                border-radius: 0px !important;
            }
            .food_page .filter_box div:first-of-type select{
                -webkit-border-radius: 0px !important;
                -moz-border-radius: 0px !important;
                border-radius: 0px !important;
            }
            /*.restaurants_box_container{*/
            /*padding-top: calc(20vh - 200px);*/
            /*display: flex;*/
            /*justify-content: space-around;*/
            /*flex-wrap: wrap;*/
            /*}*/
            /*.restaurants_box_container .restaurants_item_container{*/
            /*width: 100%;*/
            /*flex:none*/
            /*}          */
            .restaurants_box_container .restaurants_item_container .logo_container{
                display: none;
            }
            .restaurants_box_container .restaurants_item_container .content_container{
                position: absolute;
            }

        }

        @media(min-width: 768px) and  (max-width: 1024px) {
            .food_page .filter_box div:first-of-type{
                width: 23%;
                margin-right: 5px;
                position: relative;
            }
            .food_page .filter_box div:last-of-type{
                width: 23%;
                margin-right: 5px;
                position: relative;
            }
            .food_page .banner {
                height: calc(70vh - 200px);
            }
            .filter_box_container {
                padding-top: calc(35vh - 200px);
            }

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
    </style>
@endpush