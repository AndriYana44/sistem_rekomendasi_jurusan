<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sistem Rekomendasi Jurusan</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('') }}assets/img/favicon.png" rel="icon">
  <link href="{{ asset('') }}assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('') }}assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/css/libs/animate.min.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  {{-- datatables --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

  <!-- Template Main CSS File -->
  <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Nov 17 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="d-flex justify-content-center align-items-conter">
                <a class="navbar-brand" href="{{ url('/') }}">SISTEM REKOMENDASI JURUSAN</a>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('rule') }}">Soal tes</a>
                  </li>
                </ul>
            </div>
            <div class="d-flex">
                <ul class="d-flex align-items-right">
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <img class="rounded-circle" src="{{ asset('') }}assets/img/icon-user.png" style="width: 30px;" alt="logo-user">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                    <i class="bi bi-gear"></i>
                                    <span>Account Settings</span>
                                </a>
                            </li>
                            <li>
                            <hr class="dropdown-divider">
                            </li>
                
                            <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('') }}assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/chart.js/chart.umd.js"></script>
    <script src="{{ asset('') }}assets/vendor/echarts/echarts.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/quill/quill.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="{{ asset('') }}assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="{{ asset('') }}assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('') }}assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/wowjs@1.1.3/dist/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    @yield('script')
</body>
</html>