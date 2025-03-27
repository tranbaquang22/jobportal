@extends('company.layouts.app')

@section('content')

<div>
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 mx-4 p-4 pb-0 pt-2">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <div>
              <h4 class="mb-0 text-primary font-bold">Thông tin chiến dịch</h4>
            </div>
          </div>
        </div>
        <div class="card-body pt-4">
          <form action="/company/campaigns/{{$campaign->id}}/update" method="POST" role="form text-left">
            @csrf
            <div class="row">
              <div class="col-md-6 pe-md-5">
                <div class="form-group">
                  <label for="name" class="text-sm">Tên chiến dịch <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" placeholder="Tên chiến dịch" name="name" id="name" value="{{ $campaign->name }}">
                  @error('name')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="user_in_charge_id" class="text-sm">Người phụ trách <span class="text-danger">*</span></label>
                  <select class="form-select" name="user_in_charge_id" id="user_in_charge_id">
                    <option value="" disabled selected>Chọn người phụ trách</option>
                    @foreach ($managers as $manager)
                    <option value="{{$manager->id}}" @if ($manager->id === $campaign->user_in_charge_id) selected @endif>{{$manager->name}}</option>
                    @endforeach
                  </select>
                  @error('user_in_charge_id')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              <div class="col-md-6 ps-md-5">
                <div class="form-group">
                  <div class="flex align-items-center">
                    <label for="" class="text-sm">Thời gian dự kiến <span class="text-danger">*</span></label>
                  </div>
                  <div class="flex items-center gap-3 ms-md-3 mb-2">
                    <label for="campaign_start_time" class="mb-0">Ngày bắt đầu</label>
                    <div class="relative ms-1">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="bi bi-calendar-event-fill"></i>
                      </div>
                      <input id="datepicker-range-start" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="form-control p-2 ps-5" placeholder="dd/mm/yyyy" name="start_time" id="campaign_start_time" value="{{ $campaign->start_time }}">
                    </div>
                  </div>
                  @error('start_time')
                  <p class="text-danger text-xs mt-2 ps-8">{{ $message }}</p>
                  @enderror
                  <div class="flex items-center gap-3 ms-md-3">
                    <label for="campaign_end_time" class="mb-0">Ngày kết thúc</label>
                    <div class="relative">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="bi bi-calendar-event-fill"></i>
                      </div>
                      <input id="datepicker-range-end" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" class="form-control p-2 ps-5" placeholder="dd/mm/yyyy" name="end_time" id="campaign_end_time" value="{{ $campaign->end_time }}">
                    </div>
                  </div>
                  @error('end_time')
                  <p class="text-danger text-xs mt-2 ps-8">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pe-md-5">
                <div class="form-group">
                  <label for="description" class="text-sm">Mô tả <span class="text-danger">*</span></label>
                  <textarea name="description" id="description" class="form-control" placeholder="Mô tả" rows="5">{{$campaign->description}}</textarea>
                  @error('description')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              <div class="col-md-6 ps-md-5">
                <div class="form-group">
                  <label for="requirement" class="text-sm">Yêu cầu tuyển dụng <span class="text-danger">*</span></label>
                  <textarea name="requirement" id="requirement" class="form-control" placeholder="Yêu cầu tuyển dụng" rows="5">{{$campaign->requirement}}</textarea>
                  @error('requirement')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <a href="/company/recruitment-news?campaign-id={{$campaign->id}}" class="w-fit bg-blue-500 text-white font-bold btn-sm mb-3 d-flex align-items-center gap-2 px-3 py-2 hover:opacity-90">
              <i class="bi bi-pencil-square"></i>
              Quản lý vị trí tuyển dụng
            </a>
            <div class="row">

              <div class="flex items-center flex-wrap gap-3" id="jobList">
                @foreach($jobs as $job)
                <div class="text-xs flex items-center gap-2 bg-yellow-200 text-black font-bold p-2 rounded-full">
                  <span class=" max-w-60 whitespace-nowrap overflow-hidden text-ellipsis">{{$job->name}}</span>
                  <!-- <button type="button" id="delete_job_1"><i class="bi bi-x-lg hover:text-gray-600"></i></button> -->
                </div>
                @endforeach
              </div>
            </div>
            <div class="d-flex justify-content-end gap-4">
              <button type="button" class="btn btn-danger btn-md my-4" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$campaign->id}}">
                Xóa
              </button>
              <button type="submit" class="btn bg-info text-white btn-md my-4">Cập nhật</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmModal-{{$campaign->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="confirmModalLabel-{{$campaign->id}}">Xác nhận xóa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-black">Xóa chiến dịch sẽ đồng thời xóa tất cả tin tuyển dụng thuộc chiến dịch này.</p>
        <h6 class="mb-0 text-danger">Bạn có chắc chắc muốn xóa chiến dịch này?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <a href="/company/campaigns/{{$campaign->id}}/delete" type="button" class="btn btn-danger">Xóa</a>
      </div>
    </div>
  </div>
</div>

@endsection