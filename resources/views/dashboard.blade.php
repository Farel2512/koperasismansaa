@extends('layout.main')

@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

        @php
            if (auth()->user()->hasRole('kasir')) {
                $rolePrefix = 'kasir';
            } elseif (auth()->user()->hasRole('manager')) {
                $rolePrefix = 'manager';
            } else {
                $rolePrefix = 'admin';
            }
        @endphp

            <!-- Card for Barang -->
            <div class="col-lg-6 col-12">
            <a href="{{ route($rolePrefix . '.barang') }}">
            <div class="small-box bg-primary">
              <div class="inner">
                <h2><b>Barang</b></h2>
                <p>Data Barang</p>
              </div>
              <div class="icon">
                <i class="fas fa-box"></i>
              </div>
            </div>
            </a>
          </div>

          <!-- Card for User -->
          @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
          <div class="col-lg-6 col-12">
            <a href="{{ route($rolePrefix . '.user') }}">
            <div class="small-box bg-warning">
              <div class="inner">
                <h2 class="text-white"><b>User</b></h2>
                <p class="text-white">Data Pengguna</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
            </div>
            </a>
          </div>
          @endif

          @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
             <div class="col-lg-6 col-12">
              <a href="{{ route($rolePrefix . '.jualbeli.bulanan') }}">
              <div class="small-box bg-success">
                <div class="inner">
                  <h2 class="text-white"><b>Laporan Transaksi</b></h2>
                  <p class="text-white">Jual Beli</p>
                </div>
                <div class="icon">
                  <i class="fas fa-file-alt"></i>
                </div>
              </div>
              </a>
            </div>
            @endif

          <!-- Card for Laporan Pembelian -->
          @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
          <div class="col-lg-6 col-12">
            <a href="{{ route($rolePrefix . '.jualbeli.barangbulanan') }}">
            <div class="small-box bg-secondary">
              <div class="inner">
                <h2 class="text-white"><b>Laporan Barang</b></h2>
                <p class="text-white">Jual Beli</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-alt"></i>
              </div>
            </div>
            </a>
          </div>
          @endif

          <!-- Card for Transaksi -->
          <div class="col-lg-6 col-12">
            <a href="{{ route($rolePrefix . '.transaksi.create') }}">
            <div class="small-box bg-success">
              <div class="inner">
                <h2><b>Kasir</b></h2>
                <p>Input Transaksi</p>
              </div>
              <div class="icon">
                <i class="fas fa-cash-register"></i>
              </div>
            </div>
            </a>
          </div>

          <!-- Card for Belanja -->
          @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
          <div class="col-lg-6 col-12">
            <a href="{{ route($rolePrefix . '.belanja.create') }}">
            <div class="small-box bg-secondary">
              <div class="inner">
                <h2 class="text-white"><b>Shop</b></h2>
                <p class="text-white">Beli Barang</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart nav-icon"></i>
              </div>
            </div>
            </a>
          </div>
          @endif

          <!-- Card for Data Transaksi -->
          <div class="col-lg-6 col-12">
            <a href="{{ route($rolePrefix . '.transaksi.index') }}">
            <div class="small-box bg-info">
              <div class="inner">
                <h2><b>Data Penjualan</b></h2>
                <p>Info Penjualan</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-alt"></i>
              </div>
            </div>
            </a>
          </div>

          @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
          <div class="col-lg-6 col-12">
            <a href="{{ route($rolePrefix . '.belanja.index') }}">
            <div class="small-box bg-white">
              <div class="inner">
                <h2><b>Data Pembelian</b></h2>
                <p>Info Pembelian</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-alt"></i>
              </div>
            </div>
            </a>
          </div>
          @endif

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@endsection
