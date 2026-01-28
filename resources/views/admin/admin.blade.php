@extends('layouts.admin')
@section('title', 'Admin')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Admin</h1>
        <button class="btn btn-primary" onclick="openCreate()">
            <i class="fas fa-plus"></i> Tambah Admin
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif


    {{-- TABEL ADMIN --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Admin</th>
                            <th>Username</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admin as $a)
                        <tr>
                            <td>{{ $a->id_admin }}</td>
                            <td>{{ $a->nama_admin }}</td>
                            <td>{{ $a->username }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="openEdit(
                                        {{ $a->id_admin }},
                                        '{{ $a->nama_admin }}',
                                        '{{ $a->username }}'
                                    )">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.admin.destroy', $a->id_admin) }}"
                                      method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus admin?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $admin->links() }}
</div>

{{-- MODAL --}}
<div class="modal fade" id="adminModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="adminForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Admin</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Nama Admin</label>
                        <input type="text" name="nama_admin" id="nama_admin"
                               class="form-control" required>
                    </div>

                    <div class="form-group mb-2">
                        <label>Username</label>
                        <input type="text" name="username" id="username"
                               class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Password
                            <small id="pwdNote" class="text-muted">(wajib diisi)</small>
                        </label>
                        <input type="password" name="password" id="password"
                               class="form-control">
                    </div>
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

{{-- JAVASCRIPT --}}
<script>
function openCreate(){
    $('#adminModal').modal('show');
    document.getElementById('modalTitle').innerText = 'Tambah Admin';
    document.getElementById('adminForm').action = "{{ route('admin.admin.store') }}";
    document.getElementById('formMethod').value = '';
    document.getElementById('btnSubmit').innerText = 'Simpan';

    document.getElementById('nama_admin').value = '';
    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
    document.getElementById('pwdNote').innerText = '(wajib diisi)';
}

function openEdit(id, nama, username){
    $('#adminModal').modal('show');
    document.getElementById('modalTitle').innerText = 'Edit Admin';
    document.getElementById('adminForm').action = `/admin/admin/${id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('btnSubmit').innerText = 'Update';

    document.getElementById('nama_admin').value = nama;
    document.getElementById('username').value = username;
    document.getElementById('password').value = '';
    document.getElementById('pwdNote').innerText = '(kosongkan jika tidak diubah)';
}
</script>
@endsection
