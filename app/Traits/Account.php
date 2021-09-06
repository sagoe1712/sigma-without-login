<?php
namespace App\Traits;
use DB;
use Illuminate\Support\Facades\Auth;
trait Account{
    public function deductFromAccount($price, $qty){
        try {
            //Deduct cost from Account
            $deduct = \App\Accounts::
            where('user_id', '=', Auth::user()->id)
                ->where('company_id', '=', Auth::user()->company_id)
                ->decrement('point', floatval($price*$qty));
            return floatval($price*$qty);
        } catch (\Exception $e) {
            return false;
        }
    }
}