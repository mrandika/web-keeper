@section('main-sidebar')
    @if(Auth::user()->role->name == 'Super-Admin')
        <ul class="sidebar-menu">
            <li class="menu-header">Beranda</li>
            <li class=@yield('dashboard-active')><a class="nav-link" href="{{ route('superadmin.home') }}"><i class="far fa-square"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">Manajemen</li>
            <li class=@yield('warehouse-active')><a class="nav-link" href="{{ route('warehouse.index') }}"><i class="far fa-warehouse"></i> <span>Warehouse</span></a></li>
            <li class=@yield('employee-active')><a class="nav-link" href="{{ route('employee.index') }}"><i class="far fa-user"></i> <span>Employee</span></a></li>
            <li class=@yield('item-active')><a class="nav-link" href="{{ route('item.index') }}"><i class="far fa-box"></i> <span>Item</span></a></li>


            <li class="menu-header">Point of Sales</li>
            <li class="dropdown @yield('pos-active')">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Transaksi</span></a>
                <ul class="dropdown-menu">
                    <li class=@yield('pos-db-active')><a class="nav-link" href="{{ route('transaction.debit') }}">Pembelian</a></li>
                    <li class=@yield('pos-cr-active')><a class="nav-link" href="{{ route('transaction.credit') }}">Penjualan</a></li>
                </ul>
            </li>
            <li class=@yield('transaction-active')><a class="nav-link" href="{{ route('transaction.index') }}"><i class="far fa-square"></i> <span>Data Transaksi</span></a></li>
        </ul>
    @endif

    @if(Auth::user()->role->name == 'Admin')
        <ul class="sidebar-menu">
            <li class="menu-header">Beranda</li>
            <li class=@yield('dashboard-active')><a class="nav-link" href="{{ route('admin.home') }}"><i class="far fa-square"></i> <span>Dashboard</span></a></li>
        </ul>
    @endif
@endsection
