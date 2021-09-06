<?php

namespace App\Http\Proxy;

use Illuminate\Support\Facades\Auth;

class Account extends BaseProxy {


    public function updateProfile($data){
        $payload['member_no'] = Auth::user()->member_id;
        if(isset($data['first_name'])) {
            $payload['first_name'] = $data['first_name'];
        }else{
                $payload['first_name'] = Auth::user()->firstname;
            }
        if(isset($data['last_name'])) {
        $payload['last_name'] = $data['last_name'];
    }else{
$payload['last_name'] = Auth::user()->lastname;
}
        if(isset($data['email'])) {
            $payload['email'] = $data['email'];
        }else{
            $payload['email'] = Auth::user()->email;
        }
        if(isset($data['phone'])) {
        $payload['phone_no'] = $data['phone'];
        }else{
            $payload['phone_no'] = Auth::user()->phone;
        }
        return $this->postRequest('update_profile', $payload, "Updates Members Details Across Platforms", self::class);
    }


}