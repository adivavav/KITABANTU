@extends('layouts.admin')
@section('title','Profil Admin')

@section('content')
<div class="container-fluid">
  <h1 class="mb-3">Profil Admin</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label>Foto Profil</label><br>
          @php
            $foto = $admin->foto_admin ? asset('storage/'.$admin->foto_admin) : asset('assets/img/default-user.png');
          @endphp
          <img src="{{ $foto }}" style="width:90px;height:90px;border-radius:50%;object-fit:cover;margin-bottom:10px;">
          <input type="file" name="foto" class="form-control">
          @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
          <label>Nama Admin</label>
          <input type="text" name="nama_admin" class="form-control" value="{{ old('nama_admin',$admin->nama_admin) }}">
          @error('nama_admin') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" class="form-control" value="{{ old('username',$admin->username) }}">
          @error('username') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
      </form>
    </div>
  </div>
</div>
@endsection
