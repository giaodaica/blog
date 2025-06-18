<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    // Hiển thị danh sách size
    public function index()
    {
        $sizes = Size::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.pages.size.index', compact('sizes'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        return view('dashboard.pages.size.create');
    }

    // Lưu size mới
    public function store(Request $request)
    {
        $request->validate([
            'size_name' => ['required', 'unique:sizes,size_name', 'max:10', 'regex:/^[\pL\s]+$/u'],
        ], [
            'size_name.required' => 'Tên kích cỡ không được để trống.',
            'size_name.unique' => 'Tên kích cỡ đã tồn tại, vui lòng chọn tên khác.',
            'size_name.max' => 'Tên kích cỡ không được vượt quá 10 ký tự.',
            'size_name.regex' => 'Tên kích cỡ chỉ được chứa chữ và khoảng trắng.',
        ]);
        Size::create([
            'size_name' => $request->size_name,
        ]);

        return redirect()->route('sizes.index')->with('success', 'Thêm kích cỡ thành công!');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        $size = Size::findOrFail($id);
        return view('dashboard.pages.size.edit', compact('size'));
    }

    // Cập nhật size
    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'size_name' => ['required', 'unique:sizes,size_name,' . $id, 'max:10', 'regex:/^[\pL\s]+$/u'],
        ], [
            'size_name.required' => 'Tên kích cỡ không được để trống.',
            'size_name.unique' => 'Tên kích cỡ đã tồn tại, vui lòng chọn tên khác.',
            'size_name.max' => 'Tên kích cỡ không được vượt quá 50 ký tự.',
            'size_name.regex' => 'Tên kích cỡ chỉ được chứa chữ và khoảng trắng.',
        ]);

        $size->update([
            'size_name' => $request->size_name,
        ]);

        return redirect()->route('sizes.index')->with('success', 'Cập nhật kích cỡ thành công!');
    }

    // Xóa size
    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('sizes.index')->with('success', 'Xóa kích cỡ thành công!');
    }
}
