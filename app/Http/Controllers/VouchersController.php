<?php

namespace App\Http\Controllers;

use App\Http\Proxy\Vouchers;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Repository\TransactionRepository;

//Import Traits
use App\Traits\Purchase;
use App\Traits\Transaction;
use App\Traits\Account;
use App\Traits\CartActions;
use App\Traits\OrderActions;
use App\Traits\EventsTrigger;
use App\Traits\EmailTemplates;

class VouchersController extends Controller
{
    //Use Traits
    use Purchase, Transaction, Account, CartActions, OrderActions, EventsTrigger, EmailTemplates;
    protected $transactionRepository;
    /**
     * @var Vouchers
     */
    private $vouchersProxy;

    /**
     * VouchersController constructor.
     * @param Vouchers $vouchers
     */
    public function __construct(Vouchers $vouchers, TransactionRepository $transactionRepository)
    {
//        $this->middleware(['auth'], ['except' => ['uberRedeem']]);
//        $this->middleware('web');
        $this->transactionRepository =  $transactionRepository;
        $this->vouchersProxy = $vouchers;
    }

    public function uberIndex(){

        if(Auth::guest()){
            redirect()->guest('login');
        }


        try{
            $response = $this->vouchersProxy->getUberVouchers();

            if($response){
                return view('pages.vouchers.uber.index', compact('response'));
            }else{
                return response()->redirectToRoute('no_content');
            }

        }catch (\Exception $e){
            return response()->redirectToRoute('no_content');
        }
    }

    public function uberRedeem(Request $request){
        try{
            $messages = [
                'phone_no.required' => 'Phone number is required',
                'signature.required' => 'Invalid transaction',
            ];

            $validator = Validator::make($request->all(), [
                'phone_no' => 'required|min:10|max:11',
                'email' => 'required|min:5|max:255|email',
                'price' => 'required',
                'signature' => 'required',
            ], $messages);

            if ($validator->fails()) {
                return response()->json(['message' => $validator->messages()->first(), 'status' => 'validation'], 200);
            }

            if($request->max_quantity < $request->qty){
                return response()->json(['message' => 'Voucher unavailable for specified quantity', 'status' => 'validation'], 200);
            }

            $payload = [];
            //Check if the user has enough account balance before proceeding with the transaction
            $canpurchase = $this->canPurchase(ceil($request->price * $request->qty));
            if(!$canpurchase){
                return response()->json(['data' => 'Sorry! Your current balance is insufficient for this transaction.', 'status' => '400'], 200);
            }

            if($this->deductFromAccount($request->price, $request->qty) ){
                //Add properties to the array
                $payload = [
                    'member_no' => Auth::user()->member_id,
                    'signature' => $request->signature,
                    'phone_no' => $request->phone_no,
                    'email' => $request->email,
                    'price' => $request->price,
                    'quantity' => $request->qty,
                ];
            }else{
                return response()->json(['data' => 'Transaction failed. Please Try again.', 'status' => '400'], 200);
            }

            //Add to Cart
            $cartItemId = $this->postToCart($request->price, $request->packagename, $request->signature, 1);
            if(!$cartItemId){
                return response()->json(['data' => 'Transaction failed. Please Try again.', 'status' => '400'], 200);
            }

            try {

                //Send transaction
                $response = $this->vouchersProxy->redeemUberVouchers($payload);


                //confirm transaction
                if ($response) {
                    if ($response->status === 0) {
                        if ($this->refundFailedTransToAccount($request->price, $request->qty)) {
                            $this->deleteFromCart($cartItemId);
                            return response()->json(['data' => $response->message, 'status' => '400', 'failed' => 'Yes'], 200);
                        } else {
                            return response()->json(['data' => 'An error occurred. Refund action failed', 'status' => 'fail'], 200);
                        }

                    }
                    try {
                        $cartUpdate = $this->updateCart($cartItemId, $response->voucher_code);
                        if($cartUpdate){
                            //Add to Order
                            $success = [ ['ref_no' => $cartItemId, "voucher_code" => $response->voucher_code ]];
                            $orderSaveStatus = $this->addOrder($response->order_no, $success, $request->price);
                            //Save Transaction
                            $this->transactionRepository->SaveTransaction($request, $orderSaveStatus, $request->price, null);

                            if(!$orderSaveStatus){
                                return response()->json(['data' => 'Failed to save Order', 'status' => '400'], 200);
                            }else{

                                $virtual_price = null;
                                $spend_amount = null;
                                if (Auth::user()->currency->is_currency_fixed == '1'){
                                    $virtual_price ='&#8358'.number_format($request->price, 0, '.', ',');
                                    $spend_amount = number_format($request->price, 0, '.', ',');
                                }
                                else
                                {
                                    $virtual_price = number_format(Auth::user()->currency->rate * $request->price, 0, '.', ',') . ' ' . Auth::user()->currency->currency;
                                    $spend_amount = number_format(Auth::user()->currency->rate * $request->price, 0, '.', ',');
                                }

                                $product_details[] = (object)[
                                    'name' =>  $request->packagename,
                                    'quantity' =>  '1',
                                    'price' =>  $virtual_price,
                                    'delivery_type_name' => 'E-Channels',
                                    'pickup_location_name' => '__',
                                    'voucher' => $response->voucher_code,
                                    'beneficiary' => $request->phone_no,
                                ];


                                $vouchers = isset($response->data) ? $response->data : [];
                                $receipt = $this->uberReceipt($product_details, $response->order_no, $virtual_price, $vouchers);

                                $email_payload = [
                                    'order_no' => $response->order_no,
                                    'details' => $receipt,
                                    'spend_amount' => $spend_amount
                                ];


                                $this->notifyTransactionSuccess(Auth::user()->company->token, $email_payload, "uber");

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

                    }catch (\Exception $e){
                        $this->refundFailedTransToAccount($request->price, $request->qty);
                        return response()->json(['data' => 'Failed to record Order', 'reason' => $e->getMessage(), 'status' => '400'], 400);
                    }

                } else {
                    //Refund to customer because
                    $this->refundFailedTransToAccount($request->price, $request->qty);
                    return response()->json(['data' => 'No response from the network', 'status' => 'fail'], 200);
                }
            }catch (\Exception $e){
                $this->refundFailedTransToAccount($request->price, $request->qty);
                return response()->json(['data' => 'Try again please. A network error occurred.', 'status' => '400'], 400);
            }

        }catch (\Exception $e){
            return response()->json(['data' => 'Try again please. A network error occurred.', 'reason' =>$e->getMessage(), 'status' => '400'], 400);
        }
    }
}
