<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_variants;
use App\Models\Products;

class ProductVariantsController extends Controller
{
    // Danh sách tất cả biến thể
    public function index()
    {
        $variants = Product_variants::with('product')->get();
        return view('dashboard.pages.variants.index', compact('variants'));
    }

    // Form tạo biến thể
    public function create($productId)
    {
        $product = Products::findOrFail($productId);
        return view('dashboard.pages.variants.create', compact('product'));
    }

    // Lưu biến thể mới
    public function store(Request $request, $productId)
    {
          
        $request->validate([
            'name' => 'nullable|string|max:255',
            'sku' => 'required|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'size' => 'nullable|in:S,M,L,XL,XXL',
            'color' => 'nullable|in:red,blue,green,black,white',
        ]);

        $data = $request->only(['name', 'sku', 'price', 'quantity', 'status', 'size', 'color']);
        $data['product_id'] = $productId;
        $data['status'] = $data['status'] ?? 'active';

        Product_variants::create($data);

        return redirect()->route('variants.index')->with('success', 'Thêm biến thể thành công!');
    }

    // Hiển thị chi tiết biến thể
    public function show($variantId)
    {
        $variant = Product_variants::with('product')->findOrFail($variantId);
        return view('dashboard.pages.variants.show', compact('variant'));
    }

    // Form sửa biến thể
    public function edit($variantId)
    {
        $variant = Product_variants::findOrFail($variantId);
        $product = $variant->product;
        return view('dashboard.pages.variants.edit', compact('variant', 'product'));
    }

    // Cập nhật biến thể
    public function update(Request $request, $variantId)
    {
        $variant = Product_variants::findOrFail($variantId);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'sku' => 'required|unique:product_variants,sku,' . $variantId,
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'size' => 'nullable|in:S,M,L,XL,XXL',
            'color' => 'nullable|in:red,blue,green,black,white',
        ]);

        $data = $request->only(['name', 'sku', 'price', 'quantity', 'status', 'size', 'color']);
        $data['status'] = $data['status'] ?? 'active';

        $variant->update($data);

        return redirect()->route('variants.index')->with('success', 'Cập nhật biến thể thành công!');
    }

    // Xóa mềm biến thể
    public function destroy($variantId)
    {
        $variant = Product_variants::findOrFail($variantId);
        $variant->delete();

        return redirect()->route('variants.index')->with('success', 'Xóa biến thể thành công!');
    }
}
