@extends('layouts.app')

@section('title', 'Data Admin')

@section('breadcrumb')
    <a href="{{ route('super-admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Data Admin</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Data Admin</h1>
        <p class="page-subtitle">Kelola admin per sekolah</p>
    </div>
    <a href="{{ route('super-admin.admin.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        <span>Tambah Admin</span>
    </a>
</div>

<!-- Filter -->
<div class="card mb-6">
    <form action="{{ route('super-admin.admin.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="w-full sm:w-64">
            <select name="sekolah_id" class="form-select">
                <option value="">Semua Sekolah</option>
                @foreach($sekolahs as $s)
                    <option value="{{ $s->id }}" {{ request('sekolah_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-secondary">
            <i class="fas fa-filter"></i>
            <span>Filter</span>
        </button>
        @if(request('sekolah_id'))
            <a href="{{ route('super-admin.admin.index') }}" class="btn-ghost">
                <i class="fas fa-times"></i>
                <span>Reset</span>
            </a>
        @endif
    </form>
</div>

<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Sekolah</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td class="font-medium">{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <span class="badge-primary">{{ $admin->sekolah->nama ?? '-' }}</span>
                    </td>
                    <td>
                        @if($admin->is_active)
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('super-admin.admin.edit', $admin) }}" class="btn-ghost btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('super-admin.admin.destroy', $admin) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-ghost btn-sm text-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">
                        <i class="fas fa-user-shield text-4xl mb-3"></i>
                        <p>Belum ada data admin.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $admins->links() }}
</div>
@endsection
