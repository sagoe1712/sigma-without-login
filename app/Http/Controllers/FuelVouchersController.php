<?php

namespace App\Http\Controllers;

use App\Repository\TransactionRepository;
use App\Http\Proxy\FuelVoucher;
use App\Traits\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

class FuelVouchersController extends Controller
{
    //Use Traits
    use Purchase, Transaction, Account, CartActions, OrderActions, EventsTrigger, EmailTemplates;

    protected $fuelVouchersProxy;
    protected $transactionRepository;
    public function __construct(TransactionRepository $transactionRepository, FuelVoucher $fuelVouchersProxy)
    {
        $this->fuelVouchersProxy = $fuelVouchersProxy;
        $this->transactionRepository =  $transactionRepository;
        $this->middleware(['web', 'auth']);
    }

    public function index(){
        $title = "Fuel Vouchers";
        $stations = $this->fuelVouchersProxy->getFuelStations();

        if(!$stations) {
            return response()->redirectToRoute('no_content');
        }
        elseif($stations->status == 0){
            return response()->redirectToRoute('no_content');
        }
        else {

            return view('pages.fuel.index', compact('stations','title'));
        }
    }

    public function getVouchers(Request $request){
        $payload['member_no'] = Auth::user()->member_id;
        $payload['category_id'] = $request['category_id'];
        $vouchers = $this->fuelVouchersProxy->getFuelVouchers($payload);

        if(!$vouchers) {
            return response()->json(['message' => 'Failed to load vouchers', 'reason' => 'Wrong response format'], 400);
        }
        elseif($vouchers->status == 0){
            return response()->json(['message' => 'Failed to load vouchers', 'reason' => $vouchers->message], 400);
        }
        else {
            return response()->json(['data' => $vouchers, 'message' => 'Vouchers loaded']);
        }
    }

    public function redeem(Request $request){

        $messages = [
            'phone_no.numeric' => 'Phone number must be numbers',
        ];

        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|numeric|regex:/[0-9]{9}/|bail',
            'email' => 'required|min:5|max:255|email',
            'qty' => 'required',
            'signature' => 'required',
            'packagename' => 'required',
            'price' => 'required'
        
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(),
            ], 400);
        }

        $payload = [];
        $canpurchase = $this->canPurchase(floatval($request->price * $request->qty));
        //Check if the user has enough account balance before proceeding with the transaction
        if(!$canpurchase){
            return response()->json(['message' => 'Apologies! Your current balance is insufficient for this transaction.'], 400);
        }

        if($this->deductFromAccount($request->price, 1) ){
            //Add properties to the array
            $payload['member_no'] = Auth::user()->member_id;
            $payload['price'] = $request->price;
            $payload['quantity'] = $request->qty;
            $payload['signature'] = $request->signature;
            $payload['email'] = $request->email;
            $payload['phone_no'] = $request->phone_no;
        }else{
            return response()->json(['message' => 'An error occurred. Please Try again.'], 400);
        }
        //Add to Cart
        try {
            $cartItemId = $this->postToCart($request->price, $request->packagename, $request->signature, 1);
        }catch (\Exception $e){
            if($this->refundFailedTransToAccount($request->price, $request->qty)){
                return response()->json(['message' => 'Failed to add to cart. Please try again.', 'reason'=> $e->getMessage()], 400);
            }else{
                return response()->json(['message' => 'An error occurred. Refund action failed.'], 400);
            }
        }
        if(!$cartItemId){
            return response()->json(['message' => 'Apologies an Error Occurred. Try again'], 400);
        }
        try{
            $response = $this->fuelVouchersProxy->redeem($payload);

            if($response){
                if ($response->status === 0){
                    if($this->refundFailedTransToAccount($request->price, $request->qty)){
                        $this->deleteFromCart($cartItemId);
                        return response()->json(['message' => $response->message], 400);
                    }else{
                        return response()->json(['message' => 'An error occurred. Refund failed'], 400);
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
                            return response()->json(['message' => 'Failed to save Order'], 400);
                        }else{

                            $virtual_price = null;
                            $grand_total = null;
                            $spend_amount = null;
                            if (Auth::user()->currency->is_currency_fixed == '1'){
                                $virtual_price = '&#8358'. number_format($request->price, 0, '.', ',');
                                $grand_total = '&#8358'. number_format($request->price * $request->qty, 0, '.', ',');
                                $spend_amount = number_format($request->price * $request->qty, 0, '.', ',');
                            }
                            else
                            {
                                $virtual_price = number_format(Auth::user()->currency->rate * $request->price, 2, '.', ',') . ' ' . Auth::user()->currency->currency;
                                $grand_total = number_format(Auth::user()->currency->rate * ($request->price * $request->qty) ) . ' ' . Auth::user()->currency->currency;
                                $spend_amount = number_format(Auth::user()->currency->rate * ($request->price * $request->qty) );
                            }

                            $product_details[] = (object)[
                                'name' =>  $request->packagename,
                                'address' =>  $request->address,
                                'station' =>  $request->station,
                                'quantity' =>  '1',
                                'price' =>  $virtual_price,
                                'delivery_type_name' => 'E-Channel',
                                'pickup_location_name' => '__',
                                'voucher' => $response->voucher_code,
                                'beneficiary' => $request->email,
                            ];

                            $receipt = $this->fuelReceipt($product_details, $response->order_no, $grand_total);

                            $email_payload = [
                                'order_no' => $response->order_no,
                                'details' => $receipt,
                                'spend_amount' => $spend_amount
                            ];

                            $token = DB::table('company')->where('id', Auth::user()->company_id)->select('token')->first();

                            $this->notifyTransactionSuccess($token->token, $email_payload, "fuel");

                            return response()->json(['order_id' => $orderSaveStatus, 'message' => 'Transaction Successful'], 200);
                        }
                    }else{
                        return response()->json(['message' => $cartUpdate], 400);
                    }
                    return response()->json(['message' => $response->message], 400);
                }catch (\Exception $e){
                    return response()->json(['massage' => 'Failed to record Order ', 'reason' => $e->getMessage()], 400);
                }
                return response()->json(['message' => 'Transaction successfull'], 200);

            }else{
                $this->refundFailedTransToAccount($request->price, $request->qty);
                return response()->json(['message' => 'No response from the network. Try again please.'], 400);
            }
        }catch (\Exception $e){
            $this->refundFailedTransToAccount($request->price, $request->qty);
            return response()->json(['message' => 'Try again please. A network error occurred.'], 400);
        }
    }


}
