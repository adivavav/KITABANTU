@extends('layouts.admin')
@section('title', 'Donatur')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Donatur</h1>
        <button class="btn btn-primary" onclick="openCreate()">
            + Tambah Donatur
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donatur as $d)
                    <tr>
                        <td>{{ $d->id_donatur }}</td>
                        <td>{{ $d->nama_donatur }}</td>
                        <td>{{ $d->email }}</td>
                        <td>{{ $d->no_hp }}</td>
                        <td>{{ $d->alamat }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                onclick="openEdit(
                                    {{ $d->id_donatur }},
                                    '{{ $d->nama_donatur }}',
                                    '{{ $d->email }}',
                                    '{{ $d->no_hp }}',
                                    '{{ $d->alamat }}'
                                )">
                                ✏️
                            </button>

                            <form action="{{ route('admin.donatur.destroy', $d->id_donatur) }}"
                                  method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus donatur?')">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $donatur->links() }}
</div>

{{-- MODAL --}}
<div class="modal fade" id="donaturModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="donaturForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Donatur</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="text" name="nama_donatur" id="nama_donatur"
                           class="form-control mb-2" placeholder="Nama" required>

                    <input type="email" name="email" id="email"
                           class="form-control mb-2" placeholder="Email">

                    <input type="text" name="no_hp" id="no_hp"
                           class="form-control mb-2" placeholder="No HP">

                    <textarea name="alamat" id="alamat"
                              class="form-control" placeholder="Alamat"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-primary" id="btnSubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreate(){
    $('#donaturModal').modal('show');
    document.getElementById('modalTitle').innerText = 'Tambah Donatur';
    document.getElementById('donaturForm').action = "{{ route('admin.donatur.store') }}";
    document.getElementById('formMethod').value = '';
    document.getElementById('btnSubmit').innerText = 'Simpan';

    nama_donatur.value = email.value = no_hp.value = alamat.value = '';
}

function openEdit(id, nama, emailVal, hp, alamatVal){
    $('#donaturModal').modal('show');
    document.getElementById('modalTitle').innerText = 'Edit Donatur';
    document.getElementById('donaturForm').action = `/admin/donatur/${id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('btnSubmit').innerText = 'Update';

    nama_donatur.value = nama;
    email.value = emailVal;
    no_hp.value = hp;
    alamat.value = alamatVal;
}
</script>
@endsection
