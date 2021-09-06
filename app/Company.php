<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    public static function companyId($client_number){
        $companyid = self::where('client_number', $client_number)->select('id')->first();
        if($companyid){
            return $companyid->id;
        }
        return false;
    }

}
