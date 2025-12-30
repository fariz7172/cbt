@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('breadcrumb')
    <span class="text-gray-600 font-medium">Dashboard</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Admin</h1>
    <p class="page-subtitle">Selamat datang di CBT Madrasah! Berikut ringkasan data sistem.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card">
        <div class="stat-icon-primary">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_guru'] }}</p>
            <p class="text-sm text-gray-500">Total Guru</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-success">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_siswa'] }}</p>
            <p class="text-sm text-gray-500">Total Siswa</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-warning">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_rombel'] }}</p>
            <p class="text-sm text-gray-500">Total Rombel</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-info">
            <i class="fas fa-file-alt"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_ujian'] }}</p>
            <p class="text-sm text-gray-500">Total Ujian</p>
        </div>
    </div>
</div>

<!-- Guru by Jabatan -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="card">
        <h2 class="text-lg font-semibold text-accent mb-4">
            <i class="fas fa-chart-pie mr-2"></i>Guru Berdasarkan Jabatan
        </h2>
        <div class="space-y-4">
            @php
                $jabatanLabels = [
                    'kepala_madrasah' => ['label' => 'Kepala Madrasah', 'color' => 'bg-accent'],
                    'guru_kelas' => ['label' => 'Guru Kelas', 'color' => 'bg-primary-400'],
                    'guru_mapel' => ['label' => 'Guru Mapel', 'color' => 'bg-primary-600'],
                ];
            @endphp
            @foreach($jabatanLabels as $key => $jabatan)
                @php $count = $stats['guru_by_jabatan'][$key] ?? 0; @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full {{ $jabatan['color'] }}"></div>
                        <span class="text-sm text-gray-600">{{ $jabatan['label'] }}</span>
                    </div>
                    <span class="font-semibold text-gray-800">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <h2 class="text-lg font-semibold text-accent mb-4">
            <i class="fas fa-info-circle mr-2"></i>Informasi Sistem
        </h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between py-2 border-b border-secondary-200">
                <span class="text-sm text-gray-600">Total Kelas</span>
                <span class="font-semibold text-gray-800">{{ $stats['total_kelas'] }}</span>
            </div>
            <div class="flex items-center justify-between py-2 border-b border-secondary-200">
                <span class="text-sm text-gray-600">Total Mata Pelajaran</span>
                <span class="font-semibold text-gray-800">{{ $stats['total_pelajaran'] }}</span>
            </div>
            <div class="flex items-center justify-between py-2">
                <span class="text-sm text-gray-600">Total Ujian</span>
                <span class="font-semibold text-gray-800">{{ $stats['total_ujian'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Ujians -->
<div class="card">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-accent">
            <i class="fas fa-clock mr-2"></i>Ujian Terbaru
        </h2>
    </div>
    
    @if($stats['recent_ujians']->count() > 0)
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats['recent_ujians'] as $ujian)
                        <tr>
                            <td class="font-medium">{{ $ujian->judul }}</td>
                            <td>{{ $ujian->pelajaran->nama }}</td>
                            <td>{{ $ujian->rombel->kelas->nama }}</td>
                            <td>{{ $ujian->guru->nama }}</td>
                            <td>
                                @php
                                    $statusClass = match($ujian->status) {
                                        'draft' => 'badge-warning',
                                        'published' => 'badge-info',
                                        'ongoing' => 'badge-primary',
                                        'finished' => 'badge-success',
                                        default => 'badge-primary'
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ $ujian->status_label }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-3"></i>
            <p>Belum ada ujian.</p>
        </div>
    @endif
</div>
@endsection
