<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product_variants;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\Products;
use App\Models\Colors;
use App\Models\Size;
use App\Models\Sizes;

class ProductVariantsController extends Controller
{
    // Hiển thị danh sách biến thể
    public function index()
    {
        $variants = Product_variants::with('product', 'color', 'size')->get();
        return view('dashboard.pages.variants.index', compact('variants'));
    }

    // Form tạo biến thể mới
    public function create($productId)
    {
        $product = Products::findOrFail($productId);
        $colors = Color::all();
        $sizes = Size::all();

        return view('dashboard.pages.variants.create', compact('product', 'colors', 'sizes'));
    }

    // Lưu biến thể
public function store(Request $request, $productId)
{
    $request->validate([
        'color_ids' => 'required|array',
        'color_ids.*' => 'exists:colors,id',
        'size_ids' => 'required|array',
        'size_ids.*' => 'exists:sizes,id',
        'import_price' => 'required|numeric|min:0',
        'listed_price' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'variant_image_url' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'is_show' => 'nullable|boolean',
    ]);

    // Lấy sản phẩm để lấy tên
    $product = Products::findOrFail($productId);

    // Lưu ảnh
    $imagePath = null;
    if ($request->hasFile('variant_image_url')) {
        $file = $request->file('variant_image_url');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/variants'), $filename);
        $imagePath = 'uploads/variants/' . $filename;
    }

    foreach ($request->color_ids as $colorId) {
        foreach ($request->size_ids as $sizeId) {
            $color = Color::find($colorId);
            $size = Size::find($sizeId);

            // Tự động tạo tên biến thể: Tên sản phẩm - Màu - Size
            $variantName = $product->name . ' - ' . $color->color_name . ' - ' . $size->size_name;

            Product_variants::create([
                'product_id' => $productId,
                'name' => $variantName,
                'color_id' => $colorId,
                'size_id' => $sizeId,
                'import_price' => $request->import_price,
                'listed_price' => $request->listed_price,
                'sale_price' => $request->sale_price,
                'stock' => $request->stock,
                'variant_image_url' => $imagePath,
                'is_show' => $request->input('is_show', 1),
            ]);
        }
    }

    return redirect()->route('variants.index')->with('success', 'Tạo biến thể thành công!');
}



    // Hiển thị chi tiết biến thể
    public function show($id)
    {
        $variant = Product_variants::with('product', 'color', 'size')->findOrFail($id);
        return view('dashboard.pages.variants.show', compact('variant'));
    }

    // Form sửa
    public function edit($id)
    {
        $variant = Product_variants::findOrFail($id);
        $product = $variant->product;
        $colors = Color::all();
        $sizes = Size::all();
        return view('dashboard.pages.variants.edit', compact('variant', 'product', 'colors', 'sizes'));
    }

    // Cập nhật biến thể
    public function update(Request $request, $id)
    {
        
        $variant = Product_variants::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:product_variants,name,' . $id,
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'import_price' => 'required|numeric|min:0',
            'listed_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'variant_image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_show' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'name',
            'color_id',
            'size_id',
            'import_price',
            'listed_price',
            'sale_price',
            'stock',
            'is_show'
        ]);
        $data['is_show'] = $request->input('is_show', 1);

        if ($request->hasFile('variant_image_url')) {
            $file = $request->file('variant_image_url');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/variants'), $filename);
            $data['variant_image_url'] = 'uploads/variants/' . $filename;
        }

        $variant->update($data);

        return redirect()->route('variants.index')->with('success', 'Cập nhật biến thể thành công!');
    }

    // Xóa mềm
    public function destroy($id)
    {
        $variant = Product_variants::findOrFail($id);
        $variant->delete();

        return redirect()->route('variants.index')->with('success', 'Xóa biến thể thành công!');
    }
    
}
