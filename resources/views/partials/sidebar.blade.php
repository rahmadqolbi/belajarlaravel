<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                {{-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> --}}
                <div class="sidebar-brand-text mx-3">Inventory</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('kategori') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface

            </div>




       <!-- Nav Item - Tables -->
           <li class="nav-item {{ request()->routeIs('kategori') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('kategori') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Kategori</span>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('produk') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('produk') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Produk</span>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('supplier') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('supplier') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Supplier</span>
    </a>
</li>

{{-- <li class="nav-item {{ request()->routeIs('gudang') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('gudang') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Gudang</span>
    </a>
</li> --}}

<li class="nav-item {{ request()->routeIs('outlet') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('outlet') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Outlet</span>
    </a>
</li>

<li class="nav-item {{ request()->routeIs('barangmasuk') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('barangmasuk') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Barang Masuk</span>
    </a>
</li>
<li class="nav-item {{ request()->routeIs('penjualan') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penjualan') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Penjualan</span>
    </a>
</li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">


        </ul>
