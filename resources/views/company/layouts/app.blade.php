<!DOCTYPE html>
<html lang="en">

@include('company.includes.head')

<body class="g-sidenav-show bg-gray-100 relative">
  @include('company.includes.sidebar')
  <main class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    @include('company.includes.nav')
    <div class="container-fluid py-4">
      @yield('content')
    </div>
  </main>
  @include('company.includes.script')

</body>

</html>