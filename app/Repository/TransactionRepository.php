<?php
namespace App\Repository;
use \App\Transaction;
use \App\MemberTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class TransactionRepository{
    //Zero based Status indicators
    private $transtype = [
        'debit' => 0,
        'credit' => 1
    ];
    private $is_internal_action = [
        'external' => 0,
        'internal' => 1
    ];
    private function currency($company_id){
        $currency = \App\Setting::where('company_id', $company_id)->select('name', 'rate', 'currency', 'is_currency_fixed')->first();
        return $currency;
    }

    public function SaveTransaction(Request $request, $orderid, $cost, $delivery){


        $transby = [];
        $transby['user_id'] = Auth::user()->id;
        $transby['firstname'] = Auth::user()->firstname;
        $transby['lastname'] = Auth::user()->lastname;
        $transby['user_email'] = Auth::user()->email;
        $transby['company_id'] = Auth::user()->company_id;

        $currency = $this->currency(Auth::user()->company_id);

        $balance =  \App\Accounts::where([
            ['user_id', '=', Auth::user()->id],
            ['company_id', '=', Auth::user()->company_id ],
        ])->select('point')->first();

        $reason = null;

        if( $request->has('reason') ){
            $reason = $request->reason;
        }
        $point = $cost + ($delivery === null ? 0 : $delivery);
        $delivery_transform = null;

        if($delivery === null){
            $delivery_transform = 0;
        }else{
            if($currency->is_currency_fixed == 1){
                $delivery_transform = $delivery;
            }else{
                $delivery_transform = $delivery * $currency->rate;
            }
        }

        try {
            $transaction = new Transaction();
            $transaction->type = $this->transtype['debit'];
            $transaction->type_name = array_keys($this->transtype)[0];
            $transaction->is_internal_action = $this->is_internal_action['internal'];
            $transaction->is_internal_action_name = array_keys($this->is_internal_action)[1];
            $transaction->order_id = $orderid;
            $transaction->point_raw = $point;
            $transaction->company_id = Auth::user()->company_id;
            $transaction->member_id = Auth::user()->id;
            $transaction->point_virtual = $cost * ($currency->is_currency_fixed == 0 ? $currency->rate : 1) + $delivery_transform;
            $transaction->balance_raw = $balance->point;
            $transaction->balance_virtual = $balance->point * ($currency->is_currency_fixed == 0 ? $currency->rate : 1);
            $transaction->reason = $reason;
            $transaction->trans_by = json_encode($transby);
            $transaction->save();

            //Check if a total record for the member exists
            $totalExists = MemberTotal::where(
                [
                    ['member_id', Auth::user()->id],
                    ['company_id', Auth::user()->company_id]
                ]
            )->count();

            //Check if total for the member exists before updating the user's total credit
            if ($totalExists > 0) {
                //Update totals if a record exists
                \App\MemberTotal::where(
                    [
                        ['member_id', Auth::user()->id],
                        ['company_id', Auth::user()->company_id]
                    ]
                )->increment('debit', $point);
            } else {
                //Create a new record if it doesnt exist
                \App\MemberTotal::firstOrCreate(
                    [
                        'member_id' => Auth::user()->id,
                        'company_id' => Auth::user()->company_id,
                        'debit' => $point
                    ]
                );
            }
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }



}