<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class City extends Model
{
    //
    protected $table = 'cities';
    protected $fillable = [
        'city_name'
    ];
}
