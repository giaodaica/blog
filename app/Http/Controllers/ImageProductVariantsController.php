<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageProductVariants;
use App\Models\Product_variants;

class ImageProductVariantsController extends Controller
{
    // Hiển thị tất cả ảnh của 1 biến thể sản phẩm
    public function index()
    {
        $variants = Product_variants::with('images')->get();
        return view('dashboard.pages.image_product_variants.index', compact('variants'));
    }

    // Form tạo mới ảnh cho biến thể
    public function create($variantId)
    {
        $variant = Product_variants::findOrFail($variantId);
        return view('dashboard.pages.image_product_variants.create', compact('variant'));
    }

    // Lưu ảnh mới
    public function store(Request $request, $variantId)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $variant = Product_variants::findOrFail($variantId);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/product_variant_images'), $filename);

                // Tạo record mới cho mỗi ảnh
                ImageProductVariants::create([
                    'product_variant_id' => $variantId,
                    'image_url_base' => 'uploads/product_variant_images/' . $filename,
                    // Nếu bạn muốn phân biệt ảnh chính và phụ, có thể thêm cột loại ảnh trong DB
                ]);
            }
        }

        return redirect()->route('image_product_variants.index', $variantId)->with('success', 'Thêm ảnh thành công!');
    }


    // Xóa ảnh
    public function destroy($id)
    {
        $image = ImageProductVariants::findOrFail($id);
        $variantId = $image->product_variant_id;

        // Bạn có thể thêm xóa file vật lý ở đây nếu muốn

        $image->delete();

        return redirect()->route('image_product_variants.index', $variantId)->with('success', 'Xóa ảnh thành công!');
    }
}
