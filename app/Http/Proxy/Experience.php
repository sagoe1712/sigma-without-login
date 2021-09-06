<?php

namespace App\Http\Proxy;
use Illuminate\Support\Facades\Auth;
class Experience extends BaseProxy {
    private $url = "https://experiences.rewardsboxnigeria.com/giftingowl/public/api/";
//    private $url = "https://experiences.perxclm.com/public/api/";

    public function getExperinceCountries(){
        return $this->getRequest('exp_country',  'Get experience countries', self::class);
    }

    public function getPopularExperinces(){
        return $this->getRequest('exp_popular', "Get Popular Experiences cities", self::class);
    }

    public function getPopularactivities(){
        return $this->getRequest('exp_random', "Get Popular Experiences Activities", self::class);
    }

    public function getExperinceCities($payload){
        return $this->postRequest('exp_city',  $payload, "Get Experiences cities by country id", self::class);
    }

    public function getExperiences($payload){
//        $payload['member_no'] = Auth::user()->member_id;
        //$payload['limit'] = 60;
        return $this->postRequest('get_experience',  $payload, "Get Experiences cities by city id", self::class);
    }

    public function getExperienceAvailabilities($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('exp_available',  $payload, "Get Experiences availabilities", self::class);
    }

    public function getExperienceBookingForm($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('exp_booking_form',  $payload, "Get Experience booking form", self::class);
    }

    public function getSingleExperience($id){
//        $payload['member_no'] = Auth::user()->member_id;
        return $this->getRequest('product_details&product_code='.$id, "Get Single Experience", self::class);
    }


    public function redeemExperience($payload)
    {
        return $this->postRequest('exp_purchase', $payload, "Redeem experience", self::class);
    }



}
