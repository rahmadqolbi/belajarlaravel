<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/sb-admin-2.min.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

</head>
<style>
    *{
        font-size: 14px;
    }
</style>
<body id="page-top" >

<div id="wrapper">
    @include('partials.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                  <h3>@yield('title')</h3>
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
                           role="button" data-toggle="dropdown">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                {{ Auth::user()->name ?? 'User' }}
                            </span>
                            <img class="img-profile rounded-circle"
                                 src="{{ asset('admin/img/undraw_profile.svg') }}">
                        </a>

                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                            {{-- <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div> --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>

                </ul>
            </nav>

            {{-- ===== ISI HALAMAN ===== --}}
            <div class="container-fluid">
                @yield('content')
            </div>

        </div>

        {{-- ===== FOOTER ===== --}}
        <footer class="sticky-footer bg-white d-flex align-items-end">
        {{-- style="height:220px;"> --}}
    <div class="container text-center pb-3">
        <span>Copyright &copy; {{ date('Y') }}</span>
    </div>
</footer>


    </div>
</div>

<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

</body>
</html>
