<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Ixudra\Curl\Facades\Curl;
class ProductsController extends Controller
{
    protected $baseUrl = "http://www.rewardsboxnigeria.com/rewardsbox/api/v1/?api=";

    public function __construct()
    {
        $this->middleware('web');
    }

    public function getCategories(){
        $response = Curl::to($this->baseUrl.'get_category&flag=catalogue')
            ->withHeader('token: '.Auth::user()->company->token)
            ->asJsonResponse()
            ->get();
        return response()->json(['data' => $response->data, 'status' => '200'], 200);
    }

    public function getCategoryContent($id){
        $response = Curl::to($this->baseUrl.'get_products')
            ->withHeader('token: '.Auth::user()->company->token)
            ->withData(
                [
                    'category_id' => $id
                ] )
            ->asJsonResponse()
            ->post();
        return response()->json(['data' => $response, 'status' => '200'], 200);
    }

    public function getProductDetails(Request $request){
        $code = preg_replace('/\s+/', '', $request->code);
        $response = Curl::to($this->baseUrl.'product_details&product_code='.$code)
            ->withHeader('token: '.Auth::user()->company->token)
            ->asJsonResponse()
            ->get();

        return response()->json(['data' => $response, 'status' => '200'], 200);
    }
}
