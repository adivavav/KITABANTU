<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin') - DONASI</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <!-- (Opsional tapi bagus) OverlayScrollbars CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.3/css/OverlayScrollbars.min.css">

  @stack('styles')
@push('styles')
<style>
  .table-responsive{
    overflow-x:auto;
    -webkit-overflow-scrolling: touch;
  }
</style>
@endpush

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
      <li class="nav-item">
        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand (atas) -->
  <a href="/admin/dashboard" class="brand-link">
    <span class="brand-text font-weight-light">KITABANTU ADMIN</span>
  </a>

  <!-- User Panel (profil) -->
  <div class="sidebar">
    @php
  $nama = session('admin_nama') ?? 'Admin';
  $fotoPath = session('admin_foto');
  $foto = $fotoPath ? asset('storage/'.$fotoPath) : asset('assets/img/default-user.png');
@endphp
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
  <div class="image">
    <img src="{{ $foto }}" class="img-circle elevation-2" style="width:35px;height:35px;object-fit:cover;" alt="User Image">
  </div>
  <div class="info">
    <a href="{{ route('admin.profile') }}" class="d-block">{{ $nama }}</a>
         <small class="text-muted">
      {{ session('admin_username') }}
    </small>
      </div>
    </div>

    <!-- nav menu kamu tetap lanjut di bawah ini -->
    <nav class="mt-2">

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

          <li class="nav-item">
            <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/donatur" class="nav-link {{ request()->is('admin/donatur') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Donatur</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/admin" class="nav-link {{ request()->is('admin/admin') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>Admin</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/users" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>Users</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="/admin/program" class="nav-link {{ request()->is('admin/program') ? 'active' : '' }}">
              <i class="nav-icon fas fa-donate"></i>
              <p>Program Donasi</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/donasi" class="nav-link {{ request()->is('admin/donasi') ? 'active' : '' }}">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>Donasi</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/transaksi-pembayaran" class="nav-link {{ request()->is('admin/transaksi-pembayaran') ? 'active' : '' }}">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>Transaksi Pembayaran</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/komentar" class="nav-link {{ request()->is('admin/komentar') ? 'active' : '' }}">
              <i class="nav-icon fas fa-comments"></i>
              <p>Komentar Donasi</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/admin/metode" class="nav-link {{ request()->is('admin/metode') ? 'active' : '' }}">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>Metode Pembayaran</p>
            </a>
          </li>

  </ul>
</li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Kitabantu</strong> &copy; {{ date('Y') }}  
<span class="text-muted">Menyalurkan kebaikan dengan aman & transparan</span>

  </footer>

</div>

<!--  JS: URUTAN WAJIB -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- OverlayScrollbars (setelah jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@1.13.3/js/jquery.overlayScrollbars.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>
