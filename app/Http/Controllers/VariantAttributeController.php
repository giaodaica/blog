<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variant_attribute;

class VariantAttributeController extends Controller
{
    // Danh sách tất cả thuộc tính
    public function index()
    {
        $attributes = Variant_attribute::all();
        return view('dashboard.pages.variant_attributes.index', compact('attributes'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        return view('dashboard.pages.variant_attributes.create');
    }

    // Lưu thuộc tính mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:variant_attributes,name',
        ]);

        Variant_attribute::create([
            'name' => $request->name,
        ]);

        return redirect()->route('variant-attributes.index')->with('success', 'Thêm thuộc tính thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $attribute = Variant_attribute::findOrFail($id);
        return view('dashboard.pages.variant_attributes.edit', compact('attribute'));
    }

    // Cập nhật thuộc tính
    public function update(Request $request, $id)
    {
        $attribute = Variant_attribute::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:variant_attributes,name,' . $id,
        ]);

        $attribute->update([
            'name' => $request->name,
        ]);

        return redirect()->route('variant-attributes.index')->with('success', 'Cập nhật thuộc tính thành công!');
    }

    // Xoá thuộc tính
    public function destroy($id)
    {
        $attribute = Variant_attribute::findOrFail($id);
        $attribute->delete();

        return redirect()->route('variant-attributes.index')->with('success', 'Xóa thuộc tính thành công!');
    }
}
