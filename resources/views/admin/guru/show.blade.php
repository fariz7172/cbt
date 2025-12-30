@extends('layouts.app')

@section('title', 'Detail Guru')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.guru.index') }}" class="text-gray-400 hover:text-accent">Data Guru</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Detail</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Detail Guru</h1>
        <p class="page-subtitle">Informasi lengkap data guru</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.guru.edit', $guru) }}" class="btn-secondary">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <a href="{{ route('admin.guru.index') }}" class="btn-ghost">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Card -->
    <div class="card text-center">
        <div class="w-24 h-24 bg-primary-200 rounded-full mx-auto flex items-center justify-center mb-4">
            <i class="fas fa-user text-4xl text-accent"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800">{{ $guru->nama }}</h2>
        <p class="text-sm text-gray-500">{{ $guru->nip }}</p>
        <div class="mt-2">
            @php
                $jabatanClass = match($guru->jabatan) {
                    'kepala_madrasah' => 'badge-primary',
                    'guru_kelas' => 'badge-success',
                    'guru_mapel' => 'badge-info',
                    default => 'badge-primary'
                };
            @endphp
            <span class="{{ $jabatanClass }}">{{ $guru->jabatan_label }}</span>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card lg:col-span-2">
        <h3 class="text-lg font-semibold text-accent mb-4">Informasi Akun</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium">{{ $guru->user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">No. HP</p>
                <p class="font-medium">{{ $guru->no_hp ?? '-' }}</p>
            </div>
            <div class="sm:col-span-2">
                <p class="text-sm text-gray-500">Alamat</p>
                <p class="font-medium">{{ $guru->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status Akun</p>
                @if($guru->user->is_active)
                    <span class="badge-success">Aktif</span>
                @else
                    <span class="badge-danger">Nonaktif</span>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500">Terdaftar Sejak</p>
                <p class="font-medium">{{ $guru->created_at->format('d F Y') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Wali Kelas Info -->
@if($guru->rombelWaliKelas->count() > 0)
<div class="card mt-6">
    <h3 class="text-lg font-semibold text-accent mb-4">
        <i class="fas fa-chalkboard mr-2"></i>Wali Kelas
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($guru->rombelWaliKelas as $rombel)
            <div class="bg-primary-50 rounded-xl p-4">
                <h4 class="font-semibold">{{ $rombel->display_name }}</h4>
                <p class="text-sm text-gray-500">{{ $rombel->siswas->count() }} Siswa</p>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
