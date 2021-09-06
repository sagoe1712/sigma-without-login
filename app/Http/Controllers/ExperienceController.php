<?php

namespace App\Http\Controllers;

use App\LogActivity;
use App\Repository\TransactionRepository;
use App\Traits\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Validator;
use DB;
use \Carbon;
//Import Traits
use App\Traits\Purchase;
use App\Traits\Transaction;
use App\Traits\Account;
use App\Traits\CartActions;
use App\Traits\OrderActions;
use App\Http\Proxy\Experience;
use App\Traits\EventsTrigger;

class ExperienceController extends Controller
{
    //Use Traits
    use Purchase, Transaction, Account, CartActions, OrderActions, EventsTrigger, EmailTemplates;

    protected $experienceProxy;
    protected $transactionRepository;
    public function __construct(TransactionRepository $transactionRepository,Experience $Experience)
    {
        $this->experienceProxy = $Experience; //Inject Experience Proxy
        $this->transactionRepository =  $transactionRepository;
//        $this->middleware(['web', 'auth']);
    }

    public function index(){
        $title = "Experiences";
        $countries = $this->experienceProxy->getExperinceCountries();
        $popular = $this->experienceProxy->getPopularExperinces();
        $activities =$this->experienceProxy->getPopularactivities();

//        dd($activities);

        if(!$countries || !$popular) {
            return back()->withErrors("A network Error Occurred. Please try again.");
        }
        elseif($countries->status != 1 || $popular->status != 1){
            return back()->withErrors("A network Error Occurred. Please try again.");
        }
        else {
            $countries = $countries->data;
            $popular = $popular->data;

            return view('pages.experience.index', compact('countries', 'title', 'popular','activities'));
        }
    }

    public function getCities($id){
        $payload = ['country_id' => $id];

        $cities = $this->experienceProxy->getExperinceCities($payload);

        if(!$cities) {
            return response()->json(['data' => 'Failed to load Cities', 'status' => '400'], 400);
        }
        elseif($cities->status == 0) {
            return response()->json(['data' => 'Failed to load Cities', 'status' => '400'], 400);
        }
        else {
            return response()->json([
                'data' => $cities->data,
                'message' => $cities->message,
                'status' => '200'], 200);
        }
    }

    public function getPopularExperinces(){

        $data = $this->experienceProxy->getPopularExperinces();

        if(!$data) {
            return response()->json(['message' => 'Failed to load popular experiences', 'status' => '400'], 400);
        }
        elseif($data->status == 0) {
            return response()->json(['message' => 'Failed popular experiences', 'status' => '400'], 400);
        }
        else {
            return response()->json([
                'data' => $data->data,
                'message' => $data->message,
                'status' => '200'], 200);
        }
    }

    public function loadMoreItems(Request $request){
        try{
            $payload['limit'] = 20;

            if(isset($request->exp_city)){
                $payload['city_id'] = $request->exp_city;
            } else {
                $payload['city_id'] =5;

            }

            if(isset($request->page)){
                $payload['page'] = $request->page;
            } else {
                $payload['page'] = 1;
            }

            $products = $this->experienceProxy->getExperiences($payload);
            if(!isset($products) && !$products){
                return response()->json(['data' => 'Failed to load more products.'], 400);
            }else if($products->status === 0){
                return response()->json(['data' => 'That\'s all for now'], 400);
            }
            return response()->json($products, 200);
        }catch (\Exception $e){
            return response()->json(['data' => 'Failed to load more products.'], 400);
        }
    }

