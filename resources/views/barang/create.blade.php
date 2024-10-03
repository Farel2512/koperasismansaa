@extends('layout.main')

@section('title', 'Tambah Barang')

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
            <form action="{{ route($rolePrefix . '.barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tambah Barang</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputNo1">No Barang</label>
                                    <input type="text" name="no" class="form-control" id="exampleInputNo1" placeholder="Enter no barang">
                                    @error('no')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputNama1">Nama Barang</label>
                                    <input type="text" name="nama" class="form-control" id="exampleInputNama1" placeholder="Enter nama barang">
                                    @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                    <label for="jenisBarang">Jenis Barang</label>
                                    <select name="jenis_barang" class="form-control" id="jenisBarang">
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="Jasa">Jasa</option>
                                        <option value="ATK">ATK</option>
                                        <option value="Snack">Snack</option>
                                        <option value="Minuman">Minuman</option>
                                        <option value="Makanan">Makanan</option>
                                    </select>
                                    @error('jenis_barang')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="satuanBarang">Satuan</label>
                                        <select name="satuan" class="form-control" id="satuanBarang">
                                            <option value="" disabled selected>Pilih</option>
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
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputHarga1">Harga Jual</label>
                                        <input type="number" name="harga" class="form-control" id="exampleInputHarga1" placeholder="Enter harga barang">
                                        @error('harga')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputHarga2">Harga Beli</label>
                                        <input type="number" name="harga_beli" class="form-control" id="exampleInputHarga2" placeholder="Enter harga barang">
                                        @error('harga_beli')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputFoto1">Foto Barang</label>
                                        <input type="file" name="image" class="form-control" id="exampleInputFoto1">
                                        @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputStok1">Stok</label>
                                        <input type="number" name="stok" class="form-control" id="exampleInputStok1" placeholder="Enter stok barang">
                                        @error('stok')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Tambah</button>
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
