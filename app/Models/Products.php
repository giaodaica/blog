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
        'dsc',
        'meta_title',
        'meta_dsc',
        'meta_keyword',
        'category_id',
        'status',
        'slug',
    ];

    // Quan hệ: Một sản phẩm có nhiều biến thể
    public function variants()
    {
        return $this->hasMany(Product_variants::class, 'product_id', 'id');
    }

    // (Gợi ý) Nếu bạn muốn lấy category của sản phẩm
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
