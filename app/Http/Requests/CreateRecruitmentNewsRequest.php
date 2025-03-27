<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRecruitmentNewsRequest extends FormRequest
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
            'campaign_id' => 'required',
            'name' => 'required',
            'employment_type' => 'required',
            'position' => 'required',
            'deadline' => 'required',
            'description' => 'required',
            'requirement' => 'required',
            'benefit' => 'required',
            'location' => 'required',
            'workplace' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'campaign_id.required' => "Vui lòng chọn chiến dịch tuyển dụng",
            'name.required' => 'Tiêu đề không được để trống',
            'employment_type.required' => 'Vui lòng chọn hình thức',
            'position.required' => 'Vui lòng chọn cấp bậc',
            'deadline.required' => 'Vui lòng chọn hạn ứng tuyển',
            'description.required' => 'Mô tả công việc không được để trống',
            'requirement.required' => 'Yêu cầu ứng viên không được để trống',
            'benefit.required' => 'Quyền lợi không được để trống',
            'location.required' => 'Vui lòng chọn tỉnh/thành phố',
            'workplace.required' => 'Địa chỉ không được để trống',
            'start_date.required' => 'Vui lòng chọn ngày làm việc',
            'end_date.required' => 'Vui lòng chọn ngày làm việc',
            'start_time.required' => 'Vui lòng chọn giờ làm việc',
            'end_time.required' => 'Vui lòng chọn giờ làm việc',
        ];
    }
}
