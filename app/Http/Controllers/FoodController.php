<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Proxy\Food;

use App\Repository\TransactionRepository;
use App\Traits\Account;
use App\Traits\CartActions;
use App\Traits\EmailTemplates;
use App\Traits\EventsTrigger;
use App\Traits\OrderActions;
use App\Traits\Purchase;
use App\Traits\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;




class FoodController extends Controller
{


    //Use Traits
    use Purchase, Transaction, Account, CartActions, OrderActions, EventsTrigger, EmailTemplates;
    private $foodProxy;
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository, Food $food)
    {

//        $this->middleware(['auth','web'], ['except' => ['getStateCities', 'getRestaurantsByLocation', 'getFeaturedRestaurants', 'getStates', 'getFoodByRestaurant'] ]);
        $this->foodProxy = $food;
        $this->transactionRepository =  $transactionRepository;
    }

    public function index(){
        $title = "Food";
        return view('pages.food.index', compact( 'title'));
    }

    public function getStateCities($id){
        try{
        $response = $this->foodProxy->getStateCities($id);
            if(!isset($response) || !$response ) {
                return response()->json(['message' => 'Failed to load cities. Try again.'], 400);
            }
            return response()->json(['message' => 'Cities loaded', 'data' => $response->data]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to load Cities. Try again.'], 400);
        }
    }

    public function getStates(){


        try{


            $response = $this->foodProxy->getStates();
//dd($response);

            if(!isset($response) || !$response || $response->status == 0 ) {
                return response()->json(['message' => 'Failed to load states. Try again.'], 400);
            }
            return response()->json(['message' => 'States loaded', 'data' => $response->data]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to load states... Try again.'], 400);
        }
    }

    public function getRestaurantsByLocation($id){
        try{
            $response = $this->foodProxy->getRestaurantsByLocation($id);

            if(isset($response->error)){
                return response()->json(['message' => 'Failed to load restaurants. Try again.'], 400);
            }
            if(!isset($response) || !$response ) {
                return response()->json(['message' => 'Failed to load restaurants. Try again.' , 'data' =>$response], 400);
            }
            return response()->json(['message' => 'Restaurants loaded' , 'data' => $response->data]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to load restaurants. Try again.', 'reason' => $e->getMessage()], 400);
        }
    }

    public function getFeaturedRestaurants(){


        try{
            $response = $this->foodProxy->getFeaturedRestaurants();

            if(isset($response->error)){
                return response()->json(['message' => 'Failed to load restaurants. Try again.', 'error' =>$response], 400);
            }

            if(!isset($response) || !$response ) {
                return response()->json(['message' => 'Failed to load restaurants. Try again.' , 'error' => $response], 400);
            }

            return response()->json(['message' => 'Featured Restaurants loaded' , 'data' => $response->data]);

        }catch (\Exception $e){
            return response()->json(['message' => 'Failed to load restaurants... Try again.', 'reason' => $e->getMessage()], 400);
        }
    }

    public function getRestaurant($name){
        $id = last(explode('__',$name));
        $array = explode('__',$name);
        array_pop($array);

        $restaurant = $this->foodProxy->getRestaurantById($id);

        if(isset($restaurant->error)){
            return response()->redirectToRoute('no_content');
        }

        if(!$restaurant){
            return response()->redirectToRoute('no_content');
        }

        $title = implode('-',$array);
        $title = str_slug($title);

        return view('pages.food.restaurant', compact('restaurant', 'title', 'id'));

    }

    public function getFoodByRestaurant($id){

        try{

            $response = $this->foodProxy->getFoodByRestaurant($id);
            //var_dump($response);

            if(isset($response->error)){
                return response()->json(['message' => 'Failed to load meals. Try again.' , 'error' => $response], 400);
            }

            if(!isset($response) || !$response ) {
                return response()->json(['message' => 'Failed to load meals. Try again.' , 'error' => $response], 400);
            }

            $categories = [];

            foreach ($response->data as $item){
                $categories[] = (object)[
                    'category_name' => $item->category->name,
                    'category_id' => $item->category->_id,
                    'slug' => str_slug($item->category->name),
                    'products' => [],
                ];
            }

            $categories = array_unique($categories, SORT_REGULAR);
            foreach ($categories as $item) {
                foreach ($response->data as $product) {
                    if($product->category->_id == $item->category_id){
                        $item->products[] = (object)[
                            'id' => $product->_id,
                            'name' => $product->name,
                            'slug' => str_slug($product->name),
                            'description' => $product->description,
                            //'amount' => $product->amount + empty($product->restaurant->pack_fee) ? $product->restaurant->pack_fee[0]->amount : 0,
                            'amount' => Auth::user()->currency->rate *  $product->amount,
                            'image' => $product->image,
                        ];
                    }
//                    $new_item = $product;
//                    $new_item->category_name = $item->category_name;
//                    $new_item->category_id = $item->category_id;
//                    array_push($products, $new_item);
                }
            }

            return response()->json(['message' => 'Meals loaded' , 'data' => $categories]);

        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage() , 'data' => $categories]);
        }
    }

    public function redeem(Request $request){

        $foodqty = 1;

        $payload = [];

        $payload['first_name'] = $request->first_name;
        $payload['last_name'] = $request->last_name;
        $payload['price'] = $request->price;
        $payload['signature'] = $request->signature;
        $payload['phone_no'] = $request->phone_no;
        $payload['email'] = $request->email;

        //dd($request->restaurant_name);





        $payload['member_no'] = Auth::user()->member_id;

//        var_dump($request->restaurant_name);
//       dd("stop");

        $canpurchase = $this->canPurchase(floatval($request->price));
        $full_name = $request->first_name." ".$request->last_name;
        if (!$canpurchase) {
            return response()->json(['data' => 'Apologies! Your current balance is insufficient for this transaction.', 'status' => '400'], 200);
        }else{

            if ($this->deductFromAccount($request->price, $foodqty)) {

                //Add to Cart
                $cartItemId = $this->postToCart($request->price, $request->restaurant_name, $request->signature, 1);
                if(!$cartItemId){
                    return response()->json(['data' => 'Apologies an Error Occurred. Try again', 'status' => '400'], 200);
                }else{

                $response = $this->foodProxy->redeem($payload);

                if ($response) {
                    if ($response->status == 0) {
                        //return response()->json(['data' => $response, 'message' => 'Sorry! The Transaction failed. Please try again.' ], 400);

                        if ($this->refundFailedTransToAccount($request->price, 1)) {
                            return response()->json(['data' => $response, 'status' => '400'], 200);
                        } else {
                            return response()->json(['data' => 'An error occurred. Refund action failed', 'status' => 'fail'], 200);
                        }

                    } else if ($response->status == 1) {
                        //return response()->json(['data' => $response, 'message' => 'Transaction Successful' ]);

                        try {
                            //$cartItemId = $response->order_no;

                            $cartUpdate = $this->updateCart($cartItemId, $response->voucher_code);
                            if ($cartUpdate) {

                                $cartUpdate = $this->updateCart($cartItemId, $response->voucher_code);
                                if ($cartUpdate) {
                                    //Add to Order
                                    $success = [['ref_no' => $cartItemId, "voucher_code" => $response->voucher_code]];

                                    $orderSaveStatus = $this->addOrder($response->order_no, $success, $request->price);
                                    //Save Transaction
                                    $this->transactionRepository->SaveTransaction($request, $orderSaveStatus, $request->price, null);

                                    if (!$orderSaveStatus) {
                                        return response()->json(['data' => 'Failed to save Order', 'status' => '400'], 200);
                                    } else {

                                        $virtual_price = null;
                                        $spend_amount = null;
                                        if (Auth::user()->currency->is_currency_fixed == '1') {
                                            $virtual_price = '&#8358' . number_format($request->price, 0, '.', ',');
                                            $delivery_cost = '&#8358' . number_format($response->booking_info->delivery_price, 0, '.', ',');
                                            $total_cost = '&#8358' . number_format($response->booking_info->sub_total, 0, '.', ',');
                                            $spend_amount = number_format($request->price, 0, '.', ',');
                                        } else {
                                            $virtual_price = number_format(Auth::user()->currency->rate * $request->price, 0, '.', ',') . ' ' . Auth::user()->currency->currency;
                                            $delivery_cost = number_format(Auth::user()->currency->rate * $response->booking_info->delivery_price, 0, '.', ',') . ' ' . Auth::user()->currency->currency;
                                            $total_cost = number_format(Auth::user()->currency->rate * $response->booking_info->sub_total, 0, '.', ',') . ' ' . Auth::user()->currency->currency;
                                            $spend_amount = number_format(Auth::user()->currency->rate * $request->price, 0, '.', ',');
                                        }

                                        $product_details[] = (object)[
                                            'name' => $response->booking_info->restaurant,
                                            'address' => $response->booking_info->address,
                                            'cart' => $response->booking_info->cart,
                                            'price' => $virtual_price,
                                            'delivery_type_name' => 'E-Channels',
                                            'pickup_location_name' => '__',
                                            'voucher' => $response->voucher_code,
                                            'beneficiary' => $request->phone_no,
                                            'full_name' => $full_name
                                        ];


                                        $receipt = $this->foodReceipt($product_details, $response->order_no, $virtual_price, $delivery_cost, $total_cost);

                                        $email_payload = [
                                            'order_no' => $response->order_no,
                                            'details' => $receipt,
                                            'spend_amount' => $spend_amount
                                        ];

                                        $token = DB::table('company')->where('id', Auth::user()->company_id)->select('token')->first();


                                        $this->notifyTransactionSuccess($token->token, $email_payload, "food");

                                        return response()->json([
                                            'data' => $orderSaveStatus,
                                            'status' => '200',
                                            'account' => Auth::user()->accountBalaceText(),
                                            'message' => 'Transaction Successful'
                                        ], 200);
                                    }
                                } else {
                                    return response()->json(['data' => $cartUpdate, 'status' => '400'], 200);
                                }
                                return response()->json(['data' => $response->message, 'status' => '200'], 200);
                            }else{
                                return response()->json(['data' => $cartUpdate, 'status' => '400'], 200);
                            }
                        }catch (\Exception $e) {
                            return response()->json(['massage' => 'Failed to record Order ', 'reason' => $e->getMessage(), 'status' => 400], 400);
                        }

                    }
                }

            }
            }else{
                return response()->json(['data' => 'An error occurred. Please Try again.', 'status' => '400'], 200);
            }

        }





    }

    public function confirmPrice(Request $request)
    {
        $messages = [
            'phone_no.numeric' => 'Phone number must be numbers',
        ];

        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|numeric|regex:/[0-9]{9}/|bail|digits:11',
            'email' => 'required|min:5|max:255|email',
            'address' => 'required|min:5'

        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
                'status' => 'validation',
            ], 400);
        }

        try{

            $cart = [];

            //Populate cart
            foreach ($request->cart as $item){
                $cart[] = (object)[
                    '_id' => $item['id'],
                    'name'=> $item['name'],
                    'qty' => $item['qty'],
                    'options' => [],
                ];
            }

            $payload = [];

            $payload['phone_no'] = $request->phone_no;
            $payload['delivery_city'] = "Lekki";
            $payload['delivery_location'] = "Lagos";

            $payload['member_no'] = Auth::user()->member_id;
            $payload['email'] = $request->email;
            $payload['restaurant_id'] = $request->restaurant_id;
            $payload['delivery_address'] = $request->address;
            if($request->delivery_instruction == ""){
                $payload['delivery_instruction'] = " ";
            }else {
                $payload['delivery_instruction'] = $request->delivery_instruction;
            }
            $payload['cart'] = json_encode($cart);

//            var_dump($payload);
//            dd('stop');

            $response = $this->foodProxy->confirmFoodPrice($payload);

            if($response){
                if($response->status == 0){
                    return response()->json(['data' => $response, 'message' => 'Sorry! Failed Trying To Confirm Price. Please try again.' ], 400);
                }else{

                    $newpayload = [];

                        $newpayload['status'] = $response->status;
                        $newpayload['message'] = $response->message;
                    $newpayload['data']['sub_total'] = $response->data->sub_total;
                    $newpayload['data']['delivery_price'] = $response->data->delivery_price;
                    $newpayload['data']['price'] = $response->data->price;

                        $newpayload['data']['con_sub_total'] = Auth::user()->currency->rate * $response->data->sub_total;
                        $newpayload['data']['con_delivery_price'] = Auth::user()->currency->rate * $response->data->delivery_price;
                        $newpayload['data']['con_price'] = Auth::user()->currency->rate * $response->data->price;
                        $newpayload['data']['address'] = $response->data->address;
                        $newpayload['data']['signature'] = $response->data->signature;

                    return response()->json(['data' => $newpayload, 'message' => 'Price Retrieved Successful' ]);
                }
            }
            return response()->json(['data' => $response, 'message' => 'Sorry! Failed Trying To Confirm Price. Please try again.' ], 400);
        }catch (\Exception $e){
            return response()->json([
                'data' => [],
                'message' => 'Sorry! The Transaction failed. Please try again.',
                'reason' => $e->getMessage(),
            ], 400);
        }

    }


}
