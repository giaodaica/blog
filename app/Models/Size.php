<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{

    protected $fillable = ['size_name'];

    // Nếu có quan hệ với product_variants (gợi ý)
    public function productVariants()
    {
        return $this->hasMany(Product_variants::class, 'size_id');
    }
}

