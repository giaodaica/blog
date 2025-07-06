<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistories extends Model
{
    protected $table = 'order_histories';
    protected $fillable = ['order_id',
                'from_status',
                'to_status',
                'note',
                'time_action',
                'users',
                'content'
            ];
}
