@extends('layouts.app')
@section('title','Beranda')

@php
  use Illuminate\Support\Str;
@endphp

@section('content')

<div class="container">

  {{-- ================= CAROUSEL HERO ================= --}}
  <div id="heroCarousel" class="carousel slide hero-carousel mb-5"
       data-ride="carousel" data-interval="4000">

    <ol class="carousel-indicators">
      <li data-target="#heroCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#heroCarousel" data-slide-to="1"></li>
      <li data-target="#heroCarousel" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner rounded-lg shadow">

      {{-- SLIDE 1 --}}
      <div class="carousel-item active hero-slide"
           style="background-image:url('/assets/img/hero.jpg')">
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <h1>Mereka Membutuhkan Kita</h1>
          <p>Donasi kecilmu membawa harapan besar</p>
          <a href="{{ route('donasi') }}" class="btn-hero">
            Mulai Donasi
          </a>
        </div>
      </div>

      {{-- SLIDE 2 --}}
      <div class="carousel-item hero-slide"
           style="background-image:url('/assets/img/hero.jpg')">
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <h1>Berbagi Itu Mudah</h1>
          <p>Salurkan kebaikan dengan aman & transparan</p>
          <a href="{{ route('donasi') }}" class="btn-hero">
            Donasi Sekarang
          </a>
        </div>
      </div>

      {{-- SLIDE 3 --}}
      <div class="carousel-item hero-slide"
           style="background-image:url('/assets/img/hero.jpg')">
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <h1>Bersama Kita Bisa</h1>
          <p>Satu donasi, sejuta manfaat</p>
          <a href="{{ route('donasi') }}" class="btn-hero">
            Ikut Berbagi
          </a>
        </div>
      </div>

    </div>

    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon"></span>
    </a>

  </div>
  {{-- ================= END CAROUSEL ================= --}}


  {{-- ================= PROGRAM AKTIF ================= --}}
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Program Donasi Aktif</h4>
    <a href="{{ route('donasi') }}" class="small">Lihat Semua →</a>
  </div>

  <div class="row">
    @forelse($programAktif as $p)
      <div class="col-md-6 col-lg-4 mb-4">
        <a href="{{ route('donasi.detail',$p->id_program) }}" class="text-dark text-decoration-none">
          <div class="card program-card h-100 border-0 shadow-sm">
            <img src="{{ $p->foto ? asset('storage/'.$p->foto) : asset('assets/img/default-program.jpg') }}"
                 class="card-img-top" alt="">
            <div class="card-body d-flex flex-column">
              <h5 class="fw-bold">{{ $p->nama_program }}</h5>
              <p class="text-muted small flex-grow-1">
                {{ Str::limit($p->deskripsi,90) }}
              </p>
              <span class="btn btn-outline-primary btn-sm align-self-start">
                Lihat Detail
              </span>
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-info text-center">
          Belum ada program donasi aktif
        </div>
      </div>
    @endforelse
  </div>


  {{-- ================= PROGRAM UNGGULAN ================= --}}
  <h4 class="fw-bold text-danger mb-3">Program Unggulan</h4>

  <div class="row mb-5">
    @forelse($programUnggulan as $u)
      <div class="col-md-6 col-lg-4 mb-4">
        <a href="{{ route('donasi.detail',$u->id_program) }}" class="text-dark text-decoration-none">
          <div class="card program-card h-100 border-0 shadow position-relative">
            <span class="badge badge-danger position-absolute m-2">Unggulan</span>
            <img src="{{ $u->foto ? asset('storage/'.$u->foto) : asset('assets/img/default-program.jpg') }}"
                 class="card-img-top">
            <div class="card-body d-flex flex-column">
              <h5 class="fw-bold">{{ $u->nama_program }}</h5>
              <p class="text-muted small flex-grow-1">
                {{ Str::limit($u->deskripsi,90) }}
              </p>
              <div class="small text-danger fw-bold mb-2">
                Rp {{ number_format($u->target_dana,0,',','.') }}
              </div>
              <span class="btn btn-danger btn-sm align-self-start">
                Donasi Sekarang
              </span>
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-warning text-center">
          Belum ada program unggulan
        </div>
      </div>
    @endforelse
  </div>

</div>


{{-- ================= STYLE ================= --}}
<style>
.hero-carousel { overflow:hidden; }
.hero-slide {
  height:420px;
  background-size:cover;
  background-position:center;
  position:relative;
}
.hero-overlay {
  position:absolute; inset:0;
  background:rgba(0,0,0,.55);
}
.hero-content {
  position:relative;
  height:100%;
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  text-align:center;
  color:#fff;
}
.hero-content h1 {
  font-weight:800;
  font-size:2.1rem;
}
.hero-content p { opacity:.95; }

.btn-hero {
  background:#0d6efd;
  color:#fff;
  padding:12px 30px;
  border-radius:50px;
  font-weight:600;
  text-decoration:none;
  transition:.3s;
}
.btn-hero:hover {
  background:#084298;
  color:#fff;
}

.program-card {
  border-radius:14px;
  overflow:hidden;
  transition:.3s;
}
.program-card:hover {
  transform:translateY(-6px);
  box-shadow:0 18px 35px rgba(0,0,0,.15);
}
.program-card img {
  height:200px;
  object-fit:cover;
}
</style>

@endsection
