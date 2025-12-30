@extends('layouts.app')

@section('title', $ujian->judul)

@section('breadcrumb')
    <a href="{{ route('siswa.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('siswa.ujian.index') }}" class="text-gray-400 hover:text-accent">Daftar Ujian</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">{{ $ujian->judul }}</span>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <!-- Header -->
        <div class="text-center mb-6">
            <span class="badge-info">{{ $ujian->jenis_label }}</span>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $ujian->judul }}</h1>
            <p class="text-gray-500">{{ $ujian->pelajaran->nama }}</p>
        </div>

        <!-- Info -->
        <div class="bg-primary-50 rounded-xl p-6 mb-6">
            <h2 class="font-semibold text-accent mb-4">Informasi Ujian</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Guru</p>
                    <p class="font-medium">{{ $ujian->guru->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Jumlah Soal</p>
                    <p class="font-medium">{{ $ujian->soals->count() }} soal</p>
                </div>
                <div>
                    <p class="text-gray-500">Durasi</p>
                    <p class="font-medium">{{ $ujian->durasi }} menit</p>
                </div>
                <div>
                    <p class="text-gray-500">Waktu Selesai</p>
                    <p class="font-medium">{{ $ujian->waktu_selesai->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        @if($ujian->deskripsi)
            <div class="mb-6">
                <h2 class="font-semibold text-accent mb-2">Petunjuk</h2>
                <p class="text-gray-600">{{ $ujian->deskripsi }}</p>
            </div>
        @endif

        <!-- Rules -->
        <div class="alert-warning mb-6">
            <i class="fas fa-exclamation-triangle text-lg"></i>
            <div>
                <p class="font-medium">Perhatian!</p>
                <ul class="text-sm mt-1 space-y-1">
                    <li>• Pastikan koneksi internet stabil</li>
                    <li>• Ujian tidak dapat diulang setelah dimulai</li>
                    <li>• Waktu akan berjalan otomatis setelah memulai</li>
                </ul>
            </div>
        </div>

        <!-- Action -->
        @if($hasil && $hasil->status === 'selesai')
            <div class="text-center">
                <div class="bg-success-light rounded-xl p-6 mb-4">
                    <i class="fas fa-check-circle text-4xl text-success mb-2"></i>
                    <p class="text-success-dark font-medium">Anda sudah menyelesaikan ujian ini</p>
                    <p class="text-3xl font-bold text-success mt-2">{{ number_format($hasil->nilai, 0) }}</p>
                </div>
                <a href="{{ route('siswa.ujian.hasil', $ujian) }}" class="btn-primary">
                    <i class="fas fa-eye"></i>
                    <span>Lihat Hasil</span>
                </a>
            </div>
        @elseif($hasil && $hasil->status === 'sedang_mengerjakan')
            <form action="{{ route('siswa.ujian.kerjakan', $ujian) }}" method="GET" class="text-center">
                <p class="text-warning-dark mb-4">Anda sedang mengerjakan ujian ini.</p>
                <button type="submit" class="btn-primary btn-lg">
                    <i class="fas fa-play"></i>
                    <span>Lanjutkan Ujian</span>
                </button>
            </form>
        @elseif($ujian->isActive())
            <form action="{{ route('siswa.ujian.start', $ujian) }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="btn-primary btn-lg" onclick="return confirm('Yakin ingin memulai ujian? Waktu akan berjalan setelah memulai.')">
                    <i class="fas fa-play"></i>
                    <span>Mulai Ujian</span>
                </button>
            </form>
        @else
            <div class="text-center text-gray-500">
                <i class="fas fa-clock text-4xl mb-2"></i>
                <p>Ujian tidak tersedia saat ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
