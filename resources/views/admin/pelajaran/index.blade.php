@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Mata Pelajaran</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Mata Pelajaran</h1>
        <p class="page-subtitle">Kelola data mata pelajaran</p>
    </div>
    <a href="{{ route('admin.pelajaran.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        <span>Tambah Mapel</span>
    </a>
</div>

<!-- Filter -->
<div class="card mb-6">
    <form action="{{ route('admin.pelajaran.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari kode atau nama mapel..." 
                   class="form-input">
        </div>
        <div class="w-full sm:w-48">
            <select name="jenis" class="form-select">
                <option value="">Semua Jenis</option>
                <option value="guru_kelas" {{ request('jenis') == 'guru_kelas' ? 'selected' : '' }}>Guru Kelas</option>
                <option value="guru_mapel" {{ request('jenis') == 'guru_mapel' ? 'selected' : '' }}>Guru Mapel</option>
            </select>
        </div>
        <button type="submit" class="btn-secondary">
            <i class="fas fa-search"></i>
            <span>Cari</span>
        </button>
    </form>
</div>

<!-- Table -->
<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Mata Pelajaran</th>
                <th>Jenis Pengajar</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelajarans as $pelajaran)
                <tr>
                    <td class="font-mono text-sm font-medium">{{ $pelajaran->kode }}</td>
                    <td class="font-medium">{{ $pelajaran->nama }}</td>
                    <td>
                        @if($pelajaran->jenis == 'guru_kelas')
                            <span class="badge-success">Guru Kelas</span>
                        @else
                            <span class="badge-info">Guru Mapel</span>
                        @endif
                    </td>
                    <td>
                        @if($pelajaran->is_active)
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.pelajaran.edit', $pelajaran) }}" class="btn-ghost btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.pelajaran.destroy', $pelajaran) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
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
                        <i class="fas fa-book text-4xl mb-3"></i>
                        <p>Belum ada data mata pelajaran.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $pelajarans->links() }}
</div>
@endsection
