<?php
namespace App\Http\Proxy;

class Events extends BaseProxy {

    public function getEvents(){
        return $this->getRequest('view_events', "Get available events", self::class);
    }

    public function redeem($payload){
        return $this->postRequest('event_purchase', $payload, "Redeem Event", self::class);
    }
}