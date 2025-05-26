<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $products = Products::all();
        return view('dashboard.product.index', compact('products'));
    }

    // Hiển thị form thêm sản phẩm
    public function create()
    {
        return view('dashboard.product.create');
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'dsc' => 'required',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|unique:products,slug',
        ]);

        Products::create($request->all());
        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Products::findOrFail($id);
        return view('dashboard.product.show', compact('product'));
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('dashboard.product.edit', compact('product'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'dsc' => 'required',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|unique:products,slug,' . $id,
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}