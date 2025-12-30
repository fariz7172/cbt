@extends('layouts.app')

@section('title', 'Tambah Rombel')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.rombel.index') }}" class="text-gray-400 hover:text-accent">Data Rombel</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Tambah Rombel</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Rombel</h1>
    <p class="page-subtitle">Tambahkan rombongan belajar baru</p>
</div>

<div class="card max-w-xl">
    <form action="{{ route('admin.rombel.store') }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            <!-- Kelas -->
            <div>
                <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                <select name="kelas_id" id="kelas_id" 
                        class="form-select @error('kelas_id') border-danger @enderror" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelass as $kelas)
                        <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama }} (Tingkat {{ $kelas->tingkat }})
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tahun Ajaran -->
            <div>
                <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                <input type="text" name="tahun_ajaran" id="tahun_ajaran" value="{{ old('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)) }}" 
                       placeholder="Contoh: 2024/2025"
                       class="form-input @error('tahun_ajaran') border-danger @enderror" required>
                @error('tahun_ajaran')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Semester -->
            <div>
                <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                <select name="semester" id="semester" 
                        class="form-select @error('semester') border-danger @enderror" required>
                    <option value="">Pilih Semester</option>
                    <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                </select>
                @error('semester')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Wali Kelas -->
            <div>
                <label for="wali_kelas_id" class="form-label">Wali Kelas <span class="text-danger">*</span></label>
                <select name="wali_kelas_id" id="wali_kelas_id" 
                        class="form-select @error('wali_kelas_id') border-danger @enderror" required>
                    <option value="">Pilih Wali Kelas</option>
                    @foreach($guruKelas as $guru)
                        <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
                @error('wali_kelas_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Hanya guru dengan jabatan "Guru Kelas" yang dapat menjadi wali kelas.</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8">
            <a href="{{ route('admin.rombel.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan</span>
            </button>
        </div>
    </form>
</div>
@endsection
