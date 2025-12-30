@extends('layouts.app')

@section('title', 'Data Rombel')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Data Rombel</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Data Rombel</h1>
        <p class="page-subtitle">Kelola rombongan belajar</p>
    </div>
    <a href="{{ route('admin.rombel.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        <span>Tambah Rombel</span>
    </a>
</div>

<!-- Filter -->
<div class="card mb-6">
    <form action="{{ route('admin.rombel.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="w-full sm:w-48">
            <select name="tahun_ajaran" class="form-select">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjarans as $ta)
                    <option value="{{ $ta }}" {{ request('tahun_ajaran') == $ta ? 'selected' : '' }}>{{ $ta }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full sm:w-40">
            <select name="semester" class="form-select">
                <option value="">Semua Semester</option>
                <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>
        <div class="w-full sm:w-48">
            <select name="kelas_id" class="form-select">
                <option value="">Semua Kelas</option>
                @foreach($kelass as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-secondary">
            <i class="fas fa-filter"></i>
            <span>Filter</span>
        </button>
        @if(request()->hasAny(['tahun_ajaran', 'semester', 'kelas_id']))
            <a href="{{ route('admin.rombel.index') }}" class="btn-ghost">
                <i class="fas fa-times"></i>
                <span>Reset</span>
            </a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="table-wrapper">
    <table class="table">
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Semester</th>
                <th>Wali Kelas</th>
                <th class="text-center">Siswa</th>
                <th class="text-center">Mapel</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rombels as $rombel)
                <tr>
                    <td class="font-medium">
                        <span class="badge-primary">{{ $rombel->kelas->nama }}</span>
                    </td>
                    <td>{{ $rombel->tahun_ajaran }}</td>
                    <td>
                        <span class="capitalize">{{ $rombel->semester }}</span>
                    </td>
                    <td>{{ $rombel->waliKelas->nama ?? '-' }}</td>
                    <td class="text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-medium">
                            {{ $rombel->siswas_count }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-700 font-medium">
                            {{ $rombel->pelajarans_count }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.rombel.show', $rombel) }}" class="btn-ghost btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.rombel.edit', $rombel) }}" class="btn-ghost btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.rombel.manage-siswa', $rombel) }}" class="btn-ghost btn-sm" title="Kelola Siswa">
                                <i class="fas fa-users"></i>
                            </a>
                            <a href="{{ route('admin.rombel.manage-pelajaran', $rombel) }}" class="btn-ghost btn-sm" title="Kelola Mapel">
                                <i class="fas fa-book"></i>
                            </a>
                            <form action="{{ route('admin.rombel.destroy', $rombel) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus rombel ini?')">
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
                        <i class="fas fa-users-class text-4xl mb-3"></i>
                        <p>Belum ada data rombel.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $rombels->links() }}
</div>
@endsection
