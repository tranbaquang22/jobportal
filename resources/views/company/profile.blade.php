@extends('company.layouts.app')

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card mb-4 mx-4">
      <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
          <div>
            <h5 class="mb-0">Cập nhật tài khoản</h5>
          </div>
        </div>
      </div>
      <div class="card-body pt-4">
        <form action="/company/profile" method="POST" role="form text-left">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email đăng nhập <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Email" name="email" id="email" aria-label="Email" aria-describedby="email-addon" value="{{ $current_user->email }}">
                @error('email')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="name">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="Họ và tên" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ $current_user->name }}">
                @error('name')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                <input type="tel" maxlength="10" class="form-control" placeholder="Số điện thoại" name="phone" id="phone" aria-label="Phone" aria-describedby="phone" value="{{ $current_user->phone }}">
                @error('phone')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <a href="/company/profile/change-password" type="button" class="btn bg-info text-white btn-md mt-4 mb-4">Đổi mật khẩu</a>
            <button type="submit" class="btn bg-primary text-white btn-md mt-4 mb-4">Lưu</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

@endsection