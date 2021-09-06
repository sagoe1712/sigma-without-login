<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Company;
use Validator;
use Illuminate\Support\Facades\Auth;
class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web', 'auth'], ['except' => ['storeapi', 'currency']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => DB::table('company')->get(), 'status' => '200'], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'token' => 'required',
//            'client_number' => 'required'
//        ]);
//        if ($validator->fails()) {
//            return response()->json(['errors' => $validator->messages()], 400);
//        }
//        try {
//            $company = new Company();
//            $company->name = $request->name;
//            $company->token = $request->token;
//            $company->client_number = $request->client_number;
//            $company->save();
//            if($company){
//                return response()->json(['data' => $company, 'status' => '200'], 200);
//            }
//        }catch (\Exception $e){
//            return response()->json(['data' => "An Error Occurred", 'status' => '400'], 400);
//        }
    }

    public function storeapi(Request $request)
    {

//        if($request->header('Authorization') && $request->header('Authorization') == config('app.apikey')){
//
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'token' => 'required',
//            'client_number' => 'required'
//        ]);
//        if ($validator->fails()) {
//            return response()->json(['errors' => $validator->messages()], 400);
//        }
//        try {
//            $company = new Company();
//            $company->name = $request->name;
//            $company->token = $request->token;
//            $company->client_number = $request->client_number;
//            $company->save();
//            if($company){
//                return response()->json(['data' => $company, 'status' => '200'], 200);
//            }
//        }catch (\Exception $e){
//            return response()->json(['data' => "An Error Occurred", 'status' => '400'], 400);
//        }
//
//        }else{
//            return 'Apologies! You do not have access to this resource.';
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function currency(){
        $currency = DB::table('setting')->where('company_id', Auth::user()->id)->select('rate as apprate', 'currency as appcurrency', 'is_currency_fixed as appfixcurrency')->first();
        return response()->json(['data' =>$currency, 'status' => '200'],200);
    }


}
