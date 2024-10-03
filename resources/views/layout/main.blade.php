<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'KPRI SMA Negeri 1 Rengat')</title>
  <link rel="icon" href="{{ asset('img/smansa.png') }}" type="image/png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <h3 class="mb-5">KOPERASI PEGAWAI REPUBLIK INDONESIA</h3>
    <img class="animation__wobble mb-5" src="{{ asset('img/smansa.png') }}" alt="SmansaRengat" height="120" width="90">
    <h2>SMA NEGERI 1 RENGAT</h2>
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
              <p><i class="fas fa-power-off nav-icon"></i> Log Out</p>
            </a>
          </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link" style="pointer-events: none;  display: flex; align-items: center;">
        <img src="{{ asset('img/smansa.png') }}" width="20" height="30" class="mr-2" style="margin-left: 20px;">
        <span class="brand-text font-weight-light" style="font-size: 20px;">KPRI HARAPAN MAJU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
        <div class="user-panel d-flex justify-content-center align-items-center">
            <div class="image">
                <img src="{{ Auth::user()->image ? asset('storage/photo-user/' . Auth::user()->image) : asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info mt-3">
                <p style="font-size: 18px;">Welcome, {{ Auth::user()->name }} <br> <span style="font-size: 14px;">{{ Auth::user()->getRoleNames()->map(fn($role) => ucwords($role))->implode(', ') }}</span> </p>
            </div>
        </div>

      <!-- Sidebar Menu -->
      @php
      if (auth()->user()->hasRole('kasir')) {
          $rolePrefix = 'kasir';
      } elseif (auth()->user()->hasRole('manager')) {
          $rolePrefix = 'manager';
      } else {
          $rolePrefix = 'admin';
      }
    @endphp

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route($rolePrefix . '.dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>Dashboard</p>
                </a>
            </li>

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                <li class="nav-item">
                    <a href="{{ route($rolePrefix . '.user') }}" class="nav-link">
                    <i class="fas fa-user nav-icon"></i>
                    <p>User</p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route($rolePrefix . '.barang') }}" class="nav-link">
                      <i class="fas fa-box nav-icon"></i>
                      <p>Barang</p>
                    </a>
                </li>

            <li class="nav-item">
                <a href="{{ route($rolePrefix . '.transaksi.create') }}" class="nav-link">
                  <i class="fas fa-cash-register nav-icon"></i>
                  <p>Kasir</p>
                </a>
            </li>

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                <li class="nav-item">
                    <a href="{{ route($rolePrefix . '.belanja.create') }}" class="nav-link">
                    <i class="fas fa-shopping-bag nav-icon"></i>
                    <p>Shop</p>
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route($rolePrefix . '.transaksi.index') }}" class="nav-link">
                  <i class="fas fa-file-alt nav-icon"></i>
                  <p>Data Penjualan</p>
                </a>
            </li>

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                <li class="nav-item">
                    <a href="{{ route($rolePrefix . '.belanja.index') }}" class="nav-link">
                      <i class="fas fa-file-alt nav-icon"></i>
                      <p>Data Pembelian</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-file-alt"></i>
                      <p>Laporan Transaksi<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($rolePrefix . '.jualbeli.bulanan') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Jual Beli Bulanan</p>
                            </a>
                          </li>
                        <li class="nav-item">
                            <a href="{{ route($rolePrefix . '.jualbeli.tahunan') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Jual Beli Tahunan</p>
                            </a>
                          </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-file-alt"></i>
                      <p>Laporan Barang<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route($rolePrefix . '.jualbeli.barangbulanan') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Jual Beli Bulanan</p>
                            </a>
                          </li>
                        <li class="nav-item">
                            <a href="{{ route($rolePrefix . '.jualbeli.barangtahunan') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Jual Beli Tahunan</p>
                            </a>
                          </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
    <!-- /.content-header -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>

<!-- PAGE -->
<!-- jQuery Mapael -->
<script src="{{ asset('lte/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('lte/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('lte/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('lte/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('lte/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('lte/dist/js/pages/dashboard2.js') }}"></script>

</body>
</html>
