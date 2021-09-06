<?php

namespace App\Http\Controllers;

use App\Http\Proxy\Meals;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Cart;
class MealsController extends Controller
{

    //Zero based Status indicators
    private $cartstatus = [
        'fail' => 0,
        'pending' => 1,
        'done' => 2,
        'reversed' => 3,
        'cancelled' => 4,
        'deleted' => 5
    ];

    //Zero based Status indicators
    private $transtype = [
        'debit' => 0,
        'credit' => 1
    ];
    private $is_internal_action = [
        'external' => 0,
        'internal' => 1
    ];


    private $mealsProxy;
    public function __construct( Meals $meals)
{
//    $this->middleware(['auth'], ['except' => ['getMeals', 'redeemMeals', 'postToCart'] ]);
//    $this->middleware(['web']);
    $this->mealsProxy = $meals;
}

    public function index(){
        try{
            $categories = $this->mealsProxy->getCategories();

            if(!isset($categories) && !$categories ){
                return response()->redirectToRoute('no_content');
            }else if($categories->status === 0){
                return response()->redirectToRoute('no_content');
            }
            $title = "Meals";
            return view('pages.meals', compact('categories', 'title'));
        }catch (\Exception $e){
            return response()->redirectToRoute('no_content');
        }
    }

    public function getMeals(Request $request){

        try{
            $categories = $this->mealsProxy->getCategories();

            if(!isset($categories) && !$categories ){
                return response()->redirectToRoute('no_content');
            }else if($categories->status === 0){
                return response()->redirectToRoute('no_content');
            }

            $payload = [
                'branch_id' => $request->branch_id,
                'category_data' => json_encode($request->categories)
            ];

        $meals_products = $this->mealsProxy->getCategoryContent($payload);

        if($meals_products){
            $title = $request->segment(2);
            return view('pages.meals_products', compact('meals_products', 'categories', 'title'));
        }
            return back()->withErrors("Apologies. Meals are not availbale for the selected branch at the moment.");
        }catch (\Exception $e){
            return response()->redirectToRoute('no_content');
        }
    }


    public function postToCart(Request $request){
        //run for only Ajax requests

        if($request->ajax()){
            if($request->orderqty == '0'){
                return response()->json(['data' => 'Quantity has to be 1 or more.', 'status' => '400'], 200);
            }else if(!isset($request->delivery_method)){
                return response()->json(['data' => 'Please select a Delivery method.', 'status' => '400'], 200);
            }else if($request['delivery_method'] == 1 && !isset($request['pickup_location']) ){
                return response()->json(['data' => 'Please select a Pick up location.', 'status' => '400'], 200);
            }
            else if($request->signature == '' || $request->price == ''){
                return response()->json(['data' => 'Error. Invalid item.', 'status' => '400'], 200);
            }else{
                $pickuploc = null;
                if(isset($request->pickup_location)){
                    $pickuploc = $request->pickup_location;
                }
                $combo = null;

                $itemExists = Cart::where(
                    [
                        ['signature', $request->signature],
                        ['status', $this->cartstatus['pending']],
                        ['user_id', Auth::user()->id],
                        ['company_id', Auth::user()->company_id],
                        ['delivery_type', $request->delivery_method],
                    ])->first();
                //Update cart if item already exists
                if($itemExists) {
                    try {
                        Cart::where(
                            [
                                ['signature', $request->signature],
                                ['status', $this->cartstatus['pending']],
                                ['user_id', Auth::user()->id],
                                ['company_id', Auth::user()->company_id],
                                ['delivery_type', $request->delivery_method]
                            ])->update([
                            'qty' => $request->orderqty + $itemExists->qty,
                            'delivery_location' => $pickuploc,
                            'delivery_type' => $request->delivery_method
                        ]);

                        return response()->json(['data' => 'Cart updated.', "cartqty" => Auth::user()->cartCount()[0], 'status' => '200'], 200);

                    } catch (\Exception $e) {
                        return response()->json(['data' => 'An Error Occurred. Try again.'. $e->getMessage(), 'status' => '400'], 400);
                    }
                }

                //Insert into cart if item doesn't exist
                try {
                    $addtocart = Cart::create([
                        'user_id' => Auth::user()->id,
                        'company_id' => Auth::user()->company_id,
                        'name' => $request->name,
                        'delivery_type' => $request->delivery_method,
                        'delivery_location' => $pickuploc,
                        'qty' => $request->orderqty,
                        'price' => $request->price,
                        'signature' => $request->signature,
                        'image' => $request['product_image'],
                        'combo' => $combo,
                        'status' => $this->cartstatus['pending'],
                    ]);
                    return response()->json(['data' => $request->name.' Added to cart. (Qty: ' .$request->orderqty . ")", "cartqty" => Auth::user()->cartCount()[0], 'status' => '200'], 200);

                }catch (\Exception $e){
                    return response()->json(['data' => 'An Error Occurred. Try again.' .$e->getMessage(), 'status' => '400'], 400);
                }

            }
        }
    }



}
