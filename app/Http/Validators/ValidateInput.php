<?php
namespace App\Http\Validators;

use Validator;
use Illuminate\Http\Request;
use \App\User;
use \App\Company;
class ValidateInput{

    public function ValidateMember($request){
        //Validate request

        if(!isset($request['firstname']) || str_replace(' ', '', $request['firstname']) == " "){
            return 'firstname is Required';
        } if(!isset($request['lastname']) || str_replace(' ', '', $request['lastname']) == " "){
            return 'lastname is Required';
        }if(!isset($request['email']) && str_replace(' ', '', $request['email']) == " "){
            return 'lastname is Required';
        }
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            return 'email validation error';
        }
        if(!isset($request['member_id']) || str_replace(' ', '', $request['member_id']) == " "){
            return 'member_id is Required';
        }
        if(User::memberIdUnique($request['member_id'])){
            return 'member number is already exists';
        }
        if(!isset($request['password']) || str_replace(' ', '', $request['password']) == " "){
            return 'Password validation error';
        }
         if(!isset($request['point']) && str_replace(' ', '', $request['point']) == " "){
            return 'point required';
        }
        if(!isset($request['status']) && str_replace(' ', '', $request['status']) == " "){
            return 'status required';
        }
        if(!isset($request['client_number']) && str_replace(' ', '', $request['client_number']) == " "){
            return 'client_number required';
        }
        $companyid = Company::companyId($request['client_number']);
        if(!$companyid){
            return 'Company does not exist';
        }

        return true;
}
}