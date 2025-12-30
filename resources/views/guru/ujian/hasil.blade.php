@extends('layouts.app')

@section('title', 'Hasil Ujian')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.ujian.index') }}" class="text-gray-400 hover:text-accent">Ujian</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Hasil Ujian</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Hasil Ujian: {{ $ujian->judul }}</h1>
        <p class="page-subtitle">{{ $ujian->pelajaran->nama }} • {{ $ujian->rombel->kelas->nama ?? '' }}</p>
    </div>
    <div class="flex gap-2">
        @if(isset($ungradedEssays) && $ungradedEssays > 0)
            <a href="{{ route('guru.ujian.grading', $ujian) }}" class="btn-warning">
                <i class="fas fa-edit"></i>
                <span>Nilai Essay ({{ $ungradedEssays }})</span>
            </a>
        @else
            <a href="{{ route('guru.ujian.grading', $ujian) }}" class="btn-secondary">
                <i class="fas fa-edit"></i>
                <span>Nilai Essay</span>
            </a>
        @endif
        <a href="{{ route('guru.ujian.show', $ujian) }}" class="btn-ghost">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

@if(isset($ungradedEssays) && $ungradedEssays > 0)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
            <div>
                <p class="font-semibold text-yellow-700">{{ $ungradedEssays }} jawaban essay belum dinilai</p>
                <p class="text-sm text-yellow-600">Nilai yang ditampilkan mungkin belum final. <a href="{{ route('guru.ujian.grading', $ujian) }}" class="underline hover:no-underline">Klik di sini untuk menilai.</a></p>
            </div>
        </div>
    </div>
@endif

<!-- Statistics -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="stat-card">
        <div class="stat-icon-primary">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $ujian->hasilUjians->count() }}</p>
            <p class="text-sm text-gray-500">Peserta</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-success">
            <i class="fas fa-chart-line"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">
                {{ $ujian->hasilUjians->count() > 0 ? number_format($ujian->hasilUjians->avg('nilai'), 1) : 0 }}
            </p>
            <p class="text-sm text-gray-500">Rata-rata Nilai</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-info">
            <i class="fas fa-arrow-up"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $ujian->hasilUjians->max('nilai') ?? 0 }}</p>
            <p class="text-sm text-gray-500">Nilai Tertinggi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon-warning">
            <i class="fas fa-arrow-down"></i>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $ujian->hasilUjians->min('nilai') ?? 0 }}</p>
            <p class="text-sm text-gray-500">Nilai Terendah</p>
        </div>
    </div>
</div>

<!-- Results Table -->
<div class="card">
    <h2 class="text-lg font-semibold text-accent mb-4">
        <i class="fas fa-list-ol mr-2"></i>Daftar Hasil
    </h2>

    @if($ujian->hasilUjians->count() > 0)
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Benar</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ujian->hasilUjians->sortByDesc('nilai') as $index => $hasil)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="font-medium">{{ $hasil->siswa->nama ?? '-' }}</td>
                            <td class="font-mono text-sm">{{ $hasil->siswa->nisn ?? '-' }}</td>
                            <td>{{ $hasil->waktu_mulai ? $hasil->waktu_mulai->format('H:i:s') : '-' }}</td>
                            <td>{{ $hasil->waktu_selesai ? $hasil->waktu_selesai->format('H:i:s') : '-' }}</td>
                            <td>
                                {{ $hasil->jawabanSiswas->where('is_benar', true)->count() }}/{{ $ujian->soals->count() }}
                            </td>
                            <td>
                                @if($hasil->isGradingComplete())
                                    <span class="text-lg font-bold {{ $hasil->nilai >= 75 ? 'text-green-600' : ($hasil->nilai >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ number_format($hasil->nilai, 0) }}
                                    </span>
                                @else
                                    <span class="text-sm text-orange-500 font-medium">
                                        <i class="fas fa-clock mr-1"></i>
                                        Koreksi ({{ $hasil->getTotalEssayCount() - $hasil->getUngradedEssayCount() }}/{{ $hasil->getTotalEssayCount() }})
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if(!$hasil->waktu_selesai)
                                    <span class="badge-warning">Berlangsung</span>
                                @elseif(!$hasil->isGradingComplete())
                                    <span class="badge-info">Perlu Koreksi</span>
                                @else
                                    <span class="badge-success">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('guru.ujian.hasil-detail', [$ujian, $hasil]) }}" 
                                   class="btn-ghost btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-3"></i>
            <p>Belum ada siswa yang mengerjakan ujian ini.</p>
        </div>
    @endif
</div>
@endsection
