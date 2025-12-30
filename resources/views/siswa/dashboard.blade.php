@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('breadcrumb')
    <span class="text-gray-600 font-medium">Dashboard</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Siswa</h1>
    <p class="page-subtitle">Selamat datang, {{ $siswa->nama }}!</p>
</div>

<!-- Student Info Card -->
<div class="card mb-8 bg-gradient-to-r from-primary-100 to-primary-200 border-0">
    <div class="flex flex-col md:flex-row items-center gap-6">
        <div class="w-20 h-20 bg-accent rounded-full flex items-center justify-center">
            <i class="fas fa-user-graduate text-3xl text-white"></i>
        </div>
        <div class="text-center md:text-left">
            <h2 class="text-xl font-bold text-accent">{{ $siswa->nama }}</h2>
            <p class="text-gray-600">NISN: {{ $siswa->nisn }}</p>
            @if($currentRombel)
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-door-open mr-1"></i>{{ $currentRombel->display_name }}
                </p>
            @endif
        </div>
        <div class="md:ml-auto flex gap-4 text-center">
            <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                <p class="text-2xl font-bold text-accent">{{ $stats['ujian_selesai'] }}</p>
                <p class="text-xs text-gray-500">Ujian Selesai</p>
            </div>
            <div class="bg-white rounded-xl px-4 py-3 shadow-sm">
                <p class="text-2xl font-bold text-accent">{{ number_format($stats['rata_rata_nilai'], 1) }}</p>
                <p class="text-xs text-gray-500">Rata-rata Nilai</p>
            </div>
        </div>
    </div>
</div>

<!-- Available Ujians -->
<div class="card mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-accent">
            <i class="fas fa-play-circle mr-2 text-success"></i>Ujian Tersedia
        </h2>
        <a href="{{ route('siswa.ujian.index') }}" class="text-sm text-accent hover:underline">
            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    @if($availableUjians->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($availableUjians as $ujian)
                <div class="card-hover border border-success/30 bg-success-light/30">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $ujian->judul }}</h3>
                            <p class="text-sm text-gray-500">{{ $ujian->pelajaran->nama }}</p>
                        </div>
                        <span class="badge-success">
                            <i class="fas fa-clock mr-1"></i>{{ $ujian->durasi }} menit
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">
                            <i class="fas fa-user mr-1"></i>{{ $ujian->guru->nama }}
                        </span>
                        <a href="{{ route('siswa.ujian.show', $ujian) }}" class="btn-primary btn-sm">
                            <i class="fas fa-play mr-1"></i>Mulai
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-check-circle text-4xl mb-3 text-success"></i>
            <p>Tidak ada ujian yang tersedia saat ini.</p>
        </div>
    @endif
</div>

<!-- Completed Ujians -->
<div class="card">
    <h2 class="text-lg font-semibold text-accent mb-4">
        <i class="fas fa-history mr-2"></i>Ujian Terakhir
    </h2>
    
    @if($completedUjians->count() > 0)
        <div class="space-y-4">
            @foreach($completedUjians as $hasil)
                <div class="flex items-center justify-between p-4 bg-secondary-100 rounded-xl">
                    <div>
                        <h3 class="font-medium text-gray-800">{{ $hasil->ujian->judul }}</h3>
                        <p class="text-sm text-gray-500">
                            {{ $hasil->ujian->pelajaran->nama }} • {{ $hasil->waktu_selesai->format('d M Y H:i') }}
                        </p>
                    </div>
                    <div class="text-right">
                        @php
                            $nilaiClass = $hasil->nilai >= 75 ? 'text-success' : ($hasil->nilai >= 50 ? 'text-warning' : 'text-danger');
                        @endphp
                        <p class="text-2xl font-bold {{ $nilaiClass }}">{{ number_format($hasil->nilai, 0) }}</p>
                        <p class="text-xs text-gray-400">{{ $hasil->benar }}/{{ $hasil->benar + $hasil->salah }} benar</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-3"></i>
            <p>Belum ada riwayat ujian.</p>
        </div>
    @endif
</div>
@endsection
