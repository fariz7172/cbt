@extends('layouts.app')

@section('title', 'Edit Admin')

@section('breadcrumb')
    <a href="{{ route('super-admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('super-admin.admin.index') }}" class="text-gray-400 hover:text-accent">Data Admin</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Edit</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Admin</h1>
        <p class="page-subtitle">Edit data admin {{ $admin->name }}</p>
    </div>
</div>

<div class="card max-w-2xl">
    <form action="{{ route('super-admin.admin.update', $admin) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Sekolah -->
            <div>
                <label for="sekolah_id" class="form-label required">Sekolah</label>
                <select id="sekolah_id" name="sekolah_id" class="form-select @error('sekolah_id') border-danger @enderror" required>
                    <option value="">Pilih Sekolah</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ old('sekolah_id', $admin->sekolah_id) == $sekolah->id ? 'selected' : '' }}>
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
                       value="{{ old('name', $admin->name) }}" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="form-label required">Email</label>
                <input type="email" id="email" name="email" class="form-input @error('email') border-danger @enderror" 
                       value="{{ old('email', $admin->email) }}" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" id="password" name="password" class="form-input @error('password') border-danger @enderror">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
            </div>

            <!-- Status -->
            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" class="form-checkbox" {{ old('is_active', $admin->is_active) ? 'checked' : '' }}>
                    <span class="text-sm">Aktif</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Update</span>
            </button>
            <a href="{{ route('super-admin.admin.index') }}" class="btn-ghost">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>
@endsection
