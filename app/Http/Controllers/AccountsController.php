<?php

namespace App\Http\Controllers;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Ixudra\Curl\Facades\Curl;
use Carbon\Carbon;
use Validator;
use App\User;
class AccountsController extends Controller
{
    protected $baseUrl = "http://www.rewardsboxnigeria.com/rewardsbox/api/v1/?api=";
    // protected $livenotificationUrl= "https://rewardsbox.perxclm.com/rewardsbox_app/v1/api/v1/?api=notification&note=";
   protected $notificationUrl = "https://rewardsboxnigeria.com/rewardsbox/api/v1/?api=notification&note=";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = \App\Order::where([
            ['user_id', '=', Auth::user()->id],
            ['company_id', '=', Auth::user()->company_id]
        ])
            ->select('success','fail','created_at', 'sub_total_cost', 'shipping_cost', 'is_shipping', 'id', 'order_no')
            ->get();

        return view('pages.order.index', compact('accounts'));
    }


    public function statement()
    {
        try{
            $response = Curl::to($this->baseUrl.'get_category&flag=catalogue')
                ->withHeader('token: '.Auth::user()->company->token)
                ->asJsonResponse()
                ->get();

        }catch (\Exception $e){
            return back()->withErrors("Error loading contents.");
        }

        $accounts = \App\Transaction::where([
            ['member_id', '=', Auth::user()->id],
            ['company_id', '=', Auth::user()->company_id]
        ])
            ->select('point_virtual','type','created_at', 'order_id')
            ->get();
        return view('pages.newstatement', compact('accounts', 'response'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function showResetPasswordView(){
        if (view()->exists('auth.passwords.email')) {
            return view('auth.passwords.email');
        }
        return view('auth.password');
    }


    public function validatePasswordRequest(Request $request){

        //Validate user
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'company_id' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => trans('Please enter a valid email')]);
        }

        $user = DB::table('users')->where('email', '=', $request->email)
            ->where('company_id', '=', $request->company_id);

        if(!$user->exists()){
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        //Create Password Reset Token
        $checkreset = DB::table('password_resets')
            ->where('email', $request->email)->first();
        if(!$checkreset) {
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => str_random(60),
                'created_at' => Carbon::now()
            ]);
        }else{
            DB::table('password_resets')->where('email', $request->email)->update([
                'token' => str_random(60)
            ]);
        }
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if($this->sendResetEmail($request->email, $tokenData->token)){
            return redirect()->back()->withErrors(['done' => trans('A Password reset link has been sent to your email address.')]);
        }else{
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }

    }

    public function resetPassword(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;
        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->first();
        if ( !$tokenData ) return view('auth.passwords.email');
        $user = User::where('email', $tokenData->email)->first();
        if ( !$user ) return redirect()->back()->withErrors(['email' => 'Email not found']);


        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //do we log the user directly or let them login and try their password for the first time ? if yes
        Auth::login($user);

        // // If the user shouldn't reuse the token later, delete the token
        DB::table('password_resets')->where('email', $user->email)->delete();
        if($this->sendSuccessEmail($tokenData->email)){
            return view('landing/index');
        }else{
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }

    }

    private function sendResetEmail($email, $token){

        $user = DB::table('users')->where('email' , $email)->where('company_id' , config('app.id'))->select('firstname', 'email', 'company_id', 'member_id as member_no')->first();
        $companytoken = DB::table('company')->where('id', config('app.id'))->first();

        $link = config('app.email_base_url').'password/reset/'.$token.'?email='.urlencode($user->email);

        try{
            $response = Curl::to($this->notificationUrl.'reset')
                ->withHeader('token: '.$companytoken->token)
                ->withData([
                    'first_name' => $user->firstname,
                    'reset_url' => $link,
                    'member_no' => $user->member_no,
                    'email' => $user->email
                ])
                ->asJsonResponse()
                ->post();
//            dd($response);
            if($response){
                if($response->status == 1){
                    return true;
                }else{
                    return $response->message;
                }
            }
            return false;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    

    private function sendSuccessEmail($email){
        $user = DB::table('users')->where('email' , $email)->where('company_id' , config('app.id'))->select('firstname', 'email', 'member_id as member_no', 'company_id')->first();
        $companytoken = DB::table('company')->where('id', config('app.id'))->first();

        try{
            $response = Curl::to($this->notificationUrl.'change_password')
                ->withHeader('token: '.$companytoken->token)
                ->withData([
                    'email' => $user->email,
                    'member_no' => $user->member_no,
                    'first_name' => $user->firstname
                ])
                ->asJsonResponse()
                ->post();
            if($response){

//                dd($response);
                if($response->status == 1){
                    return true;
                }else{
                    return false;
                }
            }
            return false;
        }catch (\Exception $e){
            return false;
        }
    }


    public function changePasswordAction(Request $request){
        $this->validate($request, [
            'password' => [
                'required',
                'string',
                'min:6',             // must be at least 10 characters in length
// //                'regex:/[a-z]/',      // must contain at least one lowercase letter
// //                'regex:/[A-Z]/',      // must contain at least one uppercase letter
//                 'regex:/[0-9]/',      // must contain at least one digit
//                 'regex:/[@$!%*#?&]/', // must contain a special character
                'old_password' => 'required'
            ]
        ]);


        if($this->authenticate($request)){
            $user = User::where('email', Auth::user()->email)->where('company_id' , config('app.id'))->first();
            $user->password = \Hash::make($request->password);
            $user->update();
            Auth::login($user);

            return redirect()->back()->withErrors(['info' => 'Password changed']);
        }else{
            return redirect()->back()->withErrors(['info' => 'Invalid Password']);
        }

    }

    private function authenticate(Request $request)
    {
        if (Auth::attempt([
            'email' => Auth::user()->email,
            'password' => $request->old_password,
            'company_id' => config('app.id')
        ])) {
            return true;
        }else{
            return false;
        }
    }

    public function validatePin(Request $request){
        $this->validate($request, [
            'pin' => [
                'required',
                'min:4',
                'max:4'
            ]
        ]);

        //Validate PIN
        if (Hash::check($request->pin, Auth::user()->pin)) {
            return response()->json(['message' => 'PIN valid', 'status' => 'valid'], 200);
        }else{
            return response()->json(['message' => 'PIN Invalid', 'status' => 'invalid'], 200);
        }
    }

}
