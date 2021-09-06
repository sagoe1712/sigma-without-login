<?php

namespace App\Http\Proxy;

class Orders extends BaseProxy {


    public function getCategories(){
        return $this->getRequest('nested_category&flag=payment', "Get Bills Categories", self::class);
    }
    public function getCategoryContent($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('get_products', $payload, "Get Bills categories content", self::class);
    }

    public function redeem($payload){
        return $this->postRequest('bills_purchase', $payload, "Redeem Bill", self::class);
    }

    public function getProductDetails($productcode){
        return $this->getRequest('product_details&product_code='.$productcode, "Get Bills Product details", self::class);
    }


}