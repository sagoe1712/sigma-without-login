<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'company_id',
        'name',
        'delivery_type',
        'delivery_location',
        'pickup_location_name',
        'qty',
        'price',
        'signature',
        'image',
        'voucher',
        'combo',
        'status'
    ];

    public function deliveryLocation(){
        return $this->hasOne('App\ShippingAddress',  'id', 'delivery_location');
    }


    public function attrib(){
        return $this->hasOne('App\CartItemAttrib',  'cart_item_id', 'id');
    }
}
