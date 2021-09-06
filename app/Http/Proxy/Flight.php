<?php

namespace App\Http\Proxy;
use Illuminate\Support\Facades\Auth;
class Flight extends FlightBaseProxy {

    public function getCities(){
        return $this->getRequest('cities', "Get Cities", self::class);
    }

    public function getPopular(){
        return $this->getRequest('popular', "Get Popular Locations", self::class);
    }

    public function getCountries(){
        return $this->getRequest('countries', "Get Countries", self::class);
    }

    public function getCityAirport(){
        return $this->getRequest('city_airport', "Get Airport Cities", self::class);
    }

    public function getAirports($search){
        return $this->getRequest('airports&search='.$search, "Search Airports", self::class);
    }

    public function flightSearch($payload){

        return $this->postRequest('flight_search', $payload, "Flight Search", self::class);
    }


    public function flightDetails($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('flight_details', $payload, "Flight Search", self::class);
    }


    public function flightPurchase($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('purchase', $payload, "Flight Search", self::class);
    }

}