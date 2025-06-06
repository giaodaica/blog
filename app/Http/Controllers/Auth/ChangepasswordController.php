<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ChangepasswordController extends Controller
{
public function showChangePasswordForm()
{
    return view('pages.shop.account');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]); 

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Đổi mật khẩu thành công');
}
}