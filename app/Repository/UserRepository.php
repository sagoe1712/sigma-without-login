<?php
namespace App\Repository;
use App\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Validators\ValidateInput;
use App\Company;
class UserRepository {

    protected $report = [ 'success' => [], 'error' => [], 'validation_failed' => ['ref' => []]];
    public function _construct(ValidateInput $validateInput){

    }

    public function Create($data)
    {
        $data;
        $validateInput = new validateInput();

        foreach($data as $request) {
            $isValid = $validateInput->ValidateMember($request);
            if (gettype($isValid) == 'string') {
                //Save Failed Reference here
                $report['validation_failed']['ref'] = $request;
//                $report['validation_failed']['ref'] = ['reason' => $isValid];
            }else{

            //Start transaction
            DB::beginTransaction();
            try {
                //Create a new member
                $member = new User();
                $member->firstname = $request['firstname'];
                $member->member_id = $request['member_id'];
                $member->lastname = $request['lastname'];
                $member->company_id =  Company::companyId($request['client_number']);
                $member->name = $request['firstname'] . " " . $request['lastname'];
                $member->email = $request['email'];
                $member->phone = $request['phone'];
//            $member->address = $this->request['address'];
//            $member->country_name = $this->request['country_name'];
//            $member->state_name = $this->request['state_name'];
//            $member->city_name = $this->request['city_name'];
//            $member->country_id = $this->request['country_id'];
//            $member->state_id = $this->request['state_id'];
//            $member->city_id = $this->request['city_id'];
                $member->status = $request['status'];
                $member->password = bcrypt($request['password']);
                $member->save();


                //Credit the member just created
                $account = new \App\Accounts();
                $account->user_id = $member->id;
                $account->point = $request['point'];
                $account->company_id = Company::companyId($request['client_number']);
                $account->save();
//            $account = \App\Accounts::firstOrCreate(
//                [
//                    'user_id' => $member->id,
//                    'point' => $this->request->point,
//                    'company_id' => $this->companyid
//                ]);

                //Check if there's any error, rollback transaction is any error
                if (!$member || !$account) {
                    DB::rollBack();
                }
                //Commit transaction
                DB::commit();

                $response = [
                    'firstname' => $member->firstname,
                    'lastname' => $member->lastname,
                    'email' => $member->email,
                    'client_number' => $request['client_number'],
                    'member_number' => $member->member_id,
                    'member_id' => $member->id,
                    'phone' => $member->phone,
                    'status' => $member->status,
                    'balance_raw' => $account->point,
                    'balance_virtual' => $account->point * (!$this->currency(Company::companyId($request['client_number']))->is_currency_fixed ? $this->currency(Company::companyId($request['client_number']))->rate : 1)
                ];
                $this->report['success'] = $response;
                //Return data with the newly created Member

            } catch (\Exception $e) {
                DB::rollBack();
                $this->report['error'] =  $e->getMessage();
//                return "An Error Occurred Usr Repo Error " . $e->getMessage();
            }
        }
        }
        dd($this->report);

    }

    private function currency($company_id){
        $currency = \App\Setting::where('company_id', $company_id)->select('name', 'rate', 'currency', 'is_currency_fixed')->first();
        return $currency;
    }
}