<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_variants;
use App\Models\Products;
use App\Models\Variant_attribute;
use App\Models\Variant_attribute_values;
use App\Models\Product_variant_attribute_values;

class ProductVariantsController extends Controller
{
public function index()
{
    // Lấy tất cả biến thể, kèm quan hệ với sản phẩm và các thuộc tính biến thể (nếu cần)
    $variants = Product_variants::with(['product', 'attributeValues.attribute', 'attributeValues.value'])->get();
     $products = Products::all();
    // Truyền dữ liệu ra view
    return view('dashboard.pages.variants.index', compact('variants', 'products'));
}
public function create($productId)
{
    $product = Products::findOrFail($productId);
    $attributes = Variant_attribute::with('values')->get();
    return view('dashboard.pages.variants.create', compact('product', 'attributes'));
}
public function store(Request $request, $productId)
{
    $request->validate([
        'variants' => 'required|array|min:1',
        'variants.*.sku' => 'required|unique:product_variants,sku',
        'variants.*.price' => 'required|numeric|min:0',
        'variants.*.quantity' => 'required|integer|min:0',
        'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'variants.*.status' => 'nullable|in:0,1',
        'variants.*.attributes' => 'nullable|array',
    ]);

    foreach ($request->variants as $variantData) {
        $imagePath = null;
        if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
            $file = $variantData['image'];
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/variant_images'), $filename);
            $imagePath = 'uploads/variant_images/' . $filename;
        }

        Product_variants::create([
            'product_id' => $productId,
            'sku' => $variantData['sku'],
            'price' => $variantData['price'],
            'quantity' => $variantData['quantity'],
            'image' => $imagePath,
            'status' => $variantData['status'] ?? 1,
        ]);
    }

    return redirect()->route('variants.index')->with('success', 'Thêm biến thể sản phẩm thành công!');
}




public function edit($variantId)
{
    $variant = Product_variants::with('attributeValues')->findOrFail($variantId);
    $product = $variant->product;
    $attributes = Variant_attribute::with('values')->get();

    // Chuyển biến thể object thành mảng (nếu cần)
    $variantArray = [
        'sku' => $variant->sku,
        'price' => $variant->price,
        'quantity' => $variant->quantity,
        'status' => $variant->status,
        'image_url' => $variant->image ? asset($variant->image) : null,
        // Nếu có thêm thuộc tính khác thì thêm vào đây
    ];

    $variants = [$variantArray]; // Mảng gồm 1 biến thể

    return view('dashboard.pages.variants.edit', compact('variants', 'product', 'attributes', 'variant'));
}
public function update(Request $request, $productId, $variantId)
{
    $variant = Product_variants::findOrFail($variantId);

    $request->validate([
        'sku' => 'required|unique:product_variants,sku,' . $variantId,
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'attributes' => 'nullable|array',
        'status' => 'nullable|in:0,1',
    ]);

    $data = [
        'sku' => $request->sku,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'status' => $request->status ?? 1,
    ];

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/variant_images'), $filename);
        $data['image'] = 'uploads/variant_images/' . $filename;
    }

    $variant->update($data);

    // Xóa attribute cũ
    Product_variant_attribute_values::where('variant_id', $variant->id)->delete();

    // Thêm attribute mới nếu có
    if ($request->has('attributes')) {
        foreach ($request->attributes as $attribute_id => $value_id) {
            Product_variant_attribute_values::create([
                'variant_id' => $variant->id,
                'attribute_id' => $attribute_id,
                'value_id' => $value_id,
            ]);
        }
    }

    return redirect()->route('variants.index', $productId)->with('success', 'Cập nhật biến thể thành công!');
}

public function destroy($variantId)
{
    $variant = Product_variants::findOrFail($variantId);
    $productId = $variant->product_id;
    $variant->delete();

    return redirect()->route('variants.index', $productId)->with('success', 'Xóa biến thể thành công!');
}
public function show($variantId)
{
    $variant = Product_variants::with([
        'product',
        'attributeValues.attribute',
        'attributeValues.value'
    ])->findOrFail($variantId);

    return view('dashboard.pages.variants.show', compact('variant'));
}

}
