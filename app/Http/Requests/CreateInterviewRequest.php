<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInterviewRequest extends FormRequest
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
            'name' => 'required',
            'type' => 'required',
            'date' => 'required',
            'interviewer_name' => 'required',
            'interviewer_email' => 'required|email',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên lịch phỏng vấn không được để trống',
            'type.required' => 'Vui lòng chọn vòng phỏng vấn',
            'date.required' => 'Vui lòng chọn ngày phỏng vấn',
            'interviewer_name.required' => "Cần có ít nhất 1 người phỏng vấn: Vui lòng nhập họ tên",
            'interviewer_email.required' => "Cần có ít nhất 1 người phỏng vấn: Vui lòng nhập email",
            'interviewer_email.email' => "Email không hợp lệ"
        ];
    }
}
