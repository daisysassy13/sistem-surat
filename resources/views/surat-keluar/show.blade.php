@extends('layouts.app')

@section('title', 'Detail Surat Keluar')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-eye"></i> Detail Surat Keluar</h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Surat</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>Nomor Surat</strong></td>
                        <td>: <span class="badge bg-success">{{ $suratKeluar->nomor_surat }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Surat</strong></td>
                        <td>: {{ $suratKeluar->tanggal_surat->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tujuan Surat</strong></td>
                        <td>: {{ $suratKeluar->tujuan_surat }}</td>
                    </tr>
                    <tr>
                        <td><strong>Perihal</strong></td>
                        <td>: {{ $suratKeluar->perihal }}</td>
                    </tr>
                    <tr>
                        <td><strong>Keterangan</strong></td>
                        <td>: {{ $suratKeluar->keterangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat Oleh</strong></td>
                        <td>: {{ $suratKeluar->creator->name }} ({{ $suratKeluar->creator->role }})</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat Pada</strong></td>
                        <td>: {{ $suratKeluar->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-4">
                    <a href="{{ asset('storage/' . $suratKeluar->file_surat) }}" class="btn btn-success" target="_blank">
                        <i class="bi bi-download"></i> Download File Surat
                    </a>
                    <a href="{{ route('surat-keluar.edit', $suratKeluar->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark"></i> Preview File</h5>
            </div>
            <div class="card-body text-center">
                <iframe src="{{ asset('storage/' . $suratKeluar->file_surat) }}" width="100%" height="500px" style="border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection