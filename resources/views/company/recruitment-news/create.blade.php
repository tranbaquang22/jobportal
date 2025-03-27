@extends('company.layouts.app')

@section('content')

<div class="mx-4">
  <div class="card">
    <div class="card-header pb-0 px-4">
      <div class="d-flex flex-row justify-content-between">
        <div>
          <h5 class="mb-0">Đăng tin tuyển dụng</h5>
        </div>
      </div>
    </div>
    <div class="card-body p-4">
      <form action="/company/recruitment-news/create" method="POST" role="form text-left">
        @csrf
        <input type="hidden" name="query" value="{{$query}}">
        <div class="form-group">
          <label for="campaign_id" class="text-sm">Chiến dịch tuyển dụng <span class="text-danger">*</span></label>
          <select class="form-select" name="campaign_id" id="campaign_id">
            @if (isset($current_campaign))
            <option value="{{$current_campaign->id}}" selected>{{$current_campaign->name}}</option>
            @else
            <option value="" disabled selected>Chọn chiến dịch</option>
            @foreach ($campaigns as $campaign)
            <option value="{{$campaign->id}}">{{$campaign->name}}</option>
            @endforeach
            @endif
          </select>
          @error('campaign_id')
          <p class="text-danger text-xs mt-2">{{ $message }}</p>
          @enderror
        </div>
        <div class="row">
          <div class="form-group">
            <label for="name" class="text-sm">Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Tiêu đề công việc" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ old('name') }}">
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
                <option value="Toàn thời gian">Toàn thời gian</option>
                <option value="Bán thời gian">Bán thời gian</option>
                <option value="Thực tập">Thực tập</option>
              </select>
              @error('employment_type')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="position" class="text-sm">Cấp bậc <span class="text-danger">*</span></label>
              <select class="form-select" name="position" id="position">
                <option value="">Chọn cấp bậc</option>
                <option value="Nhân viên">Nhân viên</option>
                <option value="Trưởng nhóm">Trưởng nhóm</option>
                <option value="Trưởng/Phó phòng">Trưởng/Phó phòng</option>
                <option value="Quản lý/Giám sát">Quản lý/Giám sát</option>
                <option value="Trưởng chi nhánh">Trưởng chi nhánh</option>
                <option value="Phó giám đốc">Phó giám đốc</option>
                <option value="Giám đốc">Giám đốc</option>
                <option value="Thực tập sinh">Thực tập sinh</option>
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
                  <input class="m-0 rounded-sm focus:ring-0 focus:outline-white text-[#3db87a] cursor-pointer" type="checkbox" id="negotiable" name="negotiable" value="0">
                  <label class="text-xs font-bold ms-1 text-truncate w-80 mb-0 cursor-pointer" for="negotiable">Thỏa thuận</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="d-flex align-items-center gap-3">
                    <label for="min_salary" class="mb-0">Từ</label>
                    <input type="number" class="form-control p-2" placeholder="0" name="min_salary" id="min_salary" value="{{ old('min_salary') }}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center gap-3">
                    <label for="max_salary" class="mb-0">Đến</label>
                    <input type="number" class="form-control p-2" placeholder="0" name="max_salary" id="max_salary" value="{{ old('max_salary') }}" required>
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
                <input datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" autocomplete="off" class="form-control p-2 ps-5" placeholder="dd/mm/yyyy" name="deadline" id="deadline" value="{{ old('deadline') }}">
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
              <x-trix-input id="description" placeholder="Mô tả công việc" name="description" value="{{ sanitize_html(old('description')) }}" />
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
              <x-trix-input id="requirement" placeholder="Yêu cầu ứng viên" name="requirement" value="{{ sanitize_html(old('requirement')) }}" />
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
              <x-trix-input id="benefit" placeholder="Quyền lợi" name="benefit" value="{{ sanitize_html(old('benefit')) }}" />
            </div>
            @error('benefit')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="row mt-3">
          <label for="workplace" class="text-sm">Địa điểm làm việc <span class="text-danger">*</span></label>
          <div class="col-md-4">
            <div class="form-group">
              <label for="location">Tỉnh/Thành phố <span class="text-danger">*</span></label>
              <select class="form-select" name="location" id="location" aria-label="location" aria-describedby="location">
                <option value="">Chọn tỉnh/thành phố</option>
                <option value="Hà Nội">Hà Nội</option>
                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                <option value="Bình Dương">Bình Dương</option>
                <option value="Bắc Ninh">Bắc Ninh</option>
                <option value="Đồng Nai">Đồng Nai</option>
                <option value="Hưng Yên">Hưng Yên</option>
                <option value="Hải Dương">Hải Dương</option>
                <option value="Đà Nẵng">Đà Nẵng</option>
                <option value="Hải Phòng">Hải Phòng</option>
                <option value="An Giang">An Giang</option>
                <option value="Bà Rịa-Vũng Tàu">Bà Rịa-Vũng Tàu</option>
                <option value="Bắc Giang">Bắc Giang</option>
                <option value="Bắc Kạn">Bắc Kạn</option>
                <option value="Bạc Liêu">Bạc Liêu</option>
                <option value="Bến Tre">Bến Tre</option>
                <option value="Bình Định">Bình Định</option>
                <option value="Bình Phước">Bình Phước</option>
                <option value="Bình Thuận">Bình Thuận</option>
                <option value="Cà Mau">Cà Mau</option>
                <option value="Cần Thơ">Cần Thơ</option>
                <option value="Cao Bằng">Cao Bằng</option>
                <option value="Cửu Long">Cửu Long</option>
                <option value="Đắk Lắk">Đắk Lắk</option>
                <option value="Đắc Nông">Đắc Nông</option>
                <option value="Điện Biên">Điện Biên</option>
                <option value="Đồng Tháp">Đồng Tháp</option>
                <option value="Gia Lai">Gia Lai</option>
                <option value="Hà Giang">Hà Giang</option>
                <option value="Hà Nam">Hà Nam</option>
                <option value="Hà Tĩnh">Hà Tĩnh</option>
                <option value="Hậu Giang">Hậu Giang</option>
                <option value="Hoà Bình">Hoà Bình</option>
                <option value="Khánh Hoà">Khánh Hoà</option>
                <option value="Kiên Giang">Kiên Giang</option>
                <option value="Kon Tum">Kon Tum</option>
                <option value="Lai Châu">Lai Châu</option>
                <option value="Lâm Đồng">Lâm Đồng</option>
                <option value="Lạng Sơn">Lạng Sơn</option>
                <option value="Lào Cai">Lào Cai</option>
                <option value="Long An">Long An</option>
                <option value="Miền Bắc">Miền Bắc</option>
                <option value="Miền Nam">Miền Nam</option>
                <option value="Miền Trung">Miền Trung</option>
                <option value="Nam Định">Nam Định</option>
                <option value="Nghệ An">Nghệ An</option>
                <option value="Ninh Bình">Ninh Bình</option>
                <option value="Ninh Thuận">Ninh Thuận</option>
                <option value="Phú Thọ">Phú Thọ</option>
                <option value="Phú Yên">Phú Yên</option>
                <option value="Quảng Bình">Quảng Bình</option>
                <option value="Quảng Nam">Quảng Nam</option>
                <option value="Quảng Ngãi">Quảng Ngãi</option>
                <option value="Quảng Ninh">Quảng Ninh</option>
                <option value="Quảng Trị">Quảng Trị</option>
                <option value="Sóc Trăng">Sóc Trăng</option>
                <option value="Sơn La">Sơn La</option>
                <option value="Tây Ninh">Tây Ninh</option>
                <option value="Thái Bình">Thái Bình</option>
                <option value="Thái Nguyên">Thái Nguyên</option>
                <option value="Thanh Hoá">Thanh Hoá</option>
                <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
                <option value="Tiền Giang">Tiền Giang</option>
                <option value="Toàn Quốc">Toàn Quốc</option>
                <option value="Trà Vinh">Trà Vinh</option>
                <option value="Tuyên Quang">Tuyên Quang</option>
                <option value="Vĩnh Long">Vĩnh Long</option>
                <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                <option value="Yên Bái">Yên Bái</option>
                <option value="Nước Ngoài">Nước Ngoài</option>
              </select>
              @error('location')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label for="workplace">Địa chỉ <span class="text-danger">*</span></label>
              <input type="text" class="form-control" placeholder="Địa chỉ" name="workplace" id="workplace" aria-label="workplace" aria-describedby="workplace" value="{{ old('workplace') }}">
              @error('workplace')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
        <div class="row form-group mt-3">
          <label for="working_time" class="text-sm">Thời gian làm việc <span class="text-danger">*</span></label>
          <div class="col-md-6 row">
            <label for="start_date">Ngày làm việc <span class="text-danger">*</span></label>
            <div class="col-md-6">
              <div class="d-flex align-items-center gap-3">
                <label for="start_date" class="mb-0">Từ</label>
                <select class="form-select" name="start_date" id="start_date">
                  <option value="Thứ 2">Thứ 2</option>
                  <option value="Thứ 3">Thứ 3</option>
                  <option value="Thứ 4">Thứ 4</option>
                  <option value="Thứ 5">Thứ 5</option>
                  <option value="Thứ 6">Thứ 6</option>
                  <option value="Thứ 7">Thứ 7</option>
                  <option value="Chủ nhật">Chủ nhật</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center gap-3">
                <label for="end_date" class="mb-0">Đến</label>
                <select class="form-select" name="end_date" id="end_date">
                  <option value="Thứ 2">Thứ 2</option>
                  <option value="Thứ 3">Thứ 3</option>
                  <option value="Thứ 4">Thứ 4</option>
                  <option value="Thứ 5">Thứ 5</option>
                  <option value="Thứ 6">Thứ 6</option>
                  <option value="Thứ 7">Thứ 7</option>
                  <option value="Chủ nhật" selected>Chủ nhật</option>
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
                <input type="time" value="08:00" class="form-control p-2" placeholder="0" name="start_time" id="start_time" value="{{ old('start_time') }}">
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
                <input type="time" value="17:00" class="form-control p-2" placeholder="0" name="end_time" id="end_time" value="{{ old('end_time') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-end mt-5">
          <button type="submit" class="btn bg-primary w-full text-white btn-md">Đăng tin</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById("negotiable").addEventListener("change", function() {
    console.log(this.checked);
    document.getElementById("min_salary").disabled = this.checked
    document.getElementById("max_salary").disabled = this.checked
  })
</script>

@endsection