@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-speedometer2"></i> Dashboard</h1>
    <p class="text-muted">Ringkasan data surat masuk dan keluar</p>
</div>

<!-- Statistik Cards -->
<div class="row g-4 mb-4">
    <!-- Surat Masuk Bulan Ini -->
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Surat Masuk</p>
                        <h2 class="mb-0 fw-bold">{{ $suratMasukBulanIni }}</h2>
                        <small class="text-muted">Bulan ini</small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-inbox-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Surat Keluar Bulan Ini -->
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Surat Keluar</p>
                        <h2 class="mb-0 fw-bold">{{ $suratKeluarBulanIni }}</h2>
                        <small class="text-muted">Bulan ini</small>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-send-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Arsip -->
    <div class="col-md-4">
        <div class="stat-card card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Arsip</p>
                        <h2 class="mb-0 fw-bold">{{ $totalArsip }}</h2>
                        <small class="text-muted">Semua surat</small>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-archive-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Surat Terbaru -->
<div class="row g-4">
    <!-- Surat Masuk Terbaru -->
    <div class="col-lg-6">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-inbox"></i> Surat Masuk Terbaru</h5>
                <a href="{{ route('surat-masuk.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            
            @if($suratMasukTerbaru->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No. Agenda</th>
                            <th>Asal Surat</th>
                            <th>Perihal</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suratMasukTerbaru as $surat)
                        <tr>
                            <td>
                                <span class="badge bg-primary">{{ $surat->nomor_agenda }}</span>
                            </td>
                            <td>{{ Str::limit($surat->asal_surat, 20) }}</td>
                            <td>{{ Str::limit($surat->perihal, 30) }}</td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> 
                                    {{ $surat->tanggal_diterima->format('d/m/Y') }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4 text-muted">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-2">Belum ada surat masuk</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Surat Keluar Terbaru -->
    <div class="col-lg-6">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-send"></i> Surat Keluar Terbaru</h5>
                <a href="{{ route('surat-keluar.index') }}" class="btn btn-sm btn-outline-success">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            
            @if($suratKeluarTerbaru->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No. Surat</th>
                            <th>Tujuan</th>
                            <th>Perihal</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suratKeluarTerbaru as $surat)
                        <tr>
                            <td>
                                <span class="badge bg-success">{{ $surat->nomor_surat }}</span>
                            </td>
                            <td>{{ Str::limit($surat->tujuan_surat, 20) }}</td>
                            <td>{{ Str::limit($surat->perihal, 30) }}</td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> 
                                    {{ $surat->tanggal_surat->format('d/m/Y') }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4 text-muted">
                <i class="bi bi-send" style="font-size: 3rem;"></i>
                <p class="mt-2">Belum ada surat keluar</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection