@extends('company.layouts.app')

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-body p-5">
        <!-- Head -->
        <div class="flex justify-between items-center border-b mb-4 pb-4">
          <div class="flex items-center gap-2">
            <img src="/user.png" alt="user avatar" width="50px" class="">
            <div>
              <div class="font-bold">{{$application->candidate->name}}</div>
              <div>Ngày tạo hồ sơ: {{ date("d/m/Y", strtotime($application->created_at)) }}</div>
            </div>
          </div>
          <div class="flex gap-3">
            <a href="/company/applications/{{$application->id}}" class="border-2 rounded-lg py-2 px-4 hover:text-black hover:bg-green-50">
              <i class="bi bi-person-fill text-primary"></i>
              Hồ sơ ứng viên
            </a>
            <a href="#" class="border-2 rounded-lg py-2 px-4 bg-green-200 text-black hover:text-black cursor-default">
              <i class="bi bi-briefcase-fill text-danger"></i>
              Quy trình tuyển dụng
            </a>
          </div>
        </div>

        <!-- Body -->
        <div class="row">
          <div class="col-xl-3 col-md-4">
            <div class="w-full mb-2">
              <div
                @if($status==='Ứng tuyển' ) class="w-full rounded-lg py-2 px-4 border-2 border-green-200 bg-green-100 text-black"
                @else
                class="w-full rounded-lg py-2 px-4"
                @endif>
                <i class="fa-solid fa-file"></i>
                Ứng tuyển
              </div>
            </div>
            <div class="w-full mb-2">
              <div
                @if($status==='Phỏng vấn chuyên sâu' ) class="w-full rounded-lg py-2 px-4 border-2 border-green-200 bg-green-100 text-black"
                @else
                class="w-full rounded-lg py-2 px-4"
                @endif>
                <i class="fa-solid fa-file-lines"></i>
                Phỏng vấn chuyên sâu
              </div>
            </div>
            <div class="w-full mb-2">
              <div
                @if($status==='Phỏng vấn doanh nghiệp' ) class="w-full rounded-lg py-2 px-4 border-2 border-green-200 bg-green-100 text-black"
                @else
                class="w-full rounded-lg py-2 px-4"
                @endif>
                <i class="fa-solid fa-file-circle-check"></i>
                Phỏng vấn doanh nghiệp
              </div>
            </div>
            <div class="w-full">
              <div
                @if($status=='Trúng tuyển' || $status=='Không trúng tuyển' ) class="w-full rounded-lg py-2 px-4 border-2 border-green-200 bg-green-100 text-black"
                @else
                class="w-full rounded-lg py-2 px-4"
                @endif>
                <i class="fa-solid fa-cube"></i>
                Kết quả
              </div>
            </div>
          </div>
          <div class="col-xl-9 col-md-8 px-4 py-2 border-2 rounded-md">
            @switch($status)
            @case("Ứng tuyển")
            <form action="/company/applications/{{$application->id}}/recruitment-process/comment" method="POST">
              @csrf
              <div class="py-3">
                <label for="name" class="text-sm mr-3">CV ứng tuyển:</label>
                <button
                  type="button"
                  class="text-xs bg-green-500 text-white font-bold py-1.5 px-4 rounded-md hover:opacity-80"
                  data-bs-toggle="modal" data-bs-target="#cv-modal">
                  <i class=" bi bi-eye"></i> Xem CV
                </button>
                
              </div>
              @if (!empty($application->candidate->video_path))
              <div class="py-3">
                  <label for="name" class="text-sm mr-3">Video ứng tuyển:</label>
                  <button
                      type="button"
                      class="text-xs bg-blue-500 text-white font-bold py-1.5 px-4 rounded-md hover:opacity-80"
                      data-bs-toggle="modal" data-bs-target="#video-modal">
                      <i class="bi bi-play-circle"></i> Xem Video
                  </button>
              </div>
              @endif
              <div class="form-group">
                <label for="" class="text-sm">Ghi chú</label>
                <textarea name="comment" class="form-control" placeholder="Ghi chú" rows="5">{{$comment}}</textarea>
              </div>
              <div>
                <button type="submit" class="btn btn-info">Cập nhật</button>
                <a
                  href="/company/applications/{{$application->id}}/recruitment-process/update-status"
                  class="btn btn-primary">Chuyển sang phỏng vấn chuyên sâu</a>
              </div>
            </form>
            @break
            @case("Phỏng vấn chuyên sâu")
            <form action="/company/applications/{{$application->id}}/recruitment-process/comment" method="POST">
              @csrf
              <div class="row my-2 items-center">
                <div class="text-sm text-black font-bold col-xl-3">Lịch phỏng vấn:</div>
                <div class="col-xl-9">
                  @if ($interview)
                  <div class="flex gap-3">
                    <div class="col-md-auto d-flex align-items-center gap-3">
                      <label for="start_time" class="mb-0">Từ</label>
                      <div class="relative">
                        <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
                          </svg>
                        </div>
                        <input type="time" readonly value="{{$interview->start_time}}" class="form-control p-2">
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
                        <input type="time" readonly value="{{$interview->end_time}}" class="form-control p-2">
                      </div>
                    </div>
                    <div class="flex items-center gap-1">
                      <label for="date" class="mb-0">Ngày</label>
                      <div class="relative ms-1">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                          <i class="bi bi-calendar-event-fill"></i>
                        </div>
                        <input datepicker-format="dd/mm/yyyy" value="{{$interview->date}}" type="text" readonly class="form-control p-2 ps-5">
                      </div>
                    </div>
                  </div>
                  @else
                  <div class="font-semibold text-sm">Chưa có lịch phỏng vấn cho ứng viên này.
                    <a href="/company/interviews/create" class="text-primary underline underline-offset-2 font-bold">Tạo ngay</a>
                  </div>
                  @endif
                </div>
              </div>
              @if ($interview)
              <div class="row mt-4">
                <div class="text-sm text-black  font-bold col-xl-3">Người phỏng vấn:</div>
                <div class="table-responsive rounded-lg border w-full col-xl-9 max-lg:mx-2">
                  <table class="table align-items-center mb-0 rounded">
                    <thead>
                      <tr>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-0">
                          STT
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                          Họ tên
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                          Email
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($interviewers as $index => $interviewer)
                      <tr>
                        <td class="text-center text-xs font-weight-bold">
                          {{$index + 1}}
                        </td>
                        <td class="">
                          <p class="text-xs font-weight-bold mb-0">{{$interviewer['name']}}</p>
                        </td>
                        <td class="">
                          <p class="text-xs font-weight-bold mb-0">{{$interviewer['email']}}</p>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @if(count($interviewers) === 0)
                  <div class="text-center py-5">
                    Không có ứng viên phù hợp cho vòng phỏng vấn này. Vui lòng chọn vòng phỏng vấn khác hoặc cập nhật trạng thái ứng viên.
                  </div>
                  @endif
                </div>
              </div>
              @endif
              <div class="form-group">
                <label for="" class="text-sm mx-0 text-black">Ghi chú</label>
                <textarea name="comment" class="form-control" placeholder="Ghi chú" rows="5">{{$comment}}</textarea>
              </div>
              <div>
                <button type="submit" class="btn btn-info">Cập nhật</button>
                <!-- <a
                  href="/company/applications/{{$application->id}}/recruitment-process/update-status"
                  class="btn btn-primary">Chuyển sang phỏng vấn doanh nghiệp</a> -->
              </div>
            </form>
            @break
            @case("Phỏng vấn doanh nghiệp")
            <form action="/company/applications/{{$application->id}}/recruitment-process/comment" method="POST">
              @csrf
              <div class="row my-2 items-center">
                <div class="text-sm text-black font-bold col-xl-3">Lịch phỏng vấn:</div>
                <div class="col-xl-9">
                  @if ($interview)
                  <div class="flex gap-3">
                    <div class="col-md-auto d-flex align-items-center gap-3">
                      <label for="start_time" class="mb-0">Từ</label>
                      <div class="relative">
                        <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd" />
                          </svg>
                        </div>
                        <input type="time" readonly value="{{$interview->start_time}}" class="form-control p-2">
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
                        <input type="time" readonly value="{{$interview->end_time}}" class="form-control p-2">
                      </div>
                    </div>
                    <div class="flex items-center gap-1">
                      <label for="date" class="mb-0">Ngày</label>
                      <div class="relative ms-1">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                          <i class="bi bi-calendar-event-fill"></i>
                        </div>
                        <input datepicker-format="dd/mm/yyyy" value="{{$interview->date}}" type="text" readonly class="form-control p-2 ps-5">
                      </div>
                    </div>
                  </div>
                  @else
                  <div class="font-semibold text-sm">Chưa có lịch phỏng vấn cho ứng viên này.
                    <a href="/company/interviews/create" class="text-primary underline underline-offset-2 font-bold">Tạo ngay</a>
                  </div>
                  @endif
                </div>
              </div>
              @if ($interview)
              <div class="row mt-4">
                <div class="text-sm text-black font-bold col-xl-3">Người phỏng vấn:</div>
                <div class="table-responsive rounded-lg border w-full col-xl-9 max-lg:mx-2">
                  <table class="table align-items-center mb-0 rounded">
                    <thead>
                      <tr>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-0">
                          STT
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                          Họ tên
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                          Email
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($interviewers as $index => $interviewer)
                      <tr>
                        <td class="text-center text-xs font-weight-bold">
                          {{$index + 1}}
                        </td>
                        <td class="">
                          <p class="text-xs font-weight-bold mb-0">{{$interviewer['name']}}</p>
                        </td>
                        <td class="">
                          <p class="text-xs font-weight-bold mb-0">{{$interviewer['email']}}</p>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @if(count($interviewers) === 0)
                  <div class="text-center py-5">
                    Không có ứng viên phù hợp cho vòng phỏng vấn này. Vui lòng chọn vòng phỏng vấn khác hoặc cập nhật trạng thái ứng viên.
                  </div>
                  @endif
                </div>
              </div>
              @endif
              <div class="form-group">
                <label for="" class="text-sm mx-0 text-black">Ghi chú</label>
                <textarea name="comment" class="form-control" placeholder="Ghi chú" rows="5">{{$comment}}</textarea>
              </div>
              <div>
                <button type="submit" class="btn btn-info">Cập nhật</button>
                <!-- <a
                  href="/company/applications/{{$application->id}}/recruitment-process/update-status"
                  class="btn btn-primary">Xác nhận trúng tuyển</a> -->
              </div>
            </form>
            @break
            @case("Trúng tuyển")
            <div class="h-full flex gap-1 justify-center items-center text-lg font-bold">
              <i class="bi bi-check-circle-fill text-primary"></i>Ứng viên đã trúng tuyển.
            </div>
            @break
            @case("Không trúng tuyển")
            <div class="h-full flex gap-1 justify-center items-center text-lg font-bold">
              <i class="bi bi-x-circle-fill text-danger"></i>Ứng viên không trúng tuyển
            </div>
            @break
            @endswitch
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="video-modal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Video ứng tuyển</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <video width="100%" controls>
                    <source src="{{$application->candidate->video_path}}" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ video.
                </video>
            </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="cv-modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="cv-modal-label">CV ứng tuyển</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body flex justify-center">
        <object
          data="{{$application->candidate->cv_path}}"
          width="800"
          height="800">
        </object>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

@endsection