<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Proxy\Discount;
use App\Http\Proxy\DiscountOut;
use App\Traits\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use App\Repository\TransactionRepository;

//Import Traits
use App\Traits\Purchase;
use App\Traits\Transaction;
use App\Traits\Account;
use App\Traits\CartActions;
use App\Traits\OrderActions;
use App\Http\Proxy\Bills;
use App\Traits\EventsTrigger;

class OutdiscountController extends Controller
{

    private $token;
    public function __construct(DiscountOut $discountProxy)
    {
        $this->discountProxy = $discountProxy;
        $this->token = $this->get_token();

    }

    public function get_token(){
        $company_id = env('COMPANY_ID');

        $get_token = Company::select('token')
            ->where('id',$company_id)
            ->get();


            if(isset($get_token[0]['token'])) {
                return $get_token[0]['token'];
            } else {

                return "Access Denied";
            }

    }

    public function index(){

            $categories= $this->discountProxy->get_all_partner($this->token);


            //dd($categories);

            if(!$categories){
               return response()->redirectToRoute('no_content');
            }else if($categories->status === 0){
                return response()->redirectToRoute('no_content');
            }
            $title = "Discounts";

            return view('landing.discounts', compact('categories', 'title'));



    }

    public function get_discount_offer(Request $request)
    {
        $partner = [];
        $partner['partner_id'] = $request->partner_id;

        $response = $this->discountProxy->discount_details($partner,$this->token);

//        var_dump($response);
//        dd();

        if (!$response) {
            return response()->json(['data' => $response->message, 'status' => '400'], 200);

        }else if($response->status === 0){

            return response()->json(['data' => $response->message, 'status' => '400'], 200);

        }else if($response->status == 1){
            return response()->json(['data' => $response->data, 'status' => '200'], 200);
        }
    }

    public function state_partner($id){

        $response = $this->discountProxy->get_state_partner($this->token,$id);
        if (!$response) {
            return response()->json(['data' => $response->message, 'status' => '400'], 200);

        }else if($response->status === 0){

            return response()->json(['data' => $response->message, 'status' => '400'], 200);

        }else if($response->status == 1){
            return response()->json(['data' => $response->data, 'status' => '200'], 200);
        }
    }

    public function all_state_partner(){

        $response = $this->discountProxy->get_state_partner();
        if (!$response) {
            return response()->json(['data' => $response->message, 'status' => '400'], 200);

        }else if($response->status === 0){

            return response()->json(['data' => $response->message, 'status' => '400'], 200);

        }else if($response->status == 1){
            return response()->json(['data' => $response->data, 'status' => '200'], 200);
        }
    }


}
