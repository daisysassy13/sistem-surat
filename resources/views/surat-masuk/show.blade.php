@extends('layouts.app')

@section('title', 'Detail Surat Masuk')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-eye"></i> Detail Surat Masuk</h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Surat</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>Nomor Agenda</strong></td>
                        <td>: <span class="badge bg-primary">{{ $suratMasuk->nomor_agenda }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Nomor Surat</strong></td>
                        <td>: {{ $suratMasuk->nomor_surat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Surat</strong></td>
                        <td>: {{ $suratMasuk->tanggal_surat->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Diterima</strong></td>
                        <td>: {{ $suratMasuk->tanggal_diterima->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Asal Surat</strong></td>
                        <td>: {{ $suratMasuk->asal_surat }}</td>
                    </tr>
                    <tr>
                        <td><strong>Perihal</strong></td>
                        <td>: {{ $suratMasuk->perihal }}</td>
                    </tr>
                    <tr>
                        <td><strong>Keterangan</strong></td>
                        <td>: {{ $suratMasuk->keterangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat Oleh</strong></td>
                        <td>: {{ $suratMasuk->creator->name }} ({{ $suratMasuk->creator->role }})</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat Pada</strong></td>
                        <td>: {{ $suratMasuk->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-4">
                    <a href="{{ asset('storage/' . $suratMasuk->file_surat) }}" class="btn btn-primary" target="_blank">
                        <i class="bi bi-download"></i> Download File Surat
                    </a>
                    <a href="{{ route('surat-masuk.edit', $suratMasuk->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">
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
                @if(pathinfo($suratMasuk->file_surat, PATHINFO_EXTENSION) == 'pdf')
                    <iframe src="{{ asset('storage/' . $suratMasuk->file_surat) }}" width="100%" height="500px" style="border: none;"></iframe>
                @else
                    <img src="{{ asset('storage/' . $suratMasuk->file_surat) }}" class="img-fluid" alt="Preview">
                @endif
            </div>
        </div>
    </div>
</div>
@endsection