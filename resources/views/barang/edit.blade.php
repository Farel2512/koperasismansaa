@extends('layout.main')

@section('title', 'Edit Barang')

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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route($rolePrefix . '.barang.update', ['nama' => $barang->nama]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- left column -->
                    <div class="col">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Barang</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFoto1">Foto Barang</label>
                                    <br/>
                                    <img class="mb-2" src="{{ asset('storage/photo-barang/'.$barang->image) }}" width="150" height="150" style="border: 2px solid #000; border-radius: 10px;">
                                    <input type="file" name="image" class="form-control" id="exampleInputFoto1">
                                    @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputNama1">Nama Barang</label>
                                    <input type="text" name="nama" class="form-control" id="exampleInputNama1" placeholder="Enter nama barang" value="{{ $barang->nama }}">
                                    @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputNomor1">No Barang</label>
                                    <input type="text" name="no" class="form-control" id="exampleInputNomor1" placeholder="Enter no barang" value="{{ $barang->no }}">
                                    @error('no')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                </div>

                                <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="jenisBarang">Jenis Barang</label>
                                    <select name="jenis_barang" class="form-control" id="jenisBarang">
                                        <option value="Jasa" {{ $barang->jenis_barang == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                        <option value="ATK" {{ $barang->jenis_barang == 'ATK' ? 'selected' : '' }}>ATK</option>
                                        <option value="Makanan" {{ $barang->jenis_barang == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                        <option value="Minuman" {{ $barang->jenis_barang == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                    </select>
                                    @error('jenis_barang')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputHarga1">Harga Jual</label>
                                    <input type="number" name="harga" class="form-control" id="exampleInputHarga1" placeholder="Enter harga barang" value="{{ number_format($barang->harga, 0, ',', '.') }}">
                                    @error('harga')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="exampleInputHarga2">Harga Beli</label>
                                    <input type="number" name="harga_beli" class="form-control" id="exampleInputHarga2" placeholder="Enter harga barang" value="{{ number_format($barang->harga_beli, 0, ',', '.') }}">
                                    @error('harga_beli')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="satuanBarang">Satuan</label>
                                        <select name="satuan" class="form-control" id="satuanBarang" value="{{ $barang->satuan }}">
                                            <option value="buah">Buah</option>
                                            <option value="lembar">Lembar</option>
                                            <option value="bungkus">Bungkus</option>
                                            <option value="botol">Botol</option>
                                            <option value="pcs">pcs</option>
                                        </select>
                                        @error('satuan')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputStok1">Stok</label>
                                        <input type="number" name="stok" class="form-control" id="exampleInputStok1" placeholder="Enter stok barang" value="{{ $barang->stok }}" min="0">
                                        @error('stok')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Ubah</button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (right) -->
                </div>
            </form>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
