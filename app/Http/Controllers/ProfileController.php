<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update()
    {
        $current_user = Auth::user();

        return view('company.profile', [
            "role" => User::DISPLAYED_ROLE[$current_user->role],
            "breadcrumb_tabs" => ["Quản lý tài khoản" => ""],
            "current_user" => $current_user
        ]);
    }

    public function post_update(UpdateProfileRequest $request)
    {
        $validated = $request->validated();
        $user = User::findOrFail(Auth::user()->id);
        $user->name = !is_null($validated['name']) ? $validated['name'] : $user->name;
        $user->email = !is_null($validated['email']) ? $validated['email'] : $user->email;
        $user->phone = !is_null($validated['phone']) ? $validated['phone'] : $user->phone;
        $user->save();

        session()->flash('success', 'Cập nhật tài khoản thành công!');

        return redirect('/company/profile');
    }

    public function change_password()
    {
        $current_user = Auth::user();

        return view('company.change-password', [
            "role" => User::DISPLAYED_ROLE[$current_user->role],
            "breadcrumb_tabs" => ["Quản lý tài khoản" => "/company/profile", "Đổi mật khẩu" => ""],
            "current_user" => $current_user
        ]);
    }

    public function post_change_password(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($request->input('password'),  $user->password)) {
            $user->password = Hash::make($request->input('new_password'));
            $user->save();

            session()->flash('success', 'Đổi mật khẩu thành công');
            return redirect('/company/profile');
        } else {
            return back()->withErrors(['error' => 'Mật khẩu không đúng']);
        }

        // return view('company.change-password', [
        //     "role" => User::DISPLAYED_ROLE[$current_user->role],
        //     "breadcrumb_tabs" => ["Quản lý tài khoản" => "/company/profile", "Đổi mật khẩu" => ""],
        //     "current_user" => $current_user
        // ]);
    }
}
