<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory ;

    protected $table = 'carts';
    protected $fillable = ['user_id','product_variants_id','flash_sale_items_id','quantity','price_at_time','promotion_type'];
    
    public function productVariant()
    {
        return $this->belongsTo(Product_variants::class, 'product_variants_id');
    }

    public function product()
    {
        return $this->hasOneThrough(
            Products::class,
            Product_variants::class,
            'id', // Foreign key on product_variants table
            'id', // Foreign key on products table
            'product_variants_id', // Local key on carts table
            'product_id' // Local key on product_variants table
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
