@extends('layouts.app')

@section('title', 'Detail Rombel')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.rombel.index') }}" class="text-gray-400 hover:text-accent">Data Rombel</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Detail</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">{{ $rombel->kelas->nama }}</h1>
        <p class="page-subtitle">{{ $rombel->tahun_ajaran }} - Semester {{ ucfirst($rombel->semester) }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.rombel.edit', $rombel) }}" class="btn-secondary">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <a href="{{ route('admin.rombel.index') }}" class="btn-ghost">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Info Rombel -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Info Dasar -->
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-info-circle text-accent mr-2"></i>
                Informasi Rombel
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Kelas</p>
                    <p class="font-medium">{{ $rombel->kelas->nama }} (Tingkat {{ $rombel->kelas->tingkat }})</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tahun Ajaran</p>
                    <p class="font-medium">{{ $rombel->tahun_ajaran }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Semester</p>
                    <p class="font-medium capitalize">{{ $rombel->semester }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Wali Kelas</p>
                    <p class="font-medium">{{ $rombel->waliKelas->nama ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Daftar Siswa -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-users text-accent mr-2"></i>
                    Daftar Siswa ({{ $rombel->siswas->count() }})
                </h2>
                <a href="{{ route('admin.rombel.manage-siswa', $rombel) }}" class="btn-secondary btn-sm">
                    <i class="fas fa-user-plus"></i>
                    <span>Kelola</span>
                </a>
            </div>
            
            @if($rombel->siswas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>L/P</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rombel->siswas as $index => $siswa)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="font-mono text-sm">{{ $siswa->nisn }}</td>
                                    <td class="font-medium">{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->jenis_kelamin }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-user-slash text-4xl mb-3"></i>
                    <p>Belum ada siswa di rombel ini.</p>
                    <a href="{{ route('admin.rombel.manage-siswa', $rombel) }}" class="btn-primary btn-sm mt-3">
                        <i class="fas fa-user-plus"></i>
                        <span>Tambah Siswa</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Daftar Mata Pelajaran -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-book text-accent mr-2"></i>
                    Mata Pelajaran ({{ $rombel->pelajarans->count() }})
                </h2>
                <a href="{{ route('admin.rombel.manage-pelajaran', $rombel) }}" class="btn-secondary btn-sm">
                    <i class="fas fa-book-medical"></i>
                    <span>Kelola</span>
                </a>
            </div>
            
            @if($rombel->pelajarans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru Pengajar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rombel->pelajarans as $pelajaran)
                                @php
                                    $guru = $rombel->gurus->where('pivot.pelajaran_id', $pelajaran->id)->first();
                                @endphp
                                <tr>
                                    <td class="font-mono text-sm">{{ $pelajaran->kode }}</td>
                                    <td class="font-medium">{{ $pelajaran->nama }}</td>
                                    <td>{{ $guru->nama ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-book text-4xl mb-3"></i>
                    <p>Belum ada mata pelajaran di rombel ini.</p>
                    <a href="{{ route('admin.rombel.manage-pelajaran', $rombel) }}" class="btn-primary btn-sm mt-3">
                        <i class="fas fa-book-medical"></i>
                        <span>Tambah Mapel</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar Statistik -->
    <div class="space-y-6">
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-pie text-accent mr-2"></i>
                Statistik
            </h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <span class="text-gray-700">Total Siswa</span>
                    </div>
                    <span class="text-2xl font-bold text-blue-600">{{ $rombel->siswas->count() }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-green-600"></i>
                        </div>
                        <span class="text-gray-700">Total Mapel</span>
                    </div>
                    <span class="text-2xl font-bold text-green-600">{{ $rombel->pelajarans->count() }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-mars text-purple-600"></i>
                        </div>
                        <span class="text-gray-700">Laki-laki</span>
                    </div>
                    <span class="text-2xl font-bold text-purple-600">{{ $rombel->siswas->where('jenis_kelamin', 'L')->count() }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-pink-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-venus text-pink-600"></i>
                        </div>
                        <span class="text-gray-700">Perempuan</span>
                    </div>
                    <span class="text-2xl font-bold text-pink-600">{{ $rombel->siswas->where('jenis_kelamin', 'P')->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-bolt text-accent mr-2"></i>
                Aksi Cepat
            </h2>
            
            <div class="space-y-2">
                <a href="{{ route('admin.rombel.manage-siswa', $rombel) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-user-plus text-accent"></i>
                    <span>Kelola Siswa</span>
                </a>
                <a href="{{ route('admin.rombel.manage-pelajaran', $rombel) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-book-medical text-accent"></i>
                    <span>Kelola Mata Pelajaran</span>
                </a>
                <a href="{{ route('admin.rombel.edit', $rombel) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-edit text-accent"></i>
                    <span>Edit Rombel</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
