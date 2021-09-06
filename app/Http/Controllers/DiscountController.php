<?php

namespace App\Http\Controllers;

use App\Http\Proxy\Discount;
use App\Traits\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

class DiscountController extends Controller
{

    public function __construct(Discount $discountProxy)
    {
        $this->discountProxy = $discountProxy;
//        $this->middleware(['web', 'auth']);
    }


    public function index(){
        try{
            $categories= $this->discountProxy->get_all_partner();
            $state= $this->discountProxy->get_state();
            //dd($categories);

            if(!$categories){
                return response()->redirectToRoute('no_content');
            }else if($categories->status === 0){
                return response()->redirectToRoute('no_content');
            }
            $title = "Discounts";

            return view('pages.discount.index', compact('categories', 'title','state'));


        }catch (\Exception $e){
            return response()->redirectToRoute('no_content');
        }
    }

    public function get_discount_offer(Request $request)
    {
        $partner['partner_id'] = $request->partner_id;
        //var_dump($partner);
        //dd();
        $response = $this->discountProxy->discount_details($partner);

        if (!$response) {
            return response()->json(['data' => $response->message, 'status' => '400'], 200);

        }else if($response->status === 0){

            return response()->json(['data' => $response->message, 'status' => '400'], 200);

        }else if($response->status == 1){
            return response()->json(['data' => $response->data, 'status' => '200'], 200);
        }
    }

    public function state_partner($id){

        $response = $this->discountProxy->get_state_partner($id);
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
