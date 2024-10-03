@extends('layout.main')

@section('title', 'Tambah User')

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
            <form action="{{ route($rolePrefix . '.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tambah User</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputPicture1">Foto Profil</label>
                                    <input type="file" name="image" class="form-control" id="exampleInputPicture1">
                                    @error('image')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputUserName1">Username</label>
                                    <input type="text" name="username" class="form-control" id="exampleInputUserName1" placeholder="Enter username">
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="exampleInputName1" placeholder="Enter name">
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleRole">Role</label>
                                    <select name="role" class="form-control" id="exampleRole">
                                        <option value="" disabled selected>Pilih Role</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Kasir">Kasir</option>
                                        <option value="Anggota">Anggota</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                    @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Enter Password</label>
                                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
