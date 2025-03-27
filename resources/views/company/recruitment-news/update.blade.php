@extends('company.layouts.app')

@section('content')

<div class="mx-4">
  <div class="card">
    <div class="card-header pb-0 px-4">
      <div class="d-flex flex-row justify-content-between">
        <div>
          <h5 class="mb-0">Cập nhật tin tuyển dụng</h5>
        </div>
      </div>
    </div>
    <div class="card-body p-4">
      <form action="/company/recruitment-news/update/{{$job->id}}" method="POST" role="form text-left">
        @csrf
        <input type="hidden" name="query" value="{{$query}}">
        <div class="form-group">
          <label for="campaign_id" class="text-sm">Chiến dịch tuyển dụng <span class="text-danger">*</span></label>
          <select class="form-select" name="campaign_id" id="campaign_id" aria-disabled="true">
            <option value="{{$job->campaign->id}}" selected>{{$job->campaign->name}}</option>
          </select>
          @error('campaign_id')
          <p class="text-danger text-xs mt-2">{{ $message }}</p>
          @enderror
        </div>
        <div class="row">
          <div class="form-group">
            <label for="name" class="text-sm">Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Tiêu đề công việc" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ $job->name }}">
            @error('name')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="employment_type" class="text-sm">Hình thức <span class="text-danger">*</span></label>
              <select class="form-select" name="employment_type" id="employment_type">
                <option value="">Chọn hình thức</option>
                <option value="Toàn thời gian" @if($job->employment_type=="Toàn thời gian" ) selected @endif>Toàn thời gian</option>
                <option value="Bán thời gian" @if($job->employment_type=="Bán thời gian" ) selected @endif>Bán thời gian</option>
                <option value="Thực tập" @if($job->employment_type=="Thực tập" ) selected @endif>Thực tập</option>
              </select>
              @error('employment_type')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
          @php
          $levels = ["Nhân viên","Trưởng nhóm","Trưởng/Phó phòng","Quản lý/Giám sát", "Trưởng chi nhánh", "Phó giám đốc", "Giám đốc", "Thực tập sinh"];
          @endphp
          <div class="col-md-6">
            <div class="form-group">
              <label for="position" class="text-sm">Cấp bậc <span class="text-danger">*</span></label>
              <select class="form-select" name="position" id="position">
                <option value="">Chọn cấp bậc</option>
                @foreach($levels as $level)
                <option value="{{$level}}" @if($job->position==$level) selected @endif>{{$level}}</option>
                @endforeach
              </select>
              @error('position')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <div class="flex align-items-center">
                <label for="" class="text-sm">Mức lương (triệu đồng) <span class="text-danger">*</span></label>
                <div class="mb-0 ps-0 d-flex align-items-center ms-auto">
                  <input class="m-0 rounded-sm focus:ring-0 focus:outline-white text-[#3db87a] cursor-pointer" type="checkbox" id="negotiable" name="negotiable" value="0" @if($job->salary=="Thỏa thuận") checked @endif>
                  <label class="text-xs font-bold ms-1 text-truncate w-80 mb-0 cursor-pointer" for="negotiable">Thỏa thuận</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center gap-3">
                    <label for="min_salary" class="mb-0">Từ</label>
                    <input type="number" class="form-control p-2" placeholder="0" name="min_salary" id="min_salary" value="{{ isset($job->min_salary) ? $job->min_salary : old('min_salary') }}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center gap-3">
                    <label for="max_salary" class="mb-0">Đến</label>
                    <input type="number" class="form-control p-2" placeholder="0" name="max_salary" id="max_salary" value="{{ isset($job->max_salary) ? $job->max_salary : old('max_salary') }}" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="flex align-items-center">
                <label for="deadline" class="text-sm">Hạn ứng tuyển <span class="text-danger">*</span></label>
              </div>
              <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                  <i class="bi bi-calendar-event-fill"></i>
                </div>
                <input id="datepicker-format" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="form-control p-2 ps-5" placeholder="dd/mm/yyyy" name="deadline" id="deadline" value="{{ $job->deadline }}">
              </div>
              @error('deadline')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <label for="description" class="text-sm">Mô tả công việc <span class="text-danger">*</span></label>
            <div class="">
              <x-trix-input id="description" placeholder="Mô tả công việc" name="description" value="{{ sanitize_html($job->description) }}" />
            </div>
            @error('description')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <label for="requirement" class="text-sm">Yêu cầu ứng viên <span class="text-danger">*</span></label>
            <div class="">
              <x-trix-input id="requirement" placeholder="Yêu cầu ứng viên" name="requirement" value="{{ sanitize_html($job->requirement) }}" />
            </div>
            @error('requirement')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <label for="benefit" class="text-sm">Quyền lợi <span class="text-danger">*</span></label>
            <div class="">
              <x-trix-input id="benefit" placeholder="Quyền lợi" name="benefit" value="{{ sanitize_html($job->benefit) }}" />
            </div>
            @error('benefit')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
          </div>
        </div>

        @php
        $provinces = [
        "Hà Nội", "Hồ Chí Minh", "Bình Dương", "Bắc Ninh", "Đồng Nai", "Hưng Yên", "Hải Dương", "Đà Nẵng",
        "Hải Phòng", "An Giang", "Bà Rịa-Vũng Tàu", "Bắc Giang", "Bắc Kạn", "Bạc Liêu", "Bến Tre",
        "Bình Định", "Bình Phước", "Bình Thuận", "Cà Mau", "Cần Thơ", "Cao Bằng", "Đắk Lắk",
        "Đắk Nông", "Điện Biên", "Đồng Tháp", "Gia Lai", "Hà Giang", "Hà Nam", "Hà Tĩnh",
        "Hậu Giang", "Hoà Bình", "Khánh Hoà", "Kiên Giang", "Kon Tum", "Lai Châu", "Lâm Đồng",
        "Lạng Sơn", "Lào Cai", "Long An", "Nam Định", "Nghệ An", "Ninh Bình", "Ninh Thuận",
        "Phú Thọ", "Phú Yên", "Quảng Bình", "Quảng Nam", "Quảng Ngãi", "Quảng Ninh", "Quảng Trị",
        "Sóc Trăng", "Sơn La", "Tây Ninh", "Thái Bình", "Thái Nguyên", "Thanh Hoá", "Thừa Thiên Huế",
        "Tiền Giang", "Trà Vinh", "Tuyên Quang", "Vĩnh Long", "Vĩnh Phúc", "Yên Bái"
        ];
        @endphp
        <div class="row mt-3">
          <label for="workplace" class="text-sm">Địa điểm làm việc <span class="text-danger">*</span></label>
          <div class="col-md-4">
            <div class="form-group">
              <label for="location">Tỉnh/Thành phố <span class="text-danger">*</span></label>
              <select class="form-select" name="location" id="location" aria-label="location" aria-describedby="location">
                <option value="">Chọn tỉnh/thành phố</option>
                @foreach($provinces as $province)
                <option value="{{$province}}" @if($job->location==$province ) selected @endif>{{$province}}</option>
                @endforeach
              </select>
              @error('location')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="workplace">Địa chỉ <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Địa chỉ" name="workplace" id="workplace" aria-label="workplace" aria-describedby="workplace" value="{{ $job->workplace }}">
              @error('workplace')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
        @php
        $days_in_week = ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"];
        @endphp
        <div class="row form-group mt-3">
          <label for="working_time" class="text-sm">Thời gian làm việc <span class="text-danger">*</span></label>
          <div class="col-md-6 row">
            <label for="start_date">Ngày làm việc <span class="text-danger">*</span></label>
            <div class="col-md-6">
              <div class="d-flex align-items-center gap-3">
                <label for="start_date" class="mb-0">Từ</label>
                <select class="form-select" name="start_date" id="start_date">
                  @foreach($days_in_week as $day)
                  <option value="{{$day}}" @if($job->start_date==$day) selected @endif>{{$day}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center gap-3">
                <label for="end_date" class="mb-0">Đến</label>
                <select class="form-select" name="end_date" id="end_date">
                  @foreach($days_in_week as $day)
                  <option value="{{$day}}" @if($job->end_date==$day) selected @endif>{{$day}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6 row">
            <label for="start_time">Giờ làm việc <span class="text-danger">*</span></label>
            <div class=" col-md-auto d-flex align-items-center gap-3">
              <label for="start_time" class="mb-0">Từ</label>
              <div class="relative">
                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input type="time" value="{{$job->start_time}}" class="form-control p-2" placeholder="0" name="start_time" id="start_time" value="{{ old('start_time') }}">
              </div>
            </div>
            <div class="col-md-auto d-flex align-items-center gap-3">
              <label for="end_time" class="mb-0">Đến</label>
              <div class="relative">
                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input type="time" value="{{$job->end_time}}" class="form-control p-2" placeholder="0" name="end_time" id="end_time" value="{{ old('end_time') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end mt-5">
          <button type="submit" class="btn bg-primary w-full text-white btn-md">Cập nhật</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  if (document.getElementById("negotiable").checked) {
    document.getElementById("min_salary").disabled = true
    document.getElementById("max_salary").disabled = true
  }

  document.getElementById("negotiable").addEventListener("change", function() {
    console.log(this.checked);
    document.getElementById("min_salary").disabled = this.checked
    document.getElementById("max_salary").disabled = this.checked
  })
</script>

@endsection