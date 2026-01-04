@extends('layouts.app')

@section('title', 'Import Soal')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.bank-soal.index') }}" class="text-gray-400 hover:text-accent">Bank Soal</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Import</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Import Soal dari Excel</h1>
    <p class="page-subtitle">Upload file Excel untuk menambahkan soal secara massal</p>
</div>

<!-- Instructions Card -->
<div class="card mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-info-circle text-primary"></i>
        Petunjuk Import
    </h3>
    
    <div class="space-y-3 text-sm text-gray-700">
        <p><strong>1. Download Template Excel</strong></p>
        <p class="ml-4">Klik tombol "Download Template" untuk mendapatkan file contoh dengan format yang benar.</p>
        
        <p><strong>2. Isi Data Soal</strong></p>
        <ul class="ml-8 list-disc space-y-1">
            <li><strong>Mata Pelajaran:</strong> Nama mata pelajaran yang sudah ada di sistem</li>
            <li><strong>Tingkat Kelas:</strong> Angka 1-12</li>
            <li><strong>Tipe:</strong> pilihan_ganda, essay, atau benar_salah</li>
            <li><strong>Pertanyaan:</strong> Teks pertanyaan</li>
            <li><strong>Opsi A-E:</strong> Isi untuk pilihan ganda (minimal 2 opsi), kosongkan untuk essay/benar_salah</li>
            <li><strong>Kunci Jawaban:</strong> Huruf (A/B/C/D/E) untuk pilihan ganda, teks untuk essay, benar/salah untuk benar_salah</li>
            <li><strong>Poin:</strong> Nilai poin soal (angka)</li>
        </ul>
        
        <p><strong>3. Upload File</strong></p>
        <p class="ml-4">Upload file Excel yang sudah diisi. Sistem akan memvalidasi dan mengimport data.</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('guru.bank-soal.download-template') }}" class="btn-primary">
            <i class="fas fa-download"></i>
            <span>Download Template Excel</span>
        </a>
    </div>
</div>

<!-- Upload Form -->
<div class="card max-w-2xl">
    <form action="{{ route('guru.bank-soal.process-import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="file" class="form-label">File Excel <span class="text-danger">*</span></label>
            <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" 
                   class="form-input @error('file') border-danger @enderror" required>
            @error('file')
                <p class="form-error">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-1">Format: Excel (.xlsx, .xls) atau CSV (maksimal 2MB)</p>
        </div>

        <div class="flex items-center justify-end gap-3 mt-6">
            <a href="{{ route('guru.bank-soal.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-upload"></i>
                <span>Upload & Import</span>
            </button>
        </div>
    </form>
</div>

<!-- Show Import Errors if any -->
@if(session('import_errors') && count(session('import_errors')) > 0)
<div class="card mt-6 border-l-4 border-warning">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">
        <i class="fas fa-exclamation-triangle text-warning"></i>
        Error Import ({{ count(session('import_errors')) }} baris)
    </h3>
    
    <div class="max-h-64 overflow-y-auto">
        <ul class="space-y-1 text-sm text-gray-700">
            @foreach(session('import_errors') as $error)
                <li class="flex items-start gap-2">
                    <i class="fas fa-times-circle text-danger mt-0.5"></i>
                    <span>{{ $error }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@endsection
