<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #02228d;">

    <a class="sidebar-brand d-flex align-items-center justify-content-center my-3" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-box-open text-primary" style="font-size: 1.5rem;"></i>
        </div>
        <div class="sidebar-brand-text mx-3 fw-bold text-white text-capitalize">Inventory <span class="text-primary">Pro</span></div>
    </a>

    <hr class="sidebar-divider my-0" style="opacity: 0.1;">

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-columns"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <div class="sidebar-heading mt-3 text-uppercase text-light" style="font-size: 0.65rem; opacity: 0.5;">
        Master Data
    </div>

    <li class="nav-item {{ request()->routeIs('kategori') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kategori') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Kategori</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('produk') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('produk') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Produk</span>
        </a>
    </li>

    @if(auth()->user()->role == 'admin')
    <li class="nav-item {{ request()->routeIs('supplier') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('supplier') }}">
            <i class="fas fa-fw fa-truck"></i>
            <span>Supplier</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('outlet') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('outlet') }}">
            <i class="fas fa-fw fa-store"></i>
            <span>Outlet</span>
        </a>
    </li>
    @endif

    <div class="sidebar-heading mt-3 text-uppercase" style="font-size: 0.65rem; opacity: 0.5;">
        Aktivitas Stok
    </div>

    @if(auth()->user()->role == 'admin')
    <li class="nav-item {{ request()->routeIs('barangmasuk') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barangmasuk') }}">
            <i class="fas fa-fw fa-arrow-down-short-wide"></i>
            <span>Barang Masuk</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('penyesuaianstok') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('penyesuaianstok') }}">
            <i class="fas fa-fw fa-arrow-down-short-wide"></i>
            <span>Penyesuaian Stok</span>
        </a>
    </li>
    @endif

    <li class="nav-item {{ request()->routeIs('penjualan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('penjualan') }}">
            <i class="fas fa-fw fa-cart-shopping"></i>
            <span>Penjualan</span>
        </a>
    </li>

    @if(auth()->user()->role == 'admin')
    <hr class="sidebar-divider mt-3" style="opacity: 0.1;">

    <div class="sidebar-heading text-uppercase" style="font-size: 0.65rem; opacity: 0.5;">
        User Management
    </div>

    <li class="nav-item {{ request()->routeIs('akunpenjualan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('akunpenjualan') }}">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Kelola Akun</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block" style="opacity: 0.1;">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" style="background-color: rgba(255,255,255,0.1);"></button>
    </div>

</ul>

<style>
/* CSS Tambahan untuk mempercantik sidebar */
.sidebar {
    transition: all 0.3s ease;
}

.sidebar .nav-item .nav-link {
    padding: 0.8rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.sidebar .nav-item .nav-link i {
    font-size: 0.9rem;
    margin-right: 0.5rem;
    opacity: 0.7;
}

.sidebar .nav-item.active .nav-link {
    background: rgba(78, 115, 223, 0.15); /* Soft Blue Background */
    color: #4e73df !important;
    border-left: 3px solid #4e73df;
}

.sidebar .nav-item.active .nav-link i {
    color: #4e73df !important;
    opacity: 1;
}

.sidebar .nav-item .nav-link:hover {
    background: rgba(255, 255, 255, 0.05);
}

.sidebar-heading {
    margin-bottom: 0.5rem;
    color: white;
}
</style>
