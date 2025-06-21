<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Product_variants;
use App\Models\ImageProductVariants;

class ProductDetailController extends Controller
{
    public function index($slug){
        $product = Products::with(['category', 'variants.color', 'variants.size'])
            ->where('slug', $slug)
            ->firstOrFail();
        // dd($product);
        // Lấy tất cả biến thể của sản phẩm
        $variants = Product_variants::with(['color', 'size'])
        ->where('product_id','=',$product->id)
        ->where('is_show', 1)->get();
// dd($variants);
        return view('pages.shop.show', compact('product', 'variants'));
    }
}
