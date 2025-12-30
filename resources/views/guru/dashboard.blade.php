@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('breadcrumb')
    <span class="text-gray-600 font-medium">Dashboard</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Guru</h1>
    <p class="page-subtitle">Selamat datang, {{ $guru->nama }}!</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card">
        <div class="stat-icon-primary">
            <i class="fas fa-question-circle"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_soal'] }}</p>
            <p class="text-sm text-gray-500">Bank Soal</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-success">
            <i class="fas fa-file-alt"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_ujian'] }}</p>
            <p class="text-sm text-gray-500">Total Ujian</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-warning">
            <i class="fas fa-play-circle"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['ujian_aktif'] }}</p>
            <p class="text-sm text-gray-500">Ujian Aktif</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-info">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['rombel_mengajar'] }}</p>
            <p class="text-sm text-gray-500">Rombel Mengajar</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <h2 class="text-lg font-semibold text-accent mb-4">
            <i class="fas fa-bolt mr-2"></i>Aksi Cepat
        </h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('guru.bank-soal.create') }}" class="card-hover text-center py-6 bg-primary-50 hover:bg-primary-100">
                <i class="fas fa-plus-circle text-3xl text-accent mb-2"></i>
                <p class="text-sm font-medium text-gray-700">Buat Soal Baru</p>
            </a>
            <a href="{{ route('guru.ujian.create') }}" class="card-hover text-center py-6 bg-primary-50 hover:bg-primary-100">
                <i class="fas fa-file-plus text-3xl text-accent mb-2"></i>
                <p class="text-sm font-medium text-gray-700">Buat Ujian Baru</p>
            </a>
        </div>
    </div>

    @if($rombelWaliKelas)
    <div class="card">
        <h2 class="text-lg font-semibold text-accent mb-4">
            <i class="fas fa-chalkboard mr-2"></i>Wali Kelas
        </h2>
        <div class="bg-primary-50 rounded-xl p-4">
            <h3 class="font-semibold text-lg text-gray-800">{{ $rombelWaliKelas->display_name }}</h3>
            <p class="text-sm text-gray-600 mt-1">
                <i class="fas fa-users mr-1"></i>
                {{ $rombelWaliKelas->siswas->count() }} Siswa
            </p>
        </div>
    </div>
    @endif
</div>

<!-- Recent Ujians -->
<div class="card">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-accent">
            <i class="fas fa-clock mr-2"></i>Ujian Saya
        </h2>
        <a href="{{ route('guru.ujian.index') }}" class="text-sm text-accent hover:underline">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    @if($recentUjians->count() > 0)
        <div class="space-y-4">
            @foreach($recentUjians as $ujian)
                <div class="flex items-center justify-between p-4 bg-secondary-100 rounded-xl hover:bg-primary-50 transition-colors">
                    <div>
                        <h3 class="font-medium text-gray-800">{{ $ujian->judul }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ $ujian->pelajaran->nama }} • {{ $ujian->rombel->kelas->nama }}
                        </p>
                    </div>
                    <div class="text-right">
                        @php
                            $statusClass = match($ujian->status) {
                                'draft' => 'badge-warning',
                                'published' => 'badge-info',
                                'ongoing' => 'badge-primary',
                                'finished' => 'badge-success',
                                default => 'badge-primary'
                            };
                        @endphp
                        <span class="{{ $statusClass }}">{{ $ujian->status_label }}</span>
                        <p class="text-xs text-gray-400 mt-1">{{ $ujian->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-3"></i>
            <p>Belum ada ujian. <a href="{{ route('guru.ujian.create') }}" class="text-accent hover:underline">Buat sekarang!</a></p>
        </div>
    @endif
</div>
@endsection
