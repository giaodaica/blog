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
        $query = $request->get('q');

        if (!$query) {
            return redirect()->route('home.shop');
        }

        $products = Products::where('name', 'LIKE', "%{$query}%")
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->paginate(12);

        // Lấy dữ liệu cho sidebar
        $categories = Categories::withCount('products')->get();
        $colors = Color::withCount('productVariants')->get();
        $sizes = Size::withCount('productVariants')->get();

        return view('pages.shop.shop', [
            'products' => $products,
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'searchQuery' => $query
        ]);
    }

    public function suggestions(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([]);
        }

        $suggestions = Products::where('name', 'LIKE', "%{$query}%")
            ->select('name')
            ->limit(5)
            ->get();

        return response()->json($suggestions);
    }
}
