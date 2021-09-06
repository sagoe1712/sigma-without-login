<?php

namespace App\Http\Proxy;
use Illuminate\Support\Facades\Auth;
class Catalogue extends BaseProxy {

    public function getTrending(){
        return $this->getRequest('get_featured', "Get Catalogue Trending", self::class);
    }

    public function getBestSelling(){
        return $this->getRequest('best_selling&limit=8', "Get Catalogue Best Selling", self::class);
    }

    public function getCategories(){
        return $this->getRequest('nested_category&flag=catalogue', "Get Catalogue Categories", self::class);
    }

    public function getCategoryContent($payload){
//       $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('get_products', $payload, "Get Catalogue Categories", self::class);
    }

    public function getRandomContent($limit, $page){
        $payload['member_no'] = Auth::user()->member_id;
        $payload['limit'] = $limit;
        $payload['page'] = $page;
         return $this->postRequest('get_random_products', $payload, "Get Catalogue random content", self::class);
     }

    public function getProductDetails($productcode){
        return $this->getRequest('product_details&product_code='.$productcode, "Get Catalogue product details", self::class);
    }


    public function search($search_string){
        $payload['member_no'] = Auth::user()->member_id;
        $payload['search'] = $search_string;
        return $this->postRequest('search_products', $payload,"Search Catalogue", self::class);
    }

    public function sortCatalogueSearch($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('search_products', $payload,"Sort Catalogue Search results", self::class);
    }

    public function calculateDelivery($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('delivery_price', $payload,"Get delivery cost", self::class);
    }

    public function validateorder($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('validate_order', $payload,"Validate Items in cart", self::class);
    }

    public function redeem($payload){
        $payload['member_no'] = Auth::user()->member_id;
        return $this->postRequest('bulk_purchase', $payload,"Redeem Catalogue Item", self::class);
    }

}
