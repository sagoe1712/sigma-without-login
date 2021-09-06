<?php
namespace App\Traits;
use DB;
use Illuminate\Support\Facades\Auth;
trait Transaction{
    public function refundFailedTransToAccount($price, $qty){
        try {

            //Deduct cost from Account
            $deduct = \App\Accounts::
            where('user_id', '=', Auth::user()->id)
                ->where('company_id', '=', Auth::user()->company_id)
                ->increment('point', floatval($price * $qty));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}