    public function expericences(Request $request){
//        setcookie("exp_city", $request->exp_city);

        try{
            $title = "Experiences";
            $city_id = $request->exp_city;
            $payload =  [
                'city_id' => $request->exp_city,
                'limit' =>60

            ];


            if(isset($request->page)){

                $payload['page'] = $request->page;
            } else {
                $payload['page'] =0;
            }



            $products = $this->experienceProxy->getExperiences($payload);


            if($products){
                if($products->status == 0){
                    $countries = $this->experienceProxy->getExperinceCountries();
                    $current_title = "Results for experiences in ".$products->data[0]->city . '-' .$products->data[0]->country;
                    return view('pages.experience.categories', compact( 'products','countries', 'title', 'current_title'));
                }
                $countries = $this->experienceProxy->getExperinceCountries();
                $current_title = "Results for experiences in ".$products->data[0]->city . '-' .$products->data[0]->country;
                return view('pages.experience.categories', compact( 'products','countries', 'title', 'current_title','city_id'));
            }
            $current_title = "Results for experiences in ".$products->data[0]->city . '-' .$products->data[0]->country;
            return view('pages.experience.categories', compact( 'products', 'title', 'current_title'));
        }catch (\Exception $e){
            return back()->withErrors("A network Error Occurred. Please try again." );
        }
    }

    public function getExpericences(Request $request){

        try{
            $title = "Experiences";

            $payload =  [
                'city_id' => $request->exp_city,
                'page' => 0,
                'limit' => 60,

            ];

            $products = $this->experienceProxy->getExperiences($payload);


            if($products){
                if($products->status == 0){
                    $countries = $this->experienceProxy->getExperinceCountries();
                    $current_title = "Failed to load Results for experiences";
                    return view('pages.experience.categories', compact( 'products','countries', 'title', 'current_title'));
                }else{
                    $countries = $this->experienceProxy->getExperinceCountries();
                    $current_title = "Results for experiences in ".$products->data[0]->city . '-' .$products->data[0]->country;
                    return view('pages.experience.categories', compact( 'products', 'title', 'current_title', 'countries'));
                }
            }

            $current_title = "Results for experiences in ";
            return view('pages.experience.categories', compact( 'products', 'title', 'current_title'));
        }catch (\Exception $e){
            dd($e->getMessage());
            return back()->withErrors("A network Error Occurred. Please try again." );
        }
    }

    public function getSingleItem($productcode){

        if(Auth::guest()){
            redirect()->guest('login');
        }

        $company_id = env('COMPANY_ID');
        $cs =  DB::table('setting')
            ->where('company_id', '=', $company_id)
            ->first();

        $item = explode('___',$productcode);
        $countries = [];

        try {
            $guid= preg_replace('/\s+/', '', last($item));
            $payload = ['item_code' => $guid];
            $product = $this->experienceProxy->getSingleExperience($guid);
            $popular = $this->experienceProxy->getPopularExperinces();


//            dd($product);
            if(!$product){
                $countries = $this->experienceProxy->getExperinceCountries();
            }

            //Save data to cookie for areas to use
            setrawcookie('single_experience_image', $product->data->image);
            setcookie('single_experience_name', $product->data->name);

            $title = $item[0];
            $popular = $popular->data;
            $price = $cs->is_currency_fixed != '1' ? transform_product_price( $product->data->price, $cs->currency->rate ) . " " .$cs->currency: "&#8358;".transform_product_price($product->data->price, 1);

//            dd($product);
            return view('pages.experience.product', compact('product','countries', 'title', 'popular', 'price'));

        }catch (\Exception $e){
            return back()->withErrors("A network Error Occurred. Please try again.");
        }
    }

    public function get_experience_availabilities($id){
        $payload = ['item_code' => $id];
        $array = [];
        try {
            $data = $this->experienceProxy->getExperienceAvailabilities($payload);
//            dd($data);
            if($data){
                foreach ($data->data as $item){
                    $array[] = [
                        'end_time' => $item->end_time,
                        'end_time_local' => $item->end_time_local,
                        'seats_available' => $item->seats_available,
                        'start_time' => $item->start_time,
                        'start_time_local' => $item->start_time_local,
                        'type_options' => $this->buildTypeOptions($item->type_options)
                    ];
                }

                return response()->json(['data' => $array, 'message' => 'Loaded']);
            }
            return response()->json(['data' => [], 'message' => 'Failed to load'], 400);
        }catch (\Exception $e){
            return response()->json(['data' => [], 'message' => 'Failed to load. Exception Error.', 'reason' => $e->getMessage()], 400);
        }
    }
    public function get_experience_booking_form($id){
        $payload = ['item_code' => $id];
        try {
            $data = $this->experienceProxy->getExperienceBookingForm($payload);
            if($data){
                return response()->json(['data' => $data, 'message' => 'Loaded']);
            }
            return response()->json(['data' => [], 'message' => 'Failed to load'], 400);
        }catch (\Exception $e){
            return response()->json(['data' => [], 'message' => 'Failed to load. Exception Error.', 'reason' => $e->getMessage()], 400);
        }
    }

