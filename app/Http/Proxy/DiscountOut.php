<?php

namespace App\Http\Proxy;

use Illuminate\Support\Facades\Auth;

class DiscountOut extends BaseProxy {

   // private $url = "http://rewardsboxnigeria.com/discount/v1/";

    public function get_all_partner($token){
        return $this->getRequestNoAuth('discount_partners', $token,"","Get All Discount Partners", self::class);
    }

    public function discount_details($payload, $token){
        return $this->postRequestNoAuth('discount_offers', $token,$payload, "Discount Offer from Discount Partner", self::class);
    }

    public function get_state($token){
        return $this->getRequestNoAuth('discount_states',$token,"", "Get All Discount States", self::class);
    }

    public function get_state_partner($token, $id=""){
        return $this->getRequestNoAuth('discount_partners&state_id='.$id, $token, "","Get Selected State Discount partner", self::class);
    }

}