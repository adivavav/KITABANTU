@extends('layouts.admin')
@section('title','Metode Pembayaran')

@section('content')
<div class="container-fluid">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between mb-3">
  <h1>Metode Pembayaran</h1>
  <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
    <i class="fas fa-plus"></i> Tambah
  </button>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nama Metode</th>
      <th>Keterangan</th>
      <th width="160">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data as $d)
    <tr>
      <td>{{ $d->id_metode }}</td>
      <td>{{ $d->nama_metode }}</td>
      <td>{{ $d->keterangan }}</td>
      <td>
        <button class="btn btn-warning btn-sm"
          onclick="edit({{ $d->id_metode }}, '{{ $d->nama_metode }}', '{{ $d->keterangan }}')">
          ✏️
        </button>

        <form action="{{ route('admin.metode.destroy',$d->id_metode) }}"
              method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">🗑️</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.metode.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header"><h5>Tambah Metode</h5></div>
        <div class="modal-body">
          <input name="nama_metode" class="form-control mb-2" placeholder="Nama Metode" required>
          <input name="keterangan" class="form-control" placeholder="Keterangan">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit">
  <div class="modal-dialog">
    <form method="POST" id="formEdit">
  @csrf
  @method('PUT')
      <div class="modal-content">
        <div class="modal-header"><h5>Edit Metode</h5></div>
        <div class="modal-body">
          <input name="nama_metode" id="e_nama" class="form-control mb-2" required>
          <input name="keterangan" id="e_ket" class="form-control">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function edit(id,nama,ket){
  document.getElementById('formEdit').action = '/admin/metode/'+id;
  document.getElementById('e_nama').value = nama;
  document.getElementById('e_ket').value = ket ?? '';
  $('#modalEdit').modal('show');
}
</script>
@endsection
