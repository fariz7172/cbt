@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.pelajaran.index') }}" class="text-gray-400 hover:text-accent">Mata Pelajaran</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Edit Mapel</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Mata Pelajaran</h1>
    <p class="page-subtitle">Perbarui data: {{ $pelajaran->nama }}</p>
</div>

<div class="card max-w-xl">
    <form action="{{ route('admin.pelajaran.update', $pelajaran) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Kode -->
            <div>
                <label for="kode" class="form-label">Kode Mapel <span class="text-danger">*</span></label>
                <input type="text" name="kode" id="kode" value="{{ old('kode', $pelajaran->kode) }}" 
                       placeholder="Contoh: MTK, IPA, BIN"
                       class="form-input @error('kode') border-danger @enderror" required>
                @error('kode')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Kode singkat untuk mata pelajaran (maksimal 10 karakter)</p>
            </div>

            <!-- Nama -->
            <div>
                <label for="nama" class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $pelajaran->nama) }}" 
                       placeholder="Contoh: Matematika"
                       class="form-input @error('nama') border-danger @enderror" required>
                @error('nama')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis -->
            <div>
                <label for="jenis" class="form-label">Jenis Pengajar <span class="text-danger">*</span></label>
                <select name="jenis" id="jenis" 
                        class="form-select @error('jenis') border-danger @enderror" required>
                    <option value="">Pilih Jenis</option>
                    <option value="guru_kelas" {{ old('jenis', $pelajaran->jenis) == 'guru_kelas' ? 'selected' : '' }}>Guru Kelas</option>
                    <option value="guru_mapel" {{ old('jenis', $pelajaran->jenis) == 'guru_mapel' ? 'selected' : '' }}>Guru Mapel</option>
                </select>
                @error('jenis')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">
                    <strong>Guru Kelas:</strong> Mapel diajar oleh wali kelas (Tematik, dll)<br>
                    <strong>Guru Mapel:</strong> Mapel diajar oleh guru khusus (PJOK, Agama, dll)
                </p>
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $pelajaran->is_active) ? 'checked' : '' }}
                           class="form-checkbox">
                    <span class="text-gray-700">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8">
            <a href="{{ route('admin.pelajaran.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection
