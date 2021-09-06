<?php


namespace App\Http\Controllers;

use App\Company;
use App\Http\Proxy\Email;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;

class CommonController extends Controller
{
    private $emailProxy;

    public function __construct(Email $email)
    {
        $this->middleware('auth')->except('sendContactEmail', 'validateCaptcha');
        $this->emailProxy = $email;
    }

    public function contactView(){
        return view('pages.contact');
    }

    public function sendContactEmail(ContactRequest $request){

        if($request->ajax()){

            $validateCaptcha = $this->validateCaptcha($request->input('cpkt') );

            if(!$validateCaptcha){
                return response()->json(['message' => 'Error! We could not validate you are human. Please refresh the page.']);
            };

            $token = Company::where('id', config('app.id'))->first()->token;
            $this->emailProxy->sendContactEmail($request, $token);

            return response()->json(['message' => 'Success! We have received your message. We will be in touch soon.']);
        }

        $validateCaptcha = $this->validateCaptcha($request->input('cpkt') );

        if(!$validateCaptcha){
            return back()->with('success', 'Error! We could not validate you are human. Please refresh the page.');
        };

        $token = Company::where('id', config('app.id'))->first()->token;

        $this->emailProxy->sendContactEmail($token, $request);

        return back()->with('success', 'Success! We have received your message. We will be in touch soon.');
    }

    private function validateCaptcha($token)
    {

        $payload = [
            'secret' => config('app.google_secret_key'),
            'response' => $token
        ];

        $response = $this->emailProxy->validateCaptcha($payload);

        if ($response->success == true && $response->score > 0.5) {
        return true;
        }else{
            return false;
        }

    }
}