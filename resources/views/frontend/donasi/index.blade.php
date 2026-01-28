@extends('layouts.app')
@section('title','Donasi')

@section('content')
<div class="container py-4">
  <h3 class="mb-4">Program Donasi Aktif</h3>

  <div class="row">
    @foreach($programs as $p)
      <div class="col-md-4 mb-4">
        <div class="card h-100">

          @if($p->foto)
            <img src="{{ asset('storage/'.$p->foto) }}" class="card-img-top"
                 style="height:200px;object-fit:cover;">
          @endif

          <div class="card-body">
            <h5 class="card-title">{{ $p->nama_program }}</h5>
            <p class="text-muted">{{ \Illuminate\Support\Str::limit($p->deskripsi, 80) }}</p>

            <div><small class="text-muted">Target</small><br>
              <b>Rp {{ number_format($p->target_dana,0,',','.') }}</b>
            </div>

            <div class="mt-2"><small class="text-muted">Terkumpul</small><br>
              <b>Rp {{ number_format($p->terkumpul,0,',','.') }}</b>
            </div>

            <div class="progress mt-2" style="height:10px;">
              <div class="progress-bar" style="width: {{ $p->progress }}%"></div>
            </div>
            <small class="text-muted">{{ $p->progress }}%</small>

            <a href="{{ route('donasi.detail', $p->id_program) }}" class="btn btn-primary btn-block mt-3">
              Lihat Detail
            </a>
          </div>

        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
