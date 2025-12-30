@extends('layouts.app')

@section('title', 'Daftar Ujian')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Ujian</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Daftar Ujian</h1>
        <p class="page-subtitle">Kelola ujian yang Anda buat</p>
    </div>
    <a href="{{ route('guru.ujian.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i>
        <span>Buat Ujian</span>
    </a>
</div>

<!-- Filter -->
<div class="card mb-6">
    <form action="{{ route('guru.ujian.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="w-full sm:w-48">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="w-full sm:w-48">
            <select name="jenis" class="form-select">
                <option value="">Semua Jenis</option>
                <option value="ulangan_harian" {{ request('jenis') == 'ulangan_harian' ? 'selected' : '' }}>Ulangan Harian</option>
                <option value="uts" {{ request('jenis') == 'uts' ? 'selected' : '' }}>UTS</option>
                <option value="uas" {{ request('jenis') == 'uas' ? 'selected' : '' }}>UAS</option>
                <option value="try_out" {{ request('jenis') == 'try_out' ? 'selected' : '' }}>Try Out</option>
            </select>
        </div>
        <button type="submit" class="btn-secondary">
            <i class="fas fa-filter"></i>
            <span>Filter</span>
        </button>
        @if(request()->hasAny(['status', 'jenis']))
            <a href="{{ route('guru.ujian.index') }}" class="btn-ghost">
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
                <th>No</th>
                <th>Judul</th>
                <th>Mata Pelajaran</th>
                <th>Kelas</th>
                <th>Jenis</th>
                <th>Waktu</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ujians as $index => $ujian)
                <tr>
                    <td>{{ $ujians->firstItem() + $index }}</td>
                    <td class="font-medium">{{ $ujian->judul }}</td>
                    <td>{{ $ujian->pelajaran->nama }}</td>
                    <td>{{ $ujian->rombel->kelas->nama ?? '-' }}</td>
                    <td>
                        @php
                            $jenisLabel = match($ujian->jenis) {
                                'ulangan_harian' => 'Ulangan Harian',
                                'uts' => 'UTS',
                                'uas' => 'UAS',
                                'try_out' => 'Try Out',
                                default => $ujian->jenis
                            };
                        @endphp
                        <span class="badge-info">{{ $jenisLabel }}</span>
                    </td>
                    <td>
                        <p class="text-sm">{{ $ujian->waktu_mulai->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500">{{ $ujian->durasi }} menit</p>
                    </td>
                    <td>
                        @php
                            $statusClass = match($ujian->status) {
                                'draft' => 'badge-warning',
                                'published' => 'badge-info',
                                'ongoing' => 'badge-primary',
                                'finished' => 'badge-success',
                                default => 'badge-primary'
                            };
                            $statusLabel = match($ujian->status) {
                                'draft' => 'Draft',
                                'published' => 'Dipublikasikan',
                                'ongoing' => 'Berlangsung',
                                'finished' => 'Selesai',
                                default => $ujian->status
                            };
                        @endphp
                        <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('guru.ujian.show', $ujian) }}" class="btn-ghost btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($ujian->status === 'draft')
                                <a href="{{ route('guru.ujian.edit', $ujian) }}" class="btn-ghost btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('guru.ujian.manage-soal', $ujian) }}" class="btn-ghost btn-sm" title="Kelola Soal">
                                    <i class="fas fa-tasks"></i>
                                </a>
                            @endif
                            @if(in_array($ujian->status, ['published', 'ongoing', 'finished']))
                                <a href="{{ route('guru.ujian.hasil', $ujian) }}" class="btn-ghost btn-sm text-success" title="Lihat Hasil">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                            @endif
                            @if($ujian->status === 'draft')
                                <form action="{{ route('guru.ujian.destroy', $ujian) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus ujian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-ghost btn-sm text-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-3"></i>
                        <p>Belum ada ujian. <a href="{{ route('guru.ujian.create') }}" class="text-accent hover:underline">Buat sekarang!</a></p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $ujians->links() }}
</div>
@endsection
