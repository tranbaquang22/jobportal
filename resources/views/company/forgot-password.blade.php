<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login | Enuy</title>
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Main CSS -->
  <link id="pagestyle" href="/assets/admin/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
  <!-- Toast notification CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <main class="bg-gray-100">
    <section class="main-content mt-0">
      <div class="page-header min-vh-50">
        <div class="container">
          <div class="row vh-100 align-items-center">
            <div class="col-lg-5 d-flex flex-column mx-auto py-6">
              <div class="card py-md-4 px-md-5">
                <div class="card-header pb-0 text-center bg-transparent">
                  <a class="align-items-center d-flex justify-content-center m-0 navbar-brand text-wrap" href="/">
                    <img src="/assets/admin/img/logo-ct.png" height="30" class="navbar-brand-img opacity-7" alt="logo">
                    <span class="ms-2 font-weight-bold text-secondary">Enuy - Job portal website</span>
                  </a>
                  <h3 class="font-weight-bolder text-primary pt-2">Quên mật khẩu?</h3>
                </div>
                <div class="card-body pt-4">
                  @error('error')
                  <p class="text-danger text-center font-weight-bold m-0">{{ $message }}</p>
                  @enderror
                  <form role="form" method="POST" action="">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') }}" aria-label="Email" aria-describedby="email-addon">
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-primary text-white w-100 mt-4 mb-0">Khôi phục mật khẩu</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Toast notification -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  @if(session()->has('success'))
  <script>
    toastr.options = {
      "progressBar": true,
      "closeButton": true
    }
    toastr.success("{{session('success')}}", 'Thành công!', {
      timeOut: 3000
    });
  </script>
  @endif
</body>

</html>