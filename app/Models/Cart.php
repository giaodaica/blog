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
}
