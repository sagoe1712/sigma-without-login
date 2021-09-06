<?php
namespace App\Traits;
use DB;
use Illuminate\Support\Facades\Auth;
trait Purchase{
    public function canPurchase($amount){

        //Check the user's current point
        $currentuserpoints = DB::table('accounts')
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->select('point')->first();
        if( $amount > $currentuserpoints->point ){
            return false;
        }else{
            return true;
        }
    }
}