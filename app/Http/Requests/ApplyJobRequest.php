<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
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
            'candidate_name' => ['required'],
            'candidate_email' => ['required', 'email', 'max:50'],
            'candidate_phone' => ['required', 'digits_between:10,11'],
            // 'cv' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'candidate_name.required' => 'Họ và tên không được để trống',
            'candidate_email.required' => 'Email không được để trống',
            'candidate_email.email' => 'Email không hợp lệ',
            'candidate_phone.required' => 'Số điện thoại không được để trống',
            'candidate_phone.digits_between' => 'Số điện thoại phải chứa từ 10-11 chữ số',
            // 'cv.required' => 'CV ứng tuyển không được để trống'
        ];
    }
}
