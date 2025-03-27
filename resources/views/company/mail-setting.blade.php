@extends('company.layouts.app')

@section('content')

<div class="mx-4">
  <div class="card">
    <div class="card-header pb-0 px-4">
      <div class="d-flex flex-row justify-content-between">
        <div>
          <h5 class="mb-0">{{$title}}</h5>
        </div>
      </div>
    </div>
    <div class="card-body p-4">
      <form action="" method="POST" role="form">
        @csrf
        <div class="row">
          <div class="form-group">
            <label for="subject" class="text-sm">Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" class="form-control" placeholder="Tiêu đề" name="subject" id="subject" value="{{ $mail?->subject }}" />
            @error('subject')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="form-group">
            <label for="content" class="text-sm">Mẫu email <span class="text-danger">*</span></label>
            <div class="">
              <x-trix-input id="content" placeholder="Mẫu email" name="content" value="{{ sanitize_html($mail?->content) }}" />
            </div>
            @error('content')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div>
          <p class="text-sm pl-2 font-semibold italic my-1 text-yellow-400">Lưu ý: Giữ nguyên định dạng các nhãn [...] khi chỉnh sửa email</p>
        </div>
        <div class="d-flex justify-content-end mt-5">
          <button type="submit" class="btn bg-primary text-white btn-md">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection