<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories,name',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'status' => 'required|in:0,1',
    ]);

    $data = $request->only('name', 'status');

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/categories'), $filename);
        $data['image'] = 'uploads/categories/' . $filename;
    }

    Categories::create($data);

    return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công!');
}

public function update(Request $request, $id)
{
    $category = Categories::findOrFail($id);

    $request->validate([
        'name' => 'required|unique:categories,name,' . $id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'status' => 'required|in:0,1',
    ]);

    $data = $request->only('name', 'status');

    if ($request->hasFile('image')) {
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/categories'), $filename);
        $data['image'] = 'uploads/categories/' . $filename;
    }

    $category->update($data);

    return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
}

// {
//     $category = Categories::findOrFail($id);

//     $request->validate([
//         'name' => 'required|unique:categories,name,' . $id,
//         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//         'status' => 'required|in:0,1',
//     ]);

//     $data = $request->all();

//     if ($request->hasFile('image')) {
//         // Xóa ảnh cũ nếu có
//         if ($category->image && \Storage::disk('public')->exists($category->image)) {
//             \Storage::disk('public')->delete($category->image);
//         }

//         // Lưu ảnh mới
//         $path = $request->file('image')->store('categories', 'public');
//         $data['image'] = $path;
//     }

//     $category->update($data);

//     return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
// }


    public function show($id)
    {
        $category = Categories::findOrFail($id);
        return view('dashboard.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('dashboard.categories.edit', compact('category'));
    }

   

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}