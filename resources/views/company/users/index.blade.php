@extends('company.layouts.app')

@section('content')

<div>
  <div class="row">
    <div class="col-12">
      <div class="card mb-4 mx-4">
        <div class="card-header pb-0">
          <div class="d-flex flex-row justify-content-between">
            <h5 class="mb-0">Danh sách tài khoản</h5>
            <a href="/company/users/create" class="btn bg-gradient-primary btn-sm mb-0 d-flex align-items-center gap-2 px-4" type="button">
              <span class="text-md">+</span>
              Tạo tài khoản
            </a>
          </div>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr class="border-top border-light">
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    ID
                  </th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Tên
                  </th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Email
                  </th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Số điện thoại
                  </th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Chức vụ
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
                @foreach ($users as $user)
                <tr>
                  <td class="ps-4">
                    <p class="text-xs font-weight-bold mb-0">{{ $user->id }}</p>
                  </td>
                  <td class="">
                    <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                  </td>
                  <td class="">
                    <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                  </td>
                  <td class="">
                    <p class="text-xs font-weight-bold mb-0">{{ $user->phone }}</p>
                  </td>
                  <td class="">
                    <p class="text-xs font-weight-bold mb-0">{{ constant('App\Models\User::DISPLAYED_ROLE')[$user->role] }}</p>
                  </td>
                  <td class="text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ date("d/m/Y", strtotime($user->created_at)) }}</span>
                  </td>
                  <td class="text-center">
                    <a href="/company/users/update/{{$user->id}}" class="me-2">
                      <i class="fas fa-user-edit text-blue"></i>
                    </a>
                    <span type="button" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$user->id}}">
                      <i class="cursor-pointer fas fa-trash text-danger"></i>
                    </span>
                  </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="confirmModal-{{$user->id}}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="confirmModalLabel-{{$user->id}}">Xác nhận xóa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <h6 class="mb-0 text-danger">Bạn có chắc chắc muốn xóa tài khoản này?</h6>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <a href="/company/users/delete/{{$user->id}}" type="button" class="btn btn-danger">Xóa</a>
                      </div>
                    </div>
                  </div>
                </div>

                @endforeach

              </tbody>
            </table>
            @if($users->count() == 0)
            <div class="text-center py-5">
              Chưa có tài khoản nào trên hệ thống
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection