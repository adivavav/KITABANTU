@extends('layouts.admin')
@section('title','Komentar Donasi')

@section('content')
<div class="container-fluid">
    <h1 class="mb-3">Kelola Komentar Donasi</h1>

    <button class="btn btn-success mb-3" onclick="openAdd()">
        ➕ Tambah Komentar
    </button>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Donasi</th>
                <th>Nama</th>
                <th>Komentar</th>
                <th>Tanggal</th>
                <th width="120">Aksi</th>
            </tr>
        </thead>
        <tbody id="rows">
            <tr>
                <td colspan="6" class="text-center">Loading...</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- MODAL --}}
<div class="modal fade" id="modalForm">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="modalTitle">Tambah Komentar</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="id_komentar">

                <div class="form-group">
                    <label>Donasi</label>
                    <select id="id_donasi" class="form-control">
                        @foreach($donasi as $d)
                            <option value="{{ $d->id_donasi }}">
                                #{{ $d->id_donasi }} - Rp {{ number_format($d->jumlah_donasi) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Pengirim</label>
                    <input type="text" id="nama_pengirim" class="form-control">
                </div>

                <div class="form-group">
                    <label>Komentar</label>
                    <textarea id="isi_komentar" class="form-control" rows="4"></textarea>
                </div>
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
const BASE = '/admin/komentar';

function token(){
    return document.querySelector('meta[name=csrf-token]').content;
}

function req(url, opt = {}){
    opt.headers = {
        'X-CSRF-TOKEN': token(),
        'Accept': 'application/json'
    };
    return fetch(url, opt);
}

async function load(){
    const r = await req(`${BASE}/data`);
    const j = await r.json();

    rows.innerHTML = '';

    j.data.forEach(d => {
        rows.innerHTML += `
        <tr>
            <td>${d.id_komentar}</td>
            <td>#${d.id_donasi}</td>
            <td>${d.nama_pengirim ?? '-'}</td>
            <td>${d.isi_komentar}</td>
            <td>${d.tanggal_komentar ?? '-'}</td>
            <td>
                <button class="btn btn-warning btn-sm"
                    onclick="openEdit(${d.id_komentar},
                    '${d.id_donasi}',
                    '${d.nama_pengirim ?? ''}',
                    \`${d.isi_komentar}\`)">✏️</button>

                <button class="btn btn-danger btn-sm"
                    onclick="del(${d.id_komentar})">🗑️</button>
            </td>
        </tr>`;
    });
}

function openAdd(){
    modalTitle.innerText = 'Tambah Komentar';
    id_komentar.value = '';
    nama_pengirim.value = '';
    isi_komentar.value = '';
    $('#modalForm').modal('show');
}

function openEdit(id, idDonasi, nama, isi){
    modalTitle.innerText = 'Edit Komentar';
    id_komentar.value = id;
    id_donasi.value = idDonasi;
    nama_pengirim.value = nama;
    isi_komentar.value = isi;
    $('#modalForm').modal('show');
}

async function save(){
    const fd = new FormData();
    fd.append('id_donasi', id_donasi.value);
    fd.append('nama_pengirim', nama_pengirim.value);
    fd.append('isi_komentar', isi_komentar.value);

    let url = BASE;
    if(id_komentar.value){
        url += '/' + id_komentar.value;
    }

    const r = await req(url, {
        method: 'POST',
        body: fd
    });

    const j = await r.json();
    alert(j.message);

    $('#modalForm').modal('hide');
    load();
}

async function del(id){
    if(!confirm('Hapus komentar ini?')) return;

    const r = await req(`${BASE}/${id}`, { method:'DELETE' });
    const j = await r.json();

    alert(j.message);
    load();
}

load();
</script>
@endsection
