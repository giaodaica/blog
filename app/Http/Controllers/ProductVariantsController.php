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
            'size_ids' => 'required|array|min:1',
            'size_ids.*' => 'integer|exists:sizes,id',

            'color_ids' => 'required|array|min:1',
            'color_ids.*' => 'integer|exists:colors,id',

            'import_price' => 'required|numeric|min:0',
            'listed_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|lte:listed_price',

            'stock' => 'required|integer|min:0',

            // Ảnh biến thể cho từng màu
            'variant_images' => 'required|array|min:1',
            'variant_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'is_show' => 'nullable|boolean',
        ], [
            'size_ids.required' => 'Vui lòng chọn ít nhất 1 size.',
            'size_ids.array' => 'Dữ liệu size không hợp lệ.',
            'size_ids.*.exists' => 'Size được chọn không tồn tại.',

            'color_ids.required' => 'Vui lòng chọn ít nhất 1 màu.',
            'color_ids.array' => 'Dữ liệu màu không hợp lệ.',
            'color_ids.*.exists' => 'Màu được chọn không tồn tại.',

            'import_price.required' => 'Giá nhập không được để trống.',
            'import_price.numeric' => 'Giá nhập phải là số.',
            'import_price.min' => 'Giá nhập không được nhỏ hơn 0.',

            'listed_price.required' => 'Giá niêm yết không được để trống.',
            'listed_price.numeric' => 'Giá niêm yết phải là số.',
            'listed_price.min' => 'Giá niêm yết không được nhỏ hơn 0.',

            'sale_price.required' => 'Giá bán không được để trống.',
            'sale_price.numeric' => 'Giá bán phải là số.',
            'sale_price.min' => 'Giá bán không được nhỏ hơn 0.',
            'sale_price.lte' => 'Giá bán phải nhỏ hơn hoặc bằng giá niêm yết.',

            'stock.required' => 'Số lượng kho không được để trống.',
            'stock.integer' => 'Số lượng kho phải là số nguyên.',
            'stock.min' => 'Số lượng kho không được nhỏ hơn 0.',

            'variant_images.required' => 'Bạn phải chọn ít nhất một ảnh cho biến thể.',
            'variant_images.array' => 'Ảnh biến thể phải là mảng.',
            'variant_images.min' => 'Bạn phải chọn ít nhất một ảnh cho biến thể.',
            'variant_images.*.image' => 'Mỗi ảnh phải là file ảnh hợp lệ.',
            'variant_images.*.mimes' => 'Ảnh chỉ được chấp nhận định dạng jpg, jpeg, png, webp.',
            'variant_images.*.max' => 'Kích thước ảnh không được vượt quá 2MB.',

            'is_show.boolean' => 'Trạng thái hiển thị không hợp lệ.',
        ]);

        $product = Products::findOrFail($productId);

        // Validate: Mỗi màu được chọn phải có ảnh
        foreach ($request->color_ids as $colorId) {
            // Lấy tên màu
            $colorName = Color::find($colorId)?->color_name ?? 'Không xác định';

            if (!$request->hasFile("variant_images.$colorId")) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        "variant_images.$colorId" => "Vui lòng chọn ảnh cho màu: $colorName."
                    ]);
            }

            if (!$request->file("variant_images.$colorId")->isValid()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        "variant_images.$colorId" => "Ảnh cho màu: $colorName không hợp lệ."
                    ]);
            }
        }

        // Tạo biến thể: Mỗi tổ hợp Màu + Size
        foreach ($request->color_ids as $colorId) {
            $color = Color::find($colorId);

            // Upload ảnh cho màu này
            $file = $request->file("variant_images.$colorId");
            $filename = time() . "_color_{$colorId}." . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/variants'), $filename);
            $imagePath = 'uploads/variants/' . $filename;

            foreach ($request->size_ids as $sizeId) {
                $size = Size::find($sizeId);

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

        return redirect()->route('variants.index')->with('success', 'Đã tạo các biến thể thành công.');
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

        $product = Products::withTrashed()->find($variant->product_id);

        if ($product && $product->trashed()) {
            // Sản phẩm đã bị soft delete → bạn có thể chuyển hướng hoặc set biến trạng thái
            // Ví dụ: mình báo lỗi hoặc gửi biến để view biết
            // return redirect()->route('variants.index')->with('error', 'Sản phẩm liên quan đã bị xóa, không thể chỉnh sửa biến thể.');
            $isProductDeleted = true;
        } else {
            $isProductDeleted = false;
        }

        $colors = Color::all();
        $sizes = Size::all();

        return view('dashboard.pages.variants.edit', compact('variant', 'product', 'colors', 'sizes', 'isProductDeleted'));
    }


    // Cập nhật biến thể
    public function update(Request $request, $id)
    {

        $variant = Product_variants::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:product_variants,name,' . $id,
            'color_id' => 'required|integer|exists:colors,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'import_price' => 'required|numeric|min:0',
            'listed_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|lte:listed_price',
            'stock' => 'required|integer|min:0',
            'variant_image_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_show' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên biến thể không được để trống.',
            'name.string' => 'Tên biến thể phải là chuỗi ký tự.',
            'name.max' => 'Tên biến thể không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên biến thể đã tồn tại.',

            'color_id.required' => 'Bạn phải chọn màu.',
            'color_id.integer' => 'Màu không hợp lệ.',
            'color_id.exists' => 'Màu được chọn không tồn tại.',

            'size_id.required' => 'Bạn phải chọn size.',
            'size_id.integer' => 'Size không hợp lệ.',
            'size_id.exists' => 'Size được chọn không tồn tại.',

            'import_price.required' => 'Giá nhập không được để trống.',
            'import_price.numeric' => 'Giá nhập phải là số.',
            'import_price.min' => 'Giá nhập không được nhỏ hơn 0.',

            'listed_price.required' => 'Giá niêm yết không được để trống.',
            'listed_price.numeric' => 'Giá niêm yết phải là số.',
            'listed_price.min' => 'Giá niêm yết không được nhỏ hơn 0.',

            'sale_price.required' => 'Giá bán không được để trống.',
            'sale_price.numeric' => 'Giá bán phải là số.',
            'sale_price.min' => 'Giá bán không được nhỏ hơn 0.',
            'sale_price.lte' => 'Giá bán phải nhỏ hơn hoặc bằng giá niêm yết.',

            'stock.required' => 'Số lượng kho không được để trống.',
            'stock.integer' => 'Số lượng kho phải là số nguyên.',
            'stock.min' => 'Số lượng kho không được nhỏ hơn 0.',

            'variant_image_url.image' => 'Ảnh phải là file ảnh hợp lệ.',
            'variant_image_url.mimes' => 'Ảnh chỉ được chấp nhận định dạng jpg, jpeg, png, webp.',
            'variant_image_url.max' => 'Kích thước ảnh không được vượt quá 2MB.',

            'is_show.boolean' => 'Trạng thái hiển thị không hợp lệ.',
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
        $data['is_show'] = $request->has('is_show') ? 1 : 0;

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
