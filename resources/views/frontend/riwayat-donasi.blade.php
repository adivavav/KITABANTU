@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">Riwayat Donasi Saya</h3>

    @if ($riwayat->isEmpty())
        <div class="alert alert-info">
            Belum ada riwayat donasi.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
<tr>
  <th>Tanggal</th>
  <th>Program</th>
  <th>Jumlah</th>
  <th>Status</th>
  <th>Aksi</th>
</tr>
</thead>

<tbody>
@foreach ($riwayat as $row)
<tr>
  <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y H:i') }}</td>
  <td>{{ $row->program }}</td>
  <td>Rp {{ number_format($row->jumlah,0,',','.') }}</td>
  <td>
    <span class="badge bg-{{ $row->status == 'sukses' ? 'success' : 'warning' }}">
      {{ ucfirst($row->status) }}
    </span>
  </td>
  <td>
    <a href="{{ route('donasi.struk', $row->id_donasi) }}"
       class="btn btn-sm btn-outline-primary">
       Lihat Struk
    </a>
  </td>
</tr>
@endforeach
</tbody>

            </table>
        </div>
    @endif
</div>
@endsection
