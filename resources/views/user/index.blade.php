@extends('layout.main')

@section('title', 'User')

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
            <h1 class="m-0">User</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <a href="{{ route($rolePrefix . '.user.create') }}" class="btn btn-success mb-3" ><i class="fas fa-plus"></i> Tambah User</a>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tabel User</h3>

              <div class="card-tools">
                <form action="{{ route($rolePrefix . '.user') }}" method="GET">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="usersearch" class="form-control float-right" placeholder="Search" value="{{ $request->get('usersearch') }}">

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
                    <th>Foto Profil</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ asset('storage/photo-user/'.$d->image) }}" alt="" width="100" height="100"></td>
                    <td>{{ $d->username }}</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->getRoleNames()->map(fn($role) => ucwords($role))->implode(', ') }}</td>
                    <td>
                        <a href="{{ route($rolePrefix . '.user.edit', ['name' => $d->name]) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                        <a data-toggle="modal" data-target="#modal-hapus{{ $d->id }}" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                    </td>
                  </tr>

                  <div class="modal fade" id="modal-hapus{{ $d->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header justify-content-center">
                          <h4 class="modal-title">Hapus User</h4>
                        </div>
                        <div class="modal-body">
                          <p>Apakah yakin untuk menghapus user <b>{{ $d->name }}</b> ?</p>
                        </div>
                        <div class="modal-footer justify-content-center">
                          <form action="{{ route($rolePrefix . '.user.delete',['id' => $d->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                              <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                              <button type="submit" class="btn btn-danger">YES</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    </section>
@endsection
