<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::with('category')->paginate(10);
        return view('dashboard.pages.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('dashboard.pages.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'slug' => 'required|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Xử lý upload ảnh
        $path = $request->file('image_url')->store('uploads/products', 'public');

        Products::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'image_url' => $path,
        ]);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all();
        return view('dashboard.pages.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'slug' => 'required|unique:products,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->only(['name', 'slug', 'category_id']);

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('uploads/products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function show($id)
    {
        $product = Products::with('category')->findOrFail($id);
        return view('dashboard.pages.product.show', compact('product'));
    }
}
