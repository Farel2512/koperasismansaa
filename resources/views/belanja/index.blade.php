@extends('layout.main')

@section('title', 'Data Belanja')

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
                    <h3 class="card-title">Data Pembelian</h3>
                    <div class="card-tools">
                        <form action="{{ route($rolePrefix . '.belanja.index') }}" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="date" name="tanggalpembelian" class="form-control" value="{{ request()->get('tanggalpembelian') }}">
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
                            @foreach ($belanjas as $belanja)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $belanja->kd }}</td>
                                    <td>{{ $belanja->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $belanja->created_at->format('H:i:s') }}</td>
                                    <td>Rp. {{ number_format($belanja->dataBelanjas->sum('harga_total'), 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($belanja->uang_bayar, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($belanja->uang_bayar - $belanja->dataBelanjas->sum('harga_total'), 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-info" data-toggle="modal" data-target="#detailModal{{ $belanja->id }}"><i class="fas fa-eye"></i> Detail</button>
                                        <form action="{{ route($rolePrefix . '.belanja.delete', $belanja->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus belanja ini?');"><i class="fas fa-trash"></i> Hapus</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="detailModal{{ $belanja->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $belanja->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $belanja->id }}">Detail Belanja: {{ $belanja->kd }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>Tanggal : </strong> {{ $belanja->created_at->format('d-m-Y') }} <br>
                                                <strong>Jam : </strong> {{ $belanja->created_at->format('H:i:s') }} <br>
                                                <strong>Jumlah Item : </strong> {{ $belanja->dataBelanjas->count() }}<br>
                                                <h1>-------------------------------------</h1>
                                                @foreach ($belanja->dataBelanjas as $dataBelanja)
                                                    <div class="mb-2">
                                                        <strong>Nama Barang : </strong> {{ $dataBelanja->barang->nama }}<br>
                                                        <strong>Harga Barang : </strong> Rp. {{ number_format($dataBelanja->barang->harga_beli, 0, ',', '.') }}<br>
                                                        <strong>Jumlah      : </strong> {{ $dataBelanja->jumlah }}<br>
                                                        <strong>Harga Total : </strong> Rp. {{ number_format($dataBelanja->harga_total, 0, ',', '.') }}
                                                        <h1>-------------------------------------</h1>
                                                    </div>
                                                @endforeach
                                                <div>
                                                    <strong>Subtotal: Rp. {{ number_format($belanja->dataBelanjas->sum('harga_total'), 0, ',', '.') }}</strong>
                                                </div>
                                                <h1>-------------------------------------</h1>
                                                <div>
                                                    <strong>Uang Bayar: Rp. {{ number_format($belanja->uang_bayar, 0, ',', '.') }}</strong>
                                                </div>
                                                <div>
                                                    <strong>Kembalian: Rp. {{ number_format($belanja->uang_bayar - $belanja->dataBelanjas->sum('harga_total'), 0, ',', '.') }}</strong>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <a href="{{ route($rolePrefix . '.belanja.cetak', ['id' => $belanja->id]) }}" class="btn btn-primary ml-2">Cetak</a>
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
                        <li class="page-item {{ $belanjas->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $belanjas->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>

                        @for ($page = 1; $page <= $belanjas->lastPage(); $page++)
                            <li class="page-item {{ $page == $belanjas->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $belanjas->url($page) }}">{{ $page }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ !$belanjas->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $belanjas->nextPageUrl() }}" rel="next">&raquo;</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection
