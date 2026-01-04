@extends('layouts.app')

@section('title', 'Data Siswa')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Data Siswa</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Data Siswa</h1>
        <p class="page-subtitle">Kelola data siswa madrasah</p>
    </div>
    <a href="{{ route('admin.siswa.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        <span>Tambah Siswa</span>
    </a>
</div>

<!-- Filter -->
<div class="card mb-6">
    <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4" id="filterForm">
        <!-- Sekolah Filter (Super Admin Only) -->
        @if(auth()->user()->isSuperAdmin() && $sekolahs->isNotEmpty())
            <div class="w-full sm:w-48">
                <select name="sekolah_id" class="form-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Sekolah</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ request('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                            {{ $sekolah->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama atau NISN..." 
                   class="form-input">
        </div>
        <div class="w-full sm:w-40">
            <select name="kelas_id" class="form-select">
                <option value="">Semua Kelas</option>
                @foreach($kelass as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full sm:w-40">
            <select name="jenis_kelamin" class="form-select">
                <option value="">Semua L/P</option>
                <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <button type="submit" class="btn-secondary">
            <i class="fas fa-search"></i>
            <span>Cari</span>
        </button>
        @if(request()->hasAny(['search', 'kelas_id', 'jenis_kelamin', 'sekolah_id']))
            <a href="{{ route('admin.siswa.index') }}" class="btn-ghost">
                <i class="fas fa-times"></i>
                <span>Reset</span>
            </a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>NISN</th>
                <th>Nama</th>
                @if(auth()->user()->isSuperAdmin())
                    <th>Sekolah</th>
                @endif
                <th>Jenis Kelamin</th>
                <th>Email</th>
                <th>Kelas</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $siswa)
                <tr>
                    <td class="font-mono text-sm">{{ $siswa->nisn }}</td>
                    <td class="font-medium">{{ $siswa->nama }}</td>
                    @if(auth()->user()->isSuperAdmin())
                        <td>
                            <span class="badge-primary">{{ $siswa->sekolah->nama ?? '-' }}</span>
                        </td>
                    @endif
                    <td>
                        @if($siswa->jenis_kelamin == 'L')
                            <span class="badge-info">Laki-laki</span>
                        @else
                            <span class="badge-pink">Perempuan</span>
                        @endif
                    </td>
                    <td>{{ $siswa->user->email }}</td>
                    <td>
                        @if($siswa->kelas)
                            <span class="badge-primary">{{ $siswa->kelas->nama }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td>
                        @if($siswa->user->is_active)
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.siswa.show', $siswa) }}" class="btn-ghost btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn-ghost btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
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
                    <td colspan="{{ auth()->user()->isSuperAdmin() ? '8' : '7' }}" class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>Belum ada data siswa.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $siswas->links() }}
</div>
@endsection
