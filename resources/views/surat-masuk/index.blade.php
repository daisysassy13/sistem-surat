@extends('layouts.app')

@section('title', 'Surat Masuk')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-inbox-fill"></i> Surat Masuk</h1>
        <p class="text-muted">Daftar semua surat masuk</p>
    </div>
    <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Surat Masuk
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover data-table">
            <thead>
                <tr>
                    <th>No. Agenda</th>
                    <th>No. Surat</th>
                    <th>Tanggal Diterima</th>
                    <th>Asal Surat</th>
                    <th>Perihal</th>
                    <th>Dibuat Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suratMasuk as $surat)
                <tr>
                    <td><span class="badge bg-primary">{{ $surat->nomor_agenda }}</span></td>
                    <td>{{ $surat->nomor_surat ?? '-' }}</td>
                    <td>{{ $surat->tanggal_diterima->format('d/m/Y') }}</td>
                    <td>{{ $surat->asal_surat }}</td>
                    <td>{{ Str::limit($surat->perihal, 50) }}</td>
                    <td>
                        <small class="text-muted">
                            <i class="bi bi-person"></i> {{ $surat->creator->name }}
                        </small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('surat-masuk.show', $surat->id) }}" class="btn btn-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('surat-masuk.edit', $surat->id) }}" class="btn btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('surat-masuk.destroy', $surat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Arsipkan surat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="Arsipkan">
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