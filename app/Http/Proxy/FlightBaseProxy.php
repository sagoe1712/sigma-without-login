<?php
namespace App\Http\Proxy;

use App\LogActivity;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;

class FlightBaseProxy {

    public function getRequest($endpoint, $purpose, $class){

       $data = Curl::to(config('app.rb_flight_api').$endpoint)
            ->withHeader('token: '.Auth::user()->company->token)
            ->asJsonResponse()
            ->get();

        if(isset($data)) {
            if (!$data) {
                return false;
            } else if ($data->status == 0) {
                LogActivity::addLog(
                    config('app.rb_flight_api').$endpoint,
                    'external',
                    $purpose,
                    $class,
                    400,
                    'fail',
                    $data->message,
                    'token: '.Auth::user()->company->token,
                    json_encode($data)
                );
                return $data;
            }
            LogActivity::addLog(
                config('app.rb_flight_api').$endpoint,
                'external',
                $purpose,
                $class,
                200,
                'success',
                $data->message,
                'token: '.Auth::user()->company->token,
                json_encode($data)
            );
            return $data;
        }else{
            LogActivity::addLog(
                config('app.rb_flight_api').$endpoint,
                'external',
                $purpose,
                $class,
                400,
                'fail',
                "No data returned",
                'token: '.Auth::user()->company->token,
                json_encode($data)
            );
            return false;
        }
    }

    public function postRequest($endpoint, $payload, $purpose, $class){

        $data = Curl::to(config('app.rb_flight_api').$endpoint)
            ->withHeader('token: '.Auth::user()->company->token, 'content-type: multipart/form-data')
            ->withData($payload)
            ->asJsonResponse()
            ->post();
            //var_dump($payload);
            //dd();
        if(isset($data)) {
            if (!$data) {
                return false;
            } else if ($data->status == 0) {
                LogActivity::addLog(
                    config('app.rb_flight_api').$endpoint,
                    'external',
                    $purpose,
                    $class,
                    400,
                    'fail',
                    $data->message,
                    collect($payload)->toJson(),
                    json_encode($data)
                );
                return $data;
            }
            LogActivity::addLog(
                config('app.rb_flight_api').$endpoint,
                'external',
                $purpose,
                $class,
                200,
                'success',
                $data->message,
                collect($payload)->toJson(),
                json_encode($data)
            );
            return $data;
        }else{
            LogActivity::addLog(
                config('app.rb_flight_api').$endpoint,
                'external',
                $purpose,
                $class,
                400,
                'fail',
                "No data returned",
                collect($payload)->toJson(),
                json_encode($data)
            );
            return false;
        }
    }

    public function getRequestNoAuth($endpoint, $token, $payload, $purpose, $class){

        $data = Curl::to(config('app.rb_flight_api').$endpoint)
            ->withHeader('token: '.$token)
            ->asJsonResponse()
            ->get();

        if(isset($data)) {
            if (!$data) {
                LogActivity::addLog(
                    $endpoint,
                    'external',
                    $purpose,
                    $class,
                    400,
                    'fail',
                    "",
                    collect($payload)->toJson(),
                    json_encode($data)
                );
                return false;
            }
            LogActivity::addLog(
                $endpoint,
                'external',
                $purpose,
                $class,
                200,
                'success',
                "",
                collect($payload)->toJson(),
                json_encode($data)
            );
            return $data;
        }else{
            LogActivity::addLog(
                $endpoint,
                'external',
                $purpose,
                $class,
                400,
                'fail',
                "No data returned",
                collect($payload)->toJson(),
                json_encode($data)
            );
            return false;
        }
    }
    public function postRequestNoAuth($endpoint, $token, $payload, $purpose, $class){
        $data = Curl::to(config('app.rb_flight_api').$endpoint)
            ->withHeader('token: '.$token)
            ->withData($payload)
            ->asJsonResponse()
            ->post();

        if(isset($data)) {
            if (!$data) {
                LogActivity::addLog(
                    config('app.rb_flight_api').$endpoint,
                    'external',
                    $purpose,
                    $class,
                    400,
                    'fail',
                    $data->message,
                    collect($payload)->toJson(),
                    json_encode($data)
                );
                return false;
            } else if ($data->status == 0) {
                LogActivity::addLog(
                    config('app.rb_flight_api').$endpoint,
                    'external',
                    $purpose,
                    $class,
                    400,
                    'fail',
                    $data->message,
                    collect($payload)->toJson(),
                    json_encode($data)
                );
                return $data;
            }
            LogActivity::addLog(
                config('app.rb_flight_api').$endpoint,
                'external',
                $purpose,
                $class,
                200,
                'success',
                $data->message,
                collect($payload)->toJson(),
                json_encode($data)
            );
            return $data;
        }else{
            LogActivity::addLog(
                config('app.rb_flight_api').$endpoint,
                'external',
                $purpose,
                $class,
                400,
                'fail',
                "No data returned",
                collect($payload)->toJson(),
                json_encode($data)
            );
            return false;
        }
    }

    public function postRequestGeneral($endpoint, $token, $payload, $purpose, $class){

        $data = Curl::to($endpoint)
            ->returnResponseObject()
            ->withTimeout(60)
            ->withHeader($token)
            ->withData($payload)
            ->asJson()
            ->post();

        if(isset($data)) {
            if (!$data) {
                LogActivity::addLog(
                    $endpoint,
                    'external',
                    $purpose,
                    $class,
                    400,
                    'fail',
                    "",
                    collect($payload)->toJson(),
                    json_encode($data)
                );
                return false;
            }
            else {
                if($data->status == 200 || $data->status == 201 || $data->status == 203) {
                    LogActivity::addLog(
                        $endpoint,
                        'external',
                        $purpose,
                        $class,
                        200,
                        'success',
                        "",
                        collect($payload)->toJson(),
                        json_encode($data)
                    );
                    return $data;
                }else{
                    LogActivity::addLog(
                        $endpoint,
                        'external',
                        $purpose,
                        $class,
                        400,
                        'fail',
                        "",
                        collect($payload)->toJson(),
                        json_encode($data)
                    );
                    return false;
                }
            }
        }else{
            LogActivity::addLog(
                $endpoint,
                'external',
                $purpose,
                $class,
                400,
                'fail',
                "No data returned",
                collect($payload)->toJson(),
                json_encode($data)
            );
            return false;
        }
    }

    public function getRequestGeneral($endpoint, $token, $payload, $purpose, $class){

       $data = Curl::to($endpoint)
            ->withHeader($token)
            ->asJsonResponse()
            ->get();

        if(isset($data)) {
            if (!$data) {
                LogActivity::addLog(
                    $endpoint,
                    'external',
                    $purpose,
                    $class,
                    400,
                    'fail',
                    "",
                    collect($payload)->toJson(),
                    json_encode($data)
                );
                return false;
            }
            LogActivity::addLog(
                $endpoint,
                'external',
                $purpose,
                $class,
                200,
                'success',
                "",
                collect($payload)->toJson(),
                json_encode($data)
            );
            return $data;
        }else{
            LogActivity::addLog(
                $endpoint,
                'external',
                $purpose,
                $class,
                400,
                'fail',
                "No data returned",
                collect($payload)->toJson(),
                json_encode($data)
            );
            return false;
        }
    }
}