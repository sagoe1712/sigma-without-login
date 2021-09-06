<?php

namespace App\Http\Proxy;
use Illuminate\Support\Facades\Auth;

class FuelVoucher extends BaseProxy {

    public function getFuelStations(){
        return $this->getRequest('view_stations', "Get Fuel stations", self::class);
    }

    public function getFuelVouchers($payload){
        return $this->postRequest('get_products', $payload, "Get fuel vouchers", self::class);
    }

    public function redeem($payload){
        return $this->postRequest('fuel_purchase', $payload, "Redeem fuel voucher", self::class);
    }


}