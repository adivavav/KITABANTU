@extends('layouts.app')
@section('title','Bukti Donasi')

@section('content')
<div class="container py-4 print-area">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card shadow-sm">
        <div class="card-body">

          <h4 class="text-center mb-3">
            @if($donasi->status_donasi === 'sukses')
              <span class="text-success">Donasi Berhasil</span>
            @else
              <span class="text-warning">Menunggu Konfirmasi Admin</span>
            @endif
          </h4>

          <hr>

          <p><b>Program</b><br>{{ $donasi->program->nama_program }}</p>
          <p><b>Donatur</b><br>{{ $donasi->donatur->nama_donatur }}</p>

          <p><b>Jumlah</b><br>
            Rp {{ number_format($donasi->jumlah_donasi,0,',','.') }}
          </p>

          <p><b>Metode Pembayaran</b><br>
            {{ $donasi->metode->nama_metode }}
          </p>

          <p><b>Status Donasi</b><br>
            @if($donasi->status_donasi === 'sukses')
              <span class="badge bg-success">SUKSES</span>
            @else
              <span class="badge bg-warning text-dark">PENDING</span>
            @endif
          </p>

          <p><b>Status Pembayaran</b><br>
@if($transaksi)
    <span class="badge bg-{{ $transaksi->status_pembayaran == 'lunas' ? 'success' : 'warning' }}">
        {{ ucfirst($transaksi->status_pembayaran) }}
    </span>
@else
    <span class="badge bg-secondary">Belum ada transaksi</span>
@endif
</p>


          <p><b>Tanggal</b><br>
            {{ \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d M Y H:i') }}
          </p>

          <hr>

          <div class="d-flex gap-2 no-print">
            <a href="{{ route('riwayat.donasi') }}" class="btn btn-primary w-100">
              Riwayat Donasi
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary w-100">
              Cetak
            </button>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<style>
@media print {
  .no-print,
  nav,
  footer {
    display: none !important;
  }

  body {
    background: #fff;
  }

  .print-area {
    margin-top: 0;
  }

  .card {
    border: none;
    box-shadow: none;
  }
}
</style>
@endsection
