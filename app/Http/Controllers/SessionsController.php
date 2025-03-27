<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\returnSelf;

class SessionsController extends Controller
{
    public function create()
    {
        return view('company.login');
    }

    public function store(SignInRequest $request)
    {
        $attributes = $request->validated();

        if (Auth::attempt($attributes)) {
            session()->regenerate();
            $user = Auth::user();
            session()->flash('success', 'Đăng nhập thành công!');

            switch ($user->role) {
                case "ADMIN":
                    return redirect('/company/users');
                    break;
                case "HR":
                    return redirect('/company/recruitment-news');
                    break;
                case "MANAGER":
                    return redirect('/company/campaigns');
                    break;
                default:
                    return redirect("/");
            }
        } else {
            return back()->withErrors(['error' => 'Email hoặc mật khẩu không đúng']);
        }
    }

    public function forgot_password()
    {
        return view('company.forgot-password');
    }

    public function post_forgot_password(Request $request)
    {
        echo $request->input('email');

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            $new_password = uniqid();

            Mail::to($user->email)->send(new ResetPasswordMail($new_password));

            $user->password = Hash::make($new_password);
            $user->save();

            session()->flash('success', 'Mật khẩu mới đã được gửi đến email của bạn');

            return redirect('/login');
        } else {
            return back()->withErrors(['error' => 'Email không tồn tại']);
        }
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login')->with(['success' => 'Bạn đã đăng xuất']);
    }
}
