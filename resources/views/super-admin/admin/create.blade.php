@extends('layouts.app')

@section('title', 'Tambah Admin')

@section('breadcrumb')
    <a href="{{ route('super-admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('super-admin.admin.index') }}" class="text-gray-400 hover:text-accent">Data Admin</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Tambah</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Admin</h1>
        <p class="page-subtitle">Tambahkan admin baru untuk sekolah</p>
    </div>
</div>

<div class="card max-w-2xl">
    <form action="{{ route('super-admin.admin.store') }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            <!-- Sekolah -->
            <div>
                <label for="sekolah_id" class="form-label required">Sekolah</label>
                <select id="sekolah_id" name="sekolah_id" class="form-select @error('sekolah_id') border-danger @enderror" required>
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

            <!-- Nama -->
            <div>
                <label for="name" class="form-label required">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-input @error('name') border-danger @enderror" 
                       value="{{ old('name') }}" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="form-label required">Email</label>
                <input type="email" id="email" name="email" class="form-input @error('email') border-danger @enderror" 
                       value="{{ old('email') }}" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="form-label required">Password</label>
                <input type="password" id="password" name="password" class="form-input @error('password') border-danger @enderror" required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="form-label required">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" class="form-checkbox" {{ old('is_active', true) ? 'checked' : '' }}>
                    <span class="text-sm">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan</span>
            </button>
            <a href="{{ route('super-admin.admin.index') }}" class="btn-ghost">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
@endsection
