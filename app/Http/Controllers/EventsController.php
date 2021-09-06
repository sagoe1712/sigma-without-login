<?php

namespace App\Http\Controllers;

use App\Traits\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repository\TransactionRepository;
use Validator;
use DB;

//Import Traits
use App\Traits\Purchase;
use App\Traits\Transaction;
use App\Traits\Account;
use App\Traits\CartActions;
use App\Traits\OrderActions;
use App\Http\Proxy\Events;
use App\Traits\EventsTrigger;

class EventsController extends Controller
{
    use Purchase, Transaction, Account, CartActions, OrderActions, EventsTrigger,EmailTemplates;
    protected $eventsProxy;
    protected $transactionRepository;
    public function __construct(TransactionRepository $transactionRepository, Events $EventsProxy)
    {
        $this->eventsProxy = $EventsProxy;
        $this->transactionRepository =  $transactionRepository;
//        $this->middleware(['web', 'auth']);
    }


    public function index(){
        if(Auth::guest()){
            redirect()->guest('login');
        }

        try {
            $data = $this->eventsProxy->getEvents();

            if ($data) {
                if (!isset($data)) {
                    return back()->withErrors("A network Error Occurred. Please try again.");
                }
                $title = "Events";
                return view('pages.events.index', compact('data', 'title'));
            }
            return response()->redirectToRoute('no_content');
        }catch (\Exception $e){
            return response()->redirectToRoute('no_content');
        }
    }

    public function redeem(Request $request){
        $messages = [
            'phone_no.numeric' => 'Phone number must be numbers',
        ];

        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|numeric|regex:/[0-9]{9}/|bail',
            'email' => 'required|min:5|max:255|email|bail',
            'name' => 'required|bail',
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

        $canpurchase = $this->canPurchase( floatval($request->price * $request->qty));
        //Check if the user has enough account balance before proceeding with the transaction
        if(!$canpurchase){
            return response()->json(['data' => 'Apologies! Your current balance is insufficient for this transaction.', 'status' => '400'], 200);
        }
        if(!$this->deductFromAccount($request->price, $request->qty) ) {
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
            'member_no' => Auth()->user()->member_id
        ];

        $response = $this->eventsProxy->redeem($payload);

        if($response){
            if($response->status == 0){
                if($this->refundFailedTransToAccount($request->price, $request->qty)){
                    $this->deleteFromCart($cartItemId);
                    return response()->json(['data' => $response->message, 'status' => '400'], 200);
                }else{
                    return response()->json(['data' => 'An error occurred. Refund action failed', 'status' => '400'], 200);
                }
            }else{
                try {
                    $cartUpdate = $this->updateCart($cartItemId, $response->voucher_code);
                    if($cartUpdate){
                        //Add to Order
                        $success = [ ['ref_no' => $cartItemId, "voucher_code" => $response->voucher_code ]];
                        $orderSaveStatus = $this->addOrder($response->order_no, $success, ($request->price * $request->qty));
                        //Save Transaction

                        $this->transactionRepository->SaveTransaction($request, $orderSaveStatus, ($request->price * $request->qty), null);

                        if(!$request->qty){
                            return response()->json(['data' => 'Failed to save Order', 'status' => '400'], 200);
                        }else{
                            $virtual_price = null;
                            $grand_total = null;
                            $spend_amount = null;
                            if (Auth::user()->currency->is_currency_fixed == '1'){
                                $virtual_price = '&#8358'. number_format($request->price * $request->qty);
                                $grand_total = '&#8358'. number_format($request->price * $request->qty, 0, '.', ',');
                                $spend_amount =  number_format($request->price * $request->qty, 0, '.', ',');
                            }
                            else
                            {
                                $virtual_price = number_format(Auth::user()->currency->rate * ($request->price) ) . ' ' . Auth::user()->currency->currency;
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

                            $receipt = $this->eventsReceipt($product_details, $response->order_no, $grand_total);

                            $email_payload = [
                                'order_no' => $response->order_no,
                                'details' => $receipt,
                                'spend_amount' => $spend_amount
                            ];

                            $token = DB::table('company')->where('id', Auth::user()->company_id)->select('token')->first();

                            $this->notifyTransactionSuccess($token->token, $email_payload, "event");
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
                }catch (\Exception $e){
                    return response()->json(['data' => 'Failed to record Order ' . $e->getMessage(), 'status' => '400'], 400);
                }
                return response()->json(['data' => 'Transaction successfull', 'status' => '200'], 200);
            }
        }
    }

}
