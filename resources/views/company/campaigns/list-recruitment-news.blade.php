@extends('company.layouts.app')

@section('content')

<div class="mx-4">
  <div class="card mb-4">
    <div class="card-header pb-0 px-4">
      <div class="d-flex flex-row justify-content-between">
        <div>
          <h5 class="mb-0">Danh sách vị trí tuyển dụng</h5>
        </div>
        <a href="/company/campaigns/{{$campaign->id}}/recruitment-news/create" class="btn bg-gradient-primary btn-sm mb-0 d-flex align-items-center gap-2 px-4" type="button">
          <span class="text-md">+</span>
          Thêm
        </a>
      </div>
    </div>
    <div class="card-body p-4">
      <ul class="list-group">
        @foreach($jobs as $job)
        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
          <div class="d-flex flex-column">
            <h6 class="mb-3">{{$job->name}}</h6>
            <div class="d-lg-flex gap-4 d-block mb-lg-2">
              <div class="mb-2 text-sm">
                <i class="bi bi-geo-alt-fill text-primary"></i>
                <span class="text-dark  ms-sm-1">{{$job->location}}</span>
              </div>
              <div class="mb-2 text-sm">
                <i class="bi bi-clock text-primary"></i>
                <span class="text-dark ms-sm-1 ">{{$job->employment_type}}</span>
              </div>
              <div class="mb-2 text-sm">
                <i class="bi bi-cash text-primary"></i>
                <span class="text-dark ms-sm-1 ">{{$job->salary}}</span>
              </div>
              <div class="mb-2 text-sm">
                <i class="bi bi-calendar-event-fill text-primary"></i>
                <span class="text-dark ms-sm-1 ">{{$job->deadline}}</span>
              </div>
            </div>
            <div class="d-lg-flex gap-4 d-block mb-lg-2">
              <div class="mb-2 text-sm">
                <i class="bi bi-people-fill text-primary"></i>
                <span class="text-dark  ms-sm-1">Lượt ứng tuyển: {{$job->application_count}}</span>
              </div>
            </div>
            <!-- <div class="d-lg-flex gap-4 d-block mb-2">
              <div class="mb-2 text-sm">
                <i class="bi bi-megaphone-fill text-primary"></i>
                <span class="text-dark  ms-sm-1">Chiến dịch tuyển dụng: {{$campaign->name}}</span>
              </div>
            </div> -->
            <div>
              <a href="#" class="bg-green-100 px-4 py-2 text-xs font-bold rounded-sm hover:text-green-700">
                Xem CV ứng tuyển
              </a>
            </div>
          </div>
          <div class="ms-auto text-end">
            <a class="btn btn-link text-dark px-3 mb-0 d-block d-lg-inline-block" href="/company/recruitment-news/update/{{$job->id}}">
              <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Chỉnh sửa
            </a>
            <button class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$job->id}}">
              <i class="far fa-trash-alt me-2"></i>Xóa
            </button>
          </div>
        </li>
        <!-- Modal -->
        <div class="modal fade" id="confirmModal-{{$job->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="confirmModalLabel-{{$job->id}}">Xác nhận xóa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h6 class="mb-0 text-danger">Bạn có chắc chắc muốn xóa tin tuyển dụng này?</h6>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="/company/recruitment-news/delete/{{$job->id}}" type="button" class="btn btn-danger">Xóa</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </ul>
      @if($jobs->count() == 0)
      <div class="text-center py-2">Không có tin tuyển dụng nào trên hệ thống</div>
      @endif
    </div>
  </div>
</div>

@endsection