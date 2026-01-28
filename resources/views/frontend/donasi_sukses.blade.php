@extends('layouts.app')
@section('title','Sukses')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card shadow-sm">
        <div class="card-body">

          <h4 class="text-center text-success mb-3">
            Donasi Berhasil Dibuat
          </h4>

          <hr>

          <p><b>Program</b><br>
            {{ $donasi->program->nama_program }}
          </p>

          <p><b>Nama Donatur</b><br>
            {{ $donasi->donatur->nama_donatur }}
          </p>

          <p><b>Jumlah Donasi</b><br>
            Rp {{ number_format($donasi->jumlah_donasi,0,',','.') }}
          </p>

          <p><b>Metode Pembayaran</b><br>
            {{ $donasi->metode->nama_metode }}
          </p>

          <p><b>Status Donasi</b><br>
            @if($donasi->status_donasi === 'sukses')
              <span class="badge bg-success">Sukses</span>
            @else
              <span class="badge bg-warning">Pending</span>
            @endif
          </p>

          <p><b>Tanggal</b><br>
            {{ \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d M Y H:i') }}
          </p>

          <hr>

          <a href="{{ route('riwayat.donasi') }}" class="btn btn-primary w-100">
            Lihat Riwayat Donasi
          </a>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection
