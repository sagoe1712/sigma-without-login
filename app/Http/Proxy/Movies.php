<?php
namespace App\Http\Proxy;

class Movies extends BaseProxy {
    public function getMovies(){
        return $this->getRequest("get_movies", "Get Cinemas", self::class);
    }

    public function getMovie($code){
        return $this->getRequest('movie_details&product_code='.$code, "Get movie", self::class);
    }

    public function redeemMovie($payload)
    {
        return $this->postRequest('cinema_purchase', $payload, "Redeem movie", self::class);
    }
}