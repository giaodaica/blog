<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageProductVariants extends Model
{
    protected $table = 'image_product_variants';

    protected $fillable = [
        'product_variant_id',
        'image_url_base',
        'image_url_1',
        'image_url_2',
        'image_url_3',
        'image_url_4',
        'image_url_5',
        'image_url_6',
        'image_url_7',
    ];

    // Quan hệ ngược với product_variant
    public function productVariant()
    {
        return $this->belongsTo(Product_variants::class, 'product_variant_id');
    }
}
