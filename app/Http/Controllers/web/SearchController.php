<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Color;
use App\Models\Products;
use App\Models\Size;
use Illuminate\Http\Request;

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
        $query = $request->get('q');
        
        $suggestions = Products::where('name', 'LIKE', "%{$query}%")
            ->select('name')
            ->limit(5)
            ->get();

        return response()->json($suggestions);
    }
}
