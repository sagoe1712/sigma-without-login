<?php


namespace App\Http\Proxy;


use Illuminate\Support\Facades\Auth;

class Food extends BaseProxy
{
    public function getStates(){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('food_city', $payload, "Get Food States", self::class);
    }

    public function getStateCities($id){
        $payload['member_no'] = Auth::user()->member_id;
        $payload['city_id'] = $id;
        return $this->postRequest('food_location', $payload,"Get Food cities", self::class);
    }

    public function getRestaurantsByLocation($id){

        $payload['member_no'] = Auth::user()->member_id;
        $payload['location_id'] = $id;
        return $this->postRequest('location_restaurant', $payload,"Get restaurants by city", self::class);

    }

    public function getFeaturedRestaurants(){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('food_featured', $payload,"Get Restaurant Features", self::class);
    }

    public function getFoodByRestaurant($id){

        $payload['member_no'] = Auth::user()->member_id;
        $payload['restaurant_id'] = $id;
        return $this->postRequest('get_food', $payload,"Get food by Restaurant", self::class);
    }

    public function getRestaurantById($id){
        $payload['member_no'] = Auth::user()->member_id;
        $payload['restaurant_id'] = $id;
        return $this->postRequest('food_restaurant', $payload,"Get food by Restaurant", self::class);
        //return $this->getRequestGeneral(config('app.nairabox_base_url').'restaurant/'.$id, "Authorization: Bearer 12345", "", "Get NairaBox Restaurant by ID", self::class);
    }

    public function redeem($payload){
        return $this->postRequest('food_purchase', $payload,"Purchase Food", self::class);
    }

    public function confirmFoodPrice($payload){
        return $this->postRequest('food_confirm_price', $payload,"Confirm Food Price", self::class);

    }

}