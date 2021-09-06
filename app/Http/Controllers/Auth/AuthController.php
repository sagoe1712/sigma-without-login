<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Proxy\Account;
use App\Http\Proxy\Email;
//use App\Traits\EventsTrigger;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers;
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'firstlogin';
    protected $redirectAfterLogout = '/login';

    public $accountProxy;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Account $accountProxy, Email $emailProxy)
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'update', 'changePassword', 'security']]);
        $this->accountProxy = $accountProxy;
        $this->emailProxy = $emailProxy;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'company_id' => 'required',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'name' => $data['firstname'].$data['lastname'],
            'email' => $data['email'],
            'company_id' => $data['company_id'],
            'phone' => $data['phone'],
            'status' => $data['status'],
//            'country_id' => $data['country_id'],
//            'country_name' => $data['country_name'],
//            'state_id' => $data['state_id'],
//            'state_name' => $data['state_name'],
//            'city_id' => $data['city_id'],
//            'city_name' => $data['city_name'],
            'password' => bcrypt($data['password']),
        ]);
    }


    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        $date  = date('Y-m-d h:m');
        DB::table('login_activity')
            ->insert(['user_id'=>Auth::user()->id]);

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['last_login_time'=>$date]);

        if (Auth::user()->terms() == 0) {
            return redirect('firstlogin');
        } else {
            if ($throttles) {
                $this->clearLoginAttempts($request);
            }

            if (method_exists($this, 'authenticated')) {
                return $this->authenticated($request, Auth::guard($this->getGuard())->user());
            }

//            return redirect()->back();
            return redirect()->intended($this->redirectPath());
        }
    }


    protected function validateLogin(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

//        $this->validate($request, [
//            'email' => 'required',
//            'password' => 'required',
//            'company_id' => 'required|exists:users,company_id,'.'company_id,'.config('app.id'),
//        ]);

        $valid = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'company_id' => 'required|exists:users,company_id,' . 'company_id,' . config('app.id'),
        ], $messages);

        if ($valid->fails()) {
            return back()->withErrors($valid);
        }
    }

    protected function sendFailedLoginResponse(Request $request){

        $findUser =  DB::table('users')
           ->where('email', $request->email)->first();

//        dd($findUser);
        $message = "";
        if(!$findUser){
            $message = "Sorry, we couldn't find an account with this email address";
        }else{

               $message = "Sorry, that password isn't right";

        }

        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $message,
            ]);

    }

    public function update(Request $request){
        $valid = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required'
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }
        try{
            $member = new \App\User();
            $member::where('id', Auth::user()->id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'address' => trim($request->address)
            ]);
            $payload = [];
            $payload['first_name'] = $request->firstname;
            $payload['last_name'] = $request->lastname;
            $payload['phone'] = $request->phone;
            $this->accountProxy->updateProfile($payload);

            if($member){

                return back()->withErrors("Profile Updated.");
            }
        }catch (\Exception $e){
            return back()->withErrors("Error Updating Profile.". $e->getMessage());
        }
    }

    public function changePassword(){
        return view('security.changepassword');
    }


    public function security(){
        return view('security.index');
    }

    public function showResetEmailForm(){
        return view('auth.member');
    }

    public function retrieveUsername(Request $request){

        $valid = Validator::make($request->all(), [
            'membership' => 'required',
        ]);
        if($valid->fails()){
            return back()->withErrors($valid);
        }

        $findUser =  DB::table('users')
            ->where('member_id', $request->membership)->where('company_id', env('COMPANY_ID'))->first();

        if($findUser){

            $string = "@sigmapensions.com";

            if(strpos($findUser->email, $string) !== false){
                return redirect()->back()->withErrors([
                    "email" => "Kindly contact us to update your email",
                ]);
            }else{

                $token = DB::table('company')->where('id', env('COMPANY_ID'))->select('token')->first();

                $email_payload = [
                    'first_name' => $findUser->firstname,
                    'last_name' => $findUser->lastname,
                    'email' => $findUser->email,
                    'member_no' => $findUser->member_id,
                    'username' => $findUser->email
                ];

                $this->emailProxy->SendEmailResendUsername($token->token, $email_payload);

                return redirect()->back()->withErrors([
                    "done" => "Username has been sent to your email address successfully",
                ]);

            }

        }else{
            return redirect()->back()->withErrors([
                "email" => "Invalid membership number",
            ]);
        }

    }

}
