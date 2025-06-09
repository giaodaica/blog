<?php

namespace App\Http\Controllers\Spatie;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('spatie.user-role.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);
        return back()->with('success', 'Cập nhật thành công');
    }
}
