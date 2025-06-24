<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'content',
        'admin_reply',
        'rating',
        'is_show',
    ];

    // Quan hệ: mỗi review thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    // Quan hệ: mỗi review thuộc về một user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
