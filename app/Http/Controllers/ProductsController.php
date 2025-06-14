<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::with('category')->paginate(10);
        return view('dashboard.pages.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Categories::all();
        $colors = \App\Models\Color::all();
        $sizes = \App\Models\Size::all(); // Truy vấn thêm size

        return view('dashboard.pages.product.create', compact('categories', 'colors', 'sizes'));
    }

   public function store(Request $request)
{
    // dd($request->all());
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'variants' => 'required|array|min:1',
        'variants.*.color_id' => 'required|exists:colors,id',
        'variants.*.size_id' => 'required|exists:sizes,id',
        'variants.*.variant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'variants.*.import_price' => 'required|numeric|min:0',
        'variants.*.listed_price' => 'required|numeric|min:0',
        'variants.*.sale_price' => 'required|numeric|min:0',
        'variants.*.stock' => 'required|numeric|min:0',
        'variants.*.is_show' => 'nullable|boolean',
    ]);

    try {
        DB::beginTransaction();

        // Xử lý ảnh sản phẩm chính
        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        // Tạo sản phẩm
        $product = Products::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image_url' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        // Lưu các biến thể
        foreach ($request->variants as $index => $variantData) {
            $variantImagePath = null;

            // Xử lý ảnh biến thể
            if (isset($request->file('variants')[$index]['variant_image'])) {
                $variantFile = $request->file('variants')[$index]['variant_image'];
                $variantFileName = time() . '_' . $variantFile->getClientOriginalName();
                $variantFile->move(public_path('uploads/product_variants'), $variantFileName);
                $variantImagePath = 'uploads/product_variants/' . $variantFileName;
            }

            // Lấy tên màu và tên size
            $color = \App\Models\Color::find($variantData['color_id']);
            $size = \App\Models\Size::find($variantData['size_id']);

            // Tạo tên biến thể: Tên sản phẩm + Màu + Size
            $variantName = $product->name . ' - ' . ($color ? $color->color_name : '') . ' - ' . ($size ? $size->size_name : '');

            // Tạo biến thể
            $product->variants()->create([
                'color_id' => $variantData['color_id'],
                'size_id' => $variantData['size_id'],
                'name' => $variantName,
                'variant_image_url' => $variantImagePath,
                'import_price' => $variantData['import_price'],
                'listed_price' => $variantData['listed_price'],
                'sale_price' => $variantData['sale_price'],
                'stock' => $variantData['stock'],
                'is_show' => isset($variantData['is_show']) ? 1 : 0,
            ]);
        }

        DB::commit();
        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm và biến thể thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}


    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'slug' => 'required|unique:products,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',  // Ảnh có thể không có
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'slug.required' => 'Slug không được để trống',
            'slug.unique' => 'Slug đã tồn tại',
            'category_id.required' => 'Bạn chưa chọn danh mục',
            'category_id.exists' => 'Danh mục không hợp lệ',
            'image_url.image' => 'File tải lên phải là ảnh',
            'image_url.mimes' => 'Ảnh phải có định dạng: jpg, webp, jpeg hoặc png',
            'image_url.max' => 'Kích thước ảnh tối đa là 2MB',
        ]);

        $data = $request->only(['name', 'slug', 'category_id']);

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['image_url'] = 'uploads/products/' . $filename;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }


    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all();
        return view('dashboard.pages.product.edit', compact('product', 'categories'));
    }



    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function show($id)
    {
        $product = Products::with(relations: 'category')->findOrFail($id);
        return view('dashboard.pages.product.show', compact('product'));
    }
}
