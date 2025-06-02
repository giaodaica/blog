<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    // Danh sách sản phẩm
    public function index()
    {
        $products = Products::with(['category', 'variants'])->paginate(10); // Lấy thêm biến thể
        return view('dashboard.pages.product.index', compact('products'));
    }

    // Form tạo sản phẩm mới
    public function create()
    {
        $categories = Categories::all();
        return view('dashboard.pages.product.create', compact('categories'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'dsc' => 'required',
            'meta_title' => 'nullable|string',
            'meta_dsc' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|unique:products,slug',
        ]);

        $product = Products::create($request->only([
            'name', 'dsc', 'meta_title', 'meta_dsc', 'meta_keyword', 'category_id', 'slug'
        ]));

        // Nếu có thêm biến thể, bạn có thể xử lý ở đây (tùy bài làm)

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $product = Products::with('variants')->findOrFail($id); // lấy kèm biến thể nếu cần
        $categories = Categories::all();
        return view('dashboard.pages.product.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'dsc' => 'required',
            'meta_title' => 'nullable|string',
            'meta_dsc' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|unique:products,slug,' . $id,
        ]);

        $product->update($request->only([
            'name', 'dsc', 'meta_title', 'meta_dsc', 'meta_keyword', 'category_id', 'slug'
        ]));

        // Xử lý cập nhật biến thể nếu có

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // Xóa mềm sản phẩm
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Products::with(['category', 'variants'])->findOrFail($id);
        return view('dashboard.pages.product.show', compact('product'));
    }
}
