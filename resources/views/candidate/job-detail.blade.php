@extends('candidate.layouts.default')

@section('content')

<!-- Header End -->
<div class="container-xxl py-5 bg-dark page-header">
  <div class="container my-5 pt-5 pb-4">
    <h1 class="display-3 text-white mb-3 animated slideInDown">Chi tiết công việc</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb text-uppercase" id="job-detail">
        <li class="breadcrumb-item">
          <a href="/" class="text-white">Trang chủ</a>
        </li>
        <li class="breadcrumb-item">
          <a href="/jobs" class="text-light">Danh sách việc làm</a>
        </li>
        <li class="breadcrumb-item active text-light fw-bold" aria-current="page">Chi tiết</li>
      </ol>
    </nav>
  </div>
</div>
<!-- Header End -->

<!-- Job Detail Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
    <div class="row gy-5 gx-4">
      <div class="col-lg-8">
        <div class="d-flex align-items-center mb-5">
          <!-- <img class="flex-shrink-0 img-fluid border rounded" src="img/com-logo-2.jpg" alt="" style="width: 80px; height: 80px;"> -->
          <div class="text-start">
            <h3 class="mb-3">{{$job->name}}</h3>
            <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{$job->location}}</span>
            <span class="text-truncate me-3"><i class="fa fa-clock text-primary me-2"></i>{{$job->employment_type}}</span>
            <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>{{$job->salary}}</span>
          </div>
        </div>

        <div class="mb-5">
          <h4 class="mb-3">Mô tả công việc</h4>
          {{sanitize_html($job->description)}}
          <h4 class="mb-3">Yêu cầu ứng viên</h4>
          {{sanitize_html($job->requirement)}}

          <h4 class="mb-3">Quyền lợi</h4>
          {{sanitize_html($job->benefit)}}

          <h4 class="mb-3">Địa điểm làm việc</h4>
          <ul>
            <li>{{sanitize_html($job->location)}}: {{sanitize_html($job->workplace)}}</li>
          </ul>

          <h4 class="mb-3" id="working_time">Thời gian làm việc</h4>
          <ul>
            <li>Thời gian làm việc: {{sanitize_html($job->working_time)}}</li>
          </ul>

        </div>

        <div id="apply-form">
          <h4 class="mb-4">Ứng tuyển</h4>
          <form action="/jobs/{{$job->id}}#working_time" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-12 col-sm-6">
                <label for="candidate_name" class="fw-bold">Họ tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Họ và tên" id="candidate_name" name="candidate_name" value="{{ old('candidate_name') }}">
                @error('candidate_name')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="col-12 col-sm-6">
                <label for="candidate_email" class="fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" placeholder="Email" id="candidate_email" name="candidate_email" value="{{ old('candidate_email') }}">
                @error('candidate_email')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="col-12 col-sm-6">
                <label for="candidate_phone" class="fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Số điện thoại" id="candidate_phone" name="candidate_phone" value="{{ old('candidate_phone') }}">
                @error('candidate_phone')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="col-12 col-sm-6">
                <label for="cv" class="fw-bold">CV ứng tuyển <span class="text-danger">*</span></label>
                <input type="file" accept=".pdf" class="form-control bg-white" id="cv" name="cv">
                @error('cv')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="col-12 col-sm-6">
                  <label for="video" class="fw-bold">Video ứng tuyển </label>
                  <input type="file" accept="video/*" class="form-control bg-white" id="video" name="video">
                  @error('video')
                  <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                  @enderror
              </div>

              <div class="col-12">
                <label for="cover_letter" class="fw-bold">Thư giới thiệu</label>
                <textarea class="form-control" rows="5" placeholder="Thư giới thiệu" id="cover_letter" name="cover_letter"></textarea>
              </div>
              <div class="col-12">
                <input class="btn btn-primary w-100" type="submit" value="Ứng tuyển ngay" />
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
          <h4 class="mb-4">Thông tin chung</h4>
          <p><i class="fa fa-angle-right text-primary me-2"></i>Ngày đăng: {{$job->created_at}}</p>
          <p><i class="fa fa-angle-right text-primary me-2"></i>Hình thức: {{$job->employment_type}}</p>
          <p><i class="fa fa-angle-right text-primary me-2"></i>Mức lương: {{$job->salary}}</p>
          <p><i class="fa fa-angle-right text-primary me-2"></i>Địa điểm: {{$job->location}}</p>
          <p class="m-0"><i class="fa fa-angle-right text-primary me-2"></i>Hạn ứng tuyển: {{$job->deadline}}</p>
        </div>
        <!-- <div class="bg-light rounded p-5 wow slideInUp" data-wow-delay="0.1s">
          <h4 class="mb-4">Về công ty</h4>
          <p class="m-0">Ipsum dolor ipsum accusam stet et et diam dolores, sed rebum sadipscing elitr vero dolores. Lorem dolore elitr justo et no gubergren sadipscing, ipsum et takimata aliquyam et rebum est ipsum lorem diam. Et lorem magna eirmod est et et sanctus et, kasd clita labore.</p>
        </div> -->
      </div>
    </div>
  </div>
</div>
<!-- Job Detail End -->

@endsection