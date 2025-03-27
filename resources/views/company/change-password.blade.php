@extends('company.layouts.app')

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card mb-4 mx-4">
      <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
          <div>
            <h5 class="mb-0">Đổi mật khẩu</h5>
          </div>
        </div>
      </div>
      <div class="card-body pt-4">
        <form action="" method="POST" role="form text-left">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="password">Mật khẩu cũ <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Mật khẩu cũ" name="password" id="password" required>
                @error('error')
                <p class="text-danger text-xs mt-2">{{$message}}</p>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="new_password">Mật khẩu mới <span class="text-danger">*</span></label>
                <input type="password" class="form-control" placeholder="Mật khẩu mới" name="new_password" id="new_password" required>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn bg-primary text-white btn-md mt-4 mb-4">Lưu</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

@endsection