<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefundMoney extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'bank',
        'bank_account_name',
        'amount',
        'status',
        'reason',
        'stk',
        'images',
        'QR_images',
    ];
}
