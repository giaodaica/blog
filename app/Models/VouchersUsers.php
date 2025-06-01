<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VouchersUsers extends Model
{
    //
    protected $table = 'vouchers_users';
    protected $fillable = ['user_id','voucher_id'];
}
