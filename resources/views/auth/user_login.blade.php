@extends('layouts.app')
@section('title','Login')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h4 class="mb-3">Login User</h4>

          @if($errors->any())
            <div class="alert alert-danger">
              {{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('user.login.post') }}">
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
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
