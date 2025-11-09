@extends('layouts.app')

@section('title', 'Tambah Surat Masuk')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-inbox-fill"></i> Tambah Surat Masuk</h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nomor Agenda <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-light" value="{{ $nomorAgenda }}" readonly>
                        <small class="text-muted">Nomor agenda dibuat otomatis</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Surat (Opsional)</label>
                        <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" 
                               value="{{ old('nomor_surat') }}" placeholder="Contoh: 001/ABC/2024">
                        @error('nomor_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" 
                                   value="{{ old('tanggal_surat') }}" required>
                            @error('tanggal_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Diterima <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_diterima" class="form-control @error('tanggal_diterima') is-invalid @enderror" 
                                   value="{{ old('tanggal_diterima', date('Y-m-d')) }}" required>
                            @error('tanggal_diterima')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Asal Surat <span class="text-danger">*</span></label>
                        <input type="text" name="asal_surat" class="form-control @error('asal_surat') is-invalid @enderror" 
                               value="{{ old('asal_surat') }}" placeholder="Contoh: Kecamatan, Dinas, Warga" required>
                        @error('asal_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Perihal <span class="text-danger">*</span></label>
                        <textarea name="perihal" rows="3" class="form-control @error('perihal') is-invalid @enderror" 
                                  placeholder="Isi perihal surat..." required>{{ old('perihal') }}</textarea>
                        @error('perihal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Surat (PDF/JPG/PNG, Max 5MB) <span class="text-danger">*</span></label>
                        <input type="file" name="file_surat" class="form-control @error('file_surat') is-invalid @enderror" 
                               accept=".pdf,.jpg,.jpeg,.png" required>
                        @error('file_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror" 
                                  placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection