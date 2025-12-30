@extends('layouts.app')

@section('title', 'Hasil Ujian')

@section('breadcrumb')
    <a href="{{ route('siswa.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('siswa.ujian.index') }}" class="text-gray-400 hover:text-accent">Daftar Ujian</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Hasil</span>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Result Card -->
    <div class="card text-center mb-8">
        @if($hasil->isGradingComplete())
            <!-- Nilai Sudah Final -->
            <div class="mb-4">
                @if($hasil->nilai >= 75)
                    <div class="w-24 h-24 bg-success-light rounded-full mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-trophy text-4xl text-success"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-success">Selamat!</h2>
                @elseif($hasil->nilai >= 50)
                    <div class="w-24 h-24 bg-warning-light rounded-full mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-star-half-alt text-4xl text-warning"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-warning">Cukup Baik</h2>
                @else
                    <div class="w-24 h-24 bg-danger-light rounded-full mx-auto flex items-center justify-center mb-4">
                        <i class="fas fa-redo text-4xl text-danger"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-danger">Perlu Belajar Lagi</h2>
                @endif
            </div>

            <h1 class="text-5xl font-bold text-gray-800 mb-2">{{ number_format($hasil->nilai, 0) }}</h1>
            <p class="text-gray-500">Nilai Anda</p>

            <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-secondary-200">
                <div>
                    <p class="text-2xl font-bold text-success">{{ $hasil->benar }}</p>
                    <p class="text-sm text-gray-500">Benar</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-danger">{{ $hasil->salah }}</p>
                    <p class="text-sm text-gray-500">Salah</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-600">{{ $hasil->durasi_pengerjaan ?? '-' }}</p>
                    <p class="text-sm text-gray-500">Menit</p>
                </div>
            </div>
        @else
            <!-- Menunggu Koreksi Essay -->
            <div class="mb-4">
                <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-clock text-4xl text-blue-500"></i>
                </div>
                <h2 class="text-xl font-semibold text-blue-600">Menunggu Koreksi</h2>
            </div>

            <p class="text-gray-600 mb-4">
                Ujian Anda memiliki soal essay yang perlu dikoreksi oleh guru.
            </p>
            <p class="text-gray-500 text-sm">
                Nilai akan ditampilkan setelah guru selesai mengoreksi semua jawaban essay.
            </p>

            <div class="mt-6 pt-6 border-t border-secondary-200">
                <div class="flex justify-center gap-8">
                    <div class="text-center">
                        <p class="text-lg font-bold text-orange-500">{{ $hasil->getTotalEssayCount() - $hasil->getUngradedEssayCount() }}/{{ $hasil->getTotalEssayCount() }}</p>
                        <p class="text-sm text-gray-500">Essay Dikoreksi</p>
                    </div>
                    <div class="text-center">
                        <p class="text-lg font-bold text-gray-600">{{ $hasil->durasi_pengerjaan ?? '-' }}</p>
                        <p class="text-sm text-gray-500">Menit</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Exam Info -->
    <div class="card mb-8">
        <h2 class="text-lg font-semibold text-accent mb-4">Informasi Ujian</h2>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Ujian</p>
                <p class="font-medium">{{ $ujian->judul }}</p>
            </div>
            <div>
                <p class="text-gray-500">Mata Pelajaran</p>
                <p class="font-medium">{{ $ujian->pelajaran->nama }}</p>
            </div>
            <div>
                <p class="text-gray-500">Waktu Mulai</p>
                <p class="font-medium">{{ $hasil->waktu_mulai->format('d M Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500">Waktu Selesai</p>
                <p class="font-medium">{{ $hasil->waktu_selesai->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    @if($ujian->tampil_nilai && $hasil->isGradingComplete())
    <!-- Answer Review -->
    <div class="card">
        <h2 class="text-lg font-semibold text-accent mb-4">Pembahasan Jawaban</h2>
        <div class="space-y-6">
            @foreach($hasil->jawabanSiswas as $index => $jawaban)
                <div class="border-b border-secondary-200 pb-6 last:border-0">
                    <div class="flex items-start justify-between mb-3">
                        <span class="badge {{ $jawaban->is_benar ? 'badge-success' : 'badge-danger' }}">
                            Soal {{ $index + 1 }} - {{ $jawaban->is_benar ? 'Benar' : 'Salah' }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $jawaban->poin_didapat }}/{{ $jawaban->soal->poin }} poin</span>
                    </div>

                    <p class="text-gray-800 mb-3">{!! nl2br(e($jawaban->soal->pertanyaan)) !!}</p>
                    
                    @if($jawaban->soal->gambar)
                         <img src="{{ asset('uploads/' . $jawaban->soal->gambar) }}" alt="Gambar Soal" class="max-w-xs rounded-lg mb-3">
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="bg-secondary-100 rounded-xl p-3">
                            <p class="text-gray-500 text-xs mb-1">Jawaban Anda</p>
                            <p class="font-medium {{ $jawaban->is_benar ? 'text-success' : 'text-danger' }}">
                                {{ $jawaban->jawaban ?? '(Tidak dijawab)' }}
                            </p>
                        </div>
                        <div class="bg-success-light rounded-xl p-3">
                            <p class="text-gray-500 text-xs mb-1">Kunci Jawaban</p>
                            <p class="font-medium text-success-dark">{{ $jawaban->soal->kunci_jawaban }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('siswa.ujian.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Daftar Ujian</span>
        </a>
    </div>
</div>
@endsection
