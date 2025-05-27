<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_variant_attribute_values extends Model
{
    protected $table = 'product_variant_attribute_values';

    protected $fillable = [
        'variant_id',
        'attribute_id',
        'value_id',
    ];

    // Quan hệ với biến thể sản phẩm
    public function variant()
    {
        return $this->belongsTo(Product_variants::class, 'variant_id');
    }

    // Quan hệ với thuộc tính (ví dụ: màu sắc, kích thước,...)
    public function attribute()
    {
        return $this->belongsTo(Variant_attribute::class, 'attribute_id');
    }

    // Quan hệ với giá trị thuộc tính (ví dụ: đỏ, xanh, S, M, L,...)
    public function value()
    {
        return $this->belongsTo(Variant_attribute_values::class, 'value_id');
    }
}
