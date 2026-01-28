@extends('layouts.app')
@section('title', 'Riwayat Program Donasi Saya')

@section('content')
<div class="container">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Riwayat Program Donasi Saya</h3>
    <a href="{{ route('user.program_donasi.create') }}" class="btn btn-primary btn-sm">
      <i class="fas fa-plus mr-1"></i> Buat Program
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($programs->count() === 0)
    <div class="alert alert-info">
      Kamu belum membuat program donasi.
    </div>
  @endif

  <div class="row">
    @foreach($programs as $p)

      @php
        $status = strtolower($p->status_program ?? 'pending');
        $badge = 'secondary';
        $label = $p->status_program ?? 'pending';

        if ($status === 'aktif') { $badge = 'success'; $label = 'AKTIF'; }
        elseif ($status === 'pending') { $badge = 'warning'; $label = 'PENDING'; }
        elseif ($status === 'selesai') { $badge = 'dark'; $label = 'SELESAI'; }

        $img = $p->foto ? asset('storage/'.$p->foto) : 'https://via.placeholder.com/800x450?text=No+Image';
      @endphp

      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">

          <img src="{{ $img }}" class="card-img-top" style="height:180px;object-fit:cover;" alt="foto">

          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <h5 class="card-title mb-1">{{ $p->nama_program }}</h5>
              <span class="badge badge-{{ $badge }}">{{ $label }}</span>
            </div>

            <div class="text-muted small mb-2">
              Target: <b>Rp {{ number_format($p->target_dana, 0, ',', '.') }}</b>
            </div>

            <p class="card-text text-muted">
              {{ \Illuminate\Support\Str::limit($p->deskripsi, 90) }}
            </p>

            <div class="small text-muted">
              Mulai: {{ $p->tanggal_mulai ?? '-' }} <br>
              Selesai: {{ $p->tanggal_selesai ?? '-' }}
            </div>
          </div>

          <div class="card-footer bg-white">
            @if($status === 'aktif')
              {{-- kalau kamu punya halaman detail program, bisa arahkan ke sana --}}
              <a href="{{ route('donasi.detail', $p->id_program) }}" class="btn btn-outline-primary btn-sm btn-block">
                Lihat Program
              </a>
            @else
              <button class="btn btn-outline-secondary btn-sm btn-block" disabled>
                Menunggu Verifikasi Admin
              </button>
            @endif
          </div>

        </div>
      </div>

    @endforeach
  </div>
</div>
@endsection
