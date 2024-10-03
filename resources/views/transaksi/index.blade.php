@extends('layout.main')

@section('title', 'Data Penjualan')

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
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Penjualan</h3>
                    <div class="card-tools">
                        <form action="{{ route($rolePrefix . '.transaksi.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="date" name="tanggal" class="form-control" value="{{ request()->get('tanggaltransaksi') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Total</th>
                                <th>Uang Bayar</th>
                                <th>Uang Kembali</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaksi->no_transaksi }}</td>
                                    <td>{{ $transaksi->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $transaksi->created_at->format('H:i:s') }}</td>
                                    <td>Rp. {{ number_format($transaksi->dataTransaksis->sum('harga_total'), 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($transaksi->uang_bayar - $transaksi->dataTransaksis->sum('harga_total'), 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#detailModal{{ $transaksi->id }}"><i class="fas fa-eye"></i> Detail</button>
                                        <form action="{{ route($rolePrefix . '.transaksi.delete', $transaksi->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');"><i class="fas fa-trash"></i> Hapus</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="detailModal{{ $transaksi->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $transaksi->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $transaksi->id }}">Detail Transaksi: {{ $transaksi->no_transaksi }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>Tanggal : </strong> {{ $transaksi->created_at->format('d-m-Y') }} <br>
                                                <strong>Jam : </strong> {{ $transaksi->created_at->format('H:i:s') }} <br>
                                                <strong>Jumlah Item : </strong> {{ $transaksi->dataTransaksis->count() }}<br>
                                                <hr>
                                                @foreach ($transaksi->dataTransaksis as $dataTransaksi)
                                                    <div class="mb-2">
                                                        <strong>Nama Barang : </strong> {{ $dataTransaksi->barang->nama }}<br>
                                                        <strong>Harga Barang : </strong> Rp. {{ number_format($dataTransaksi->barang->harga, 0, ',', '.') }}<br>
                                                        <strong>Jumlah      : </strong> {{ $dataTransaksi->quantity }}<br>
                                                        <strong>Harga Total : </strong> Rp. {{ number_format($dataTransaksi->harga_total, 0, ',', '.') }}
                                                        <hr>
                                                    </div>
                                                @endforeach
                                                <div>
                                                    <strong>Subtotal: Rp. {{ number_format($transaksi->dataTransaksis->sum('harga_total'), 0, ',', '.') }}</strong>
                                                </div>
                                                <hr>
                                                <div>
                                                    <strong>Uang Bayar: Rp. {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</strong>
                                                </div>
                                                <div>
                                                    <strong>Kembalian: Rp. {{ number_format($transaksi->uang_bayar - $transaksi->dataTransaksis->sum('harga_total'), 0, ',', '.') }}</strong>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <a href="{{ route($rolePrefix . '.transaksi.cetak', ['id' => $transaksi->id]) }}" class="btn btn-primary ml-2">Cetak</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item {{ $transaksis->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $transaksis->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>
                        @for ($page = 1; $page <= $transaksis->lastPage(); $page++)
                            <li class="page-item {{ $page == $transaksis->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $transaksis->url($page) }}">{{ $page }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ !$transaksis->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $transaksis->nextPageUrl() }}" rel="next">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
