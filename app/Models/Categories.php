<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;use HasFactory;

    protected $table = 'categories'; // Có thể bỏ dòng này nếu tên model là Categories (Laravel sẽ tự hiểu)

    protected $fillable = [
        'name',
        'image',
        'status',
    ];

    // Gợi ý: Một category có nhiều product
    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }
}
