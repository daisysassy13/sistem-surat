@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Surat</h1>
    <p class="text-muted">Export laporan surat masuk dan keluar ke Excel atau PDF</p>
</div>

<div class="row g-4">
    <!-- Laporan Surat Masuk -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-inbox-fill"></i> Laporan Surat Masuk</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('laporan.surat-masuk.excel') }}" method="GET" id="form-surat-masuk">
                    <div class="mb-3">
                        <label class="form-label">Filter Tanggal (Opsional)</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="date" name="tanggal_dari" class="form-control" placeholder="Dari Tanggal">
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="tanggal_sampai" class="form-control" placeholder="Sampai Tanggal">
                            </div>
                        </div>
                        <small class="text-muted">Kosongkan untuk export semua data</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-file-earmark-excel"></i> Export ke Excel(.csv)
                        </button>
                        <button type="button" class="btn btn-danger" onclick="exportPDF('surat-masuk')">
                            <i class="bi bi-file-earmark-pdf"></i> Export ke PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Laporan Surat Keluar -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-send-fill"></i> Laporan Surat Keluar</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('laporan.surat-keluar.excel') }}" method="GET" id="form-surat-keluar">
                    <div class="mb-3">
                        <label class="form-label">Filter Tanggal (Opsional)</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="date" name="tanggal_dari" class="form-control" placeholder="Dari Tanggal">
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="tanggal_sampai" class="form-control" placeholder="Sampai Tanggal">
                            </div>
                        </div>
                        <small class="text-muted">Kosongkan untuk export semua data</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-file-earmark-excel"></i> Export ke Excel(.csv)
                        </button>
                        <button type="button" class="btn btn-danger" onclick="exportPDF('surat-keluar')">
                            <i class="bi bi-file-earmark-pdf"></i> Export ke PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Info Card -->
<div class="card shadow-sm border-0 mt-4">
    <div class="card-body">
        <h5><i class="bi bi-info-circle"></i> Informasi</h5>
        <ul class="mb-0">
            <li>Export <strong>Excel</strong> untuk pengolahan data lebih lanjut (bisa diedit)</li>
            <li>Export <strong>PDF</strong> untuk cetak atau arsip (tidak bisa diedit)</li>
            <li>Gunakan filter tanggal untuk export data pada periode tertentu</li>
            <li>File akan otomatis terdownload setelah Anda klik tombol export</li>
        </ul>
    </div>
</div>

@push('scripts')
<script>
function exportPDF(type) {
    let form = document.getElementById('form-' + type);
    let tanggalDari = form.querySelector('[name="tanggal_dari"]').value;
    let tanggalSampai = form.querySelector('[name="tanggal_sampai"]').value;
    
    let url = type === 'surat-masuk' 
        ? '{{ route("laporan.surat-masuk.pdf") }}'
        : '{{ route("laporan.surat-keluar.pdf") }}';
    
    // Tambahkan query string jika ada filter
    if (tanggalDari && tanggalSampai) {
        url += '?tanggal_dari=' + tanggalDari + '&tanggal_sampai=' + tanggalSampai;
    }
    
    window.open(url, '_blank');
}
</script>
@endpush
@endsection