<?php

namespace App\Http\Controllers;

use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Company;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Jobs\EnrollMembers;
use App\Http\Validators\ValidateInput;
use App\Repository\UserRepository;

class ApiController extends Controller
{

    //Zero based Status indicators
    private $transtype = [
        'debit' => 0,
        'credit' => 1
    ];
    private $is_internal_action = [
        'external' => 0,
        'internal' => 1
    ];

    private $cartstatus = [
        'cancelled' => 0,
        'pending' => 1,
        'shipped' => 2,
        'delivered' => 3,
        'processing' => 4,
        'expired' => 5,
        'noncart' => 6,
        'deleted' => 7
    ];

    public function __construct(ValidateInput $validateInput, UserRepository $userRepository)
    {
    $this->validateInput = $validateInput;
    $this->userRepository = $userRepository;
    }

    private function currency($company_id){
      $currency = \App\Setting::where('company_id', $company_id)->select('name', 'rate', 'currency', 'is_currency_fixed')->first();
      return $currency;
    }

    public function updateCurrency(Request $request){
        $validator = Validator::make($request->all(), [
            'rate' => 'required',
            'currency' => 'required',
            'is_currency_fixed' => 'required',
            'client_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }

        $company = Company::where('client_number', $request->client_number)->select('id')->first();

        if(count($company) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }

        try {
             DB::table('setting')
                ->where('company_id', $company->id)
                ->update([
                    'rate' => $request->rate,
                    'currency' => $request->currency,
                    'is_currency_fixed' => $request->is_currency_fixed
                ]);

            $newsetting = DB::table('setting')
                ->join('company', 'setting.company_id', '=', 'company.id')
                ->where('company_id', $company->id)
                ->select('company.name as company_name', 'setting.rate', 'setting.currency', 'setting.is_currency_fixed')->first();
            return response()->json(['message' => 'Success Settings updated', 'data' => $newsetting, 'status' => '200'], 200);
        }catch (\Exception $e){
            return response()->json(['data' => 'An error occurred' . $e->getMessage(), 'status' => '400'], 400);
        }
    }

    public function convertCurrency(Request $request){
        $validator = Validator::make($request->all(), [
            'point' => 'required',
            'client_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        try {
            $company = Company::where('client_number', $request->client_number)->select('id')->first();
            if(count($company) == 0){
                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
            }
            $currency = DB::table('setting')
                ->where('company_id', $company->id)
                ->select(
                    'rate',
                    'currency'
                )
                ->first();
            $data = [
              'point_virtual' => ($request->point * $currency->rate),
              'currency' => $currency->currency
            ];
            return response()->json(['data' => $data, 'status' => '200'], 200);
        }catch (\Exception $e){
            return response()->json(['data' => 'An error occurred' . $e->getMessage(), 'status' => '400'], 400);
        }
    }

//    public function deleteSetting(Request $request){
//        $validator = Validator::make($request->all(), [
//            'company_id' => 'required',
//        ]);
//        if ($validator->fails()) {
//            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
//        }
//        try {
//            DB::table('setting')
//                ->where('company_id', $request->company_id)
//                ->delete();
//            return response()->json(['data' => 'Success Settings Deleted', 'status' => '200'], 200);
//        }catch (\Exception $e){
//            return response()->json(['data' => 'An error occurred' . $e->getMessage(), 'status' => '400'], 400);
//        }
//    }

    public function appCurrency(Request $request){
        $validator = Validator::make($request->all(), [
            'client_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        try {
            $company = Company::where('client_number', $request->client_number)->select('id')->first();
            if(count($company) == 0){
                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
            }

            $currency = DB::table('setting')
                ->join('company', 'setting.company_id', '=', 'company.id')
                ->where('company_id', $company->id)
                ->select('company.name as company_name', 'setting.rate', 'setting.currency', 'setting.is_currency_fixed')->first();

            return response()->json(['data' => $currency, 'status' => '200'], 200);

        }catch (\Exception $e){
            return response()->json(['data' => 'Error getting Application Currency data'.$e->getMessage(), 'status' => '400'], 400);
        }
    }

    public function postCustomerStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'client_number' => 'required',
            'member_id' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        $companyid = Company::where('client_number', $request->client_number)->pluck('id');

        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }
        $userExists = User::where([
            ['id', $request->member_id],
            ['company_id', $companyid[0]]
        ])->count();


        if($userExists > 0) {
            $status = \App\User::where(
                [
                    ['id', '=', $request->member_id],
                    ['company_id', '=', $companyid[0]]
                ]
            )->update(['status' => $request->status]);
            return response()->json(['data' => $status, 'status' => '200'], 200);
        }else{
            return response()->json(['data' => 'Member does not exist', 'status' => '400'], 400);

        }
    }
    public function getCustomers(Request $request){
        try {
            if ($request->has('member_id')) {
                $customer = \App\User::where('id', $request->member_id)->select('firstname', 'lastname', 'email', 'company_id', 'phone', 'address')->get();
                return response()->json(['data' => $customer, 'status' => '200'], 200);
            }
            $customers = \App\User::select('firstname', 'lastname', 'email', 'company_id', 'phone', 'address')->get();
            return response()->json(['data' => $customers, 'status' => '200'], 200);
        }catch (\Exception $e){
            return response()->json(['data' => 'An Error Occurred '. $e->getMessage(), 'status' => '400'], 400);
        }
    }

    public function getCustomersPlusAccount(Request $request){
        $customersAccount = \App\User::join('accounts', function ($join){
            $join->on('users.id', '=', 'accounts.user_id');
            $join->on('accounts.company_id', '=', 'users.company_id');
            })
            ->select(
                'users.firstname',
                'users.lastname',
                'users.email',
                'users.company_id',
                'users.phone',
                'users.address',
                'accounts.point as account'
            )
            ->get();
        return response()->json(['data' => $customersAccount, 'status' => '200'], 200);
    }

//    public function getCustomerAccount(Request $request){
//
//        if($request->has(['user_id', 'company_id'])){
//
//            try {
//                $customersAccount = \App\Accounts::where(
//                    [
//                        ['accounts.user_id', '=', $request->user_id],
//                        ['accounts.company_id', '=', $request->company_id]
//                    ]
//                )->pluck('point');
//
//                return response()->json(['data' => $customersAccount[0], 'status' => 'success'], 200);
//            }catch (\Exception $e){
//                return response()->json(['data' => 'An Error Occurred. Try again.' . $e->getMessage(), 'status' => 'success'], 200);
//            }
//        }else{
//            return response()->json(['data' => 'Expected Parameters: user_id,company_id ', 'status' => 'fail'], 400);
//        }
//    }

    public function getTransactions(){
            try {
                $transactions = \App\Order::all();

                return response()->json(['data' => $transactions, 'status' => 'success'], 200);
            }catch (\Exception $e){
                return response()->json(['data' => 'An Error Occurred. Try again.' . $e->getMessage(), 'status' => '200'], 200);
            }
        }

    public function getCustomerOrder(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'client_number' => 'required',
                'member_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
            }
            $companyid = Company::where('client_number', $request->client_number)->pluck('id');

            if(count($companyid) == 0){
                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
            }
            $userExists = User::where([
                ['id', $request->member_id],
                ['company_id', $companyid[0]]
            ])->count();


            if($userExists > 0) {
                $transactions = \App\Order::where(
                    [
                        ['user_id', '=', $request->member_id],
                        ['company_id', '=', $companyid[0]]
                    ]
                )->get();
                return response()->json(['data' => $transactions, 'status' => '200'], 200);
            }else{
                return response()->json(['data' => 'Member does not exist', 'status' => '400'], 400);

            }

        }

    public function getCompanyOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'client_number' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
            $companyid = Company::where('client_number', $request->client_number)->pluck('id');

            if(count($companyid) == 0){
                return response()->json(['data' => 'company does not exist', 'status' => '400'], 400);
            }

        $data = [];
        $data['company'] = \App\Company::find($companyid[0]);

            try {
                $transactions = \App\Order::where('orders.company_id', '=', $companyid[0])
                    ->join('shipping_address', 'orders.address_id', '=', 'shipping_address.id')
                ->join('company', 'orders.company_id', '=', 'company.id')
                    ->select(
                        'orders.id',
                        'orders.sub_total_cost',
                        'orders.is_shipping',
                        'orders.shipping_cost',
                        'orders.success',
                        'orders.fail',
                        'orders.created_at as date'
                        )
                    ->get();
                $data['details'] =  $transactions;
                return response()->json(['data' => $data, 'status' => '200'], 200);
            } catch (\Exception $e) {
                return response()->json(['data' => 'An Error Occurred. Try again.' . $e->getMessage(), 'status' => '400'], 400);
            }
    }

