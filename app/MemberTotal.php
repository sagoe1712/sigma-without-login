<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberTotal extends Model
{
    protected $fillable = ['member_id', 'company_id', 'credit', 'debit'];
}
