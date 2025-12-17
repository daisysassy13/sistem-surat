@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-people-fill"></i> Kelola User</h1>
        <p class="text-muted">Manajemen user dan hak akses</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah User
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ms-2">
                                <strong>{{ $user->name }}</strong>
                                @if($user->id == auth()->id())
                                <span class="badge bg-info ms-1">Anda</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                        <span class="badge bg-danger">
                            <i class="bi bi-shield-check"></i> Admin
                        </span>
                        @else
                        <span class="badge bg-secondary">
                            <i class="bi bi-person"></i> Operator
                        </span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                        <span class="badge bg-success">Aktif</span>
                        @else
                        <span class="badge bg-warning">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $user->created_at->format('d/m/Y') }}
                        </small>
                    </td>
                   <td>
                        <div class="action-buttons">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn-futuristic btn-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($user->id != auth()->id())
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" 
                                onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-futuristic btn-delete" title="Hapus">
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
</div>

<!-- Info Card -->
<div class="card shadow-sm border-0 mt-4">
    <div class="card-body">
        <h5><i class="bi bi-info-circle"></i> Informasi</h5>
        <ul class="mb-0">
            <li><strong>Admin:</strong> Akses penuh (CRUD surat, kelola user, hapus permanen)</li>
            <li><strong>Operator:</strong> Akses terbatas (CRUD surat, tidak bisa kelola user)</li>
            <li>User nonaktif tidak bisa login ke sistem</li>
            <li>Anda tidak bisa menghapus akun sendiri</li>
        </ul>
    </div>
</div>
@endsection