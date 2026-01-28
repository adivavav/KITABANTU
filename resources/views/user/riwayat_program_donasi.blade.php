@extends('layouts.app')

@section('title','Riwayat Program Donasi Saya')

@section('content')
<div class="container py-4">
  <h3 class="mb-4">Riwayat Program Donasi Saya</h3>

  @if($programs->isEmpty())
    <div class="alert alert-info">
      Kamu belum membuat program donasi.
    </div>
  @else
    <div class="row">
      @foreach($programs as $p)
        @php
          $terkumpul = $p->donasi->sum('jumlah');
          $target = (int) $p->target_dana;
          $persen = $target > 0 ? min(100, round(($terkumpul / $target) * 100)) : 0;
        @endphp

        <div class="col-md-4 mb-4">
          <div class="card h-100">
            @if($p->foto)
              <img src="{{ asset('storage/'.$p->foto) }}" class="card-img-top" style="height:180px;object-fit:cover;">
            @endif

            <div class="card-body">
              <h5 class="mb-1">{{ $p->nama_program }}</h5>
              <div class="text-muted small mb-3">
                {{ $p->tanggal_mulai }} - {{ $p->tanggal_selesai }}
              </div>

              @if($p->status_program === 'aktif')
                <div class="small text-muted">Target</div>
                <div class="fw-semibold mb-2">Rp {{ number_format($target,0,',','.') }}</div>

                <div class="small text-muted">Terkumpul</div>
                <div class="fw-semibold mb-2">Rp {{ number_format($terkumpul,0,',','.') }}</div>

                <div class="progress mb-1" style="height:8px;">
                  <div class="progress-bar" style="width: {{ $persen }}%"></div>
                </div>
                <div class="text-muted small">{{ $persen }}%</div>
              @else
                <span class="badge bg-warning text-dark">Pending</span>
                <div class="text-muted small mt-2">
                  Program belum aktif (menunggu verifikasi admin).
                </div>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
