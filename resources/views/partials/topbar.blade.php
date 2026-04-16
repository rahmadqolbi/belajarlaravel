<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-primary">
        <i class="fa fa-bars"></i>
    </button>

    <h1 class="h4 mb-0 text-gray-800 fw-bold d-none d-sm-inline-block">
        @yield('title')
    </h1>

    <ul class="navbar-nav ml-auto align-items-center">

        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw text-gray-600"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow border-0 animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            placeholder="Cari data..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block" style="border-right: 1px solid #e3e6f0; height: 1.5rem;"></div>

        <li class="nav-item dropdown no-arrow ms-2">
            <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="text-right me-3 d-none d-lg-block">
                    <p class="mb-0 text-gray-900 small fw-bold leading-none">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="mb-0 text-muted text-uppercase fw-medium" style="font-size: 10px; letter-spacing: 0.5px;">{{ auth()->user()->role ?? 'Admin' }}</p>
                </div>
                <div class="position-relative">
                    <img class="img-profile rounded-circle border shadow-sm" width="40" height="40"
                        src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}&background=4e73df&color=fff&font-size=0.35">
                    <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle"></span>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow border-0 animated--grow-in mt-3"
                aria-labelledby="userDropdown">
                <div class="dropdown-header text-uppercase small fw-bold">Pengaturan Akun</div>
                <a class="dropdown-item py-2" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-3 text-gray-400"></i>
                    Profil Saya
                </a>
                <a class="dropdown-item py-2" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-3 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item py-2 text-danger fw-bold" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-3 text-danger"></i>
                    Keluar Sistem
                </a>
            </div>
        </li>

    </ul>

</nav>

<style>
/* Style tambahan agar sinkron dengan sidebar */
.topbar {
    height: 4.5rem;
    border-bottom: 1px solid #f1f1f1;
}

.topbar .navbar-nav .nav-item .nav-link {
    height: 4.5rem;
    display: flex;
    align-items: center;
}

.topbar .img-profile {
    object-fit: cover;
    border: 2px solid #fff !important;
}

.dropdown-item {
    font-size: 0.85rem;
    color: #4a4a4a;
    transition: all 0.2s;
}

.dropdown-item:hover {
    background-color: #f8f9fc;
    color: #4e73df;
}

.leading-none {
    line-height: 1.2;
}
</style>
