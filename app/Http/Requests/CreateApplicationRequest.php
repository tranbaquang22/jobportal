<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateApplicationRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'digits_between:10,11'],
            'job_id' => ['required'],
            'cv' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không hợp lệ',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.digits_between' => 'Số điện thoại phải chứa từ 10-11 chữ số',
            'job_id.required' => 'Vui lòng chọn vị trí ứng tuyển',
            'cv.required' => 'CV ứng tuyển không được để trống'
        ];
    }
}
