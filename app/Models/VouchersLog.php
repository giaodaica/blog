<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VouchersLog extends Model
{
    //
    protected $table = 'vouchers_logs';
    protected $fillable = ['voucher_id', 'user_id', 'order_id', 'actor', 'content','type'];
}
