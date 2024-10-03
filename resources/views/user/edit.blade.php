@extends('layout.main')

@section('title', 'Edit User')

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
            <form action="{{ route($rolePrefix . '.user.update',['name' => $data->name]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- left column -->
                    <div class="col">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit User</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFoto1">Foto User</label>
                                    <br/>
                                    <img class="mb-2" src="{{ asset('storage/photo-user/'.$data->image) }}" width="150" height="150" style="border: 2px solid #000; border-radius: 10px;">
                                    <input type="file" name="image" class="form-control" id="exampleInputFoto1">
                                    @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputUserName1">Username</label>
                                    <input type="text" name="username" value="{{ $data->username }}" class="form-control" id="exampleInputUserName1" placeholder="Enter name">
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputName1">Nama</label>
                                        <input type="text" name="nama" value="{{ $data->name }}" class="form-control" id="exampleInputName1" placeholder="Enter name">
                                        @error('nama')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="role">Role</label>
                                        <select name="role" class="form-control" id="role">
                                            <option value="Manager" {{ $hasRole == 'Manager' ? 'selected' : '' }}>Manager</option>
                                            <option value="Kasir" {{ $hasRole == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                                            <option value="Admin" {{ $hasRole == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="Anggota" {{ $hasRole == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                                        </select>
                                        @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
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
