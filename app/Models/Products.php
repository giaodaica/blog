<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
   use HasFactory ; use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'image_url',
        'category_id',
    ];

    // Quan hệ: Một sản phẩm thuộc một danh mục
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    // Nếu vẫn còn bảng product_variants thì giữ
    public function variants()
    {
        return $this->hasMany(Product_variants::class, 'product_id');
    }
}
