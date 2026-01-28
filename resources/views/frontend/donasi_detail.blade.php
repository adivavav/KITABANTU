@extends('layouts.app')
@section('title','Donasi • '.$program->nama_program)

@section('content')
<div class="row g-3">

  {{-- INFO PROGRAM --}}
  <div class="col-lg-7">
    <div class="card card-soft">
      <div class="card-body">
        <h3 class="fw-bold mb-2">{{ $program->nama_program }}</h3>

        <div class="d-flex flex-wrap gap-2 mb-3">
          <span class="badge bg-success">{{ $program->status_program }}</span>
          <span class="badge bg-light text-dark">
            Target: Rp {{ number_format((float)$program->target_dana,0,',','.') }}
          </span>
        </div>

        <div class="text-muted">
          Silakan isi form di samping untuk berdonasi ke program ini.
        </div>
      </div>
    </div>
  </div>

  {{-- FORM DONASI --}}
  <div class="col-lg-5">
    <div class="card card-soft">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Form Donasi</h5>

        @if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif


        <form method="POST" action="{{ route('donasi.store', $program->id_program) }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Nama Donatur</label>
            <input type="text" name="nama_donatur"
                   value="{{ old('nama_donatur') }}"
                   class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email (opsional)</label>
            <input type="email" name="email"
                   value="{{ old('email') }}"
                   class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Jumlah Donasi (Rp)</label>
            <input type="number" name="jumlah_donasi"
                   value="{{ old('jumlah_donasi', 10000) }}"
                   class="form-control" min="1000" required>
            <div class="form-text">Minimal Rp 1.000</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_id" class="form-select" required>
              <option value="">-- pilih metode --</option>
              @foreach($metode as $m)
                <option value="{{ $m->id_metode }}">
                  {{ $m->nama_metode }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
  <label class="form-label">No HP</label>
  <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control">
</div>

<div class="mb-3">
  <label class="form-label">Alamat</label>
  <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
</div>


   <button type="submit" class="btn btn-primary w-100">
    Buat Donasi (Pending)
  </button>
</form>

        <div class="text-muted small mt-3">
          Donasi akan berstatus <b>pending</b> sampai pembayaran dikonfirmasi admin.
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
