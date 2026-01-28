@extends('layouts.app')

@section('title', 'Tentang Kami')

@push('styles')
<style>
  .about-hero {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    min-height: 220px;
    background: #222;
    box-shadow: 0 10px 25px rgba(0,0,0,.12);
  }
  .about-hero img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    filter: brightness(.72);
  }
  .about-hero .hero-content {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 20px;
    color: #fff;
  }
  .about-hero .hero-content h1 {
    font-weight: 800;
    letter-spacing: .2px;
    text-shadow: 0 8px 30px rgba(0,0,0,.35);
  }
  .about-hero .hero-content p {
    max-width: 720px;
    margin: 8px auto 0;
    opacity: .92;
    text-shadow: 0 8px 30px rgba(0,0,0,.35);
  }

  .about-wrap {
    margin-top: -35px; 
  }

  .about-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,.08);
    border: 1px solid rgba(0,0,0,.04);
  }

  .about-illustration {
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 8px 22px rgba(0,0,0,.12);
    border: 1px solid rgba(0,0,0,.06);
  }
  .about-illustration img{
    width: 100%;
    height: 160px;
    object-fit: cover;
    display:block;
  }

  .vm-card {
    border-radius: 14px;
    border: 1px solid rgba(0,0,0,.05);
    box-shadow: 0 10px 22px rgba(0,0,0,.06);
  }
  .vm-title {
    font-weight: 700;
    margin-bottom: 10px;
    display:flex;
    align-items:center;
    gap:8px;
  }
  .vm-title i { color:#0D6EFD; }

  @media (max-width: 576px){
    .about-hero img { height: 210px; }
    .about-hero .hero-content h1 { font-size: 22px; }
    .about-hero .hero-content p { font-size: 13px; }
  }
</style>
@endpush

@section('content')
<div class="container py-3">

  {{-- HERO BANNER --}}
  <div class="about-hero mb-4">
    {{-- Ganti gambar sesuai file kamu --}}
    <img src="{{ asset('assets/img/hero.jpg') }}" alt="Tentang KITABANTU">
    <div class="hero-content">
      <div>
        <h1 class="mb-2">Tentang KITABANTU</h1>
        <p class="mb-0">
          Bersama kita wujudkan kepedulian dan kebaikan melalui donasi yang transparan.
        </p>
      </div>
    </div>
  </div>

  {{-- CARD ISI --}}
  <div class="about-wrap">
    <div class="about-card p-4 p-md-5">
      <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
          <h4 class="font-weight-bold mb-3">Apa itu KITABANTU?</h4>
          <p class="text-muted mb-3">
            <b>KITABANTU</b> adalah platform donasi online yang membantu masyarakat menyalurkan bantuan
            dengan mudah, aman, dan transparan.
          </p>
          <p class="text-muted mb-0">
            Setiap donasi yang masuk dikelola secara profesional dan dapat dipantau perkembangannya oleh para donatur.
          </p>
        </div>

        <div class="col-md-6">
          <div class="about-illustration">
            <img src="{{ asset('assets/img/donasi.jpg') }}" alt="Ilustrasi donasi">
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-6 mb-3">
          <div class="card vm-card h-100">
            <div class="card-body">
              <div class="vm-title">
                <i class="fas fa-bullseye"></i> <span>Visi</span>
              </div>
              <p class="text-muted mb-0">
                Menjadi platform donasi digital terpercaya yang memberikan dampak nyata bagi kesejahteraan sosial.
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <div class="card vm-card h-100">
            <div class="card-body">
              <div class="vm-title">
                <i class="fas fa-flag"></i> <span>Misi</span>
              </div>
              <ul class="text-muted mb-0 pl-3">
                <li>Mempermudah proses donasi online.</li>
                <li>Menjaga transparansi pengelolaan dana.</li>
                <li>Mendukung aksi sosial berkelanjutan.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div> {{-- /about-card --}}
  </div> {{-- /about-wrap --}}

</div>
@endsection