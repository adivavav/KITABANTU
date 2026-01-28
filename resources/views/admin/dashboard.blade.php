@extends('layouts.admin')
@section('title','Dashboard')

@push('styles')
<style>
  .small-box .icon { top: 10px; }
  .table td, .table th { vertical-align: middle; }
</style>
@endpush

@section('content')
<div class="container-fluid">

  <h1 class="mb-3">Dashboard</h1>

  {{-- INFO BOX --}}
  <div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $totalDonatur }}</h3>
          <p>Donatur</p>
        </div>
        <div class="icon"><i class="fas fa-users"></i></div>
        <a href="/admin/donatur" class="small-box-footer">More info</a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $totalAdmin }}</h3>
          <p>Admin</p>
        </div>
        <div class="icon"><i class="fas fa-user-shield"></i></div>
        <a href="/admin/admin" class="small-box-footer">More info</a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $totalProgram }}</h3>
          <p>Program Donasi</p>
        </div>
        <div class="icon"><i class="fas fa-hand-holding-heart"></i></div>
        <a href="/admin/program" class="small-box-footer">More info</a>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>Rp {{ number_format($totalDonasi,0,',','.') }}</h3>
          <p>Total Donasi Berhasil</p>
        </div>
        <div class="icon"><i class="fas fa-coins"></i></div>
        <a href="/admin/transaksi-pembayaran" class="small-box-footer">More info</a>
      </div>
    </div>
  </div>

  {{-- GRAFIK DONASI BULANAN --}}
  <div class="card mb-3">
    <div class="card-header">
      <b>Grafik Donasi Bulanan (Berhasil)</b>
    </div>
    <div class="card-body">
      <canvas id="donasiChart" height="120"></canvas>
    </div>
  </div>

  {{-- DONASI TERBESAR --}}
  <div class="card mb-3">
    <div class="card-header"><b>Donasi Terbesar</b></div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Donatur</th>
            <th>Program</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody>
          @forelse($donasiTerbesar as $d)
          <tr>
            <td>{{ $d->id_donasi }}</td>
            <td>{{ $d->donatur->nama_donatur ?? '-' }}</td>
            <td>{{ $d->program->nama_program ?? '-' }}</td>
            <td>Rp {{ number_format($d->jumlah_donasi,0,',','.') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center text-muted">Data kosong</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- PROGRAM AKTIF --}}
  <div class="card mb-3">
    <div class="card-header"><b>Program Aktif</b></div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama Program</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($programAktif as $p)
          <tr>
            <td>{{ $p->id_program }}</td>
            <td>{{ $p->nama_program }}</td>
            <td>
              <span class="badge badge-success">{{ $p->status_program }}</span>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="3" class="text-center text-muted">Tidak ada</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- RINGKASAN --}}
  <div class="card mb-3">
    <div class="card-header"><b>Ringkasan</b></div>
    <div class="card-body">
      <p>Donasi sukses: <b>{{ $donasiSukses }}</b></p>
      <p>Donasi pending: <b>{{ $donasiPending }}</b></p>
      <p>Donasi gagal: <b>{{ $donasiGagal }}</b></p>
    </div>
  </div>

</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
const labels = @json($donasiBulanan->pluck('bulan'));
const values = @json($donasiBulanan->pluck('total'));

new Chart(document.getElementById('donasiChart'), {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{
      label: 'Total Donasi (Rp)',
      data: values,
      borderColor: '#007bff',
      backgroundColor: 'rgba(0,123,255,0.2)',
      fill: true,
      tension: 0.3
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: true }
    },
    scales: {
      y: {
        ticks: {
          callback: value => 'Rp ' + value.toLocaleString('id-ID')
        }
      }
    }
  }
});
</script>
@endsection
