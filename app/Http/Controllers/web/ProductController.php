<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = $this->getFilteredProducts();
        $categories = Categories::withCount('products')->get();
        $colors = Color::whereHas('productVariants', function ($query) {
            $query->where('stock', '>', 0)->where('is_show', 1)->whereNull('deleted_at');
        })->withCount(['productVariants' => function ($query) {
            $query->where('stock', '>', 0)->where('is_show', 1)->whereNull('deleted_at');   
        }])->get();
        $sizes = Size::withCount('productVariants')->get();

        if (request()->ajax()) {
            return view('pages.shop.shop', compact('products', 'categories', 'colors', 'sizes'))->render();
        }

        return view('pages.shop.shop', compact('products', 'categories', 'colors', 'sizes'));
    }

    private function getFilteredProducts()
    {
        $query = Products::with(['category', 'variants.color', 'variants.size'])
        ->whereHas('category', function ($query) {
            $query->where('status', '1')
                  ->whereNull('categories.deleted_at');
        })
        ->whereHas('variants', function ($query) {
            $query->where('is_show', 1)
                  ->where('stock', '>', 0)
                  ->whereNull('product_variants.deleted_at');
        })
        ->whereNull('products.deleted_at');
    

        // Filter by categories
        if ($categories = request('categories')) {
            $query->whereIn('category_id', $categories);
        }

        // Filter by colors
        if ($colors = request('colors')) {
            $query->whereHas('variants', function ($q) use ($colors) {
                $q->whereIn('color_id', $colors);
            });
        }

        // Filter by sizes
        if ($sizes = request('sizes')) {
            $query->whereHas('variants', function ($q) use ($sizes) {
                $q->whereIn('size_id', $sizes);
            });
        }

        // Filter by price range
        $priceRange = request('price_range');

        if (!empty($priceRange) && str_contains($priceRange, '-')) {
            [$min, $max] = explode('-', $priceRange);
            $query->whereHas('variants', function ($q) use ($min, $max) {
                $q->whereBetween('sale_price', [(int)$min, (int)$max]);
            });
        }

        // Handle sorting using JOINs
        $sort = request('sort');
        if (in_array($sort, ['price_asc', 'price_desc'])) {
            $query->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                  ->where('product_variants.is_show', 1)
                  ->where('product_variants.stock', '>', 0)
                  ->whereNull('product_variants.deleted_at')
                  ->whereNull('products.deleted_at')
                  ->select('products.*', 'product_variants.sale_price')
                  ->distinct();
        }
    
        // Xử lý sắp xếp
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('product_variants.sale_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('product_variants.sale_price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('products.created_at', 'desc');
                break;
        }

        return $query->paginate(5);
    }
}
