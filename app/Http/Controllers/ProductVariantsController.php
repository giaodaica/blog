<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Color;
use App\Models\Product_variants;
use Illuminate\Http\Request;

use App\Models\Products;

use App\Models\Size;


class ProductVariantsController extends Controller
{
    // Hiển thị danh sách biến thể
    public function index(Request $request)
    {
        // Nếu có tham số product_id => Chỉ lấy biến thể của sản phẩm đó
        if ($request->has('product_id')) {
            $productId = $request->product_id;
            $product = Products::findOrFail($productId);

            $variants = Product_variants::with('product', 'color', 'size')
                ->where('product_id', $productId)
                ->get();
        } else {
            // Nếu không có => Hiển thị tất cả biến thể
            $product = null;

            $variants = Product_variants::with('product', 'color', 'size')->get();
        }

        return view('dashboard.pages.variants.index', compact('variants', 'product'));
    }


    public function create()
    {
        $products = Products::all(); // Hiển thị danh sách sản phẩm để chọn
        $sizes = Size::all();
        $colors = Color::all();

        return view('dashboard.pages.variants.create', compact('products', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variants' => 'required|array|min:1',
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.import_price' => 'required|numeric|min:0',
            'variants.*.listed_price' => 'required|numeric|min:0',
            'variants.*.sale_price' => 'nullable|numeric|min:0|lte:variants.*.listed_price',
            'variants.*.stock' => 'required|numeric|min:0',
            'variants.*.variant_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'variants.required' => 'Vui lòng thêm ít nhất một biến thể.',
            'variants.*.size_id.required' => 'Vui lòng chọn size.',
            'variants.*.color_id.required' => 'Vui lòng chọn màu.',
            'variants.*.import_price.required' => 'Giá nhập không được để trống.',
            'variants.*.import_price.numeric' => 'Giá nhập phải là số.',
            'variants.*.import_price.min' => 'Giá nhập không được nhỏ hơn 0.',

            'variants.*.listed_price.required' => 'Giá niêm yết không được để trống.',
            'variants.*.listed_price.numeric' => 'Giá niêm yết phải là số.',
            'variants.*.listed_price.min' => 'Giá niêm yết không được nhỏ hơn 0.',

            'variants.*.sale_price.numeric' => 'Giá khuyến mãi phải là số.',
            'variants.*.sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'variants.*.sale_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá niêm yết.',
            'variants.*.variant_image.required' => 'Vui lòng chọn ảnh cho biến thể.',
            'variants.*.variant_image.image' => 'File phải là hình ảnh.',
            'variants.*.variant_image.mimes' => 'Chỉ chấp nhận ảnh jpeg, png, jpg, gif.',
            'variants.*.variant_image.max' => 'Ảnh không được vượt quá 2MB.',
        ]);

        $product = Products::findOrFail($request->product_id);

        // Check trùng trong cùng 1 lần submit
        $combinationCheck = [];
        foreach ($request->variants as $index => $variantData) {
            $key = $variantData['size_id'] . '-' . $variantData['color_id'];
            if (isset($combinationCheck[$key])) {
                return redirect()->back()->withErrors(['Lỗi: Biến thể size và màu bị trùng trong cùng một lần thêm.'])->withInput();
            }
            $combinationCheck[$key] = true;
        }

        foreach ($request->variants as $index => $variantData) {
            // Kiểm tra trùng trong database
            $exists = Product_variants::where('product_id', $request->product_id)
                ->where('size_id', $variantData['size_id'])
                ->where('color_id', $variantData['color_id'])
                ->exists();

            if ($exists) {
                $size = Size::find($variantData['size_id']);
                $color = Color::find($variantData['color_id']);
                return redirect()->back()->withErrors([
                    'Lỗi: Biến thể ' . $product->name . ' - ' . $color->color_name . ' - ' . $size->size_name . ' đã tồn tại trong hệ thống.'
                ])->withInput();
            }

            $variant = new Product_variants();
            $variant->product_id = $request->product_id;
            $variant->size_id = $variantData['size_id'];
            $variant->color_id = $variantData['color_id'];
            $variant->import_price = $variantData['import_price'];
            $variant->listed_price = $variantData['listed_price'];
            $variant->sale_price = $variantData['sale_price'] ?? 0;
            $variant->stock = $variantData['stock'];

            // Tạo tên biến thể: Tên sản phẩm + Màu + Size
            $size = Size::find($variantData['size_id']);
            $color = Color::find($variantData['color_id']);
            $variant->name = $product->name . ' - ' . $color->color_name . ' - ' . $size->size_name;

            // Xử lý upload ảnh
            if (isset($variantData['variant_image'])) {
                $image = $variantData['variant_image'];
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/variants'), $imageName);
                // Lưu đúng vào variant_image_url
                $variant->variant_image_url = 'uploads/variants/' . $imageName;
            }

            $variant->save();
        }

        return redirect()->route('variants.index')->with('success', 'Thêm biến thể thành công.');
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

    public function showVariants($productId)
    {
        $product = Products::findOrFail($productId);

        $variants = Product_variants::with(['color', 'size'])
            ->where('product_id', $productId)
            ->get();

        return view('variants.index', compact('product', 'variants'));
    }
}
