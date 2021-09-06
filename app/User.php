<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Illuminate\Support\Facades\Auth;
class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password','terms_agreed','first_login','status'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function cartCount(){
      $cart_total =  DB::table('cart')
            ->select(DB::raw('sum(qty) as cart_total'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', '1')
            ->first();
      return $cart_total->cart_total ? $cart_total->cart_total : 0;
    }

    public function wishlistCount(){
        $cart_total =  DB::table('wishlist')
            ->select(DB::raw('COUNT(id) as cart_total'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', '1')
            ->first();
        return $cart_total->cart_total ? $cart_total->cart_total : 0;
    }


    public function email(){
        $email =  DB::table('users')
            ->select(DB::raw('email'))
            ->where('id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', '1')
            ->first();
        return $email->email;
    }

    public function point(){
        return $this->hasOne('App\Accounts');
    }

    public function company(){
        return $this->hasOne('App\Company', 'id', 'company_id');
    }

    public static function userExists($companyid, $email){
        $userExists = self::where([
                ['company_id', '=', $companyid],
                ['email', '=', $email]
            ]
        )->count();

        if ($userExists > 0) {
            return response()->json(['data' => 'Customer already exists under a company', 'status' => '400'], 400);
        }else{
            return true;
        }
    }

    public static function memberIdUnique($member_id){
        $test = self::where([
                ['member_id', '=', $member_id]
            ]
        )->count();

        if ($test > 0) {
            return true;
        }else{
            return false;
        }
    }


    public function currency(){
        return $this->hasOne('App\Setting', 'company_id', 'company_id');
    }

    public function accountBalaceText()
    {
        if ($this->currency->is_currency_fixed == '1'){
            return "&#8358 ".(number_format($this->point->point));
        }
        else
        {
            return number_format($this->currency->rate * $this->point->point) . " " . $this->currency->currency;
        }

    }

    public function recentlyViewedProducts(){
        return $this->hasMany('App\RecentlyViewedProduct',  'user_id', 'id');
    }

    public function firstpop()
    {
        if(Auth::user()->first_login == 0){
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['first_login' => 1]);
        }
    }

    public function updatefirstlogindate()
    {
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['first_login_time'=>date("Y-m-d H:i:sa")]);
    }

    public function updateterms()
    {
        $date = date('Y-m-d h:m');
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['terms_agreed'=>1, 'terms_datetime'=>$date]);
    }

    public function terms(){
        $terms_agreed =  DB::table('users')
            ->select(DB::raw('terms_agreed'))
            ->where('id', '=', Auth::user()->id)
            ->where('company_id', '=', Auth::user()->company_id)
            ->where('status', '=', '1')
            ->first();
        return $terms_agreed->terms_agreed;
    }

}
