@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header mb-4">
    <h1 class="page-title">
        <i class="bi bi-speedometer2"></i> Dashboard Analytics
    </h1>
    <p class="text-muted">Ringkasan dan statistik sistem surat</p>
</div>

{{-- ===================== --}}
{{-- STAT CARDS --}}
{{-- ===================== --}}
<div class="row g-4 mb-4">
    @php
        $stats = [
            ['Surat Masuk', $suratMasukBulanIni ?? 0, 'primary', 'bi-inbox-fill'],
            ['Surat Keluar', $suratKeluarBulanIni ?? 0, 'success', 'bi-send-fill'],
            ['Total Arsip', $totalArsip ?? 0, 'warning', 'bi-archive-fill'],
            ['Total User', $totalUser ?? 0, 'info', 'bi-people-fill'],
        ];
    @endphp

    @foreach($stats as $i => $stat)
    <div class="col-md-3">
        <div class="stat-card card animate-up" style="animation-delay: {{ $i * 0.1 }}s">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted mb-1 small">{{ $stat[0] }}</p>
                    <h2 class="mb-0 fw-bold counter" data-target="{{ $stat[1] }}">0</h2>
                    <small class="text-muted">Bulan ini</small>
                </div>
                <div class="stat-icon bg-{{ $stat[2] }} bg-opacity-10 text-{{ $stat[2] }}">
                    <i class="bi {{ $stat[3] }}"></i>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ===================== --}}
{{-- DASHBOARD GRID FIX --}}
{{-- ===================== --}}
<div class="row g-4">

    {{-- KOLOM KIRI --}}
    <div class="col-lg-8 d-flex flex-column gap-4">

        {{-- TREND LINE --}}
        <div class="card shadow-sm border-0 animate-up flex-fill">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up"></i> Trend Surat 6 Bulan Terakhir
                </h5>
            </div>
            <div class="card-body">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- BAR CHART --}}
        <div class="card shadow-sm border-0 animate-up flex-fill">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-bar-chart-fill"></i> Perbandingan Bulan Ini
                </h5>
            </div>
            <div class="card-body">
                <canvas id="barChart" height="120"></canvas>
            </div>
        </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div class="col-lg-4 d-flex flex-column gap-4">

        {{-- PIE CHART --}}
        <div class="card shadow-sm border-0 animate-up">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart-fill"></i> Asal Surat
                </h5>
            </div>
            <div class="card-body">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        {{-- AKTIVITAS --}}
        <div class="card shadow-sm border-0 animate-up flex-fill">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-activity"></i> Aktivitas Terbaru
                </h5>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    @forelse($recentActivity ?? [] as $activity)
                        <div class="activity-item">
                            <div class="activity-icon {{ $activity['type'] == 'masuk' ? 'bg-primary' : 'bg-success' }}">
                                <i class="bi {{ $activity['type'] == 'masuk' ? 'bi-inbox' : 'bi-send' }}"></i>
                            </div>
                            <div class="activity-content">
                                <p class="mb-1">
                                    <strong>{{ $activity['user'] }}</strong>
                                    {{ $activity['action'] }}
                                    <span class="badge bg-light text-dark">{{ $activity['detail'] }}</span>
                                </p>
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i>
                                    {{ $activity['time']->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1"></i>
                            <p class="mt-2">Belum ada aktivitas</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ===================== --}}
{{-- SCRIPTS --}}
{{-- ===================== --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================
       COUNTER
    ====================== */
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.dataset.target;
        let current = 0;
        const step = Math.max(target / 60, 1);

        const interval = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(interval);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 16);
    });

    /* =====================
       TREND LINE CHART
    ====================== */
    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendData['labels'] ?? []) !!},
                datasets: [
                    {
                        label: 'Surat Masuk',
                        data: {!! json_encode($trendData['suratMasuk'] ?? []) !!},
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52,152,219,0.15)',
                        pointBackgroundColor: '#3498db',
                        pointBorderColor: '#fff',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Surat Keluar',
                        data: {!! json_encode($trendData['suratKeluar'] ?? []) !!},
                        borderColor: '#27ae60',
                        backgroundColor: 'rgba(39,174,96,0.15)',
                        pointBackgroundColor: '#27ae60',
                        pointBorderColor: '#fff',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    /* =====================
       PIE / DOUGHNUT
    ====================== */
    const pieCtx = document.getElementById('pieChart');
    if (pieCtx) {
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($distribusiAsalSurat->pluck('asal_surat') ?? []) !!},
                datasets: [{
                    data: {!! json_encode($distribusiAsalSurat->pluck('total') ?? []) !!},
                    backgroundColor: [
                        '#3498db',
                        '#27ae60',
                        '#f1c40f'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 12
                        }
                    }
                }
            }
        });
    }

    /* =====================
       BAR CHART
    ====================== */
    const barCtx = document.getElementById('barChart');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Bulan Ini'],
                datasets: [
                    {
                        label: 'Surat Masuk',
                        data: [{{ $perbandinganBulanan['masuk'] ?? 0 }}],
                        backgroundColor: '#3498db',
                        borderRadius: 6
                    },
                    {
                        label: 'Surat Keluar',
                        data: [{{ $perbandinganBulanan['keluar'] ?? 0 }}],
                        backgroundColor: '#27ae60',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

});
</script>
@endpush


@endsection
