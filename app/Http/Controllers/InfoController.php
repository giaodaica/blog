<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class InfoController extends Controller
{
    public function updateProfile(Request $request)
{
    $user = Auth::user();
    $user->update($request->validate([
        'name' => 'required|string|max:255',
        'default_phone' => 'nullable|string|max:20',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]));
// dd($user);
    return redirect()->back()->with('success', 'Thông tin đã được cập nhật thành công!');
}
}
