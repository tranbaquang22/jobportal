<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list_users()
    {
        $users = User::where("role", "HR")->orWhere("role", "MANAGER")->get();
        return view('company.users.index', [
            "role" => "ADMIN",
            "breadcrumb_tabs" => ["Quản lý tài khoản" => ""],
            "users" => $users
        ]);
    }

    public function create()
    {
        return view('company.users.create', [
            "role" => "ADMIN",
            "breadcrumb_tabs" => ["Quản lý tài khoản" => "/company/users", "Tạo tài khoản" => ""],
        ]);
    }

    public function post_create(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        DB::beginTransaction();

        try {
            User::create([
                'email' => $validated['email'],
                'password' => $validated['password'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'role' => $validated['role']
            ]);

            session()->flash('success', 'Tạo tài khoản thành công!');

            DB::commit();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }

        return redirect('/company/users');
    }

    public function update($id)
    {
        $current_user = User::where("id", $id)->first();

        return view('company.users.update', [
            "role" => "ADMIN",
            "breadcrumb_tabs" => ["Quản lý tài khoản" => "/company/users", "Cập nhật tài khoản" => ""],
            "current_user" => $current_user
        ]);
    }

    public function post_update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();
        $user = User::findOrFail($id);
        $user->name = !is_null($validated['name']) ? $validated['name'] : $user->name;
        $user->email = !is_null($validated['email']) ? $validated['email'] : $user->email;
        $user->role = !is_null($validated['role']) ? $validated['role'] : $user->role;
        $user->phone = !is_null($validated['phone']) ? $validated['phone'] : $user->phone;
        $user->save();

        session()->flash('success', 'Cập nhật tài khoản thành công!');

        return redirect('/company/users');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->campaigns->count() > 0) {
            session()->flash('error', 'Không thể xoá do tài khoản này đang phụ trách (các) chiến dịch tuyển dụng.');
            return redirect('/company/users');
        } else {
            $user->delete();
            session()->flash('success', 'Xóa tài khoản thành công!');
            return redirect('/company/users');
        }
    }
}
