@extends('company.layouts.app')

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card p-4">
      <div class="card-header pb-0">
        <h4 class="mb-4 text-primary font-bold">Cập nhật danh sách ứng viên</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive p-0 rounded-lg">
          <table class="table align-items-center mb-0 border rounded">
            <thead>
              <tr class="border-top border-light">
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 invisible px-0">
                  Checkbox
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
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
              </tr>
            </thead>
            <tbody>
              @foreach ($candidates_selected as $candidate)
              <tr>
                <td class="ps-4">
                  <input type="checkbox" checked value="{{$candidate->id}}" class="w-4 h-4 text-green-500 cursor-pointer rounded focus:ring-0">
                </td>
                <td class="">
                  <p class="text-xs font-weight-bold mb-0">{{$candidate->name}}</p>
                </td>
                <td class="">
                  <p class="text-xs font-weight-bold mb-0">{{$candidate->application->job->name}}</p>
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
                  <span class="text-secondary text-xs font-weight-bold">{{ date("d/m/Y  h:i", strtotime($candidate->created_at)) }}</span>
                </td>
              </tr>
              @endforeach
              @foreach ($candidates_not_selected as $candidate)
              <tr>
                <td class="ps-4">
                  <input type="checkbox" value="{{$candidate->id}}" class="w-4 h-4 text-green-500 cursor-pointer rounded focus:ring-0">
                </td>
                <td class="">
                  <p class="text-xs font-weight-bold mb-0">{{$candidate->name}}</p>
                </td>
                <td class="">
                  <p class="text-xs font-weight-bold mb-0">{{$candidate->application->job->name}}</p>
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
                  <span class="text-secondary text-xs font-weight-bold">{{ date("d/m/Y  h:i", strtotime($candidate->created_at)) }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <form method="POST" action="" role="form">
          @csrf
          <input type="hidden" name="candidates" id="candidates">
          <div class="d-flex justify-content-end gap-4 mt-4">
            <a href="/company/interviews/{{$interview_id}}" class="btn btn-secondary" type="button">Quay lại</a>
            <button type="submit" id="submit_btn" class="btn bg-primary text-white btn-md" disabled>Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const candidates = [];

  document.querySelectorAll("input[type='checkbox']").forEach((e) => {
    if (e.checked) {
      candidates.push(parseInt(e.value));
    }

    document.getElementById("candidates").value = candidates.toString();
    if (candidates.length !== 0) {
      document.getElementById("submit_btn").disabled = false;
    } else {
      document.getElementById("submit_btn").disabled = true;
    }
  })

  document.querySelectorAll("input[type='checkbox']").forEach((e) => {
    e.addEventListener("change", function() {
      const index = candidates.indexOf(parseInt(e.value));
      const value = parseInt(e.value);
      if (index === -1) {
        candidates.push(value);
      } else {
        candidates.splice(index, 1);
      }
      document.getElementById("candidates").value = candidates.toString();
      if (candidates.length !== 0) {
        document.getElementById("submit_btn").disabled = false;
      } else {
        document.getElementById("submit_btn").disabled = true;
      }
    });
  });
</script>

@endsection