@extends('layouts.app')

@section('title', 'Data Sekolah')

@section('breadcrumb')
    <a href="{{ route('super-admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Data Sekolah</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Data Sekolah</h1>
        <p class="page-subtitle">Kelola semua sekolah</p>
    </div>
    <a href="{{ route('super-admin.sekolah.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        <span>Tambah Sekolah</span>
    </a>
</div>

<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>Nama Sekolah</th>
                <th>NSM</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th class="text-center">Data</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sekolahs as $sekolah)
                <tr>
                    <td class="font-medium">{{ $sekolah->nama }}</td>
                    <td>
                        <span class="badge-secondary">{{ $sekolah->nsm }}</span>
                    </td>
                    <td class="text-sm text-gray-600">{{ Str::limit($sekolah->alamat, 40) ?? '-' }}</td>
                    <td class="text-sm">
                        @if($sekolah->telepon)
                            <div><i class="fas fa-phone text-xs mr-1"></i>{{ $sekolah->telepon }}</div>
                        @endif
                        @if($sekolah->email)
                            <div><i class="fas fa-envelope text-xs mr-1"></i>{{ $sekolah->email }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-2 text-xs">
                            <span class="badge-info">{{ $sekolah->users_count }} Users</span>
                            <span class="badge-success">{{ $sekolah->gurus_count }} Guru</span>
                            <span class="badge-warning">{{ $sekolah->siswas_count }} Siswa</span>
                        </div>
                    </td>
                    <td>
                        @if($sekolah->is_active)
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('super-admin.sekolah.show', $sekolah) }}" class="btn-ghost btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('super-admin.sekolah.edit', $sekolah) }}" class="btn-ghost btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('super-admin.sekolah.destroy', $sekolah) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus sekolah ini?')">
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
                        <i class="fas fa-school text-4xl mb-3"></i>
                        <p>Belum ada data sekolah.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $sekolahs->links() }}
</div>
@endsection
