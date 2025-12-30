@extends('layouts.app')

@section('title', 'Edit Guru')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.guru.index') }}" class="text-gray-400 hover:text-accent">Data Guru</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit Data Guru</h1>
    <p class="page-subtitle">Perbarui informasi data guru</p>
</div>

<div class="card max-w-2xl">
    <form action="{{ route('admin.guru.update', $guru) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="nama">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $guru->nama) }}" 
                   class="form-input @error('nama') border-danger @enderror" required>
            @error('nama')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="nip">NIP <span class="text-danger">*</span></label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $guru->nip) }}" 
                   class="form-input @error('nip') border-danger @enderror" required>
            @error('nip')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="jabatan">Jabatan <span class="text-danger">*</span></label>
            <select name="jabatan" id="jabatan" class="form-select @error('jabatan') border-danger @enderror" required>
                <option value="kepala_madrasah" {{ old('jabatan', $guru->jabatan) == 'kepala_madrasah' ? 'selected' : '' }}>Kepala Madrasah</option>
                <option value="guru_kelas" {{ old('jabatan', $guru->jabatan) == 'guru_kelas' ? 'selected' : '' }}>Guru Kelas</option>
                <option value="guru_mapel" {{ old('jabatan', $guru->jabatan) == 'guru_mapel' ? 'selected' : '' }}>Guru Mata Pelajaran</option>
            </select>
            @error('jabatan')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email', $guru->user->email) }}" 
                   class="form-input @error('email') border-danger @enderror" required>
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="form-group">
                <label class="form-label" for="password">Password Baru</label>
                <input type="password" name="password" id="password" 
                       class="form-input @error('password') border-danger @enderror"
                       placeholder="Kosongkan jika tidak diubah">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="no_hp">No. HP</label>
            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $guru->no_hp) }}" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label" for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3" class="form-textarea">{{ old('alamat', $guru->alamat) }}</textarea>
        </div>

        <div class="form-group">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" 
                       {{ old('is_active', $guru->user->is_active) ? 'checked' : '' }}
                       class="form-checkbox">
                <span class="text-sm text-gray-700">Akun Aktif</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 mt-6">
            <a href="{{ route('admin.guru.index') }}" class="btn-ghost">Batal</a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection
