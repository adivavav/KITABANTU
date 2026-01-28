@extends('layouts.user')

@section('content')
<div class="container py-4">

    <h3 class="mb-4">Riwayat Program Donasi Saya</h3>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($programs as $program)
        <div class="card mb-3 shadow-sm">
            <div class="row g-0">

                {{-- GAMBAR --}}
                <div class="col-md-3">
                    @php
                        $gambar = $program->gambar ?? $program->foto ?? null;
                    @endphp

                    @if ($gambar)
                        <img src="{{ asset('storage/' . $gambar) }}"
                             class="img-fluid rounded-start"
                             style="height:100%; object-fit:cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light"
                             style="height:100%;">
                            <span class="text-muted">Tidak ada gambar</span>
                        </div>
                    @endif
                </div>

                {{-- KONTEN --}}
                <div class="col-md-9">
                    <div class="card-body">

                        {{-- JUDUL --}}
                        <h5 class="card-title">
                            {{ $program->judul 
                                ?? $program->nama_program 
                                ?? 'Program Donasi' }}
                        </h5>

                        {{-- DESKRIPSI --}}
                        <p class="card-text text-muted">
                            {{ Str::limit(
                                $program->deskripsi 
                                ?? $program->detail 
                                ?? '-', 
                                120
                            ) }}
                        </p>

                        {{-- TARGET --}}
                        <p class="mb-1">
                            <strong>Target Donasi:</strong>
                            Rp {{ number_format(
                                $program->target_donasi 
                                ?? $program->target_dana 
                                ?? 0
                            ) }}
                        </p>

                        {{-- STATUS --}}
                        @php
                            $status = $program->status 
                                   ?? $program->status_program 
                                   ?? 'pending';
                        @endphp

                        <p class="mb-1">
                            <strong>Status:</strong>

                            @if ($status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($status === 'aktif' || $status === 'approved')
                                <span class="badge bg-success">Aktif</span>
                            @elseif ($status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($status) }}
                                </span>
                            @endif
                        </p>

                        {{-- TANGGAL --}}
                        <small class="text-muted">
                            Dibuat:
                            {{ $program->created_at
                                ? $program->created_at->format('d M Y')
                                : '-' }}
                        </small>

                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada program donasi yang kamu buat.
        </div>
    @endforelse

</div>
@endsection
