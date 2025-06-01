<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Product_variants;
use App\Models\Variant_attribute;
use App\Models\Variant_attribute_values;
use App\Models\Product_variant_attribute_values;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{
    // Hiển thị danh sách sản phẩm kèm biến thể và thuộc tính
    public function index()
    {
        $products = Products::with(['variants.attributeValues.attribute'])->get();
        return view('dashboard.pages.product.index', compact('products'));
    }

    // Trang tạo sản phẩm mới (cần danh sách danh mục + thuộc tính biến thể để chọn)
  public function create()
{
    $categories = Categories::all();
    $variantAttributes = Variant_attribute::all(); // lấy tất cả thuộc tính biến thể

    return view('dashboard.pages.product.create', compact('categories', 'variantAttributes'));
}

    // Lưu sản phẩm mới và biến thể + thuộc tính biến thể
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'dsc' => 'required',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|unique:products,slug',

            'variants.*.sku' => 'required|distinct|unique:product_variants,sku',
            'variants.*.price' => 'required|numeric',
            'variants.*.quantity' => 'required|integer',
            'variants.*.image' => 'required|image',
            'variants.*.attributes' => 'array',
        ]);

        $product = Products::create($request->only([
            'name', 'dsc', 'meta_title', 'meta_dsc', 'meta_keyword', 'category_id', 'slug'
        ]));

        if ($request->has('variants')) {
            foreach ($request->variants as $index => $variantData) {
                $imageFile = $request->file("variants.$index.image");
                $path = $imageFile->store('product_variants', 'public');

                $variant = Product_variants::create([
                    'product_id' => $product->id,
                    'sku' => $variantData['sku'],
                    'price' => $variantData['price'],
                    'quantity' => $variantData['quantity'],
                    'image' => $path,
                    'status' => 1,
                ]);

                if (!empty($variantData['attributes'])) {
                    foreach ($variantData['attributes'] as $attributeId => $valueId) {
                        Product_variant_attribute_values::create([
                            'variant_id' => $variant->id,
                            'attribute_id' => $attributeId,
                            'value_id' => $valueId,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm kèm biến thể thành công!');
    }

    // Trang chỉnh sửa sản phẩm (cần load đầy đủ sản phẩm + biến thể + thuộc tính biến thể)
    public function edit($id)
    {
        $product = Products::with(['variants.attributeValues.attribute'])->findOrFail($id);
        $categories = Categories::all();
        $variantAttributes = Variant_attribute::with('values')->get();

        return view('dashboard.pages.product.edit', compact('product', 'categories', 'variantAttributes'));
    }

    // Cập nhật sản phẩm + biến thể + thuộc tính biến thể
    public function update(Request $request, $id)
{
    $product = Products::findOrFail($id);

   try {
        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'dsc' => 'required',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'required|unique:products,slug,' . $id,

            'variants.*.sku' => 'required|distinct|unique:product_variants,sku,' . ($request->variants ? implode(',', array_column($request->variants, 'id')) : ''),
            'variants.*.price' => 'required|numeric',
            'variants.*.quantity' => 'required|integer',
            'variants.*.image' => 'nullable|image',
            'variants.*.attributes' => 'array',
        ]);
    } catch (ValidationException $e) {
        // Xem các lỗi validate
        dd($e->errors());
    }

    $product->update($request->only([
        'name', 'dsc', 'meta_title', 'meta_dsc', 'meta_keyword', 'category_id', 'slug'
    ]));

    // Lấy danh sách ID biến thể gửi lên từ form
    $variantIdsFromRequest = collect($request->variants)->pluck('id')->filter()->all();

    // Lấy danh sách ID biến thể hiện tại trong DB
    $existingVariantIds = $product->variants()->pluck('id')->all();

    // Xóa các biến thể trong DB không có trong form
    $variantsToDelete = array_diff($existingVariantIds, $variantIdsFromRequest);
    if (!empty($variantsToDelete)) {
        // Xóa các thuộc tính của biến thể trước
        Product_variant_attribute_values::whereIn('variant_id', $variantsToDelete)->delete();
        // Xóa biến thể
        Product_variants::whereIn('id', $variantsToDelete)->delete();
    }

    if ($request->has('variants')) {
        foreach ($request->variants as $index => $variantData) {
            $variant = isset($variantData['id']) ? Product_variants::find($variantData['id']) : new Product_variants();
            $variant->product_id = $product->id;
            $variant->sku = $variantData['sku'];
            $variant->price = $variantData['price'];
            $variant->quantity = $variantData['quantity'];
            $variant->status = $variantData['status'] ?? 1;

            if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $imageFile = $request->file("variants.$index.image");
                $path = $imageFile->store('product_variants', 'public');
                $variant->image = $path;
            }

            $variant->save();

            // Xóa các thuộc tính cũ của biến thể
            Product_variant_attribute_values::where('variant_id', $variant->id)->delete();

            if (!empty($variantData['attributes'])) {
                foreach ($variantData['attributes'] as $attributeId => $valueId) {
                    Product_variant_attribute_values::create([
                        'variant_id' => $variant->id,
                        'attribute_id' => $attributeId,
                        'value_id' => $valueId,
                    ]);
                }
            }
        }
    }

    return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
}

    // Xóa sản phẩm (soft delete)
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    // Hiển thị chi tiết sản phẩm (có đầy đủ biến thể + thuộc tính)
    public function show($id)
    {
         $product = Products::with(['variants.attributeValues.attribute'])->findOrFail($id);
    
    return view('dashboard.pages.product.show', compact('product'));
     }
}
