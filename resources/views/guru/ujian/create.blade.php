@extends('layouts.app')

@section('title', 'Buat Ujian')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.ujian.index') }}" class="text-gray-400 hover:text-accent">Ujian</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Buat Ujian</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Buat Ujian Baru</h1>
    <p class="page-subtitle">Atur ujian untuk siswa Anda</p>
</div>

<div class="card max-w-4xl">
    <form action="{{ route('guru.ujian.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="judul" class="form-label">Judul Ujian <span class="text-danger">*</span></label>
            <input type="text" name="judul" id="judul" 
                   class="form-input @error('judul') border-danger @enderror" 
                   placeholder="Contoh: Ulangan Harian Matematika Bab 1" 
                   value="{{ old('judul') }}" required>
            @error('judul')
                <p class="text-danger text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="pelajaran_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="pelajaran_id" id="pelajaran_id" class="form-select @error('pelajaran_id') border-danger @enderror" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($pelajarans as $pelajaran)
                        <option value="{{ $pelajaran->id }}" {{ old('pelajaran_id') == $pelajaran->id ? 'selected' : '' }}>
                            {{ $pelajaran->nama }}
                        </option>
                    @endforeach
                </select>
                @error('pelajaran_id')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rombel_id" class="form-label">Kelas/Rombel <span class="text-danger">*</span></label>
                <select name="rombel_id" id="rombel_id" class="form-select @error('rombel_id') border-danger @enderror" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($rombels as $rombel)
                        <option value="{{ $rombel->id }}" {{ old('rombel_id') == $rombel->id ? 'selected' : '' }}>
                            {{ $rombel->kelas->nama ?? 'Kelas' }} - {{ $rombel->nama }}
                        </option>
                    @endforeach
                </select>
                @error('rombel_id')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jenis" class="form-label">Jenis Ujian <span class="text-danger">*</span></label>
                <select name="jenis" id="jenis" class="form-select @error('jenis') border-danger @enderror" required>
                    <option value="">Pilih Jenis</option>
                    <option value="ulangan_harian" {{ old('jenis') == 'ulangan_harian' ? 'selected' : '' }}>Ulangan Harian</option>
                    <option value="uts" {{ old('jenis') == 'uts' ? 'selected' : '' }}>UTS</option>
                    <option value="uas" {{ old('jenis') == 'uas' ? 'selected' : '' }}>UAS</option>
                    <option value="try_out" {{ old('jenis') == 'try_out' ? 'selected' : '' }}>Try Out</option>
                </select>
                @error('jenis')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" 
                      class="form-input @error('deskripsi') border-danger @enderror" 
                      placeholder="Deskripsi ujian (opsional)">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="text-danger text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="waktu_mulai" class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" 
                       class="form-input @error('waktu_mulai') border-danger @enderror" 
                       value="{{ old('waktu_mulai') }}" required>
                @error('waktu_mulai')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="waktu_selesai" class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" 
                       class="form-input @error('waktu_selesai') border-danger @enderror" 
                       value="{{ old('waktu_selesai') }}" required>
                @error('waktu_selesai')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="durasi" class="form-label">Durasi (menit) <span class="text-danger">*</span></label>
                <input type="number" name="durasi" id="durasi" min="1" 
                       class="form-input @error('durasi') border-danger @enderror" 
                       placeholder="60" value="{{ old('durasi', 60) }}" required>
                @error('durasi')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-secondary-100 rounded-xl p-4 mb-6">
            <h3 class="font-semibold text-gray-700 mb-4">Pengaturan Ujian</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="acak_soal" value="1" class="form-checkbox" {{ old('acak_soal') ? 'checked' : '' }}>
                    <span class="text-sm">Acak Urutan Soal</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="acak_opsi" value="1" class="form-checkbox" {{ old('acak_opsi') ? 'checked' : '' }}>
                    <span class="text-sm">Acak Urutan Opsi</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="tampil_nilai" value="1" class="form-checkbox" {{ old('tampil_nilai', true) ? 'checked' : '' }}>
                    <span class="text-sm">Tampilkan Nilai Setelah Selesai</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-6 border-t border-secondary-200">
            <a href="{{ route('guru.ujian.index') }}" class="btn-secondary">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan & Tambah Soal</span>
            </button>
        </div>
    </form>
</div>
@endsection
