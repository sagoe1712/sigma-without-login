<?php

namespace App\Http\Controllers;

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

class BillsController extends Controller
{
    //Use Traits
    use Purchase, Transaction, Account, CartActions, OrderActions, EventsTrigger, EmailTemplates;
    protected $transactionRepository;
    public $billsProxy;
    public function __construct(TransactionRepository $transactionRepository, Bills $BillsProxy)
    {
//        $this->middleware(['auth'], ['except' => ['redeemBill', 'validateCode']]);
        $this->middleware(['web']);
        $this->transactionRepository =  $transactionRepository;
        $this->billsProxy = $BillsProxy;
    }

    public function index(){
        try{
            $categories = $this->billsProxy->getCategories();
            if(!$categories ){
                return response()->redirectToRoute('no_content');
            }else if($categories->status === 0){
                return response()->redirectToRoute('no_content');
            }
            $title = "Bills";
            return view('pages.bills.index', compact('categories', 'title'));
        }catch (\Exception $e){
            return response()->redirectToRoute('no_content');
        }
    }


    public function redeemBill(Request $request){



        $messages = [
            'customer_id.required' => $request->customerfield.' is required',
        ];

        $validator = Validator::make($request->all(), [
            'phone_no' => 'required|min:10|max:11',
            'email' => 'required|min:5|max:255|email',
            'customer_id' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()->first(), 'status' => '400'], 400);
        }

        $payload = [];

        $canpurchase = $this->canPurchase(floatval($request->price * 1));
        //Check if the user has enough account balance before proceeding with the transaction

        if(!$canpurchase){
            return response()->json(['data' => 'Apologies! Your current balance is insufficient for this transaction.', 'status' => '400'], 200);
        }

        if($this->deductFromAccount($request->price, 1) ){
            //Add properties to the array
            $payload['customer_id'] = $request->customer_id;
            $payload['member_no'] = Auth::user()->member_id;
            $payload['price'] = $request->price;
            $payload['signature'] = $request->signature;
            $payload['email'] = $request->email;
            $payload['phone_no'] = $request->phone_no;
        }else{
            return response()->json(['data' => 'An error occurred. Please Try again.', 'status' => '400'], 200);
        }
        //Add to Cart
        $cartItemId = $this->postToCart($request->price, $request->packagename, $request->signature, 1);
        if(!$cartItemId){
            return response()->json(['data' => 'Apologies an Error Occurred. Try again', 'status' => '400'], 200);
        }
        try{
            $payload['ref_no'] = $cartItemId;
            $response = $this->billsProxy->redeem($payload);

            if($response){
                if ($response->status === 0){
                    if($this->refundFailedTransToAccount($request->price, 1)){
                        $this->deleteFromCart($cartItemId);
                        return response()->json(['data' => $response->message, 'status' => '400', 'failed' => 'Yes'], 200);
                    }else{
                        return response()->json(['data' => 'An error occurred. Refund action failed', 'status' => 'fail'], 200);
                    }

                } elseif ($response->status === 99){

                    return response()->json(['data' => 'Tranaction Pending', 'status' => 'fail'], 200);
                }
                try {
                    $cartUpdate = $this->updateCart($cartItemId, $response->voucher_code,"delivered");
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
                                'beneficiary' => $request->customer_id,
                            ];


                            $receipt = $this->billsReceipt($product_details, $response->order_no, $virtual_price);

                            $email_payload = [
                                'order_no' => $response->order_no,
                                'details' => $receipt,
                                'spend_amount' => $spend_amount
                            ];

                            $token = DB::table('company')->where('id', Auth::user()->company_id)->select('token')->first();

                            $this->notifyTransactionSuccess($token->token, $email_payload, "bills");

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
                    //$this->refundFailedTransToAccount($request->price, $request->qty);
                    return response()->json(['data' => 'Failed to record Order', 'reason' => $e->getMessage(), 'status' => '400'], 400);
                }
                return response()->json(['data' => 'Transaction successfull', 'status' => '200'], 200);

            }else{
                //$this->refundFailedTransToAccount($request->price, $request->qty);
                return response()->json(['data' => 'No response from the network', 'status' => 'fail'], 200);
            }
        }catch (\Exception $e){
            //$this->refundFailedTransToAccount($request->price, $request->qty);
            return response()->json(['data' => 'Try again please. A network error occurred.', 'status' => '400'], 400);
        }
    }

    public function getPaymentVendors($id){
        try{

            if(Auth::guest()){
                redirect()->guest('login');
            }


            $payload = [
                'category_id' => $id,
//                $payload['member_no'] = Auth::user()->member_id
            ];
            $products = $this->billsProxy->getCategoryContent($payload);

//            dd($products);

            if($products){
                if($products->status == 0){
                    return back()->withErrors($products->message);
                }
                return view('pages.bills.bills_vendor_products', compact('products'));
            }
            return response()->redirectToRoute('no_content');
        }catch (\Exception $e){
            return response()->redirectToRoute('no_content');
        }
    }


    public function validateCode(Request $request){
        try{
            $payload = [
                'signature' => $request['signature'],
                'customer_id' => $request['customer_id'],
                $payload['member_no'] = Auth::user()->member_id
            ];
            $response = $this->billsProxy->validatePin($payload);

            if($response){
                if($response->status == 0){
                    return response()->json(['data' => $response->message, 'status' => 'fail'], 200);
                }
                return response()->json(['data' => $response, 'status' => '200'], 200);
            }
            return response()->json(['data' => 'No response from the network', 'status' => 'fail'], 200);
        }catch (\Exception $e){
            return response()->json(['data' => 'Error! Process failed.', 'status' => 'fail'], 200);
        }
    }

}
