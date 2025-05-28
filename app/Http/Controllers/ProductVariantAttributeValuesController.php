<?php

namespace App\Http\Controllers;

use App\Models\Product_variant_attribute_values;
use App\Models\Product_variants;
use App\Models\Variant_attribute;
use App\Models\Variant_attribute_values;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductVariantAttributeValuesController extends Controller
{
    // Hiển thị danh sách các bản ghi
    public function index()
    {
        $items = Product_variant_attribute_values::with(['variant', 'attribute', 'value'])->paginate(15);
        return view('dashboard.pages.product_variant_attribute_values.index', compact('items'));
    }

    // Form tạo mới
    public function create()
    {
        $variants = Product_variants::all();
        $attributes = Variant_attribute::all();
        $values = Variant_attribute_values::all();
        return view('dashboard.pages.product_variant_attribute_values.create', compact('variants', 'attributes', 'values'));
    }

    // Lưu mới
    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'attribute_id' => 'required|exists:variant_attributes,id',
            'value_id' => 'required|exists:variant_attribute_values,id',
        ]);

        Product_variant_attribute_values::create($request->only('variant_id', 'attribute_id', 'value_id'));

        return redirect()->route('product_variant_attribute_values.index')->with('success', 'Thêm thành công.');
    }

    // Form sửa
    public function edit($id)
    {
        $item = Product_variant_attribute_values::findOrFail($id);
        $variants = Product_variants::all();
        $attributes = Variant_attribute::all();
        $values = Variant_attribute_values::all();
        return view('dashboard.pages.product_variant_attribute_values.edit', compact('item', 'variants', 'attributes', 'values'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'attribute_id' => 'required|exists:variant_attributes,id',
            'value_id' => 'required|exists:variant_attribute_values,id',
        ]);

        $item = Product_variant_attribute_values::findOrFail($id);
        $item->update($request->only('variant_id', 'attribute_id', 'value_id'));

        return redirect()->route('product_variant_attribute_values.index')->with('success', 'Cập nhật thành công.');
    }

    // Xóa
    public function destroy($id)
    {
        $item = Product_variant_attribute_values::findOrFail($id);
        $item->delete();

        return redirect()->route('product_variant_attribute_values.index')->with('success', 'Xóa thành công.');
    }

    // Hiển thị chi tiết (tuỳ chọn)
    public function show($id)
    {
        $item = Product_variant_attribute_values::with(['variant', 'attribute', 'value'])->findOrFail($id);
        return view('dashboard.pages.product_variant_attribute_values.show', compact('item'));
    }
}
