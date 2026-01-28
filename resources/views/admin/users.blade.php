@extends('layouts.admin')
@section('title','Users')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between mb-3">
    <h1>Kelola Users</h1>
    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCreate">
      + Tambah User
    </button>
  </div>

  {{-- NOTIF --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
  <div class="alert alert-danger">
    {{ $errors->first() }}
  </div>
@endif


  <table class="table table-hover">
    <thead>
      <tr>
        <th width="60">ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th width="140">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $u)
      <tr>
        <td>{{ $u->id }}</td>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>
          <button 
            class="btn btn-sm btn-warning"
            data-toggle="modal"
            data-target="#modalEdit{{ $u->id }}">
            ✏️
          </button>

          <form 
            action="{{ route('admin.users.destroy',$u->id) }}"
            method="POST"
            style="display:inline"
            onsubmit="return confirm('Hapus user ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">🗑️</button>
          </form>
        </td>
      </tr>

      {{-- MODAL EDIT --}}
      <div class="modal fade" id="modalEdit{{ $u->id }}">
        <div class="modal-dialog">
          <form method="POST" action="{{ route('admin.users.update',$u->id) }}">
            @csrf
            <div class="modal-content">
              <div class="modal-header">
                <h5>Edit User</h5>
                <button class="close" data-dismiss="modal">&times;</button>
              </div>

              <div class="modal-body">
                <input name="name" class="form-control mb-2"
                  value="{{ $u->name }}" required>

                <input name="email" type="email" class="form-control mb-2"
                  value="{{ $u->email }}" required>

                <input name="password" type="password"
                  class="form-control"
                  placeholder="Password baru (opsional)">
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      @empty
      <tr>
        <td colspan="4" class="text-center text-muted">Belum ada user</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="modalCreate">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5>Tambah User</h5>
          <button class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <input name="name" class="form-control mb-2"
            placeholder="Nama" required>

          <input name="email" type="email" class="form-control mb-2"
            placeholder="Email" required>

          <input name="password" type="password"
            class="form-control"
            placeholder="Password" required>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
