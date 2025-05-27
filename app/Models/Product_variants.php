<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_variants extends Model
{
    use SoftDeletes;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'quantity',
        'image',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    // Thêm quan hệ với product_variant_attribute_values
    public function attributeValues()
    {
        return $this->hasMany(Product_variant_attribute_values::class, 'variant_id');
    }
}
