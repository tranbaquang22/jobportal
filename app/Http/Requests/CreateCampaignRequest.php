<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCampaignRequest extends FormRequest
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
            'description' => 'required',
            'user_in_charge_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'requirement' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên chiến dịch không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'user_in_charge_id.required' => 'Vui lòng chọn người phụ trách',
            'start_time.required' => 'Vui lòng chọn ngày bắt đầu',
            'end_time.required' => 'Vui lòng chọn ngày kết thúc',
            'requirement.required' => 'Yêu cầu tuyển dụng không được để trống',
        ];
    }
}
