<?php

namespace App\Http\Controllers;

use App\Traits\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Ixudra\Curl\Facades\Curl;
use Validator;
use DB;
use App\Repository\TransactionRepository;

//Import Traits
use App\Traits\Purchase;
use App\Traits\Transaction;
use App\Traits\Account;
use App\Traits\CartActions;
use App\Traits\OrderActions;
use App\Http\Proxy\Movies;
use App\Traits\EventsTrigger;
class CinemaController extends Controller
{
    //Use Traits
    use Purchase, Transaction, Account, CartActions, OrderActions, EventsTrigger, EmailTemplates;

    //Define Class variables
    protected $transactionRepository;
    protected $moviesProxy;

    public function __construct(TransactionRepository $transactionRepository, Movies $MoviesProxy)
    {
//        $this->middleware(['web', 'auth']);
        $this->transactionRepository =  $transactionRepository;
        $this->moviesProxy = $MoviesProxy;
    }

    public function index(Request $request){
        if ($request->session()->has('cinemas')) {
            $request->session()->forget('cinemas');
        }
        $data = $this->moviesProxy->getMovies();
        if(!$data){
            return response()->redirectToRoute('no_content');
        }else if($data->status === 0){
            return response()->redirectToRoute('no_content');
        }

        $request->session()->put('cinemas', $data->data);
        $cinemas = session('cinemas');

        return view('pages.cinemas.index', compact('cinemas'));
    }

    public function getMoviesByCinema($cinema, Request $request){
        $item = explode('-',$cinema);
        $request->session()->put('cinema', $cinema);
        if ($request->session()->has('cinemas')) {
        $movies = (session('cinemas')[last($item)]);
        return view('pages.cinemas.movies', compact('movies'));
        }else{
            return redirect()->action('CinemaController@index');
        }
    }

    public function view($code){
        $data = $this->moviesProxy->getMovie($code);
        $movies = session('cinema');
        if(!$data){
            return response()->redirectToRoute('no_content');
        }else if($data->status === 0){
            return response()->redirectToRoute('no_content');
        }
        $title = "Cinemas";
        return view('pages.cinemas.movie', compact('data', 'title', 'movies'));
    }

    public function redeem(Request $request){

        $messages = [
            'phone_no.numeric' => 'Phone number must be numbers',
            'signature.required' => 'Please select a Ticket type',
        ];

        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|numeric|regex:/[0-9]{9}/|bail',
            'email' => 'required|min:5|max:255|email|bail',
            'firstname' => 'required|bail',
            'lastname' => 'required|bail',
            'show_time' => 'required|bail',
            'signature' => 'required|bail',
            'type' => 'required|bail',
            'price' => 'required|bail',
            'qty' => 'required|bail',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()->first(), 'status' => 'validation'], 200);
        }


        if($request->ajax()) {
            if ($request->qty == '0') {
                return response()->json(['data' => 'Quantity has to be 1 or more.', 'status' => '400'], 200);
            } else if (!isset($request->email)) {
                return response()->json(['data' => 'Please enter your Email', 'status' => '400'], 200);
            } else if (!$request->phone_no) {
                return response()->json(['data' => 'Please enter your phone number.', 'status' => '400'], 200);
            }
        }

        $canpurchase = $this->canPurchase(floatval($request->price * $request->qty));
        //Check if the user has enough account balance before proceeding with the transaction
        if(!$canpurchase){
            return response()->json(['data' => 'Apologies! Your current balance is insufficient for this transaction.', 'status' => '400'], 200);
        }
        if($this->deductFromAccount($request->price, $request->qty) ){
        }else{
            return response()->json(['data' => 'An error occurred. Please Try again.', 'status' => '400'], 200);
        }
        //Add to Cart
        $cartItemId = $this->postToCart($request->price, $request->name, $request->signature, $request->qty);

        if(!$cartItemId){
            return response()->json(['data' => 'Apologies an Error Occurred. Try again', 'status' => '400'], 200);
        }
        $payload = [
            'quantity' => $request->qty,
            'price' => $request->price,
            'signature' => $request->signature,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'member_no' => Auth()->user()->member_id,
            'ref_no' => $cartItemId
        ];
        $response = $this->moviesProxy->redeemMovie($payload);

        if($response){
            if($response->status == 0){
                if($this->refundFailedTransToAccount($request->price,$request->qty)){
                    $this->deleteFromCart($cartItemId);
                    return response()->json(['data' => $response->message, 'status' => '400'], 200);
                }else{
                    return response()->json(['data' => 'An error occurred. Refund action failed', 'status' => '400'], 200);
                }
            }else{
                $cartUpdate = $this->updateCart($cartItemId, $response->voucher_code);
                if($cartUpdate){
                    $success = [ ['ref_no' => $cartItemId, "voucher_code" => $response->voucher_code ]];
                    $orderSaveStatus = $this->addOrder($response->order_no, $success, ($request->price * $request->qty));
                    $this->transactionRepository->SaveTransaction($request, $orderSaveStatus, ($request->price * $request->qty), null);

                    if(!$orderSaveStatus){
                        return response()->json(['data' => 'Failed to save Order', 'status' => '400'], 200);
                    }else{
                        $virtual_price = null;
                        $grand_total = null;
                        $spend_amount = null;
                        if (Auth::user()->currency->is_currency_fixed == '1'){
                            $virtual_price ='&#8358 '.number_format($request->price, 0, '.', ',');
                            $grand_total ='&#8358'.number_format($request->price * $request->qty, 0, '.', ',');
                            $spend_amount = number_format($request->price * $request->qty, 0, '.', ',');
                        }
                        else
                        {
                            $virtual_price = number_format(Auth::user()->currency->rate * $request->price  ) . ' ' . Auth::user()->currency->currency;
                            $grand_total = number_format(Auth::user()->currency->rate * ($request->price * $request->qty) ) . ' ' . Auth::user()->currency->currency;
                            $spend_amount = number_format(Auth::user()->currency->rate * ($request->price * $request->qty) );
                        }


                        $product_details[] = (object)[
                            'name' =>  $request->name,
                            'type' =>  $request->type,
                            'show_time' =>  $request->show_time,
                            'quantity' =>  $request->qty,
                            'price' =>  $virtual_price,
                            'delivery_type_name' => 'E-Channels',
                            'pickup_location_name' => '__',
                            'voucher' => $response->voucher_code,
                            'beneficiary' => $request->email,
                        ];


                        $receipt = $this->cinemasReceipt($product_details, $response->order_no, $grand_total );

                        $email_payload = [
                            'order_no' => $response->order_no,
                            'details' => $receipt,
                            'spend_amount' => $spend_amount
                        ];

                        $token = DB::table('company')->where('id', Auth::user()->company_id)->select('token')->first();

                        $this->notifyTransactionSuccess($token->token, $email_payload, "cinema");

                        return response()->json([
                            'data' => $orderSaveStatus,
                            'status' => '200',
                            'account' => Auth::user()->accountBalaceText(),
                            'message' => 'Transaction Successful'
                        ], 200);
                    }
                }else{
                    return response()->json(['data' => $cartUpdate, 'status' => '400'], 200);
                }
                return response()->json(['data' => $response->message, 'status' => '200'], 200);
            }
        }else{
            return response()->json(['data' => 'No response from the network', 'status' => '400'], 400);
        }
    }

}
