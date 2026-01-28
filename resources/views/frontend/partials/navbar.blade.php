<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
      <span class="text-primary">●</span> KITABANTU
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('home') ? 'fw-semibold text-primary' : '' }}" href="{{ route('home') }}">
            Beranda
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('donasi') ? 'fw-semibold text-primary' : '' }}" href="{{ route('donasi') }}">
            Donasi
          </a>
        </li>

        <li class="nav-item ms-lg-2">
          @if(auth()->check())
            <form method="POST" action="{{ route('user.logout') }}">
              @csrf
              <button class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
          @else
            <a class="btn btn-outline-primary btn-sm" href="{{ route('user.login') }}">Login</a>
          @endif
        </li>
      </ul>
    </div>
  </div>
</nav>
