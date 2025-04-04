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

    <!-- Nhúng chatbot -->
    @include('partials.chatbot')

    <!-- Toast notification -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @if(session()->has('success'))
    <script>
        toastr.options = {
            "progressBar": true,
            "closeButton": true
        }
        toastr.success("{{ session('success') }}", 'Thành công!', { timeOut: 3000 });
    </script>
    @endif

    @if(session()->has('error'))
    <script>
        toastr.options = {
            "progressBar": true,
            "closeButton": true
        }
        toastr.error("{{ session('error') }}", 'Thất bại!', { timeOut: 3000 });
    </script>
    @endif

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/candidate/lib/wow/wow.min.js"></script>
    <script src="/assets/candidate/lib/easing/easing.min.js"></script>
    <script src="/assets/candidate/lib/waypoints/waypoints.min.js"></script>
    <script src="/assets/candidate/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Chatbot -->
    <script src="{{ asset('js/chatbot.js') }}"></script>

    <!-- Template Javascript -->
    <script src="/assets/candidate/js/main.js"></script>

</body>

</html>
