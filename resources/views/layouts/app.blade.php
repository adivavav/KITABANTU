<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'KITABANTU')</title>

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">

  <style>
    body { background:#f7f7f7; }
    .navbar-brand { font-weight: 800; letter-spacing: .5px; }
    .navbar { background:#fff; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
    .nav-link { font-weight: 500; }
    .dropdown-item button { width:100%; text-align:left; }
  </style>

  @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <i class="fas fa-hands-helping text-primary mr-1"></i> KITABANTU
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navBar">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{ request()->is('donasi') ? 'active' : '' }}" href="{{ route('donasi') }}">Donasi</a>
        </li>

        

        {{-- RIWAYAT DONASI (MENU ATAS) --}}
        @auth
          <li class="nav-item">
            <a class="nav-link {{ request()->is('riwayat-donasi') ? 'active' : '' }}"
               href="{{ route('riwayat.donasi') }}">
              <i class="fas fa-receipt mr-1"></i> Riwayat Donasi
            </a>
          </li>
        @endauth

        <li class="nav-item">
          <a class="nav-link {{ request()->is('tentang_kami') ? 'active' : '' }}" href="{{ route('tentang.kami') }}">Tentang Kami</a>
        </li>

        {{-- MENU LOGIN / DROPDOWN USER --}}
        @if(auth()->check())
          @php
            $navPhoto = auth()->user()->photo
              ? asset('storage/'.auth()->user()->photo)
              : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0D6EFD&color=fff';
          @endphp

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center"
               href="#"
               id="userMenu"
               role="button"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">
              <img src="{{ $navPhoto }}" class="rounded-circle mr-2" width="26" height="26" alt="user">
              <span>{{ auth()->user()->name }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
              <a class="dropdown-item" href="{{ route('user.profile') }}">
                <i class="fas fa-id-badge mr-1"></i> Profil
              </a>

              <a class="dropdown-item" href="{{ route('user.program_donasi.create') }}">
                <i class="fas fa-plus-circle mr-1"></i> Buat Program Donasi
              </a>

              {{-- ✅ TAMBAHAN: RIWAYAT DONASI SAYA --}}
            <a class="dropdown-item" href="{{ route('user.program_donasi.riwayat') }}">
              <i class="fas fa-receipt mr-1"></i> Riwayat Program Donasi Saya
            </a>


              <div class="dropdown-divider"></div>

              <form action="{{ route('user.logout') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="dropdown-item">
                  <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
              </form>
            </div>
          </li>
       @else
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle"
       href="#"
       id="guestMenu"
       role="button"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
      <i class="fas fa-user-circle mr-1"></i> Login/Register
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="guestMenu">
      <a class="dropdown-item {{ request()->is('login') ? 'active' : '' }}"
         href="{{ route('login') }}">
        <i class="fas fa-sign-in-alt mr-1"></i> Login
      </a>

      <a class="dropdown-item {{ request()->is('register') ? 'active' : '' }}"
         href="{{ route('register') }}">
        <i class="fas fa-user-plus mr-1"></i> Register
      </a>
    </div>
  </li>
@endif

      </ul>
    </div>
  </div>
</nav>

<main class="py-4">
  @yield('content')
</main>

<footer class="text-center text-muted py-4">
  <div class="container">
    <small>© {{ date('Y') }} <b>KITABANTU</b> — Platform Donasi</small>
  </div>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
