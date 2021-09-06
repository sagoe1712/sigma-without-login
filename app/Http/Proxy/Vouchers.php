<?php

namespace App\Http\Proxy;


class Vouchers extends BaseProxy {

    public function getUberVouchers(){
        return $this->getRequest('get_uber', "Get Uber vouchers", self::class);
    }

    public function redeemUberVouchers($payload){
        return $this->postRequest('uber_purchase', $payload,"Redeem Uber vouchers", self::class);
    }



}
