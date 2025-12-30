@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.siswa.index') }}" class="text-gray-400 hover:text-accent">Data Siswa</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Edit Siswa</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Siswa</h1>
    <p class="page-subtitle">Perbarui data siswa: {{ $siswa->nama }}</p>
</div>

<div class="card max-w-2xl">
    <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- NISN -->
            <div>
                <label for="nisn" class="form-label">NISN <span class="text-danger">*</span></label>
                <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}" 
                       class="form-input @error('nisn') border-danger @enderror" required>
                @error('nisn')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div>
                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama) }}" 
                       class="form-input @error('nama') border-danger @enderror" required>
                @error('nama')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" 
                        class="form-select @error('jenis_kelamin') border-danger @enderror" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kelas -->
            <div>
                <label for="kelas_id" class="form-label">Kelas</label>
                <select name="kelas_id" id="kelas_id" 
                        class="form-select @error('kelas_id') border-danger @enderror">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelass as $kelas)
                        <option value="{{ $kelas->id }}" {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama }} (Tingkat {{ $kelas->tingkat }})
                        </option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Pilih kelas untuk menentukan rombel siswa</p>
            </div>

            <!-- Tempat & Tanggal Lahir -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" 
                           class="form-input @error('tempat_lahir') border-danger @enderror">
                    @error('tempat_lahir')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}" 
                           class="form-input @error('tanggal_lahir') border-danger @enderror">
                    @error('tanggal_lahir')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" 
                          class="form-input @error('alamat') border-danger @enderror">{{ old('alamat', $siswa->alamat) }}</textarea>
                @error('alamat')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- No HP Orang Tua -->
            <div>
                <label for="no_hp_ortu" class="form-label">No. HP Orang Tua</label>
                <input type="text" name="no_hp_ortu" id="no_hp_ortu" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu) }}" 
                       class="form-input @error('no_hp_ortu') border-danger @enderror">
                @error('no_hp_ortu')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-gray-200">

            <h3 class="text-lg font-semibold text-gray-700">Akun Login</h3>

            <!-- Email -->
            <div>
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $siswa->user->email) }}" 
                       class="form-input @error('email') border-danger @enderror" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" id="password" 
                           class="form-input @error('password') border-danger @enderror">
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="form-input">
                </div>
            </div>

            <!-- Status Aktif -->
            <div>
                <label class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $siswa->user->is_active) ? 'checked' : '' }}
                           class="form-checkbox">
                    <span class="text-gray-700">Akun Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 mt-8">
            <a href="{{ route('admin.siswa.index') }}" class="btn-secondary">
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
