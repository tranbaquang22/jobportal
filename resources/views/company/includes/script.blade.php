<!--   Core JS Files   -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="/assets/admin/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/assets/admin/js/plugins/smooth-scrollbar.min.js"></script>

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
    timeOut: 2000
  });
</script>
@endif

@if(session()->has('error'))
<script>
  toastr.options = {
    "progressBar": true,
    "closeButton": true
  }
  toastr.error("{{session('error')}}", 'Thất bại!', {
    timeOut: 3000
  });
</script>
@endif

<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/assets/admin/js/soft-ui-dashboard.js"></script>