<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressBookController extends Controller
{
    public function index()
    {
        $addresses = AddressBook::where('user_id', Auth::id())->get();
        return view('pages.shop.addresses', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20'
        ], [
            'name.required' => 'Vui lòng nhập tên người nhận',
            'address.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'phone.required' => 'Vui lòng nhập số điện thoại'
        ]);

        AddressBook::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        return redirect()->back()->with('success', 'Thêm địa chỉ thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20'
        ]);

        $address = AddressBook::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $address->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone
        ]);

        return redirect()->back()->with('success', 'Cập nhật địa chỉ thành công!');
    }

    public function destroy($id)
    {
        $address = AddressBook::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $address->delete();

        return redirect()->back()->with('success', 'Xóa địa chỉ thành công!');
    }
}
