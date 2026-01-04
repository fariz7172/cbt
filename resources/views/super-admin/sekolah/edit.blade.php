@extends('layouts.app')

@section('title', 'Edit Sekolah')

@section('breadcrumb')
    <a href="{{ route('super-admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('super-admin.sekolah.index') }}" class="text-gray-400 hover:text-accent">Data Sekolah</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Sekolah</h1>
        <p class="page-subtitle">Edit data sekolah {{ $sekolah->nama }}</p>
    </div>
</div>

<div class="card max-w-3xl">
    <form action="{{ route('super-admin.sekolah.update', $sekolah) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Sekolah -->
            <div class="md:col-span-2">
                <label for="nama" class="form-label required">Nama Sekolah</label>
                <input type="text" id="nama" name="nama" class="form-input @error('nama') border-danger @enderror" 
                       value="{{ old('nama', $sekolah->nama) }}" required>
                @error('nama')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- NSM -->
            <div>
                <label for="nsm" class="form-label required">NSM</label>
                <input type="text" id="nsm" name="nsm" class="form-input @error('nsm') border-danger @enderror" 
                       value="{{ old('nsm', $sekolah->nsm) }}" required>
                @error('nsm')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Telepon -->
            <div>
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" id="telepon" name="telepon" class="form-input @error('telepon') border-danger @enderror" 
                       value="{{ old('telepon', $sekolah->telepon) }}">
                @error('telepon')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="md:col-span-2">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input @error('email') border-danger @enderror" 
                       value="{{ old('email', $sekolah->email) }}">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" class="form-input @error('alamat') border-danger @enderror">{{ old('alamat', $sekolah->alamat) }}</textarea>
                @error('alamat')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo -->
            <div class="md:col-span-2">
                <label for="logo" class="form-label">Logo Sekolah</label>
                @if($sekolah->logo)
                    <div class="mb-2">
                        <img src="{{ Storage::url($sekolah->logo) }}" alt="Logo" class="h-20 w-20 object-cover rounded">
                    </div>
                @endif
                <input type="file" id="logo" name="logo" class="form-input @error('logo') border-danger @enderror" accept="image/*">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</p>
                @error('logo')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="md:col-span-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" class="form-checkbox" {{ old('is_active', $sekolah->is_active) ? 'checked' : '' }}>
                    <span class="text-sm">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Update</span>
            </button>
            <a href="{{ route('super-admin.sekolah.index') }}" class="btn-ghost">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
@endsection
