<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductSuggestionResource;
use App\Models\Categories;
use App\Models\Color;
use App\Models\Products;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = $request->get('q');

            if (!$query) {
                if ($request->ajax()) {
                    return response()->json([
                        'error' => 'Query parameter is required'
                    ], 400);
                }
                return redirect()->route('home.shop');
            }

            $products = Products::with(['category', 'variants.color', 'variants.size'])
                ->whereHas('category', function ($query) {
                    $query->where('status', '1')
                          ->whereNull('categories.deleted_at');
                })
                ->whereHas('variants', function ($query) {
                    $query->where('is_show', 1)
                          ->where('stock', '>', 0)
                          ->whereNull('product_variants.deleted_at');
                })
                ->where('name', 'LIKE', "%{$query}%")
                ->whereNull('products.deleted_at')
                ->paginate(5);

            // Lấy dữ liệu cho sidebar
            $categories = Categories::withCount('products')->get();
            $colors = Color::withCount('productVariants')->get();
            $sizes = Size::withCount('productVariants')->get();

            if ($request->ajax()) {
                $view = view('pages.shop.search-results', [
                    'products' => $products,
                    'categories' => $categories,
                    'colors' => $colors,
                    'sizes' => $sizes,
                    'searchQuery' => $query
                ])->render();

                return response()->json([
                    'html' => $view,
                    'query' => $query,
                    'total' => $products->total(),
                    'success' => true
                ]);
            }

            return view('pages.shop.shop', [
                'products' => $products,
                'categories' => $categories,
                'colors' => $colors,
                'sizes' => $sizes,
                'searchQuery' => $query
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'An error occurred while searching',
                    'message' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Có lỗi xảy ra khi tìm kiếm');
        }
    }


    public function suggestions(Request $request)
    {
        try {
            $query = $request->get('q');
    
            if (!$query) {
                return response()->json([
                    'suggestions' => [],
                    'featured_products' => []
                ]);
            }
    
            // Get keyword suggestions (5 distinct product names)
            $suggestions = Products::where('name', 'LIKE', "%{$query}%")
                ->whereNull('deleted_at')
                ->select('name')
                ->distinct()
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return ['name' => $item->name];
                });
    
            // Get featured products (3 active products)
            $featuredProducts = Products::join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->where('products.name', 'LIKE', "%{$query}%")
                ->where('product_variants.is_show', 1)
                ->where('product_variants.stock', '>', 0)
                ->whereNull('product_variants.deleted_at')
                ->whereNull('products.deleted_at')
                ->select(
                    'products.id',
                    'products.name',
                    'products.image_url as image',
                    'product_variants.sale_price as price',
                    'product_variants.listed_price as old_price'
                )
                ->limit(3)
                ->get();
                $featuredProducts = ProductSuggestionResource::collection($featuredProducts);
    
            return response()->json([
                'suggestions' => $suggestions,
                'featured_products' => $featuredProducts
            ]);
        } catch (\Throwable $e) {
            Log::error('Suggestion error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
}
