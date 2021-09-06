<?php

namespace App\Http\Proxy;

use Illuminate\Support\Facades\Auth;

class Discount extends BaseProxy {

   // private $url = "http://rewardsboxnigeria.com/discount/v1/";

    public function get_all_partner(){
        return $this->getRequest('discount_partners', "Get All Discount Partners", self::class);
    }

    public function discount_details($payload){
        return $this->postRequest('discount_offers', $payload, "Discount Offer from Discount Partner", self::class);
    }

    public function get_state(){
        return $this->getRequest('discount_states', "Get All Discount States", self::class);
    }

    public function get_state_partner($id=""){
        return $this->getRequest('discount_partners&state_id='.$id, "Get Selected State Discount partner", self::class);
    }

}