@extends('layouts.admin')
@section('title','Donasi')

@section('content')
<div class="container-fluid">
  <h1>Kelola Donasi</h1>

  <button class="btn btn-primary mb-3" onclick="openAdd()">+ Tambah Donasi</button>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Program</th>
        <th>Donatur</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="rows"></tbody>
  </table>
</div>

{{-- MODAL --}}
<div class="modal fade" id="modalForm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="titleModal">Tambah Donasi</h5>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_donasi">

        <div id="formTambah">
          <select id="id_donatur" class="form-control mb-2">
            <option value="">Pilih Donatur</option>
            @foreach($donatur as $d)
              <option value="{{ $d->id_donatur }}">{{ $d->nama_donatur }}</option>
            @endforeach
          </select>

          <select id="id_program" class="form-control mb-2">
            <option value="">Pilih Program</option>
            @foreach($program as $p)
              <option value="{{ $p->id_program }}">{{ $p->nama_program }}</option>
            @endforeach
          </select>

          <select id="id_metode" class="form-control mb-2">
            @foreach($metode as $m)
              <option value="{{ $m->id_metode }}">{{ $m->nama_metode }}</option>
            @endforeach
          </select>

          <input id="jumlah_donasi" class="form-control mb-2" placeholder="Jumlah Donasi">
        </div>

        <select id="status_donasi" class="form-control">
          <option value="pending">Pending</option>
          <option value="sukses">Sukses</option>
        </select>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary" onclick="save()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
const BASE = '/admin/donasi';

function req(url,opt={}) {
  opt.headers={
    'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content,
    'Accept':'application/json'
  };
  return fetch(url,opt);
}

async function load(){
  const r = await req(`${BASE}/data`);
  const j = await r.json();

  rows.innerHTML='';
  j.data.forEach(d=>{
    rows.innerHTML+=`
<tr>
<td>${d.id_donasi}</td>
<td>${d.program?.nama_program ?? '-'}</td>
<td>${d.donatur?.nama_donatur ?? '-'}</td>
<td>Rp ${Number(d.jumlah_donasi).toLocaleString()}</td>
<td>${d.status_donasi}</td>
<td>
<button class="btn btn-warning btn-sm" onclick="openEdit(${d.id_donasi},'${d.status_donasi}')">✏️</button>
<button class="btn btn-danger btn-sm" onclick="del(${d.id_donasi})">🗑️</button>
</td>
</tr>`;
  });
}

function openAdd(){
  titleModal.innerText='Tambah Donasi';
  id_donasi.value='';
  formTambah.style.display='block';
  $('#modalForm').modal('show');
}

function openEdit(id,status){
  titleModal.innerText='Edit Status';
  id_donasi.value=id;
  status_donasi.value=status;
  formTambah.style.display='none';
  $('#modalForm').modal('show');
}

async function save(){
  const fd=new FormData();
  fd.append('status_donasi',status_donasi.value);

  if(!id_donasi.value){
    fd.append('id_donatur',id_donatur.value);
    fd.append('id_program',id_program.value);
    fd.append('id_metode',id_metode.value);
    fd.append('jumlah_donasi',jumlah_donasi.value);
  }

  const url=id_donasi.value?`${BASE}/${id_donasi.value}`:BASE;
  await req(url,{method:'POST',body:fd});
  $('#modalForm').modal('hide');
  load();
}

async function del(id){
  if(!confirm('Hapus donasi?'))return;
  await req(`${BASE}/${id}`,{method:'DELETE'});
  load();
}

load();
</script>
@endsection
