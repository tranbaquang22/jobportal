<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:50'],
            'password' => ['max:20'],
            'name' => ['required', 'max:50'],
            'phone' => ['required', 'digits_between:10,11'],
            'role' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email đăng nhập không được để trống',
            'email.email' => 'Email không hợp lệ',
            'name.required' => 'Họ và tên không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.digits_between' => 'Số điện thoại phải chứa từ 10-11 chữ số',
            'role' => 'Vui lòng chọn chức vụ'
        ];
    }
}
