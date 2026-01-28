@extends('layouts.admin')
@section('title','Program Donasi')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between mb-3">
    <h1>Program Donasi</h1>
    <button class="btn btn-primary" onclick="openCreate()">+ Tambah Program</button>
  </div>
   @if($errors->any())
  <div class="alert alert-danger">
    {{ $errors->first() }}
  </div>
@endif

  <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Foto</th>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Target</th>
        <th>Mulai</th>
        <th>Selesai</th>
        <th>Status</th>
        <th width="120">Aksi</th>
      </tr>
    </thead>
    <tbody id="rows">
      <tr><td colspan="9" class="text-center text-muted p-3">Loading...</td></tr>
    </tbody>
  </table>

  <div class="d-flex justify-content-between">
    <span id="meta">-</span>
    <div>
      <button class="btn btn-sm btn-outline-secondary" onclick="prevPage()">Prev</button>
      <button class="btn btn-sm btn-outline-secondary" onclick="nextPage()">Next</button>
    </div>
  </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="modalForm">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalTitle">Tambah Program</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="id_program">

        <input id="nama_program" class="form-control mb-2" placeholder="Nama Program">
        <textarea id="deskripsi" class="form-control mb-2" placeholder="Deskripsi"></textarea>

        <div class="row">
          <div class="col">
            <input id="target_dana" type="number" class="form-control mb-2" placeholder="Target Dana">
          </div>
          <div class="col">
            <input id="tanggal_mulai" type="date" class="form-control mb-2">
          </div>
          <div class="col">
            <input id="tanggal_selesai" type="date" class="form-control mb-2">
          </div>
        </div>

        <select id="status_program" class="form-control mb-2">
          <option value="aktif">Aktif</option>
          <option value="selesai">Selesai</option>
        </select>

        <input type="file" id="foto" class="form-control mb-2">
        <img id="fotoPreview" style="max-height:80px;display:none;border-radius:6px">

        <div class="alert alert-danger d-none" id="errBox"></div>
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
let page = 1, lastPage = 1;

const BASE_DATA = '/admin/program/data';
const BASE_CRUD = '/admin/program';

function token(){
  return document.querySelector('meta[name=csrf-token]').content;
}

function req(url, opt = {}) {
  opt.headers = {
    'X-CSRF-TOKEN': token(),
    'Accept': 'application/json'
  };
  return fetch(url, opt);
}

function openCreate(){
  modalTitle.innerText = 'Tambah Program';
  id_program.value = '';
  nama_program.value = '';
  deskripsi.value = '';
  target_dana.value = '';
  tanggal_mulai.value = '';
  tanggal_selesai.value = '';
  status_program.value = 'aktif';
  foto.value = '';
  fotoPreview.style.display = 'none';
  $('#modalForm').modal('show');
}

async function openEdit(id){
  const r = await req(`${BASE_CRUD}/${id}`);
  const d = await r.json();

  modalTitle.innerText = 'Edit Program';
  id_program.value = d.id_program;
  nama_program.value = d.nama_program;
  deskripsi.value = d.deskripsi;
  target_dana.value = d.target_dana;
  tanggal_mulai.value = d.tanggal_mulai;
  tanggal_selesai.value = d.tanggal_selesai ?? '';
  status_program.value = d.status_program;

  if(d.foto){
    fotoPreview.src = `/storage/${d.foto}`;
    fotoPreview.style.display = 'block';
  }

  $('#modalForm').modal('show');
}

async function save(){
  const fd = new FormData();
  ['nama_program','deskripsi','target_dana','tanggal_mulai','tanggal_selesai','status_program']
    .forEach(i => fd.append(i, window[i].value));

  if(foto.files[0]) fd.append('foto', foto.files[0]);

  const id = id_program.value;
  const url = id ? `${BASE_CRUD}/${id}` : BASE_CRUD;

  if(id) fd.append('_method','POST');

  const r = await req(url, { method:'POST', body:fd });

  if(!r.ok){
    alert('Gagal menyimpan data');
    return;
  }

  $('#modalForm').modal('hide');
  load();
}

async function del(id){
  if(!confirm('Hapus program ini?')) return;
  await req(`${BASE_CRUD}/${id}`, { method:'DELETE' });
  load();
}

async function load(p = 1){
  page = p;
  const url = new URL(BASE_DATA, location.origin);
  url.searchParams.set('page', page);

  const r = await req(url);
  const j = await r.json();

  lastPage = j.last_page;
  rows.innerHTML = '';

  j.data.forEach(p => {
    rows.innerHTML += `
      <tr>
        <td>${p.id_program}</td>
        <td>${p.foto ? `<img src="/storage/${p.foto}" height="40" style="border-radius:6px">` : '-'}</td>
        <td>${p.nama_program}</td>
        <td>${p.deskripsi}</td>
        <td>Rp ${Number(p.target_dana).toLocaleString('id-ID')}</td>
        <td>${p.tanggal_mulai}</td>
        <td>${p.tanggal_selesai ?? '-'}</td>
        <td>
          <span class="badge badge-${p.status_program === 'aktif' ? 'success' : 'secondary'}">
            ${p.status_program}
          </span>
        </td>
        <td>
          <button class="btn btn-sm btn-warning" onclick="openEdit(${p.id_program})">✏️</button>
          <button class="btn btn-sm btn-danger" onclick="del(${p.id_program})">🗑️</button>
        </td>
      </tr>`;
  });

  meta.innerText = `Page ${j.current_page} / ${j.last_page}`;
}

function prevPage(){ if(page > 1) load(page - 1); }
function nextPage(){ if(page < lastPage) load(page + 1); }

load();
</script>


@endsection
