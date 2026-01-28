@extends('layouts.app')
@section('title','Donasi')

@section('content')
  <h3 class="fw-bold mb-3">Program Donasi</h3>

  <div class="row g-3">
    @foreach($programs as $p)
      <div class="col-md-6 col-lg-4">
        <div class="card card-soft h-100">
          <div class="card-body">
            <h5 class="fw-bold">{{ $p->nama_program }}</h5>

            <div class="small text-muted">
              Terkumpul:
              <strong>Rp {{ number_format($p->total_terkumpul,0,',','.') }}</strong>
            </div>

            <div class="progress my-2" style="height:10px;">
              <div class="progress-bar"
                   style="width: {{ $p->persentase_pencapaian }}%">
              </div>
            </div>

            <div class="small text-muted mb-3">
              Target: Rp {{ number_format($p->target_dana,0,',','.') }}
              ({{ $p->persentase_pencapaian }}%)
            </div>

            <a class="btn btn-primary w-100" href="{{ route('donasi.detail', $p->id_program) }}">
                Donasi Sekarang
            </a>

          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
