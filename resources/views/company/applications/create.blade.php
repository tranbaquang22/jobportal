@extends('company.layouts.app')

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card mb-4 p-4">
      <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
          <div>
            <h4 class="text-primary font-bold">Thêm ứng viên mới</h4>
          </div>
        </div>
      </div>
      <div class="card-body">
        <form action="" method="POST" role="form" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Họ và tên" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group">
                <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                <input type="tel" maxlength="11" class="form-control" placeholder="Số điện thoại" name="phone" id="phone" value="{{ old('phone') }}">
                @error('phone')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="job_id">Vị trí ứng tuyển <span class="text-danger">*</span></label>
                <select name="job_id" id="job_id" class="form-select">
                  <option value="" selected disabled>Chọn vị trí ứng tuyển</option>
                  @foreach($jobs as $job)
                  <option value="{{$job->id}}">{{$job->name}}</option>
                  @endforeach
                </select>
                @error('job_id')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group">
                <label for="cv">CV ứng tuyển <span class="text-danger">*</span></label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="cv"
                  name="cv" type="file" accept=".pdf">
                @error('cv')
                <p class="text-danger text-sm fw-bold mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>

          <div class="d-flex gap-2 justify-content-end">
            <button type="submit" class="btn bg-info text-white btn-md mt-4 mb-4">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection