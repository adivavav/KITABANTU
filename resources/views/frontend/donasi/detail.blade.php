@extends('layouts.app')
@section('title','Donasi • '.$program->nama_program)

@section('content')
<div class="row g-4">

  {{-- KOLOM KIRI : FOTO + INFO PROGRAM --}}
  <div class="col-lg-7">

    {{-- FOTO PROGRAM --}}
    @if($program->foto)
      <div class="mb-3">
        <img src="{{ asset('storage/'.$program->foto) }}"
             class="img-fluid rounded w-100"
             style="max-height:360px;object-fit:cover"
             alt="{{ $program->nama_program }}">
      </div>
    @endif

    {{-- INFO TARGET & PROGRESS --}}
    <div class="card card-soft mb-3">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <div>
            <small class="text-muted">Target Donasi</small><br>
            <b>Rp {{ number_format($program->target_dana,0,',','.') }}</b>
          </div>
          <div class="text-end">
            <small class="text-muted">Dana Terkumpul</small><br>
            <b>Rp {{ number_format($program->terkumpul,0,',','.') }}</b>
          </div>
        </div>

        <div class="progress" style="height:10px;">
          <div class="progress-bar bg-success"
               style="width: {{ $program->progress }}%">
          </div>
        </div>
        <small class="text-muted">{{ $program->progress }}% tercapai</small>
      </div>
    </div>

    {{-- INFO PROGRAM --}}
    <div class="card card-soft">
      <div class="card-body">
        <h3 class="fw-bold mb-2">{{ $program->nama_program }}</h3>

        <div class="d-flex gap-2 mb-3">
          <span class="badge bg-success">{{ $program->status_program }}</span>
        </div>

        <p class="text-muted mb-0">
          Silakan isi form di samping untuk berdonasi ke program ini.
        </p>
      </div>
    </div>

  </div>

  {{-- KOLOM KANAN : FORM DONASI --}}
  <div class="col-lg-5">
    <div class="card card-soft">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Form Donasi</h5>

        @if ($errors->any())
  <div class="alert alert-danger">
    <b>Donasi gagal:</b>
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif


        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ url('/donasi/'.$program->id_program.'/store') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label">Jumlah Donasi (Rp)</label>
            <input type="number" name="jumlah_donasi"
                   value="{{ old('jumlah_donasi', 10000) }}"
                   class="form-control" min="1000" required>
            <small class="text-muted">Minimal Rp 1.000</small>
          </div>

          <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="id_metode" class="form-select" required>
              <option value="">-- pilih metode --</option>
              @foreach($metode as $m)
                <option value="{{ $m->id_metode }}">{{ $m->nama_metode }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Alamat Donatur</label>
            <textarea name="alamat" class="form-control" rows="2"
              placeholder="Alamat lengkap (opsional)">{{ old('alamat') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Komentar</label>
            <textarea name="komentar" class="form-control" rows="2"
              placeholder="Isi Komentar Anda🙏">{{ old('komentar') }}</textarea>
          </div>

          <button class="btn btn-primary w-100">
            Buat Donasi
          </button>
        </form>

        <small class="text-muted d-block mt-3">
          Donasi akan berstatus <b>pending</b> sampai dikonfirmasi admin.
        </small>
      </div>
    </div>
  </div>

</div>
@endsection
