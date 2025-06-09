<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product_variants extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'name',
        'variant_image_url',
        'import_price',
        'listed_price',
        'sale_price',
        'stock',
        'is_show'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
    public function getFormattedImportPriceAttribute()
    {
        return number_format($this->import_price, 0);
    }

    public function getFormattedListedPriceAttribute()
    {
        return number_format($this->listed_price, 0);
    }

    public function getFormattedSalePriceAttribute()
    {
        return number_format($this->sale_price, 0);
    }
}
