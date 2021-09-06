<?php

namespace App\Http\Controllers;


use App\Events\PasswordChange;
use App\Events\PasswordReset;
use App\Events\PinChange;
use App\Events\PinReset;
use App\Http\Proxy\Account;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
public $accountProxy;
    public function __construct(Account $accountProxy)
    {
//        $this->middleware('auth');
        $this->accountProxy = $accountProxy;
    }

    private function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->old_password])) {
            return true;
        } else {
            return false;
        }
    }

    private function validatePin(Request $request)
    {
        $this->validate($request, [
            'pin' => [
                'required',
                'min:4',
                'max:4'
            ]
        ]);

        //Validate PIN
        if (\Hash::check($request->current_pin, Auth::user()->pin->user_pin)) {
            return true;
        } else {
            return false;
        }
    }


    public function profile(){
        return view('profile');
    }

    public function changePin(){
        return view('auth/pin/change_pin');
    }

    public function update(UserUpdate $user)
    {
        try {
            \App\User::where('id', Auth::user()->id)->update([
                'firstname' => $user['firstname'],
                'lastname' => $user['lastname'],
                'name' => $user['firstname'] . " " . $user['lastname'],
                'phone' => $user['phone']
            ]);

            return back()->with('success', "Success! Profile updated.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error! Failed to update Profile.');
        }
    }

    public function checkEmail($email)
    {
        $check_email = DB::table('users')->where('email', '=', $email)
            ->where('company_id', '=', env('COMPANY_ID'))->first();
        if($check_email){
            return true;
        }else{
            return false;
        }
    }

    public function firsttimepage(){
//        return 'hello';

        if(Auth::guest()){
            return redirect('login');
        }else {
            if(Auth::user()->terms() == 0){
                return view('auth/first_time');
            }else{
                return redirect('/');
            }

        }
    }

    public function firstTimeLogin(Request $request)
    {

        $this->validate($request, [
            'password' => [
                'required',
                'min:6'
            ]
        ]);

        if(Auth::user()->terms() == 0) {
            if ($this->checkEmail($request->email)) {

                $confirm_same_user = DB::table('users')->where('id', Auth::user()->id)->where('email', '=', $request->email)
                    ->where('company_id', '=', env('COMPANY_ID'))->first();

                if ($confirm_same_user) {

                    //only updates password

                    $user = User::where('id', Auth::user()->id)->first();
                    $user->password = \Hash::make($request->password);
                    $user->update();
                    if ($user->update()) {
                        Auth::login($user);

                        Auth::user()->updatefirstlogindate();
                        Auth::user()->updateterms();


                        //Trigger Email notification

                        $email_data = [
                            'email' => $request->email,
                            'first_name' => Auth::user()->firstname,
                            'last_name' => Auth::user()->lastname,
                        ];

//                    Event::fire(new PasswordChange($email_data));

                        return redirect('/');

                    } else {
                        return redirect()->back()->with(['error' => 'Error! Problem Changing Password']);

                    }

                }

                return redirect()->back()->withErrors(['info' => 'Email Address Already Exist. Kindly use another one']);

            } else {

                //updates email and password

                $user = User::where('id', Auth::user()->id)->first();
                $user->password = \Hash::make($request->password);
                $user->email = $request->email;
                if ($user->update()) {

                    $payload = [];
                    $payload['email'] = $request->email;
                        $this->accountProxy->updateProfile($payload);

                    Auth::login($user);

                    //Trigger Email notification

                    Auth::user()->updatefirstlogindate();
                    Auth::user()->updateterms();

                    $email_data = [
                        'email' => Auth::user()->email,
                        'first_name' => Auth::user()->firstname,
                        'last_name' => Auth::user()->lastname,
                    ];

//                Event::fire(new PasswordChange($email_data));


                    return redirect('/');

                } else {
                    return redirect()->back()->with(['error' => 'Error! Problem Changing Password']);

                }
            }
        }else{
            return redirect('/');
        }
    }

    public function changePasswordAction(Request $request)
    {
        $this->validate($request, [
            'password' => [
                'required',
                'string',
                'min:6',             // must be at least 10 characters in length
////                'regex:/[a-z]/',      // must contain at least one lowercase letter
////                'regex:/[A-Z]/',      // must contain at least one uppercase letter
//                'regex:/[0-9]/',      // must contain at least one digit
//                'regex:/[@$!%*#?&]/', // must contain a special character
//                'old_password' => 'required'
            ]
        ]);


        if ($this->authenticate($request)) {
            $user = User::where('email', Auth::user()->email)->first();
            $user->password = \Hash::make($request->password);
            $user->update();
            Auth::login($user);

            //Trigger Email notification

            $email_data =  [
                'email' => Auth::user()->email,
                'first_name' => Auth::user()->firstname,
                'last_name' => Auth::user()->lastname,
            ];

            Event::fire(new PasswordChange($email_data));

            return redirect()->back()->with(['success' => 'Success! Password changed']);
        } else {
            return redirect()->back()->with(['error' => 'Error! Current Password incorrect']);
        }

    }

    public function changePinAction(Request $request)
    {
        //Validate request
        $this->validate($request, [
            'current_pin' => 'bail|required|min:4|max:4',
            'pin' => 'bail|required|min:4:max:4|confirmed',
        ]);


        if ($this->validatePin($request)) {
            $user = \App\UserPin::where('user_id', Auth::user()->id)->first();
            $user->user_pin = \Hash::make($request->pin);
            $user->update();

            $email_data =  [
                'email' => Auth::user()->email,
                'first_name' => Auth::user()->firstname,
                'last_name' => Auth::user()->lastname,
            ];

            Event::fire(new PinChange($email_data));

            return redirect()->back()->with(['success' => 'Success! Pin changed']);
        } else {
            return redirect()->back()->with(['error' => 'Error! Current PIN incorrect']);
        }

    }

    public function resetPassword(Request $request)
    {
        try{
        //Validate user
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => trans('Please enter a valid email')]);
        }

        $user = DB::table('users')->where('email', '=', $request->email);

        if (!$user->exists()) {
            return redirect()->back()->withErrors(['email' => 'Account does not exist']);
        }

        //Create Password Reset Token
        DB::table('password_resets')->where('email', $request->email)->delete();

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        $link = config('app.url') . 'password/reset/' . $tokenData->token . '?email=' . urlencode($user->first()->email);

            $email_data =  [
                'email' => $user->first()->email,
                'first_name' => $user->first()->firstname,
                'last_name' => $user->first()->lastname,
                'url' => $link
            ];

        Event::fire(new PasswordReset($email_data));

            return redirect()->back()->with(['success' => 'Success! A Password reset link has been sent to your email address.']);
        }catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'An Error occurred. Please try again.']);
        }

    }

    public function resetPinView(){
        return view('auth.pin.reset_pin');
    }

    public function resetPinViewWithToken(Request $request, $token){
        if(!$request->has('email')){
            abort(404);
        }

        $pin_reset = DB::table('pin_reset')->where('email', $request->email);

        if(!$pin_reset->exists()){
            abort(404);
        }

        $now = Carbon::now();
        $from = Carbon::createFromFormat('Y-m-d H:s:i', $pin_reset->first()->created_at);
        $diff_in_minutes = $now->diffInMinutes($from);

        if( $diff_in_minutes > 60 ){
            $pin_reset->delete();
           return view('errors.expired_link');
        }

        $email = $request->email;
        return view('auth.pin.reset_pin_with_token', compact('token', 'email'));
    }

    public function resetPin(Request $request)
    {
        try{
        //Validate user
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => trans('Please enter a valid email')]);
        }

        $user = DB::table('users')->where('email', '=', $request->email);

        if (!$user->exists()) {
            return redirect()->back()->withErrors(['email' => 'Account does not exist']);
        }

        //Create Password Reset Token
        DB::table('pin_reset')->where('email', $request->email)->delete();

        DB::table('pin_reset')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        $link = config('app.url') . 'pin/reset/' . $tokenData->token . '?email=' . urlencode($user->first()->email);

            $email_data =  [
                'email' => $user->first()->email,
                'first_name' => $user->first()->firstname,
                'last_name' => $user->first()->lastname,
                'url' => $link
            ];

        Event::fire(new PinReset($email_data));

            return redirect()->back()->with(['success' => 'Success! A PIN reset link has been sent to your email address.']);
        }catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'An Error occurred. Please try again.']);
        }

    }

    public function resetPinWithToken(Request $request)
    {
        try{
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'pin' => 'required|confirmed',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['error' => 'Please complete the form']);
        }


        $tokenData = DB::table('pin_reset')->where('token', $request->token);

        if (!$tokenData->exists()) return view('auth.pin.reset_pin');
        $user = User::where('email', $tokenData->email);
        if (!$user->exists()) return redirect()->back()->withErrors(['email' => 'Account not found']);


        $user_pin = \App\UserPin::where('user_id', $user->first()->id)->first();
        $pin = mt_rand(0000, 9999);
        $user_pin->user_pin = \Hash::make($pin);
        $user_pin->update();
        
        // // If the user shouldn't reuse the token later, delete the token
        DB::table('pin_reset')->where('email', $user->email)->delete();

        return redirect()->back()->with(['success' => 'Success! Pin changed']);
        } catch (\Exception $e) {
        return redirect()->back()->with(['error' => 'Error! Current PIN incorrect']);
        }

    }
}