    public function getCategoryItems($id){
        if(!isset($_COOKIE["exp_country"]) && !isset($_COOKIE["exp_country"])) {
            redirect('experience');
        }

        try{
            $categories = $this->experienceProxy->getExpericenceCategories();
            $category = explode('__',$id);
            $pagename = ucfirst(preg_replace('/\-+/',' ',$category[0]));

            $payload = [
                'category_id' => last($category),
                'country_id' => $_COOKIE["exp_country"],
                'city_id' => $_COOKIE["exp_city"],
                'limit' => 10,
                'page' => 1
            ];

            $products = $this->experienceProxy->getCategoryContent($payload);
            $response = $categories;
            $total = $products->total;
            $productid= last($category);

            if($products){
                if($products->status == 0){
                    return back()->withErrors($products->message);
                }
                if($products->data == null){
                    return back()->withErrors("Sorry, there are no Experiences for your selection");
                }
                $title = "Experiences";

                return view('pages.experience.category', compact('products', 'response', 'pagename', 'total', 'productid' ));
            }else{
                return back()->withErrors("Failed to load experiences. Please try again.");
            }
        }catch (\Exception $e){
            return back()->withErrors("Sorry, A network Error occurred.");
        }
    }

    public function redeemExperience(Request $request){

        try {
            $canpurchase = $this->canPurchase(floatval($request->price * $request->quantity));
            //Check if the user has enough account balance before proceeding with the transaction
            if (!$canpurchase) {
                return response()->json(['data' => 'Apologies! Your current balance is insufficient for this transaction.', 'status' => '400'], 200);
            }
            if (!$this->deductFromAccount($request->price, $request->quantity)) {
                return response()->json(['data' => 'An error occurred. Please Try again.', 'status' => '400'], 200);
            }
            //Add to Cart
            $cartItemId = $this->postToCart($request->price, $request->name, $request->signature, $request->quantity);

            if (!$cartItemId) {
                return response()->json(['message' => 'Apologies an Error Occurred. Try again', 'status' => '400'], 200);
            }

            $payload = [
                'participant_forms' => json_encode($request->participant_form),
                'booking_form' => json_encode($request->per_booking_form),
                'quantity' => $request->quantity,
                'price' => round($request->price,2),
                'type_id' => $request->type,
                'signature' => $request->signature,
                'phone_no' => $request->phone_no,
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'member_no' => Auth()->user()->member_id
            ];

            try {
                $response = $this->experienceProxy->redeemExperience($payload);

                if ($response) {

                    if ($response->status === 0) {
                        if ($this->refundFailedTransToAccount($request->price, $request->quantity)) {
                            $this->deleteFromCart($cartItemId);
                            return response()->json(['message' => $response->message, 'status' => 400], 200);
                        } else {
                            return response()->json(['message' => 'An error occurred. Refund failed'], 400);
                        }

                    }
                    try {
                        $cartUpdate = $this->updateCart($cartItemId, $response->voucher_code);
                        if ($cartUpdate) {
                            //Add to Order
                            $success = [['ref_no' => $cartItemId, "voucher_code" => $response->voucher_code]];
                            $orderSaveStatus = $this->addOrder($response->order_no, $success, $request->price);
                            //Save Transaction
                            $this->transactionRepository->SaveTransaction($request, $orderSaveStatus, $request->price, null);

                            if (!$orderSaveStatus) {
                                return response()->json(['message' => 'Failed to save Order', 'status' => 400], 400);
                            } else {

                                $virtual_price = null;
                                $grand_total = null;
                                $spend_amount = null;
                                if (Auth::user()->currency->is_currency_fixed == '1') {
                                    $virtual_price = '&#8358' . number_format($request->price, 0, '.', ',');
                                    $grand_total = '&#8358' . number_format($request->price * $request->quantity, 0, '.', ',');
                                    $spend_amount = number_format($request->price * $request->quantity, 0, '.', ',');
                                } else {
                                    $virtual_price = number_format(Auth::user()->currency->rate * $request->price, 2, '.', ',') . ' ' . Auth::user()->currency->currency;
                                    $grand_total = number_format(Auth::user()->currency->rate * ($request->price * $request->quantity)) . ' ' . Auth::user()->currency->currency;
                                    $spend_amount = number_format(Auth::user()->currency->rate * ($request->price * $request->quantity));
                                }

                                $product_details[] = (object)[
                                    'name' => $request->name,
                                    'address' => $request->address,
                                    'station' => $request->station,
                                    'quantity' => '1',
                                    'price' => $virtual_price,
                                    'delivery_type_name' => 'E-Channel',
                                    'pickup_location_name' => '__',
                                    'voucher' => $response->voucher_code,
                                    'beneficiary' => $request->email,
                                    'booking_id' => $response->booking_info->booking_id,
                                    'booking_type' => $response->booking_info->type,
                                    'session_start' => $request->session_start,
                                    'session_end' => $request->session_end,

                                ];

                                //dd($response->booking_info->additional_info);
                                $receipt = $this->experienceReceipt(
                                    $product_details,
                                    $response->order_no,
                                    $grand_total,
                                    $response->booking_info->booking_id,
                                    $response->booking_info->type,
                                    $response->booking_info->supplier->name,
                                    $response->booking_info->supplier->email,
                                    $response->booking_info->supplier->phone,
                                    $response->booking_info->experience->google_country,
                                    $response->booking_info->experience->google_city,
                                    $response->booking_info->experience->location_address,
                                    $response->booking_info->additional_info

                                );

                                $email_payload = [
                                    'order_no' => $response->order_no,
                                    'details' => $receipt,
                                    'spend_amount' => $spend_amount,
                                    'supplier_email'=> $response->booking_info->supplier->email,
                                    'supplier_phone'=>$response->booking_info->supplier->phone
                                ];

                                $token = DB::table('company')->where('id', Auth::user()->company_id)->select('token')->first();

                                $this->notifyTransactionSuccess($token->token, $email_payload, "experience");

                                return response()->json(['order_id' => $orderSaveStatus, 'message' => 'Transaction Successful', 'status' => 200], 200);
                            }
                        } else {
                            return response()->json(['message' => $cartUpdate, 'status' => 400], 400);
                        }

                    } catch (\Exception $e) {
                        return response()->json(['massage' => 'Failed to record Order ', 'reason' => $e->getMessage(), 'status' => 400], 400);
                    }


                } else {
                    $this->refundFailedTransToAccount($request->price, $request->quantity);
                    return response()->json(['message' => 'No response from the network. Try again please.', 'status' => 400], 400);
                }
            } catch (\Exception $e) {
                $this->refundFailedTransToAccount($request->price, $request->quantity);
                return response()->json(['message' => 'Try again please. A network error occurred.', 'status' => 400], 400);
            }
        }catch (\Exception $e) {
            $this->refundFailedTransToAccount($request->price, $request->quantity);
            return response()->json(['message' => 'Try again please. A booking Error occurred', 'reason' => $e->getMessage(), 'status' => 400], 400);
        }
    }

    private function processCost($price){
        return Auth::user()->currency->is_currency_fixed != '1' ? transform_product_price( $price, Auth::user()->currency->rate ) : transform_product_price($price, 1);
    }


    private function getCurrency(){
        return Auth::user()->currency->is_currency_fixed != '1' ? Auth::user()->currency->currency: "&#8358";
    }

    private function buildTypeOptions($data){
        $array = [];
        foreach ($data as $item){
            $array[] = [
                'price_raw' => $item->price,
                'price_processed' => $this->processCost($item->price),
                'currency' => $this->getCurrency(),
                'type' => $item->type,
                'type_label' => $item->type_label,
                'min_age' => $item->min_age,
                'max_age' => $item->max_age,
                'item_code' => $item->item_code,
                'signature' => $item->signature,
            ];
        }
        return $array;
    }

}
