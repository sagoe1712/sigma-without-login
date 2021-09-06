<?php

namespace App\Http\Controllers;

use App\Traits\EmailTemplates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use App\Repository\TransactionRepository;

//Import Traits
use App\Traits\Purchase;
use App\Traits\Transaction;
use App\Traits\Account;
use App\Traits\CartActions;
use App\Traits\OrderActions;
use App\Http\Proxy\Bills;
use App\Traits\EventsTrigger;

class ReturnsController extends Controller
{


    public function index(){
        try{
            $title = "Returns";
            return view('pages.returns.index', compact( 'title'));
        }catch (\Exception $e){
            return response()->redirectToRoute('no_content');
        }
    }


}
