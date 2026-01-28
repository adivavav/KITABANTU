@extends('layouts.app')
@section('title', 'Buat Program Donasi')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Buat Program Donasi</h3>
        <a href="{{ route('user.program_donasi.riwayat') }}" class="btn btn-outline-primary btn-sm">
          <i class="fas fa-list mr-1"></i> Riwayat Program Saya
        </a>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="card shadow-sm">
        <div class="card-body">

          <form action="{{ route('user.program_donasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label>Nama Program</label>
              <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required
                     placeholder="Contoh: Bantu Renovasi Masjid">
            </div>

            <div class="form-group">
              <label>Deskripsi Program</label>
              <textarea name="deskripsi" class="form-control" rows="5" required
                        placeholder="Ceritakan program donasi kamu...">{{ old('deskripsi') }}</textarea>
              <small class="text-muted">Minimal 10 karakter.</small>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Target Donasi (Rp)</label>
                  <input type="number" name="target_donasi" class="form-control" min="1000" required
                         value="{{ old('target_donasi') }}" placeholder="contoh: 1000000">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Selesai (opsional)</label>
                  <input type="date" name="tanggal_selesai" class="form-control"
                         value="{{ old('tanggal_selesai') }}">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Foto Program (opsional)</label>
              <input type="file" name="gambar" class="form-control-file" accept="image/*">
              <small class="text-muted">JPG/PNG/WebP max 2MB.</small>
            </div>

            <button class="btn btn-primary btn-block">
              <i class="fas fa-paper-plane mr-1"></i> Submit Program (Pending)
            </button>
          </form>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection
