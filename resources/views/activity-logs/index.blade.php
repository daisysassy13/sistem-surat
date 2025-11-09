{{-- FILE: resources/views/activity-logs/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-clock-history"></i> Activity Log</h1>
    <p class="text-muted">Riwayat aktivitas semua user di sistem</p>
</div>

<!-- Filter Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('activity-logs.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipe Aktivitas</label>
                    <select name="activity_type" class="form-select">
                        <option value="">Semua Tipe</option>
                        <option value="create" {{ request('activity_type') == 'create' ? 'selected' : '' }}>Create</option>
                        <option value="update" {{ request('activity_type') == 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('activity_type') == 'delete' ? 'selected' : '' }}>Delete</option>
                        <option value="restore" {{ request('activity_type') == 'restore' ? 'selected' : '' }}>Restore</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Activity Timeline -->
<div class="card shadow-sm border-0">
    <div class="card-body">
        @if($logs->count() > 0)
        <div class="timeline">
            @foreach($logs as $log)
            <div class="timeline-item mb-4 pb-3 border-bottom">
                <div class="d-flex">
                    <!-- Icon -->
                    <div class="me-3">
                        @if($log->activity_type == 'create')
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" 
                             style="width: 45px; height: 45px;">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        @elseif($log->activity_type == 'update')
                        <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" 
                             style="width: 45px; height: 45px;">
                            <i class="bi bi-pencil"></i>
                        </div>
                        @elseif($log->activity_type == 'delete')
                        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" 
                             style="width: 45px; height: 45px;">
                            <i class="bi bi-trash"></i>
                        </div>
                        @else
                        <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center" 
                             style="width: 45px; height: 45px;">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">
                                    <strong>{{ $log->user->name }}</strong>
                                    <span class="badge bg-secondary ms-2">{{ $log->user->role }}</span>
                                </h6>
                                <p class="mb-1">{{ $log->description }}</p>
                                
                                @if($log->properties)
                                <div class="small text-muted">
                                    <strong>Detail:</strong>
                                    @foreach($log->properties as $key => $value)
                                    <span class="badge bg-light text-dark me-1">{{ $key }}: {{ $value }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            
                            <div class="text-end">
                                <small class="text-muted">
                                    <i class="bi bi-clock"></i> 
                                    {{ $log->created_at->diffForHumans() }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </small>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-laptop"></i> IP: {{ $log->ip_address ?? '-' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} aktivitas
            </div>
            <div>
                {{ $logs->links() }}
            </div>
        </div>

        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-clock-history" style="font-size: 4rem; opacity: 0.3;"></i>
            <p class="mt-3">Belum ada aktivitas yang tercatat</p>
        </div>
        @endif
    </div>
</div>

<!-- Info Card -->
<div class="card shadow-sm border-0 mt-4">
    <div class="card-body">
        <h5><i class="bi bi-info-circle"></i> Informasi Activity Log</h5>
        <ul class="mb-0">
            <li><strong>Create:</strong> Menambah data baru (surat/user)</li>
            <li><strong>Update:</strong> Mengubah data yang sudah ada</li>
            <li><strong>Delete:</strong> Menghapus/mengarsipkan data</li>
            <li><strong>Restore:</strong> Mengembalikan data dari arsip</li>
            <li>Log mencatat IP address dan waktu aktivitas untuk audit</li>
            <li>Hanya admin yang bisa melihat activity log</li>
        </ul>
    </div>
</div>
@endsection