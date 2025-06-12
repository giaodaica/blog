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
            'image_url' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048',  // Ảnh bắt buộc
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'slug.required' => 'Slug không được để trống',
            'slug.unique' => 'Slug đã tồn tại',
            'category_id.required' => 'Bạn chưa chọn danh mục',
            'category_id.exists' => 'Danh mục không hợp lệ',
            'image_url.required' => 'Bạn phải chọn ảnh sản phẩm',
            'image_url.image' => 'File tải lên phải là ảnh',
            'image_url.mimes' => 'Ảnh phải có định dạng: jpg, jpeg, webp hoặc png',
            'image_url.max' => 'Kích thước ảnh tối đa là 2MB',
        ]);

        $data = $request->only(['name', 'slug', 'category_id']);

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['image_url'] = 'uploads/products/' . $filename;
        }

        Products::create($data);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'slug' => 'required|unique:products,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',  // Ảnh có thể không có
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'slug.required' => 'Slug không được để trống',
            'slug.unique' => 'Slug đã tồn tại',
            'category_id.required' => 'Bạn chưa chọn danh mục',
            'category_id.exists' => 'Danh mục không hợp lệ',
            'image_url.image' => 'File tải lên phải là ảnh',
            'image_url.mimes' => 'Ảnh phải có định dạng: jpg, webp, jpeg hoặc png',
            'image_url.max' => 'Kích thước ảnh tối đa là 2MB',
        ]);

        $data = $request->only(['name', 'slug', 'category_id']);

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['image_url'] = 'uploads/products/' . $filename;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }


    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all();
        return view('dashboard.pages.product.edit', compact('product', 'categories'));
    }



    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function show($id)
    {
        $product = Products::with(relations: 'category')->findOrFail($id);
        return view('dashboard.pages.product.show', compact('product'));
    }
}
