@extends('layout.main')

@section('title', 'Laporan Penjualan Tahunan')

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
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="col text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tahun
                </button>
                <div class="dropdown-menu dropdown-menu-right overflow-auto" style="max-height: 200px;">
                    @php
                        $startYear = 2021;
                        $currentYear = request('year', now()->year); // Ambil tahun dari request atau tahun saat ini
                    @endphp
                    @for ($year = $startYear; $year <= $currentYear + 5; $year++)
                        <a class="dropdown-item" href="{{ route($rolePrefix . '.jualbeli.tahunan', ['year' => $year]) }}">{{ $year }}</a>
                    @endfor
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Laporan Tahunan
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route($rolePrefix . '.jualbeli.bulanan') }}">Laporan Bulanan</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0 text-center">Laporan Transaksi Penjualan <br> Tahun {{ $currentYear }}</h1>
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
                                    <td>Rp {{ number_format($mergedTransaksis['Jasa'][$index + 1], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($mergedTransaksis['ATK'][$index + 1], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($mergedTransaksis['Makanan'][$index + 1], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($mergedTransaksis['Minuman'][$index + 1], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format(
                                        ($mergedTransaksis['Jasa'][$index + 1] ) +
                                        ($mergedTransaksis['ATK'][$index + 1] ) +
                                        ($mergedTransaksis['Makanan'][$index + 1] ) +
                                        ($mergedTransaksis['Minuman'][$index + 1] ), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2"><strong>Total</strong></th>
                                <th>Rp {{ number_format(array_sum($mergedTransaksis['Jasa']), 0, ',', '.') }}</th>
                                <th>Rp {{ number_format(array_sum($mergedTransaksis['ATK']), 0, ',', '.') }}</th>
                                <th>Rp {{ number_format(array_sum($mergedTransaksis['Makanan']), 0, ',', '.') }}</th>
                                <th>Rp {{ number_format(array_sum($mergedTransaksis['Minuman']), 0, ',', '.') }}</th>
                                <th>Rp {{ number_format(
                                    array_sum($mergedTransaksis['Jasa']) +
                                    array_sum($mergedTransaksis['ATK']) +
                                    array_sum($mergedTransaksis['Makanan']) +
                                    array_sum($mergedTransaksis['Minuman']), 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col text-right">
            <a href="{{ route($rolePrefix . '.penjualan.tahunan_pdf', ['year' => $currentYear]) }}" class="btn btn-danger ml-2">Cetak<i class="fas fa-file-pdf ml-2"></i></a>
        </div>
    </section>

    <hr>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0 text-center">Laporan Transaksi Pembelian <br> Tahun {{ $currentYear }}</h1>
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
                                    <td>Rp {{ number_format($mergedBelanjas['Jasa'][$index + 1], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($mergedBelanjas['ATK'][$index + 1], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($mergedBelanjas['Makanan'][$index + 1], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($mergedBelanjas['Minuman'][$index + 1], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format(
                                        ($mergedBelanjas['Jasa'][$index + 1]) +
                                        ($mergedBelanjas['ATK'][$index + 1]) +
                                        ($mergedBelanjas['Makanan'][$index + 1]) +
                                        ($mergedBelanjas['Minuman'][$index + 1]), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2"><strong>Total</strong></th>
                                <th>Rp {{ number_format(array_sum($mergedBelanjas['Jasa']), 0, ',', '.') }}</th>
                                <th>Rp {{ number_format(array_sum($mergedBelanjas['ATK']), 0, ',', '.') }}</th>
                                <th>Rp {{ number_format(array_sum($mergedBelanjas['Makanan']), 0, ',', '.') }}</th>
                                <th>Rp {{ number_format(array_sum($mergedBelanjas['Minuman']), 0, ',', '.') }}</th>
                                <th>Rp {{ number_format(
                                    array_sum($mergedBelanjas['Jasa']) +
                                    array_sum($mergedBelanjas['ATK']) +
                                    array_sum($mergedBelanjas['Makanan']) +
                                    array_sum($mergedBelanjas['Minuman']), 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col text-right">
            <a href="{{ route($rolePrefix . '.pembelian.tahunan_pdf', ['year' => $currentYear]) }}" class="btn btn-danger ml-2">Cetak<i class="fas fa-file-pdf ml-2"></i></a>
        </div>
    </section>
</div>
@endsection
