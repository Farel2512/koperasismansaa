<!-- pembelian/tahunan.blade.php -->
@extends('layout.main')

@section('title', 'Laporan Jual Beli Barang')

@section('content')

@php
    if (auth()->user()->hasRole('kasir')) {
        $rolePrefix = 'kasir';
    } elseif (auth()->user()->hasRole('manager')) {
        $rolePrefix = 'manager';
    } else {
        $rolePrefix = 'admin';
    }
@endphp

<div class="content-wrapper">

    {{-- Penjualan --}}
    <div class="content-header">
        <div class="col text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tahun
                </button>
                <div class="dropdown-menu dropdown-menu-right overflow-auto" style="max-height: 200px;">
                    @php
                        $startYear = 2021;
                        $currentYear = request('year', now()->year);
                    @endphp
                    @for ($year = $startYear; $year <= $currentYear + 5; $year++)
                        <a class="dropdown-item" href="{{ route($rolePrefix . '.jualbeli.barangtahunan', ['year' => $year]) }}">{{ $year }}</a>
                    @endfor
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Laporan Tahunan
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route($rolePrefix . '.jualbeli.barangbulanan') }}">Laporan Bulanan</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0 text-center">Laporan Penjualan Barang <br> Tahun {{ $currentYear }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Bulan</th>
                                <th>Jasa</th>
                                <th>ATK</th>
                                <th>Makanan</th>
                                <th>Minuman</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $months = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ];
                                $no = 1;
                            @endphp
                            @foreach ($months as $index => $month)
                                <tr>
                                    <td><strong>{{ $no++ }}</strong></td>
                                    <td><strong>{{ $month }}</strong></td>
                                    <td>{{ number_format($mergedTransaksis['Jasa'][$index + 1] ?? 0) }}</td>
                                    <td>{{ number_format($mergedTransaksis['ATK'][$index + 1] ?? 0) }}</td>
                                    <td>{{ number_format($mergedTransaksis['Makanan'][$index + 1] ?? 0) }}</td>
                                    <td>{{ number_format($mergedTransaksis['Minuman'][$index + 1] ?? 0) }}</td>
                                    <td>{{ number_format(
                                        ($mergedTransaksis['Jasa'][$index + 1] ?? 0) +
                                        ($mergedTransaksis['ATK'][$index + 1] ?? 0) +
                                        ($mergedTransaksis['Makanan'][$index + 1] ?? 0) +
                                        ($mergedTransaksis['Minuman'][$index + 1] ?? 0)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2"><strong>Total</strong></th>
                                <th>{{ number_format(array_sum($mergedTransaksis['Jasa'])) }}</th>
                                <th>{{ number_format(array_sum($mergedTransaksis['ATK'])) }}</th>
                                <th>{{ number_format(array_sum($mergedTransaksis['Makanan'])) }}</th>
                                <th>{{ number_format(array_sum($mergedTransaksis['Minuman'])) }}</th>
                                <th>{{ number_format(
                                    array_sum($mergedTransaksis['Jasa']) +
                                    array_sum($mergedTransaksis['ATK']) +
                                    array_sum($mergedTransaksis['Makanan']) +
                                    array_sum($mergedTransaksis['Minuman'])) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col text-right">
            <a href="{{ route($rolePrefix . '.penjualan.barangtahunan_pdf', ['year' => $currentYear]) }}" class="btn btn-danger ml-2">Cetak<i class="fas fa-file-pdf ml-2"></i></a>
        </div>
    </section>

    <hr>

    {{-- Pembelian --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0 text-center">Laporan Pembelian Barang <br> Tahun {{ $currentYear }}</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Bulan</th>
                                <th>Jasa</th>
                                <th>ATK</th>
                                <th>Makanan</th>
                                <th>Minuman</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $months = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ];
                                $no = 1;
                            @endphp
                            @foreach ($months as $index => $month)
                                <tr>
                                    <td><strong>{{ $no++ }}</strong></td>
                                    <td><strong>{{ $month }}</strong></td>
                                    <td>{{ number_format($mergedBelanjas['Jasa'][$index + 1] ?? 0) }}</td>
                                    <td>{{ number_format($mergedBelanjas['ATK'][$index + 1] ?? 0) }}</td>
                                    <td>{{ number_format($mergedBelanjas['Makanan'][$index + 1] ?? 0) }}</td>
                                    <td>{{ number_format($mergedBelanjas['Minuman'][$index + 1] ?? 0) }}</td>
                                    <td>{{ number_format(
                                        ($mergedBelanjas['Jasa'][$index + 1] ?? 0) +
                                        ($mergedBelanjas['ATK'][$index + 1] ?? 0) +
                                        ($mergedBelanjas['Makanan'][$index + 1] ?? 0) +
                                        ($mergedBelanjas['Minuman'][$index + 1] ?? 0)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2"><strong>Total</strong></th>
                                <th>{{ number_format(array_sum($mergedBelanjas['Jasa'])) }}</th>
                                <th>{{ number_format(array_sum($mergedBelanjas['ATK'])) }}</th>
                                <th>{{ number_format(array_sum($mergedBelanjas['Makanan'])) }}</th>
                                <th>{{ number_format(array_sum($mergedBelanjas['Minuman'])) }}</th>
                                <th>{{ number_format(
                                    array_sum($mergedBelanjas['Jasa']) +
                                    array_sum($mergedBelanjas['ATK']) +
                                    array_sum($mergedBelanjas['Makanan']) +
                                    array_sum($mergedBelanjas['Minuman'])) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col text-right">
            <a href="{{ route($rolePrefix . '.pembelian.barangtahunan_pdf', ['year' => $currentYear]) }}" class="btn btn-danger ml-2">Cetak<i class="fas fa-file-pdf ml-2"></i></a>
        </div>
    </section>
</div>

@endsection
