<?php
namespace App\Http\Proxy;
use Illuminate\Support\Facades\Auth;
class Meals extends BaseProxy {

    public function getCategories(){
        return $this->getRequest('nested_category&flag=meals', "Get meals categories", self::class);
    }

    public function getCategoryContent($payload){
//        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('meals_products', $payload, "Get meals by vendor", self::class);
    }
}
