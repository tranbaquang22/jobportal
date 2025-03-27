@extends('company.layouts.app')

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-4">
        <div class="d-flex flex-row justify-content-between">
          <h5 class="mb-0">Danh sách ứng viên</h5>
          <div class="flex gap-3">
            <button
              type="button"
              class="bg-blue-500 text-white font-bold d-flex align-items-center gap-1 px-3 hover:opacity-90 rounded-lg text-sm"
              data-bs-toggle="modal" data-bs-target="#searchModal">
              <i class="bi bi-filter text-lg mt-1"></i>
              Lọc
            </button>
            <a href="/company/applications/create" class="btn bg-gradient-primary btn-sm mb-0 d-flex align-items-center gap-2 px-4" type="button">
              <span class="text-md">+</span>
              Thêm ứng viên
            </a>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr class="border-top border-light">
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                  Ứng viên
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                  Tin tuyển dụng
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                  Thông tin liên lạc
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Trạng thái
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                  Thời gian ứng tuyển
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 invisible">
                  Action
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($candidates as $candidate)
              <tr>
                <td class="ps-4">
                  <p class="text-xs font-weight-bold mb-2">{{$candidate->name}}</p>
                  <button
                    class="text-xs bg-green-400 text-white py-1 px-2 rounded-sm"
                    data-bs-toggle="modal" data-bs-target="#cvModal-{{$candidate->application->id}}">
                    <i class="bi bi-eye"></i> Xem CV
                  </button>
                  @if (!empty($candidate->video_path))
                  <button
                    class="text-xs bg-purple-400 text-white py-1 px-2 rounded-sm"
                    data-bs-toggle="modal" data-bs-target="#videoModal-{{$candidate->application->id}}">
                    <i class="bi bi-play-circle"></i> Xem Video
                  </button>
                  @endif
                </td>
                <td class="">
                  <div class="text-xs font-weight-bold mb-0">{{$candidate->job_title}}</div>
                </td>
                <td class="">
                  <p class="text-xs mb-2"><i class="bi bi-envelope-at-fill"></i> {{$candidate->email}}</p>
                  <p class="text-xs mb-0"><i class="bi bi-telephone-fill"></i> {{$candidate->phone}}</p>
                </td>
                <td class="text-center">
                  <p class="text-xs font-weight-bold mb-0">
                    @if ($candidate->status === "Trúng tuyển")
                    <span class="bg-green-400 text-white py-0.5 px-2 rounded">{{$candidate->status}}</span>
                    @elseif ($candidate->status === "Không trúng tuyển")
                    <span class="bg-gray-400 text-white py-0.5 px-2 rounded">{{$candidate->status}}</span>
                    @elseif ($candidate->status === "Ứng tuyển")
                    <span class="bg-blue-500 text-white py-0.5 px-2 rounded">{{$candidate->status}}</span>
                    @else
                    <span class="bg-yellow-200 text-gray-600 py-0.5 px-2 rounded">{{$candidate->status}}</span>
                    @endif
                  </p>
                </td>
                <td class="text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ date("d/m/Y  h:i", strtotime($candidate->application->created_at)) }}</span>
                </td>
                <td class="text-left text-xs">
                  <a href="/company/applications/{{$candidate->application->id}}" class="me-2 text-md">
                    <i class="fa-solid fa-up-right-from-square"></i>
                  </a>
                </td>
              </tr>

              <!-- Modal Video -->
              @if (!empty($candidate->video_path))
              <div class="modal fade" id="videoModal-{{$candidate->application->id}}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="videoModalLabel-{{$candidate->application->id}}">Video ứng tuyển</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex justify-center">
                      <video width="800" height="800" controls>
                        <source src="{{$candidate->video_path}}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ trình phát video.
                      </video>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                  </div>
                </div>
              </div>
              @endif

              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection