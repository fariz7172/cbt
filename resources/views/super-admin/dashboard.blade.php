@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('breadcrumb')
    <span class="text-gray-600 font-medium">Dashboard</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Super Admin Dashboard</h1>
        <p class="page-subtitle">Kelola semua sekolah dan data</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Sekolah -->
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Sekolah</p>
                <h3 class="text-3xl font-bold text-primary">{{ $totalSekolahs }}</h3>
            </div>
            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                <i class="fas fa-school text-2xl text-primary"></i>
            </div>
        </div>
    </div>

    <!-- Total Admin -->
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Admin</p>
                <h3 class="text-3xl font-bold text-blue-600">{{ $totalAdmins }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-shield text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Guru -->
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Guru</p>
                <h3 class="text-3xl font-bold text-green-600">{{ $totalGurus }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Siswa -->
    <div class="card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Siswa</p>
                <h3 class="text-3xl font-bold text-purple-600">{{ $totalSiswas }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-graduate text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Schools List -->
    <div class="card">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold">Daftar Sekolah</h2>
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
                    <th class="text-center">Users</th>
                    <th class="text-center">Guru</th>
                    <th class="text-center">Siswa</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center">Mapel</th>
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
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-medium">
                                {{ $sekolah->users_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-700 font-medium">
                                {{ $sekolah->gurus_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-100 text-purple-700 font-medium">
                                {{ $sekolah->siswas_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                {{ $sekolah->kelas_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-pink-100 text-pink-700 font-medium">
                                {{ $sekolah->pelajarans_count }}
                            </span>
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
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500">
                            <i class="fas fa-school text-4xl mb-3"></i>
                            <p>Belum ada data sekolah.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
