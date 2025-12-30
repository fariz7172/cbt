@extends('layouts.app')

@section('title', 'Nilai Essay')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.ujian.index') }}" class="text-gray-400 hover:text-accent">Ujian</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.ujian.hasil', $ujian) }}" class="text-gray-400 hover:text-accent">Hasil</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Nilai Essay</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Nilai Soal Essay</h1>
        <p class="page-subtitle">{{ $ujian->judul }}</p>
    </div>
    <a href="{{ route('guru.ujian.hasil', $ujian) }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Hasil</span>
    </a>
</div>

@if(count($essayAnswers) > 0)
    <div class="space-y-6">
        @foreach($essayAnswers as $index => $item)
            <div class="card">
                <div class="flex flex-col md:flex-row md:items-start gap-4">
                    <!-- Left: Question & Answer -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-semibold text-sm">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $item['siswa']->nama ?? 'Siswa' }}</h3>
                                <p class="text-xs text-gray-500">NIS: {{ $item['siswa']->nis ?? '-' }}</p>
                            </div>
                            @if(!is_null($item['jawaban']->poin_didapat))
                                <span class="badge-success ml-auto">Sudah Dinilai</span>
                            @else
                                <span class="badge-warning ml-auto">Belum Dinilai</span>
                            @endif
                        </div>
                        
                        <!-- Question -->
                        <div class="bg-secondary-100 rounded-xl p-4 mb-4">
                            <p class="text-sm text-gray-500 mb-2">Pertanyaan:</p>
                            <p class="text-gray-700">{!! nl2br(e($item['soal']->pertanyaan)) !!}</p>
                            @if($item['soal']->gambar)
                                <img src="{{ Storage::url($item['soal']->gambar) }}" alt="Gambar Soal" class="mt-3 max-w-sm rounded-lg">
                            @endif
                        </div>

                        <!-- Student Answer -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                            <p class="text-sm text-blue-600 mb-2">Jawaban Siswa:</p>
                            <p class="text-gray-800">{!! nl2br(e($item['jawaban']->jawaban ?? 'Tidak dijawab')) !!}</p>
                        </div>

                        <!-- Expected Answer -->
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                            <p class="text-sm text-green-600 mb-2">Kunci Jawaban:</p>
                            <p class="text-gray-800">{!! nl2br(e($item['soal']->kunci_jawaban)) !!}</p>
                        </div>
                    </div>

                    <!-- Right: Grading Form -->
                    <div class="md:w-64 bg-secondary-100 rounded-xl p-4">
                        <h4 class="font-semibold text-gray-700 mb-3">Penilaian</h4>
                        <form action="{{ route('guru.ujian.grade-essay', [$ujian, $item['jawaban']]) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Poin (Maks: {{ $item['soal']->poin }})</label>
                                <input type="number" name="poin_didapat" min="0" max="{{ $item['soal']->poin }}" 
                                       value="{{ $item['jawaban']->poin_didapat ?? '' }}"
                                       class="form-input text-center text-xl font-bold" required>
                            </div>
                            <button type="submit" class="btn-primary w-full">
                                <i class="fas fa-check"></i>
                                <span>Simpan Nilai</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card text-center py-12">
        <i class="fas fa-check-circle text-6xl text-green-400 mb-4"></i>
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Essay</h2>
        <p class="text-gray-500">Ujian ini tidak memiliki soal essay atau belum ada siswa yang mengerjakan.</p>
        <a href="{{ route('guru.ujian.hasil', $ujian) }}" class="btn-secondary mt-4">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Hasil</span>
        </a>
    </div>
@endif
@endsection
