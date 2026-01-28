@extends('layouts.app')
@section('title','Login')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">

      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h4 class="mb-3 font-weight-bold">Login</h4>

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">
              {{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('login.post') }}">

            @csrf

            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary btn-block">
              <i class="fas fa-sign-in-alt mr-1"></i> Login
            </button>

            <div class="text-center mt-3">
              <small class="text-muted">Belum punya akun? (register)</small>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection
