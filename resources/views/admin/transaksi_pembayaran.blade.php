@extends('layouts.admin')
@section('title','Transaksi Pembayaran')

@section('content')
<div class="container-fluid">
    <h1 class="mb-3">Kelola Transaksi Pembayaran</h1>

    <button class="btn btn-primary mb-3" onclick="openAdd()">+ Tambah Transaksi</button>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Donasi</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th width="140">Aksi</th>
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
    <h5 id="modalTitle">Tambah Transaksi</h5>
    <button class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
<input type="hidden" id="id">

<select id="id_donasi" class="form-control mb-2">
@foreach($donasi as $d)
<option value="{{ $d->id_donasi }}">
#{{ $d->id_donasi }} - Rp {{ number_format($d->jumlah_donasi) }}
</option>
@endforeach
</select>

<select id="metode_pembayaran" class="form-control mb-2">
@foreach($metode as $m)
<option value="{{ $m->nama_metode }}">{{ $m->nama_metode }}</option>
@endforeach
</select>

<select id="status_pembayaran" class="form-control mb-2">
<option value="pending">Pending</option>
<option value="lunas">Lunas</option>
<option value="gagal">Gagal</option>
</select>

<input type="date" id="tanggal_bayar" class="form-control">
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
const BASE = '/admin/transaksi-pembayaran';

function req(url,opt={}){
    opt.headers = {
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
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
<td>${d.id_transaksi}</td>
<td>#${d.id_donasi}</td>
<td>${d.metode_pembayaran}</td>
<td>${d.status_pembayaran}</td>
<td>${d.tanggal_bayar ?? '-'}</td>
<td>
<button class="btn btn-warning btn-sm"
onclick="openEdit(${d.id_transaksi},'${d.metode_pembayaran}','${d.status_pembayaran}','${d.tanggal_bayar ?? ''}')">✏️</button>
<button class="btn btn-danger btn-sm"
onclick="del(${d.id_transaksi})">🗑️</button>
</td>
</tr>`;
    });
}

function openAdd(){
    id.value='';
    $('#modalForm').modal('show');
}

function openEdit(i,m,s,t){
    id.value=i;
    metode_pembayaran.value=m;
    status_pembayaran.value=s;
    tanggal_bayar.value=t;
    $('#modalForm').modal('show');
}

async function save(){
    const fd=new FormData();
    fd.append('id_donasi',id_donasi.value);
    fd.append('metode_pembayaran',metode_pembayaran.value);
    fd.append('status_pembayaran',status_pembayaran.value);
    fd.append('tanggal_bayar',tanggal_bayar.value);

    let url=BASE;
    if(id.value) url+='/'+id.value;

    const r=await req(url,{method:'POST',body:fd});
    const j=await r.json();
    alert(j.message);
    $('#modalForm').modal('hide');
    load();
}

async function del(i){
    if(!confirm('Hapus transaksi ini?'))return;
    const r=await req(`${BASE}/${i}`,{method:'DELETE'});
    const j=await r.json();
    alert(j.message);
    load();
}

load();
</script>
@endsection
