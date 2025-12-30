@extends('layouts.app')

@section('title', 'Data Guru')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Data Guru</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Data Guru</h1>
        <p class="page-subtitle">Kelola data guru madrasah</p>
    </div>
    <a href="{{ route('admin.guru.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        <span>Tambah Guru</span>
    </a>
</div>

<!-- Filter -->
<div class="card mb-6">
    <form action="{{ route('admin.guru.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama atau NIP..." 
                   class="form-input">
        </div>
        <div class="w-full sm:w-48">
            <select name="jabatan" class="form-select">
                <option value="">Semua Jabatan</option>
                <option value="kepala_madrasah" {{ request('jabatan') == 'kepala_madrasah' ? 'selected' : '' }}>Kepala Madrasah</option>
                <option value="guru_kelas" {{ request('jabatan') == 'guru_kelas' ? 'selected' : '' }}>Guru Kelas</option>
                <option value="guru_mapel" {{ request('jabatan') == 'guru_mapel' ? 'selected' : '' }}>Guru Mapel</option>
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
                <th>NIP</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gurus as $guru)
                <tr>
                    <td class="font-mono text-sm">{{ $guru->nip }}</td>
                    <td class="font-medium">{{ $guru->nama }}</td>
                    <td>
                        @php
                            $jabatanClass = match($guru->jabatan) {
                                'kepala_madrasah' => 'badge-primary',
                                'guru_kelas' => 'badge-success',
                                'guru_mapel' => 'badge-info',
                                default => 'badge-primary'
                            };
                        @endphp
                        <span class="{{ $jabatanClass }}">{{ $guru->jabatan_label }}</span>
                    </td>
                    <td>{{ $guru->user->email }}</td>
                    <td>{{ $guru->no_hp ?? '-' }}</td>
                    <td>
                        @if($guru->user->is_active)
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.guru.show', $guru) }}" class="btn-ghost btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.guru.edit', $guru) }}" class="btn-ghost btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">
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
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>Belum ada data guru.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $gurus->links() }}
</div>
@endsection
