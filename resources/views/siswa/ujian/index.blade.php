@extends('layouts.app')

@section('title', 'Daftar Ujian')

@section('breadcrumb')
    <a href="{{ route('siswa.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Daftar Ujian</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Ujian</h1>
    <p class="page-subtitle">Ujian yang tersedia untuk Anda</p>
</div>

@if($ujians->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($ujians as $ujian)
            <div class="card-hover">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <span class="badge-info text-xs mb-2">{{ $ujian->jenis_label }}</span>
                        <h3 class="font-semibold text-lg text-gray-800">{{ $ujian->judul }}</h3>
                        <p class="text-sm text-gray-500">{{ $ujian->pelajaran->nama }}</p>
                    </div>
                </div>

                <!-- Info -->
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock w-4 text-primary-500"></i>
                        <span>{{ $ujian->durasi }} menit</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-question-circle w-4 text-primary-500"></i>
                        <span>{{ $ujian->soals_count }} soal</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar w-4 text-primary-500"></i>
                        <span>{{ $ujian->waktu_mulai->format('d M Y H:i') }}</span>
                    </div>
                </div>

                <!-- Status / Action -->
                @if($ujian->hasil && $ujian->hasil->status === 'selesai')
                    <div class="bg-success-light rounded-xl p-3 text-center">
                        <p class="text-sm text-success-dark font-medium">Selesai</p>
                        <p class="text-2xl font-bold text-success">{{ number_format($ujian->hasil->nilai, 0) }}</p>
                        <a href="{{ route('siswa.ujian.hasil', $ujian) }}" class="text-sm text-accent hover:underline">
                            Lihat Hasil <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @elseif($ujian->is_available)
                    <a href="{{ route('siswa.ujian.show', $ujian) }}" class="btn-primary w-full">
                        <i class="fas fa-play"></i>
                        <span>Mulai Ujian</span>
                    </a>
                @elseif(now()->lt($ujian->waktu_mulai))
                    <div class="bg-warning-light rounded-xl p-3 text-center">
                        <p class="text-sm text-warning-dark">Belum dimulai</p>
                        <p class="text-xs text-gray-500">{{ $ujian->waktu_mulai->diffForHumans() }}</p>
                    </div>
                @else
                    <div class="bg-secondary-200 rounded-xl p-3 text-center">
                        <p class="text-sm text-gray-500">Waktu habis</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div class="card text-center py-12">
        <i class="fas fa-file-alt text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Ujian</h3>
        <p class="text-gray-500">Tidak ada ujian yang tersedia untuk rombel Anda saat ini.</p>
    </div>
@endif
@endsection
