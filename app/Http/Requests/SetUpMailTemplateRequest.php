<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetUpMailTemplateRequest extends FormRequest
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
            'subject' => 'required',
            'content' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'Tiêu đề mail không được để trống',
            'content.required' => 'Nội dung mail không được để trống'
        ];
    }
}
