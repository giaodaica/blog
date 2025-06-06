<?php

namespace App\Models;

use Database\Factories\ProductVariantsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_variants extends Model
{
    use SoftDeletes; use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price',
        'quantity',
        'status',
        'size',
        'color'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function images()
    {
        return $this->hasMany(ImageProductVariants::class, 'product_variant_id');
    }
 
}
