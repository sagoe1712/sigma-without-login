<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Request;
class LogActivity extends Model
{
    protected $table = "activity_log";
    protected $guarded = [];
    public static function addLog($api_flag, $event_type, $event_nature, $class_name, $http_status, $status, $message, $payload, $response)
    {
        $log = [];
        $log['api_flag'] = $api_flag;
        $log['url'] = Request::fullUrl();
        $log['http_method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['user_agent'] = Request::header('User-Agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : null;
        $log['user_name'] = auth()->check() ? auth()->user()->firstname . ' ' .auth()->user()->lastname : null;
        $log['event_type'] = $event_type;
        $log['event_nature'] = $event_nature;
        $log['class_name'] = $class_name;
        $log['http_status'] =  $http_status;
        $log['status'] = $status;
        $log['message'] = $message;
        $log['request'] = $payload;
        $log['response'] = $response;
        LogActivity::create($log);
    }
}
