@extends('layouts.app')

@section('title', 'Detail Sekolah')

@section('breadcrumb')
    <a href="{{ route('super-admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('super-admin.sekolah.index') }}" class="text-gray-400 hover:text-accent">Data Sekolah</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Detail</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">{{ $sekolah->nama }}</h1>
        <p class="page-subtitle">Detail informasi sekolah</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('super-admin.sekolah.edit', $sekolah) }}" class="btn-secondary">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <a href="{{ route('super-admin.sekolah.index') }}" class="btn-ghost">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Info Sekolah -->
    <div class="lg:col-span-2 card">
        <h2 class="text-lg font-semibold mb-4">Informasi Sekolah</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nama Sekolah</p>
                <p class="font-medium">{{ $sekolah->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">NSM</p>
                <p class="font-medium">{{ $sekolah->nsm }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Telepon</p>
                <p class="font-medium">{{ $sekolah->telepon ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium">{{ $sekolah->email ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Alamat</p>
                <p class="font-medium">{{ $sekolah->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                @if($sekolah->is_active)
                    <span class="badge-success">Aktif</span>
                @else
                    <span class="badge-danger">Nonaktif</span>
                @endif
            </div>
            @if($sekolah->logo)
                <div>
                    <p class="text-sm text-gray-500 mb-2">Logo</p>
                    <img src="{{ Storage::url($sekolah->logo) }}" alt="Logo" class="h-24 w-24 object-cover rounded">
                </div>
            @endif
        </div>
    </div>

    <!-- Statistik -->
    <div class="card">
        <h2 class="text-lg font-semibold mb-4">Statistik</h2>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $sekolah->users_count }}</p>
                </div>
                <i class="fas fa-users text-3xl text-blue-600"></i>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Total Guru</p>
                    <p class="text-2xl font-bold text-green-600">{{ $sekolah->gurus_count }}</p>
                </div>
                <i class="fas fa-chalkboard-teacher text-3xl text-green-600"></i>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Total Siswa</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $sekolah->siswas_count }}</p>
                </div>
                <i class="fas fa-user-graduate text-3xl text-purple-600"></i>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Total Kelas</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $sekolah->kelas_count }}</p>
                </div>
                <i class="fas fa-door-open text-3xl text-yellow-600"></i>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-pink-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Total Mapel</p>
                    <p class="text-2xl font-bold text-pink-600">{{ $sekolah->pelajarans_count }}</p>
                </div>
                <i class="fas fa-book text-3xl text-pink-600"></i>
            </div>
        </div>
    </div>
</div>
@endsection
