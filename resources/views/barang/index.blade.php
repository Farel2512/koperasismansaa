@extends('layout.main')

@section('title', 'Barang')

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
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Barang</h1>
            </div>
          </div>
        </div>
      </div>

    {{-- Main Content --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                    <a href="{{ route($rolePrefix . '.barang.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Tambah Barang</a>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Barang</h3>

                            <div class="card-tools">
                                <form action="{{ route($rolePrefix . '.barang') }}" method="GET">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="barangsearch" class="form-control float-right" placeholder="Search" value="{{ $request->get('barangsearch') }}">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Barang</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Jenis Barang</th>
                                        <th>Harga Jual</th>
                                        <th>Harga Beli</th>
                                        <th>Satuan</th>
                                        <th>Stok</th>
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangs as $index => $barang)
                                    <tr>
                                        <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $index + 1 }}</td>
                                        <td>{{ $barang->no }}</td>
                                        <td><img src="{{ asset('storage/photo-barang/'.$barang->image) }}" alt="" width="100" height="100"></td>
                                        <td>{{ $barang->nama }}</td>
                                        <td>{{ $barang->jenis_barang }}</td>
                                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                                        <td>{{ $barang->satuan }}</td>
                                        <td>{{ $barang->stok }}</td>
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                        <td>
                                            <a href="{{ route($rolePrefix . '.barang.edit',['nama' => $barang->nama]) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                                            <a data-toggle="modal" data-target="#modal-hapus{{ $barang->id }}" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                        @endif
                                    </tr>

                                    {{-- Modal Hapus Barang --}}
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                    <div class="modal fade" id="modal-hapus{{ $barang->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header justify-content-center">
                                                    <h4 class="modal-title">Hapus Barang</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah yakin untuk menghapus barang <b>{{ $barang->nama }}</b>?</p>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <form action="{{ route($rolePrefix . '.barang.delete', ['id' => $barang->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                                        <button type="submit" class="btn btn-danger">YES</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    {{-- /Modal Hapus Barang --}}

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        {{-- Barang Pagination --}}
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item {{ $barangs->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $barangs->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                                @foreach ($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $barangs->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li class="page-item {{ !$barangs->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $barangs->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            </ul>
                        </div>
                        {{-- /Barang Pagination --}}

                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    {{-- /Main Content --}}
</div>
@endsection
