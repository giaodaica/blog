<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = ['color_name','color_code'];

    // Nếu có liên kết với bảng product_variants
    public function productVariants()
    {
        return $this->hasMany(Product_variants::class, 'color_id');
    }

}
