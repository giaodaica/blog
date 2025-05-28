<?php

namespace App\Http\Controllers;

use App\Models\Variant_attribute_values;
use App\Models\Variant_attribute;
use Illuminate\Http\Request;

class VariantAttributeValuesController extends Controller
{
    // Hiển thị danh sách giá trị thuộc tính
    public function index()
    {
        $values = Variant_attribute_values::with('variant_attribute')->get();
        return view('dashboard.pages.variant-attribute-values.index', compact('values'));
    }

    // Form tạo giá trị thuộc tính mới
    public function create()
    {
        $attributes = Variant_attribute::all();
        return view('dashboard.pages.variant-attribute-values.create', compact('attributes'));
    }

    // Lưu giá trị thuộc tính mới
    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:variant_attributes,id',
            'value' => 'required|string|max:255',
        ]);

        Variant_attribute_values::create([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
        ]);

        return redirect()->route('variant-attributes-values.index')->with('success', 'Tạo giá trị thuộc tính thành công');
    }

    // Form sửa giá trị thuộc tính
    public function edit($id)
    {
        $value = Variant_attribute_values::findOrFail($id);
        $attributes = Variant_attribute::all();
        return view('dashboard.pages.variant-attribute-values.edit', compact('value', 'attributes'));
    }

    // Cập nhật giá trị thuộc tính
    public function update(Request $request, $id)
    {
        $value = Variant_attribute_values::findOrFail($id);

        $request->validate([
            'attribute_id' => 'required|exists:variant_attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $value->update([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
        ]);

        return redirect()->route('variant-attributes-values.index')->with('success', 'Cập nhật giá trị thuộc tính thành công');
    }

    // Xóa giá trị thuộc tính
    public function destroy($id)
    {
        $value = Variant_attribute_values::findOrFail($id);
        $value->delete();

        return redirect()->route('variant-attributes-values.index')->with('success', 'Xóa giá trị thuộc tính thành công');
    }
}
