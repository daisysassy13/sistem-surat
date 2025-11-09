@extends('layouts.app')

@section('title', 'Edit Surat Masuk')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-pencil-square"></i> Edit Surat Masuk</h1>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('surat-masuk.update', $suratMasuk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nomor Agenda</label>
                        <input type="text" class="form-control bg-light" value="{{ $suratMasuk->nomor_agenda }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Surat (Opsional)</label>
                        <input type="text" name="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror" 
                               value="{{ old('nomor_surat', $suratMasuk->nomor_surat) }}">
                        @error('nomor_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" 
                                   value="{{ old('tanggal_surat', $suratMasuk->tanggal_surat->format('Y-m-d')) }}" required>
                            @error('tanggal_surat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Diterima <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_diterima" class="form-control @error('tanggal_diterima') is-invalid @enderror" 
                                   value="{{ old('tanggal_diterima', $suratMasuk->tanggal_diterima->format('Y-m-d')) }}" required>
                            @error('tanggal_diterima')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Asal Surat <span class="text-danger">*</span></label>
                        <input type="text" name="asal_surat" class="form-control @error('asal_surat') is-invalid @enderror" 
                               value="{{ old('asal_surat', $suratMasuk->asal_surat) }}" required>
                        @error('asal_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Perihal <span class="text-danger">*</span></label>
                        <textarea name="perihal" rows="3" class="form-control @error('perihal') is-invalid @enderror" required>{{ old('perihal', $suratMasuk->perihal) }}</textarea>
                        @error('perihal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Surat (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="file" name="file_surat" class="form-control @error('file_surat') is-invalid @enderror" 
                               accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">File saat ini: {{ basename($suratMasuk->file_surat) }}</small>
                        @error('file_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="2" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $suratMasuk->keterangan) }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
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