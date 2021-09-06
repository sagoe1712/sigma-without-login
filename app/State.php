<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class State extends Model
{
    //
    protected $table = 'states';
    protected $fillable = [
        'state_name'
    ];
}
