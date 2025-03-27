@extends('company.layouts.app')

@section('content')

<div>
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 mx-4 p-4 pb-0 pt-2">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <div>
              <h4 class="mb-0 text-primary font-bold">Tạo lịch phỏng vấn mới</h4>
            </div>
          </div>
        </div>
        <div class="card-body pt-4">
          <form action="/company/interviews/pre-create" method="POST" role="form text-left">
            @csrf
            <div class="row">
              <div class="col-md-8 pe-md-5">
                <div class="form-group">
                  <label for="job_id" class="text-sm">Chọn vị trí tuyển dụng <span class="text-danger">*</span></label>
                  <select class="form-select" name="job_id" id="job_id" required>
                    <option value="" disabled selected>Chọn vị trí tuyển dụng</option>
                    @foreach($jobs as $job)
                    <option value="{{$job->id}}">{{$job->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-start gap-4 mt-2">
              <a href="/company/interviews" class="btn btn-secondary" type="button">Quay lại</a>
              <button type="submit" class="btn bg-primary text-white btn-md">Tiếp tục</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection