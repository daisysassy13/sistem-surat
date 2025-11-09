@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-archive-fill"></i> Arsip Surat</h1>
    <p class="text-muted">Daftar semua surat yang telah diarsipkan</p>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="surat-masuk-tab" data-bs-toggle="tab" data-bs-target="#surat-masuk" type="button">
            <i class="bi bi-inbox"></i> Surat Masuk ({{ $suratMasukArsip->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="surat-keluar-tab" data-bs-toggle="tab" data-bs-target="#surat-keluar" type="button">
            <i class="bi bi-send"></i> Surat Keluar ({{ $suratKeluarArsip->count() }})
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content">
    <!-- Tab Surat Masuk -->
    <div class="tab-pane fade show active" id="surat-masuk" role="tabpanel">
        <div class="table-card">
            @if($suratMasukArsip->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="table-surat-masuk">
                    <thead>
                        <tr>
                            <th>No. Agenda</th>
                            <th>No. Surat</th>
                            <th>Tanggal</th>
                            <th>Asal Surat</th>
                            <th>Perihal</th>
                            <th>Diarsipkan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suratMasukArsip as $surat)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $surat->nomor_agenda }}</span></td>
                            <td>{{ $surat->nomor_surat ?? '-' }}</td>
                            <td>{{ $surat->tanggal_diterima->format('d/m/Y') }}</td>
                            <td>{{ Str::limit($surat->asal_surat, 30) }}</td>
                            <td>{{ Str::limit($surat->perihal, 40) }}</td>
                            <td>
                                <small class="text-muted">
                                    {{ $surat->deleted_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ asset('storage/' . $surat->file_surat) }}" class="btn btn-info" target="_blank" title="Lihat File">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('arsip.surat-masuk.restore', $surat->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" title="Restore" onclick="return confirm('Restore surat ini?')">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                    @if(auth()->user()->role == 'admin')
                                    <form action="{{ route('arsip.surat-masuk.force-delete', $surat->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus Permanen" onclick="return confirm('HAPUS PERMANEN? Data tidak bisa dikembalikan!')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.3;"></i>
                <p class="mt-3">Tidak ada surat masuk di arsip</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tab Surat Keluar -->
    <div class="tab-pane fade" id="surat-keluar" role="tabpanel">
        <div class="table-card">
            @if($suratKeluarArsip->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="table-surat-keluar">
                    <thead>
                        <tr>
                            <th>No. Surat</th>
                            <th>Tanggal</th>
                            <th>Tujuan Surat</th>
                            <th>Perihal</th>
                            <th>Diarsipkan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suratKeluarArsip as $surat)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $surat->nomor_surat }}</span></td>
                            <td>{{ $surat->tanggal_surat->format('d/m/Y') }}</td>
                            <td>{{ Str::limit($surat->tujuan_surat, 30) }}</td>
                            <td>{{ Str::limit($surat->perihal, 40) }}</td>
                            <td>
                                <small class="text-muted">
                                    {{ $surat->deleted_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ asset('storage/' . $surat->file_surat) }}" class="btn btn-info" target="_blank" title="Lihat File">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('arsip.surat-keluar.restore', $surat->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" title="Restore" onclick="return confirm('Restore surat ini?')">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                    @if(auth()->user()->role == 'admin')
                                    <form action="{{ route('arsip.surat-keluar.force-delete', $surat->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus Permanen" onclick="return confirm('HAPUS PERMANEN? Data tidak bisa dikembalikan!')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-send" style="font-size: 4rem; opacity: 0.3;"></i>
                <p class="mt-3">Tidak ada surat keluar di arsip</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // DataTable untuk tab Surat Masuk (yang aktif)
        var tableMasuk = $('#surat-masuk table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 10,
            order: [[5, 'desc']]
        });

        // DataTable untuk tab Surat Keluar (init saat tab diklik)
        var tableKeluar = null;
        $('#surat-keluar-tab').on('shown.bs.tab', function () {
            if (tableKeluar == null) {
                tableKeluar = $('#surat-keluar table').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                    },
                    pageLength: 10,
                    order: [[4, 'desc']]
                });
            }
        });
    });
</script>
@endpush

@endsection