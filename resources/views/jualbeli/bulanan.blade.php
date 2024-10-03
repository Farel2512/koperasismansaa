@extends('layout.main')

@section('title', 'Laporan Penjualan Bulanan')

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

    <div class="content-header">
        <div class="col text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bulan
                </button>
                <div class="dropdown-menu dropdown-menu-right overflow-auto" style="max-height: 200px;">
                    @php
                        $months = [
                            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4, 'Mei' => 5, 'Juni' => 6,
                            'Juli' => 7, 'Agustus' => 8, 'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
                        ];
                    @endphp
                    @foreach ($months as $monthName => $monthNumber)
                        <a class="dropdown-item" href="{{ route($rolePrefix . '.jualbeli.bulanan', ['month' => $monthNumber, 'year' => $year]) }}">{{ $monthName }}</a>
                    @endforeach
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Tahun
                </button>
                <div class="dropdown-menu dropdown-menu-right overflow-auto" style="max-height: 200px;">
                    @php
                        $startYear = 2021;
                        $currentYear = now()->year;
                    @endphp
                    @for ($yearOption = $startYear; $yearOption <= $currentYear + 5; $yearOption++)
                        <a class="dropdown-item" href="{{ route($rolePrefix . '.jualbeli.bulanan', ['year' => $yearOption, 'month' => $month]) }}">{{ $yearOption }}</a>
                    @endfor
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Laporan Bulanan
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route($rolePrefix . '.jualbeli.tahunan', ['year' => $year]) }}">Laporan Tahunan</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0 text-center">Laporan Transaksi Penjualan <br> Bulan {{ $bulanNama }} {{ $year }}</h1>
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
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Minggu 1</th>
                                <th>Minggu 2</th>
                                <th>Minggu 3</th>
                                <th>Minggu 4</th>
                                <th>Minggu 5</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $totalMinggu1 = 0;
                                $totalMinggu2 = 0;
                                $totalMinggu3 = 0;
                                $totalMinggu4 = 0;
                                $totalMinggu5 = 0;
                                $totalSemua = 0;
                            @endphp
                            @foreach ($mergedTransaksis as $barangNama => $transaksi)
                                @php
                                    $totalMinggu1 += $transaksi['minggu1'];
                                    $totalMinggu2 += $transaksi['minggu2'];
                                    $totalMinggu3 += $transaksi['minggu3'];
                                    $totalMinggu4 += $transaksi['minggu4'];
                                    $totalMinggu5 += $transaksi['minggu5'];
                                    $totalSemua += $transaksi['total'];
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $barangNama }}</td>
                                    <td>{{ $transaksi['jenis'] }}</td>
                                    <td>Rp {{ number_format($transaksi['minggu1'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaksi['minggu2'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaksi['minggu3'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaksi['minggu4'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaksi['minggu5'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaksi['total'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3"><strong>Total</strong></th>
                                <th>Rp {{ number_format($totalMinggu1, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalMinggu2, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalMinggu3, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalMinggu4, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalMinggu5, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalSemua, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <hr>

    <div class="content-header">
        <div class="col text-right">
        </div>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0 text-center">Laporan Transaksi Pembelian <br> Bulan {{ $bulanNama }} {{ $year }}</h1>
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
                                <th>Nama Barang</th>
                                <th>Jenis</th>
                                <th>Minggu 1</th>
                                <th>Minggu 2</th>
                                <th>Minggu 3</th>
                                <th>Minggu 4</th>
                                <th>Minggu 5</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $totalMinggu1 = 0;
                                $totalMinggu2 = 0;
                                $totalMinggu3 = 0;
                                $totalMinggu4 = 0;
                                $totalMinggu5 = 0;
                                $totalSemua = 0;
                            @endphp
                            @foreach ($mergedBelanjas as $barangNama => $belanja)
                                @php
                                    $totalMinggu1 += $belanja['minggu1'];
                                    $totalMinggu2 += $belanja['minggu2'];
                                    $totalMinggu3 += $belanja['minggu3'];
                                    $totalMinggu4 += $belanja['minggu4'];
                                    $totalMinggu5 += $belanja['minggu5'];
                                    $totalSemua += $belanja['total'];
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $barangNama }}</td>
                                    <td>{{ $belanja['jenis'] }}</td>
                                    <td>Rp {{ number_format($belanja['minggu1'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($belanja['minggu2'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($belanja['minggu3'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($belanja['minggu4'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($belanja['minggu5'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($belanja['total'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3"><strong>Total</strong></th>
                                <th>Rp {{ number_format($totalMinggu1, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalMinggu2, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalMinggu3, 0, ',', '.')}}</th>
                                <th>Rp {{ number_format($totalMinggu4, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalMinggu5, 0, ',', '.') }}</th>
                                <th>Rp {{ number_format($totalSemua, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
