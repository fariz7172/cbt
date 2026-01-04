@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.kelas.index') }}" class="text-gray-400 hover:text-accent">Data Kelas</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Tambah Kelas</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Kelas</h1>
    <p class="page-subtitle">Tambahkan data kelas baru</p>
</div>

<div class="card max-w-xl">
    <form action="{{ route('admin.kelas.store') }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            <!-- Sekolah Selection (Super Admin Only) -->
            @if(auth()->user()->isSuperAdmin() && $sekolahs->isNotEmpty())
                <div>
                    <label for="sekolah_id" class="form-label">Sekolah <span class="text-danger">*</span></label>
                    <select name="sekolah_id" id="sekolah_id" class="form-select @error('sekolah_id') border-danger @enderror" required>
                        <option value="">Pilih Sekolah</option>
                        @foreach($sekolahs as $sekolah)
                            <option value="{{ $sekolah->id }}" {{ old('sekolah_id') == $sekolah->id ? 'selected' : '' }}>
                                {{ $sekolah->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('sekolah_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            @endif
            
            <!-- Tingkat -->
            <div>
                <label for="tingkat" class="form-label">Tingkat Kelas <span class="text-danger">*</span></label>
                <select name="tingkat" id="tingkat" 
                        class="form-select @error('tingkat') border-danger @enderror" required>
                    <option value="">Pilih Tingkat</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('tingkat') == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                    @endfor
                </select>
                @error('tingkat')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div>
                <label for="nama" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" 
                       placeholder="Contoh: 1A, 2B, 3C"
                       class="form-input @error('nama') border-danger @enderror" required>
                @error('nama')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Nama kelas harus unik, misalnya: 1A, 1B, 2A, 2B, dst.</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8">
            <a href="{{ route('admin.kelas.index') }}" class="btn-secondary">
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
