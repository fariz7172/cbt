@extends('layouts.app')

@section('title', 'Bank Soal')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Bank Soal</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Bank Soal</h1>
        <p class="page-subtitle">Kelola koleksi soal Anda</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('guru.bank-soal.create-batch') }}" class="btn-secondary">
            <i class="fas fa-layer-group"></i>
            <span>Tambah Batch</span>
        </a>
        <a href="{{ route('guru.bank-soal.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i>
            <span>Tambah Soal</span>
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card mb-6">
    <form action="{{ route('guru.bank-soal.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari pertanyaan..." 
                   class="form-input">
        </div>
        <div class="w-full sm:w-48">
            <select name="pelajaran_id" class="form-select">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($pelajarans as $pelajaran)
                    <option value="{{ $pelajaran->id }}" {{ request('pelajaran_id') == $pelajaran->id ? 'selected' : '' }}>
                        {{ $pelajaran->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-full sm:w-36">
            <select name="tingkat_kelas" class="form-select">
                <option value="">Semua Kelas</option>
                @for($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}" {{ request('tingkat_kelas') == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="w-full sm:w-40">
            <select name="tipe" class="form-select">
                <option value="">Semua Tipe</option>
                <option value="pilihan_ganda" {{ request('tipe') == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                <option value="essay" {{ request('tipe') == 'essay' ? 'selected' : '' }}>Essay</option>
                <option value="benar_salah" {{ request('tipe') == 'benar_salah' ? 'selected' : '' }}>Benar/Salah</option>
            </select>
        </div>
        <button type="submit" class="btn-secondary">
            <i class="fas fa-search"></i>
            <span>Cari</span>
        </button>
    </form>
</div>

<!-- Table -->
<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Tipe</th>
                <th>Poin</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soals as $index => $soal)
                <tr>
                    <td>{{ $soals->firstItem() + $index }}</td>
                    <td class="max-w-xs">
                        <p class="truncate" title="{{ strip_tags($soal->pertanyaan) }}">
                            {{ Str::limit(strip_tags($soal->pertanyaan), 60) }}
                        </p>
                    </td>
                    <td>{{ $soal->pelajaran->nama }}</td>
                    <td>Kelas {{ $soal->tingkat_kelas }}</td>
                    <td>
                        @php
                            $tipeClass = match($soal->tipe) {
                                'pilihan_ganda' => 'badge-primary',
                                'essay' => 'badge-info',
                                'benar_salah' => 'badge-warning',
                                default => 'badge-primary'
                            };
                            $tipeLabel = match($soal->tipe) {
                                'pilihan_ganda' => 'Pilihan Ganda',
                                'essay' => 'Essay',
                                'benar_salah' => 'Benar/Salah',
                                default => $soal->tipe
                            };
                        @endphp
                        <span class="{{ $tipeClass }}">{{ $tipeLabel }}</span>
                    </td>
                    <td class="font-semibold">{{ $soal->poin }}</td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('guru.bank-soal.show', $soal) }}" class="btn-ghost btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('guru.bank-soal.edit', $soal) }}" class="btn-ghost btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('guru.bank-soal.destroy', $soal) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-ghost btn-sm text-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>Belum ada soal. <a href="{{ route('guru.bank-soal.create') }}" class="text-accent hover:underline">Buat sekarang!</a></p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $soals->links() }}
</div>
@endsection
