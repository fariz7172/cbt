@extends('layouts.app')

@section('title', 'Data Kelas')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Data Kelas</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Data Kelas</h1>
        <p class="page-subtitle">Kelola data kelas madrasah (Kelas 1-6)</p>
    </div>
    <a href="{{ route('admin.kelas.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        <span>Tambah Kelas</span>
    </a>
</div>

<!-- Filter -->
<div class="card mb-6">
    <form action="{{ route('admin.kelas.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4" id="filterForm">
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
        
        <div class="w-full sm:w-48">
            <select name="tingkat" class="form-select">
                <option value="">Semua Tingkat</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('tingkat') == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn-secondary">
            <i class="fas fa-filter"></i>
            <span>Filter</span>
        </button>
        @if(request()->hasAny(['tingkat', 'sekolah_id']))
            <a href="{{ route('admin.kelas.index') }}" class="btn-ghost">
                <i class="fas fa-times"></i>
                <span>Reset</span>
            </a>
        @endif
    </form>
</div>

<!-- Grid Kelas -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($kelass as $kelas)
        <div class="card hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center">
                        <span class="text-xl font-bold text-accent">{{ $kelas->tingkat }}</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $kelas->nama }}</h3>
                        <p class="text-sm text-gray-500">Tingkat {{ $kelas->tingkat }}</p>
                    </div>
                </div>
            </div>
            
            @if(auth()->user()->isSuperAdmin())
                <div class="mt-3">
                    <span class="badge-primary text-xs">{{ $kelas->sekolah->nama ?? '-' }}</span>
                </div>
            @endif
            
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Rombel</span>
                    <span class="font-medium text-accent">{{ $kelas->rombels_count }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2 mt-4">
                <a href="{{ route('admin.kelas.edit', $kelas) }}" class="btn-secondary btn-sm flex-1">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                <form action="{{ route('admin.kelas.destroy', $kelas) }}" method="POST" class="flex-1"
                      onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger btn-sm w-full">
                        <i class="fas fa-trash"></i>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="card text-center py-12">
                <i class="fas fa-school text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Belum ada data kelas.</p>
                <a href="{{ route('admin.kelas.create') }}" class="btn-primary mt-4">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Kelas Pertama</span>
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $kelass->links() }}
</div>
@endsection
