@extends('layouts.app')

@section('title', 'Edit Surat Keluar')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-pencil-square"></i> Edit Surat Keluar</h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('surat-keluar.update', $suratKeluar->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control bg-light" value="{{ $suratKeluar->nomor_surat }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" 
                               value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat->format('Y-m-d')) }}" required>
                        @error('tanggal_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tujuan Surat <span class="text-danger">*</span></label>
                        <input type="text" name="tujuan_surat" class="form-control @error('tujuan_surat') is-invalid @enderror" 
                               value="{{ old('tujuan_surat', $suratKeluar->tujuan_surat) }}" required>
                        @error('tujuan_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Perihal <span class="text-danger">*</span></label>
                        <textarea name="perihal" rows="3" class="form-control @error('perihal') is-invalid @enderror" required>{{ old('perihal', $suratKeluar->perihal) }}</textarea>
                        @error('perihal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Surat (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="file" name="file_surat" class="form-control @error('file_surat') is-invalid @enderror" 
                               accept=".pdf">
                        <small class="text-muted">File saat ini: {{ basename($suratKeluar->file_surat) }}</small>
                        @error('file_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $suratKeluar->keterangan) }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection