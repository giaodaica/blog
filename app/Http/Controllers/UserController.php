<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng (có thể lọc theo trạng thái)
    public function index(Request $request)
    {
        $status = $request->get('status', 'active'); // active | trashed | all

        $query = User::query();

        if ($status === 'trashed') {
            $query->onlyTrashed();
        } elseif ($status === 'all') {
            $query->withTrashed();
        }

        $users = $query->latest()->paginate(10);
        return view('dashboard.pages.users.index', compact('users', 'status'));
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

        return redirect()->route('users.index')->with('success', 'Tạo tài khoản thành công');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('dashboard.pages.users.edit', compact('user'));
    }

    // Cập nhật người dùng
    public function update(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

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

        return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công');
    }

    // Xoá mềm người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Xoá người dùng thành công (xoá mềm)');
    }

    // Khôi phục người dùng đã xoá
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index', ['status' => 'trashed'])->with('success', 'Khôi phục người dùng thành công');
    }

    // Xoá vĩnh viễn người dùng
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.index', ['status' => 'trashed'])->with('success', 'Xoá vĩnh viễn người dùng thành công');
    }

    // Xoá mềm hàng loạt
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.pages.users.show', compact('user'));
    }
}
