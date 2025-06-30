<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('dashboard.pages.users.index', compact('users'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        return view('dashboard.pages.users.create');
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,guest',
            'rank'     => 'nullable|in:newbie,silver,gold,diamond',
            'point'    => 'nullable|integer|min:0',
            'total_spent' => 'nullable|numeric|min:0',
        ]);

        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'role'            => $request->role,
            'default_address' => $request->default_address,
            'default_phone'   => $request->default_phone,
            'total_spent'     => $request->total_spent ?? 0,
            'point'           => $request->point ?? 0,
            'rank'            => $request->rank ?? 'newbie',
        ]);

        return redirect()->route('dashboard.pages.users.index')->with('success', 'Tạo tài khoản thành công');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.pages.users.edit', compact('user'));
    }

    // Cập nhật người dùng
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,guest',
            'rank'  => 'nullable|in:newbie,silver,gold,diamond',
            'point' => 'nullable|integer|min:0',
            'total_spent' => 'nullable|numeric|min:0',
        ]);

        $user->update([
            'name'            => $request->name,
            'email'           => $request->email,
            'role'            => $request->role,
            'default_address' => $request->default_address,
            'default_phone'   => $request->default_phone,
            'total_spent'     => $request->total_spent ?? 0,
            'point'           => $request->point ?? 0,
            'rank'            => $request->rank ?? 'newbie',
        ]);

        return redirect()->route('dashboard.pages.users.index')->with('success', 'Cập nhật tài khoản thành công');
    }

    // Xoá người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('dashboard.pages.users.index')->with('success', 'Xoá tài khoản thành công');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_users', []);
        User::whereIn('id', $ids)->delete();

        return redirect()->route('dashboard.pages.users.index')->with('success', 'Đã xoá những người dùng đã chọn');
    }
}
