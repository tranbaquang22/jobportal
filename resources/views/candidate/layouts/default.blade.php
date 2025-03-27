<!DOCTYPE html>
<html lang="en">

@include('candidate.includes.head')

<body>
    <div class="container-xxl bg-white p-0">
        <!-- header -->
        @include('candidate.includes.header')
        <!-- // header -->


        <!-- contents -->
        @yield('content')
        <!-- // contents -->


        <!-- footer -->
        @include('candidate.includes.footer')
        <!-- // footer -->
    </div>

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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/candidate/lib/wow/wow.min.js"></script>
    <script src="/assets/candidate/lib/easing/easing.min.js"></script>
    <script src="/assets/candidate/lib/waypoints/waypoints.min.js"></script>
    <script src="/assets/candidate/lib/owlcarousel/owl.carousel.min.js"></script>



    <!-- Template Javascript -->
    <script src="/assets/candidate/js/main.js"></script>

</body>

</html>