@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
  <h3 class="mb-4">Profil Saya</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row">
    {{-- FOTO --}}
    <div class="col-md-4 mb-3">
      <div class="card">
        <div class="card-body text-center">
          @php
            $photo = auth()->user()->photo
              ? asset('storage/'.auth()->user()->photo)
              : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0D6EFD&color=fff';
          @endphp

          <img src="{{ $photo }}" class="rounded-circle mb-3" width="120" height="120" alt="Foto Profil">

          <form action="{{ route('user.profile.photo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group text-left">
              <label>Ganti Foto</label>
              <input type="file" name="photo" class="form-control-file" required>
              <small class="text-muted">JPG/PNG maks 2MB.</small>
            </div>
            <button class="btn btn-primary btn-block">
              <i class="fas fa-upload mr-1"></i> Upload
            </button>
          </form>
        </div>
      </div>
    </div>

    {{-- DATA PROFIL --}}
    <div class="col-md-8 mb-3">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf

            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="name" class="form-control"
                     value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control"
                     value="{{ auth()->user()->email }}" readonly>
              <small class="text-muted">Email tidak bisa diubah.</small>
            </div>

            <div class="form-group">
              <label>No. HP</label>
              <input type="text" name="phone" class="form-control"
                     value="{{ old('phone', auth()->user()->phone) }}">
            </div>

            <button class="btn btn-success">
              <i class="fas fa-save mr-1"></i> Simpan Perubahan
            </button>

            <a href="{{ route('home') }}" class="btn btn-light">
              Kembali
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