    public function CreateCompany(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'token' => 'required|unique:company,token',
                'client_number' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
            }

        //Check if Company exists
        $companyExists = Company::where([
                ['token', '=', $request->token],
                ['client_number', '=', $request->client_number]
            ]
        )->count();


            if(!$companyExists) {
                DB::beginTransaction();
                try {
                    $company = new Company();
                    $company->name = $request->name;
                    $company->token = $request->token;
                    $company->client_number = $request->client_number;
                    $company->save();

                        $setting = new Setting();
                        $setting->company_id = $company->id;
                        $setting->name = $company->name;
                        $setting->rate = 1;
                        $setting->currency = "points";
                        $setting->is_currency_fixed = 1;
                        $setting->save();

                    if(!$company || !$setting){
                        DB::rollBack();
                    }

                    DB::commit();
                    return response()->json(['data' => ['company' => $company, 'setting' => $setting], 'status' => '200'], 200);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json(['data' => "An Error Occurred" . $e->getMessage(), 'status' => '400'], 400);
                }
            }else{
                return response()->json(['data' => "Company already registered", 'status' => '400'], 400);
            }
    }

    protected function MemberCreate(Request $request)
    {

    $status = 0;

        //Validate request
        $validatorFirstname = Validator::make($request->all(), [
            'firstname' => 'required|max:255'
        ]);

        if ($validatorFirstname->fails()) {
            return response()->json(['data' => 'firstname is Required', 'status' => '400'], 400);
        }
        $validatorLastname = Validator::make($request->all(), [
            'lastname' => 'required|max:255'
        ]);

        if ($validatorLastname->fails()) {
            return response()->json(['data' => 'lastname is Required', 'status' => '400'], 400);
        }
        $validatorEmail = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
        ]);

        if ($validatorEmail->fails()) {
            return response()->json(['data' => 'email validation error', 'status' => '400'], 400);
        }

        $validatorMemberId = Validator::make($request->all(), [
            'member_id' => 'required|unique:users,member_id',

        ]);

        if ($validatorMemberId->fails()) {
            return response()->json(['data' => 'member number already exists', 'status' => '400'], 400);
        }

        $validatorPassword = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validatorPassword->fails()) {
            return response()->json(['data' => 'Password validation error', 'status' => '400'], 400);
        }

        $validatorClientNumber = Validator::make($request->all(), [
            'client_number' => 'required'
        ]);

        if ($validatorClientNumber->fails()) {
            return response()->json(['data' => 'client_number required', 'status' => '400'], 400);
        }

        $validatorPoint = Validator::make($request->all(), [
            'point' => 'required'
        ]);

        if ($validatorPoint->fails()) {
            return response()->json(['data' => 'point required', 'status' => '400'], 400);
        }




        //Get company ID
        $companyid = Company::where('client_number', $request->client_number)->pluck('id');
        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }

        $currency = $this->currency($companyid[0]);

        $userExists = User::where([
                ['company_id', '=', $companyid[0]],
                ['email', '=', $request->email]
            ]
        )->count();

        if ($userExists > 0) {
            return response()->json(['data' => 'Customer already exists under a company', 'status' => '400'], 400);
        }


        if(isset($request['status'])){
            $status = $request['status'];
        }

            //Start transaction
            DB::beginTransaction();
            try {
                //Create a new member
                $member = new User();
                $member->firstname = $request['firstname'];
                $member->member_id = $request['member_id'];
                $member->lastname = $request['lastname'];
                $member->company_id = $companyid[0];
                $member->name = $request['firstname'] . " " . $request['lastname'];
                $member->email = $request['email'];
                $member->phone = $request['phone'];
                $member->address = $request['address'];
                $member->country_name = $request['country_name'];
                $member->state_name = $request['state_name'];
                $member->city_name = $request['city_name'];
                $member->country_id = $request['country_id'];
                $member->state_id = $request['state_id'];
                $member->city_id = $request['city_id'];
                $member->status = $status;
                $member->password = bcrypt($request['password']);
                $member->save();

                //Credit the member just created
                $account = new \App\Accounts();
                $account->user_id = $member->id;
                $account->point = $request->point;
                $account->company_id = $companyid[0];
                $account->save();

                //Check if there's any error, rollback transaction is any error
                if(!$member || !$account){
                    DB::rollBack();
                }
                //Commit transaction
                DB::commit();

                $response = [
                    'firstname' => $member->firstname,
                    'lastname' => $member->lastname,
                    'email' => $member->email,
                    'client_number' => $request->client_number,
                    'member_number' => $member->member_id,
                    'member_id' => $member->id,
                    'phone' => $member->phone,
                    'status' => $member->status,
                    'balance_raw' => $account->point,
                    'balance_virtual' => $account->point * (!$currency->is_currency_fixed ? $currency->rate : 1),

                ];


                //Return data with the newly created Member
                return response()->json(['data' => $response, 'status' => '200'], 200);

            }catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['data' => "An Error Occurred" . $e->getMessage(), 'status' => '400'], 400);
            }

    }

    protected function MemberUpdate(Request $request)
    {

        //Validate request
        $validatorFirstname = Validator::make($request->all(), [
            'firstname' => 'required|max:255'
        ]);

        if ($validatorFirstname->fails()) {
            return response()->json(['data' => 'firstname is Required', 'status' => '400'], 400);
        }
        $validatorLastname = Validator::make($request->all(), [
            'lastname' => 'required|max:255'
        ]);

        if ($validatorLastname->fails()) {
            return response()->json(['data' => 'lastname is Required', 'status' => '400'], 400);
        }


        $validatorMemberId = Validator::make($request->all(), [
            'member_id' => 'required',

        ]);

        if ($validatorMemberId->fails()) {
            return response()->json(['data' => 'member number required', 'status' => '400'], 400);
        }


        $validatorClientNumber = Validator::make($request->all(), [
            'client_number' => 'required'
        ]);

        if ($validatorClientNumber->fails()) {
            return response()->json(['data' => 'client number required', 'status' => '400'], 400);
        }

        $validatorStatus = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validatorStatus->fails()) {
            return response()->json(['data' => 'status required', 'status' => '400'], 400);
        }


        //Get company ID
        $companyid = Company::where('client_number', $request->client_number)->pluck('id');
        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }


        if(isset($request['status'])){
            $status = $request['status'];
        }


            try {
                //update member
                $member =  User::where('member_id', $request['member_id']);
                $member->update(
                    [
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'name' => ($request['firstname'] . " " . $request['lastname']),
                'phone' => $request['phone'],
                'status' => $status,
//                $member->address = $request['address'];
//                $member->country_name = $request['country_name'];
//                $member->state_name = $request['state_name'];
//                $member->city_name = $request['city_name'];
//                $member->country_id = $request['country_id'];
//                $member->state_id = $request['state_id'];
//                $member->city_id = $request['city_id'];
                ]
            );

                return response()->json(['data' => ' Account updated', 'status' => '200'], 200);

            }catch (\PDOException $e) {
                DB::rollBack();
                return response()->json(['data' => "An Error Occurred. Could not update account", 'reason' => $e->getMessage(), 'status' => '400'], 400);
            }

    }

    public function getCompanyCustomers(Request $request){

        $validator = Validator::make($request->all(), [
            'client_number' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        $companyid = Company::where('client_number', $request->client_number)->pluck('id');
        $currency = $this->currency($companyid[0]);

        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }

        $customers = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->select(
                'users.id as member_id',
                'users.firstname',
                'users.lastname',
                'users.member_id as member_number',
                'users.phone',
                'users.status',
                'users.address',
                'users.company_id',
                'users.email',
                'users.created_at',
                'accounts.point as point_raw'
                )
            ->addSelect(DB::raw(" (accounts.point * $currency->rate) as point_virtual") )
            ->where('users.company_id', $companyid[0])
            ->get();
        return response()->json(['data' => $customers, 'status' => '200'], 200);

    }

    public function getCompanyCustomer(Request $request){

        $validator = Validator::make($request->all(), [
            'client_number' => 'required',
            'member_number' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        $company = Company::where('client_number', $request->client_number)->select('id')->first();
        if(count($company) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }
        $currency = $this->currency($company->id);

        $customers = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->select(
                'users.id as member_id',
                'users.firstname',
                'users.lastname',
                'users.member_id as member_number',
                'users.phone',
                'users.status',
                'users.address',
                'users.company_id',
                'users.email',
                'users.created_at',
                'accounts.point as point_raw'
            )
            ->addSelect(DB::raw(" (accounts.point * $currency->rate) as point_virtual") )
            ->where('users.company_id', $company->id)
            ->where('users.member_id', $request->member_number)
            ->first();
        return response()->json(['data' => $customers, 'status' => '200'], 200);

    }

    public function getCompanyData(Request $request){
        $validator = Validator::make($request->all(), [
            'client_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }

        $companyid = Company::where('client_number', $request->client_number)->pluck('id');

        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }

        $customers = DB::table('company')
            ->select(
                'name',
                'token',
                'client_number',
                'created_at',
                'id'
            )
            ->where('id', $companyid[0])
            ->get();
        return response()->json(['data' => $customers, 'status' => '200'], 200);
    }

    public function getOrderItems(Request $request)
    {
        //Validate request
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages()], 400);
        }
        //End validate request

        $data = [];

        $orderExists = \App\Order::where('id', '=', $request->order_id)
            ->count();
        if($orderExists < 1){
            return response()->json(['data' => 'Order ID not found', 'status' => '400'], 400);
        }

        $accounts = \App\Order::where('id', '=', $request->order_id)
            ->get();

        //Shipping address
        $address = null;
        if(isset($accounts->pluck('is_shipping')[0])) {
            if (head($accounts->pluck('is_shipping'))[0] === 1) {
                $address = \App\ShippingAddress::where('id', head($accounts->pluck('address_id'))[0])->first();
            }
        }

//        if(count(head($accounts->pluck('success')))){
//            foreach (head($accounts->pluck('success'))[0] as $item){
//                $cartitem = \App\Cart::
//                where('id',$item['ref_no'])
//                    ->get();
//                array_push($data,(object)head($cartitem->toArray()));
//            }
//        }
        if(count(head($accounts->pluck('success')))){
            foreach (head($accounts->pluck('success'))[0] as $item){
                $cartitem = \App\Cart::
                where('cart.id',$item['ref_no'])
                    ->leftJoin('shipping_address', 'cart.delivery_location', '=', 'shipping_address.id')
                    ->get();
                array_push($data,(object)head($cartitem->toArray()));
            }
        }

//        if(count(head($accounts->pluck('fail')))){
//            foreach (head($accounts->pluck('fail'))[0]['reference'] as $item){
//                $cartitem = \App\Cart::
//                where('id',$item)
//                    ->get();
//                array_push($data,(object)head($cartitem->toArray()));
//            }
//        }

        if(count(head($accounts->pluck('fail')))){
            if(isset($accounts->pluck('fail')[0]['reference'])) {
                foreach (head($accounts->pluck('fail'))[0]['reference'] as $item){
                    $cartitem = \App\Cart::
                    where('cart.id',$item)
                        ->leftJoin('shipping_address', 'cart.delivery_location', '=', 'shipping_address.id')
                        ->get();
                    array_push($data,(object)head($cartitem->toArray()));
                }
            }
        }

        return response()->json(['data' => $data, 'address' => $address, 'status' => '200'], 200);
    }

    //Credit a customer
    public function customerCredit(Request $request){
        $transby = [];
        $transby['user_id'] = null;
        $transby['name'] = "admin";
        $transby['user_email'] = null;
        $transby['company_id'] = null;


        $validator = Validator::make($request->all(), [
            'client_number' => 'required',
            'member_id' => 'required',
            'point' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        $companyid = Company::where('client_number', $request->client_number)->pluck('id');
        $currency = $this->currency($companyid[0]);
        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }
        $userExists = User::where([
            ['id', $request->member_id],
            ['company_id', $companyid[0]]
        ])->count();

        $balance = \App\Accounts::where([
            ['user_id', '=', $request->member_id],
            ['company_id', '=', $companyid[0] ],
        ])->select('point');

        try{
            if($userExists > 0){

                DB::beginTransaction();

                // Old balance
                $oldbalance =  \App\Accounts::where([
                    ['user_id', '=', $request->member_id],
                    ['company_id', '=', $companyid[0] ],
                ])->select('point')->first();

                //Update the member's account
                \App\Accounts::where([
                    ['user_id', '=', $request->member_id],
                    ['company_id', '=', $companyid[0] ],
                ])->increment('point', $request->point);

                $balance =  \App\Accounts::where([
                    ['user_id', '=', $request->member_id],
                    ['company_id', '=', $companyid[0] ],
                ])->select('point')->first();

                $transaction = new \App\Transaction();
                $transaction->type = $this->transtype['credit'];
                $transaction->type_name = array_keys($this->transtype)[1];
                $transaction->is_internal_action = $this->is_internal_action['external'];
                $transaction->is_internal_action_name = array_keys($this->is_internal_action)[0];
                $transaction->order_id = null;
                $transaction->point_raw = $request->point;
                $transaction->balance_raw = $balance->point;
                $transaction->balance_virtual = $balance->point * (!$currency->is_currency_fixed ? $currency->rate : 1);
                $transaction->company_id = $companyid[0];
                $transaction->member_id = $request->member_id;
                $transaction->point_virtual = $request->point * (!$currency->is_currency_fixed ? $currency->rate : 1);
                $transaction->reason = $request->reason;
                $transaction->trans_by = json_encode($transby);
                $transaction->save();


                //Check if a total record for the member exists
                $totalExists =  \App\MemberTotal::where(
                    [
                        ['member_id', $request->member_id],
                        ['company_id', $companyid[0]]
                    ]
                )->count();

                //Check if total for the member exists before updating the user's total credit
                if ($totalExists > 0){
                    //Update totals if a record exists
                    \App\MemberTotal::where(
                        [
                            ['member_id', $request->member_id],
                            ['company_id', $companyid[0]]
                        ]
                    )->increment('credit', $request->point);
                }else{
                    //Create a new record if it doesnt exist
                    \App\MemberTotal::firstOrCreate(
                        [
                            'member_id' => $request->member_id,
                            'company_id' => $companyid[0],
                            'credit' => $request->point
                        ]
                    );
                }

                DB::commit();

                //Get the member and and current point
                $customersAccount = \App\User::where('users.id', "=", $request->member_id)
                    ->select(
                        'users.firstname',
                        'users.lastname',
                        'users.email',
                        'users.company_id',
                        'users.id as member_id'
                    )
                    ->first();

                $response = [
                'firstname' => $customersAccount->firstname,
                    'lastname' => $customersAccount->lastname,
                    'email' => $customersAccount->email,
                    'company_id' => $customersAccount->company_id,
                    'member_id' => $customersAccount->member_id,
                    'credit_raw' => $request->point,
                    'credit_virtual' => $request->point * (!$currency->is_currency_fixed ? $currency->rate : 1),
                    'member_number' => $customersAccount->member_id,
                    'balance_raw' => $transaction->balance_raw,
                    'old_balance_raw' => $oldbalance->point,
                    'balance_virtual' => $transaction->balance_virtual,
                    'old_balance_virtual' => $oldbalance->point * (!$currency->is_currency_fixed ? $currency->rate : 1),
                    'type_name' => $transaction->type_name
                ];

                return response()->json(['data' => $response, 'status' => '200'], 200);

            }else{
                return response()->json(['data' => 'Member does not exist', 'status' => '400'], 400);
            }

        }catch (\PDOException  $e){
            DB::rollBack();
            return response()->json(['data' => "Failed to Credit Member",'reason' => $e->getMessage(), 'status' => '400'], 400);
        }
    }

    //Debit a customer
    public function customerDebit(Request $request){
        $transby = [];
        $transby['user_id'] = null;
        $transby['name'] = "admin";
        $transby['user_email'] = null;
        $transby['company_id'] = null;
        $validator = Validator::make($request->all(), [
            'client_number' => 'required',
            'member_id' => 'required',
            'point' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        $companyid = Company::where('client_number', $request->client_number)->pluck('id');
        $currency = $this->currency($companyid[0]);
        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }
        $userExists = User::where([
            ['id', $request->member_id],
            ['company_id', $companyid[0]]
        ])->count();

        try{
            if($userExists > 0){
                DB::beginTransaction();
                $account =  \App\Accounts::where([
                    ['user_id', '=', $request->member_id],
                    ['company_id', '=', $companyid[0] ],
                ])->decrement('point', $request->point);

                $balance =  \App\Accounts::where([
                    ['user_id', '=', $request->member_id],
                    ['company_id', '=', $companyid[0] ],
                ])->select('point')->first();

                $transaction = new \App\Transaction();
                $transaction->type = $this->transtype['debit'];
                $transaction->type_name = array_keys($this->transtype)[0];
                $transaction->is_internal_action = $this->is_internal_action['external'];
                $transaction->is_internal_action_name = array_keys($this->is_internal_action)[0];
                $transaction->order_id = null;
                $transaction->point_raw = $request->point;
                $transaction->point_virtual = $request->point * (!$currency->is_currency_fixed ? $currency->rate : 1);
                $transaction->balance_raw = $balance->point;
                $transaction->balance_virtual = $balance->point * (!$currency->is_currency_fixed ? $currency->rate : 1);
                $transaction->company_id = $companyid[0];
                $transaction->member_id = $request->member_id;
                $transaction->reason = $request->reason;
                $transaction->trans_by = json_encode($transby);
                $transaction->save();


                //Check if a total record for the member exists
                $totalExists =  \App\MemberTotal::where(
                    [
                        ['member_id', $request->member_id],
                        ['company_id', $companyid[0]]
                    ]
                )->count();

                //Check if total for the member exists before updating the user's total credit
                if ($totalExists > 0){
                    //Update totals if a record exists
                    \App\MemberTotal::where(
                        [
                            ['member_id', $request->member_id],
                            ['company_id', $companyid[0]]
                        ]
                    )->increment('credit', $request->point);
                }else{
                    //Create a new record if it doesnt exist
                    \App\MemberTotal::firstOrCreate(
                        [
                            'member_id' => $request->member_id,
                            'company_id' => $companyid[0],
                            'credit' => $request->point
                        ]
                    );
                }

                DB::commit();

                if($account){
                    $customersAccount = \App\User::where('users.id', "=", $request->member_id)
                        ->select(
                            'users.firstname',
                            'users.lastname',
                            'users.email',
                            'users.company_id',
                            'users.id as member_id',
                            'users.member_id as member_number'
                        )
                        ->first();

                    $response = [
                        'firstname' => $customersAccount->firstname,
                        'lastname' => $customersAccount->lastname,
                        'email' => $customersAccount->email,
                        'company_id' => $customersAccount->company_id,
                        'member_id' => $customersAccount->member_id,
                        'debit_raw' => $request->point,
                        'debit_virtual' => $request->point * (!$currency->is_currency_fixed ? $currency->rate : 1),
                        'member_number' => $customersAccount->member_id,
                        'balance_raw' => $transaction->balance_raw,
                        'balance_virtual' => $transaction->balance_virtual,
                        'type_name' => $transaction->type_name,
                    ];
                    return response()->json(['data' => $response, 'status' => '200'], 200);
                }else{
                    return response()->json(['data' => 'Failed to update Account', 'status' => '200'], 200);
                }

            }else{
                return response()->json(['data' => 'Member does not exist', 'status' => '400'], 400);
            }

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['data' => "Failed to Debit Member",'reason' => $e->getMessage(), 'status' => '400'], 400);
        }
    }

    public function customerTransactions(Request $request){
        $validator = Validator::make($request->all(), [
            'client_number' => 'required',
            'member_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        $companyid = Company::where('client_number', $request->client_number)->pluck('id');

        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }
        $userExists = User::where([
            ['id', $request->member_id],
            ['company_id', $companyid[0]]
        ])->count();

        try{
            if($userExists > 0) {
            $transaction =  \App\Transaction::rightJoin('users', 'users.id', '=', 'transactions.member_id')
                ->where([
                    ['users.company_id', '=',  $companyid[0]],
                    ['users.id', '=', $request->member_id]
                ])
                ->select(
                    'transactions.id as trans_id',
                    'transactions.type as trans_type',
                    'transactions.type_name',
                    'transactions.is_internal_action',
                    'transactions.is_internal_action_name',
                    'transactions.order_id',
                    'transactions.trans_by',
                    'transactions.point_raw',
                    'transactions.point_virtual',
                    'transactions.balance_raw',
                    'transactions.balance_virtual',
                    'users.email as email',
                    'users.firstname',
                    'users.lastname'
                    )
                ->get ();

                return response()->json(['data' => $transaction, 'status' => '200'], 200);
            }
            }catch(\PDOException $e){
            return response()->json(['data' => $e, 'status' => '400'], 400);
        }
        }

        public function customerTransaction(Request $request){
        $validator = Validator::make($request->all(), [
            'client_number' => 'required',
            'member_number' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
        }
        $companyid = Company::where('client_number', $request->client_number)->pluck('id');

        if(count($companyid) == 0){
            return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
        }
        $userExists = User::where([
            ['id', $request->member_id],
            ['company_id', $companyid[0]]
        ])->count();

        try{
            if($userExists > 0) {
            $transaction =  \App\Transaction::rightJoin('users', 'users.id', '=', 'transactions.member_id')
                ->where([
                    ['users.company_id', '=',  $companyid[0]],
                    ['users.id', '=', $request->member_id]
                ])
                ->select(
                    'transactions.id as trans_id',
                    'transactions.type as trans_type',
                    'transactions.type_name',
                    'transactions.is_internal_action',
                    'transactions.is_internal_action_name',
                    'transactions.order_id',
                    'transactions.trans_by',
                    'transactions.point_raw',
                    'transactions.point_virtual',
                    'transactions.balance_raw',
                    'transactions.balance_virtual',
                    'users.email as email',
                    'users.firstname as firstname',
                    'users.lastname as lastname'
                    )
                ->get ();

                return response()->json(['data' => $transaction, 'status' => '200'], 200);
            }
            }catch(\PDOException $e){
            return response()->json(['data' => $e, 'status' => '400'], 400);
        }
        }

    public function getCompanyTransaction(Request $request){
            if(isset($request->from_date) && isset($request->to_date)){

                $res = \App\Transaction::whereBetween(
                    'created_at', [$request->to_date, $request->from_date]
                )->get();

                if(count($res) > 0){
                    return response()->json(['data' => $res, 'status' => '200'], 200);
                }else{
                    return response()->json(['data' => 'No data available', 'status' => '400'], 400);
                }

            }
            //If no specific dates, then return all data
            $validator = Validator::make($request->all(), [
                'client_number' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
            }
            $companyid = Company::where('client_number', $request->client_number)->pluck('id');

            if(count($companyid) == 0){
                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
            }else{
                $transaction =  \App\Transaction::where('company_id', $companyid)->get();

                return response()->json(['data' => $transaction, 'status' => '200'], 200);
            }

        }
    public function getMemberPointTotalCredit(Request $request){
            $validator = Validator::make($request->all(), [
                'client_number' => 'required',
                'member_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
            }

            $companyid = Company::where('client_number', $request->client_number)->pluck('id');

            if(count($companyid) == 0){
                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
            }
            $userExists = User::where([
                ['id', $request->member_id],
                ['company_id', $companyid[0]]
            ])->count();

            if($userExists > 0){
                $totalCredit = \App\MemberTotal::where([
                    ['company_id', '=', $companyid[0] ],
                    ['member_id', '=', $request->member_id ]
                ])->select('credit')->get();
                return response()->json(['data' => $totalCredit, 'status' => '200'], 200);
            }else{
                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
            }
        }
    public function getMemberPointTotalDebit(Request $request){
            $validator = Validator::make($request->all(), [
                'client_number' => 'required',
                'member_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator->messages(), 'status'=>'400'], 400);
            }

            $companyid = Company::where('client_number', $request->client_number)->pluck('id');

            if(count($companyid) == 0){
                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
            }
            $userExists = User::where([
                ['id', $request->member_id],
                ['company_id', $companyid[0]]
            ])->count();

            if($userExists > 0){
                $totalCredit = \App\MemberTotal::where([
                    ['company_id', '=', $companyid[0] ],
                    ['member_id', '=', $request->member_id ]
                ])->select('debit')->get();
                return response()->json(['data' => $totalCredit, 'status' => '200'], 200);
            }else{
                return response()->json(['data' => 'User does not exist', 'status' => '400'], 400);
            }
        }
    public function customerAccountTotal(Request $request){
            $validator = Validator::make($request->all(), [
                'client_number' => 'required',
                'member_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
            }

            $companyid = Company::where('client_number', $request->client_number)->pluck('id');

            if(count($companyid) == 0){
                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
            }
            $userExists = User::where([
                ['id', $request->member_id],
                ['company_id', $companyid[0]]
            ])->count();

            if($userExists > 0){
                $currentBalance = \App\Accounts::where([
                    ['company_id', '=', $companyid[0] ],
                    ['user_id', '=', $request->member_id ]
                ])->select('point as current_balance')->get();
                return response()->json(['data' => $currentBalance, 'status' => '200'], 200);
            }else{
                return response()->json(['data' => 'User does not exist', 'status' => '400'], 400);
            }

        }

        public function closeOrder(Request $request){
            $transby = [];
            $transby['user_id'] = null;
            $transby['name'] = "admin";
            $transby['user_email'] = null;
            $transby['company_id'] = null;

            try{
            $statusstring = array_keys($this->cartstatus)[$request->status]; //Get status string value

            $validator = Validator::make($request->all(), [
               'voucher' => 'required',
                'status' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['data' => $validator->messages(), 'status' => '400'], 400);
            }

            $itemExists = Cart::
            where('voucher', $request->voucher)->count();
            if($itemExists < 1){
                return response()->json([ 'data' => 'Sorry, the Item does not exist in the Records. Check the Voucher number.', 'status' => '400'], 400);
            }

            //Stop Action if it's a cancellation and a reason is not provided
                if($request->status == 0) {
                    if (!$request->reason) {
                        return response()->json(['data' => 'To cancel a redemption you must provide a reason.', 'status' => '400'], 400);
                    }
                }

          
                $statusvalue = $this->cartstatus[$statusstring]; //Get status number value
         

            }catch (\Exception $e){
                return response()->json(['data' => $e->getMessage(), 'status' => '400'], 400);
            }
        }


        public function QueueCreateMember(Request $request){

            //Get Company Id
            $companyid = Company::companyId($request->client_number);
//            if(!$companyid){
//                return response()->json(['data' => 'Company does not exist', 'status' => '400'], 400);
//            }

            //Validate input
//            foreach($request->all() as $request) {
//                $isValid = $this->validateInput->ValidateMember($request);
//                if (gettype($isValid) == 'string') {
//                    return response()->json(['data' => $isValid, 'message' => 'Validation Error', 'status' => '400'], 400);
//                }
//            }


            //Get Currency
//            $currency = $this->currency($companyid);
//            if(!$currency){
//                return response()->json(['message' => 'Error getting currency', 'status' => '400'], 400);
//            }

//            //User Exists Already
//            $userExists = User::userExists($companyid, $request->email);
//            if(gettype($userExists) == 'object'){
//                return $userExists;
//            }
//
//            return $this->userRepository->Create($request->all());
            $this->dispatch( new EnrollMembers($request->all()));
            return response()->json(['data' => 'Batch Registration processing..', 'status' => '200'], 200);

        }

}
