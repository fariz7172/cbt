@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.siswa.index') }}" class="text-gray-400 hover:text-accent">Data Siswa</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Detail</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">{{ $siswa->nama }}</h1>
        <p class="page-subtitle">NISN: {{ $siswa->nisn }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn-secondary">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <a href="{{ route('admin.siswa.index') }}" class="btn-ghost">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Info Pribadi -->
    <div class="lg:col-span-2">
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-user text-accent mr-2"></i>
                Informasi Pribadi
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">NISN</p>
                    <p class="font-medium font-mono">{{ $siswa->nisn }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama Lengkap</p>
                    <p class="font-medium">{{ $siswa->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jenis Kelamin</p>
                    <p class="font-medium">{{ $siswa->jenis_kelamin_label }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                    <p class="font-medium">
                        {{ $siswa->tempat_lahir ?? '-' }}{{ $siswa->tanggal_lahir ? ', ' . $siswa->tanggal_lahir->format('d F Y') : '' }}
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p class="font-medium">{{ $siswa->alamat ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">No. HP Orang Tua</p>
                    <p class="font-medium">{{ $siswa->no_hp_ortu ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $siswa->user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Riwayat Rombel -->
        <div class="card mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-history text-accent mr-2"></i>
                Riwayat Rombel
            </h2>
            
            @if($siswa->rombels->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Tahun Ajaran</th>
                                <th>Semester</th>
                                <th>Wali Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa->rombels as $rombel)
                                <tr>
                                    <td class="font-medium">{{ $rombel->kelas->nama }}</td>
                                    <td>{{ $rombel->tahun_ajaran }}</td>
                                    <td>
                                        <span class="capitalize">{{ $rombel->semester }}</span>
                                    </td>
                                    <td>{{ $rombel->waliKelas->nama ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p>Belum ada riwayat rombel.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status -->
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-info-circle text-accent mr-2"></i>
                Status Akun
            </h2>
            
            <div class="text-center py-4">
                @if($siswa->user->is_active)
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full">
                        <i class="fas fa-check-circle"></i>
                        <span class="font-medium">Aktif</span>
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-700 rounded-full">
                        <i class="fas fa-times-circle"></i>
                        <span class="font-medium">Nonaktif</span>
                    </span>
                @endif
            </div>
            
            <hr class="my-4">
            
            <div class="text-sm text-gray-500 space-y-2">
                <div class="flex justify-between">
                    <span>Terdaftar:</span>
                    <span class="font-medium">{{ $siswa->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Diperbarui:</span>
                    <span class="font-medium">{{ $siswa->updated_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Statistik Ujian -->
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-bar text-accent mr-2"></i>
                Statistik Ujian
            </h2>
            
            @if($siswa->hasilUjians->count() > 0)
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Ujian</span>
                        <span class="text-xl font-bold text-accent">{{ $siswa->hasilUjians->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Rata-rata Nilai</span>
                        <span class="text-xl font-bold text-accent">
                            {{ number_format($siswa->hasilUjians->avg('nilai'), 1) }}
                        </span>
                    </div>
                </div>
            @else
                <div class="text-center py-4 text-gray-500">
                    <i class="fas fa-clipboard-list text-2xl mb-2"></i>
                    <p class="text-sm">Belum ada ujian.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
