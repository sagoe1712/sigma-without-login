<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ShippingAddress extends Model
{
    protected $table = 'shipping_address';
    protected $fillable = [
        'user_id',
        'company_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'address',
        'state_id',
        'city_id'
    ];

}
