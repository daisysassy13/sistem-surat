@extends('layouts.app')

@section('title', 'Surat Keluar')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-send-fill"></i> Surat Keluar</h1>
        <p class="text-muted">Daftar semua surat keluar</p>
    </div>
    <a href="{{ route('surat-keluar.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Tambah Surat Keluar
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover data-table">
            <thead>
                <tr>
                    <th>No. Surat</th>
                    <th>Tanggal Surat</th>
                    <th>Tujuan Surat</th>
                    <th>Perihal</th>
                    <th>Dibuat Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratKeluar as $surat)
                <tr>
                    <td><span class="badge bg-success">{{ $surat->nomor_surat }}</span></td>
                    <td>{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                    <td>{{ $surat->tujuan_surat }}</td>
                    <td>{{ Str::limit($surat->perihal, 50) }}</td>
                    <td>
                        <small class="text-muted">
                            <i class="bi bi-person"></i> {{ $surat->creator->name }}
                        </small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('surat-keluar.show', $surat->id) }}" class="btn-futuristic btn-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('surat-keluar.edit', $surat->id) }}" class="btn-futuristic btn-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('surat-keluar.destroy', $surat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Arsipkan surat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-futuristic btn-delete" title="Arsipkan">
                                    <i class="bi bi-archive"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
