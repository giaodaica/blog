<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Product_variants;
use App\Models\ImageProductVariants;
use App\Models\Review;

class ProductDetailController extends Controller
{
    public function index($slug)
    {
        $product = Products::with(['category', 'variants.color', 'variants.size'])
            ->where('slug', $slug)
            ->firstOrFail();
        // dd($product);
        // Lấy tất cả biến thể của sản phẩm
        $variants = Product_variants::with(['color', 'size'])
            ->where('product_id', '=', $product->id)
            ->where('is_show', 1)->get();
        // dd($variants);
        $colors = $variants->pluck('color')->unique('id'); // Lấy tất cả màu không trùng
        $sizes = $variants->pluck('size')->unique('id'); // Lấy tất cả màu không trùng
        // Lấy ảnh của từng biến thể
        $images = Product_variants::where('product_id', $product->id)
            ->where('is_show', 1)
            ->get()
            ->unique('color_id')
            ->pluck('variant_image_url');

        $reviews = Review::where('product_id', $product->id)
            ->where('is_show', 1)
            ->with('user') // Eager load the user information
            ->latest()
            ->get();

        return view('pages.shop.show', compact('product', 'variants', 'reviews', 'colors', 'sizes','images'));
    }
}
