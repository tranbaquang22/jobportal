@extends('company.layouts.app')

@section('content')

<ul class="flex flex-wrap text-sm font-bold text-center text-gray-500">
  <li class="me-2">
    <a
      href="/company/interviews"
      @if($isToday)
      class="inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100"
      @else
      class="inline-block px-4 py-2 rounded-lg text-white bg-primary"
      @endif>
      Tất cả</a>
  </li>
  <li class="me-2">
    <a
      href="{{$todayUrl}}"
      @if($isToday)
      class="inline-block px-4 py-2 rounded-lg text-white bg-primary"
      @else
      class="inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100"
      @endif>
      Hôm nay
    </a>
  </li>
</ul>

<div class="row">
  <div class="col-12">
    <div class="card mb-4 mx-4">
      <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
          <h5 class="mb-0">Danh sách lịch phỏng vấn</h5>
          <div class="flex gap-3">
            <button
              type="button"
              class="bg-blue-500 text-white font-bold d-flex align-items-center gap-1 px-3 hover:opacity-90 rounded-lg text-sm"
              data-bs-toggle="modal" data-bs-target="#searchModal">
              <i class="bi bi-filter text-lg mt-1"></i>
              Lọc
            </button>
            <a href="/company/interviews/create" class="btn bg-gradient-primary btn-sm mb-0 d-flex align-items-center gap-2 px-4" type="button">
              <span class="text-md">+</span>
              Tạo mới
            </a>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pt-3 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr class="border-top border-light">
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                  Tên lịch phỏng vấn
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Thời gian
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Ngày phỏng vấn
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Vòng phỏng vấn
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Trạng thái
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Ngày tạo
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 invisible">
                  Action
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($interviews as $interview)
              <tr>
                <td class="ps-4">
                  <p class="text-xs font-weight-bold mb-0">{{ $interview->name }}</p>
                </td>
                <td class="text-center">
                  <p class="text-xs font-weight-bold mb-0">{{ $interview->start_time . " - " . $interview->end_time }}</p>
                </td>
                <td class="text-center">
                  <p class="text-xs font-weight-bold mb-0">{{ $interview->date }}</p>
                </td>
                <td class="text-center">
                  <p class="text-xs font-weight-bold mb-0">{{ $interview->type }}</p>
                </td>
                <td class="text-center">
                  <p class="text-xs font-weight-bold mb-0">
                    @if ($interview->status === "Đang hoạt động")
                    <span class="bg-green-400 text-white pb-0.5 px-2 rounded">Đang hoạt động</span>
                    @elseif ($interview->status === "Đã kết thúc")
                    <span class="bg-gray-400 text-white pb-0.5 px-2 rounded">Đã kết thúc</span>
                    @else
                    <span class="bg-yellow-200 text-gray-600 py-0.5 px-2 rounded">Chờ xác nhận</span>
                    @endif
                  </p>
                </td>
                <td class="text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ date("d/m/Y", strtotime($interview->created_at)) }}</span>
                </td>
                <td class="text-center">
                  <a href="/company/interviews/{{$interview->id}}" class="me-2">
                    <i class="fa-solid fa-up-right-from-square"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @if ($interviews_before_filtered->count() === 0)
        <div class="text-center py-5">
          Chưa có lịch phỏng vấn nào trên hệ thống
        </div>
        @elseif ($interviews->count() == 0)
        <div class="text-center py-5">
          Không tìm thấy lịch phỏng vấn phù hợp
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<form action="/company/interviews" method="POST">
  @csrf
  <div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="searchModalLabel">Tìm kiếm lịch phỏng vấn</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name" class="text-sm">Tên</label>
            <input type="search" class="form-control" placeholder="Tên lịch phỏng vấn" name="name" id="name" value="{{$query_name}}">
          </div>
          <div class="form-group">
            <label for="type" class="text-sm">Vòng phỏng vấn</label>
            <select class="form-select" name="type" id="type">
              <option value="">Tất cả</option>
              <option value="Phỏng vấn chuyên sâu" @if($query_type==="Phỏng vấn chuyên sâu" ) selected @endif>Phỏng vấn chuyên sâu</option>
              <option value="Phỏng vấn doanh nghiệp" @if($query_type==="Phỏng vấn doanh nghiệp" ) selected @endif>Phỏng vấn doanh nghiệp</option>
            </select>
          </div>
          <div class="form-group">
            <label for="status" class="text-sm">Trạng thái</label>
            <select class="form-select" name="status" id="status">
              <option value="">Tất cả</option>
              <option value="Chờ xác nhận" @if($query_status==="Chờ xác nhận" ) selected @endif>Chờ xác nhận</option>
              <option value="Đang hoạt động" @if($query_status==="Đang hoạt động" ) selected @endif>Đang hoạt động</option>
              <option value="Đã kết thúc" @if($query_status==="Đã kết thúc" ) selected @endif>Đã kết thúc</option>
            </select>
          </div>
          <div>
            <label for="" class="text-sm">Thời gian</label>
            <div class="flex items-center gap-2 mb-2">
              <label for="start_date" class="mb-0 w-16">Từ ngày</label>
              <div class="relative flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                  <i class="bi bi-calendar-event-fill"></i>
                </div>
                <input id="datepicker-start" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" autocomplete="off" class="form-control p-2 ps-5" placeholder="dd/mm/yyyy" name="start_date" value="{{$query_start_time}}">
              </div>
            </div>
            <div class="flex items-center gap-2">
              <label for="start_date" class="mb-0 w-16">Đến ngày</label>
              <div class="relative flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                  <i class="bi bi-calendar-event-fill"></i>
                </div>
                <input id="datepicker-end" datepicker datepicker-autohide datepicker-format="dd/mm/yyyy" type="text" autocomplete="off" class="form-control p-2 ps-5" placeholder="dd/mm/yyyy" name="end_date" value="{{$query_end_time}}">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-info" data-bs-dismiss="modal">
            Tìm kiếm
          </button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  setTimeout(() => {
    const datepickerEls = document.querySelectorAll('.datepicker');
    datepickerEls.forEach(datepickerEl => {
      datepickerEl.classList.add("z-[9999]");
    })
  }, 1000);
</script>

@endsection