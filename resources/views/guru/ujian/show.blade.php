@extends('layouts.app')

@section('title', 'Detail Ujian')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.ujian.index') }}" class="text-gray-400 hover:text-accent">Ujian</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">{{ $ujian->judul }}</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">{{ $ujian->judul }}</h1>
        <p class="page-subtitle">{{ $ujian->pelajaran->nama }} • {{ $ujian->rombel->kelas->nama ?? '' }}</p>
    </div>
    <div class="flex gap-2 flex-wrap">
        @if($ujian->status === 'draft')
            <a href="{{ route('guru.ujian.edit', $ujian) }}" class="btn-secondary">
                <i class="fas fa-edit"></i>
                <span>Edit</span>
            </a>
            <a href="{{ route('guru.ujian.manage-soal', $ujian) }}" class="btn-primary">
                <i class="fas fa-tasks"></i>
                <span>Kelola Soal</span>
            </a>
        @endif
        @if(in_array($ujian->status, ['published', 'ongoing', 'finished']))
            <a href="{{ route('guru.ujian.hasil', $ujian) }}" class="btn-success">
                <i class="fas fa-chart-bar"></i>
                <span>Lihat Hasil</span>
            </a>
        @endif
        <a href="{{ route('guru.ujian.index') }}" class="btn-ghost">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Info Card -->
        <div class="card">
            <h2 class="text-lg font-semibold text-accent mb-4">
                <i class="fas fa-info-circle mr-2"></i>Informasi Ujian
            </h2>
            
            @if($ujian->deskripsi)
                <div class="bg-secondary-100 rounded-xl p-4 mb-4">
                    <p class="text-gray-700">{{ $ujian->deskripsi }}</p>
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-primary-50 rounded-xl">
                    <i class="fas fa-clock text-2xl text-accent mb-2"></i>
                    <p class="text-2xl font-bold text-gray-800">{{ $ujian->durasi }}</p>
                    <p class="text-sm text-gray-500">Menit</p>
                </div>
                <div class="text-center p-4 bg-primary-50 rounded-xl">
                    <i class="fas fa-question-circle text-2xl text-accent mb-2"></i>
                    <p class="text-2xl font-bold text-gray-800">{{ $ujian->soals->count() }}</p>
                    <p class="text-sm text-gray-500">Soal</p>
                </div>
                <div class="text-center p-4 bg-primary-50 rounded-xl">
                    <i class="fas fa-star text-2xl text-accent mb-2"></i>
                    <p class="text-2xl font-bold text-gray-800">{{ $ujian->soals->sum('poin') }}</p>
                    <p class="text-sm text-gray-500">Total Poin</p>
                </div>
                <div class="text-center p-4 bg-primary-50 rounded-xl">
                    <i class="fas fa-users text-2xl text-accent mb-2"></i>
                    <p class="text-2xl font-bold text-gray-800">{{ $ujian->hasilUjians->count() }}</p>
                    <p class="text-sm text-gray-500">Peserta</p>
                </div>
            </div>
        </div>

        <!-- Soal List -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-accent">
                    <i class="fas fa-list-ol mr-2"></i>Daftar Soal
                </h2>
                @if($ujian->status === 'draft')
                    <a href="{{ route('guru.ujian.manage-soal', $ujian) }}" class="text-sm text-accent hover:underline">
                        Kelola Soal <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                @endif
            </div>

            @if($ujian->soals->count() > 0)
                <div class="space-y-3">
                    @foreach($ujian->soals as $index => $soal)
                        <div class="flex items-start gap-3 p-3 bg-secondary-100 rounded-xl">
                            <span class="w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-700 truncate">{{ Str::limit(strip_tags($soal->pertanyaan), 80) }}</p>
                                <div class="flex items-center gap-3 mt-1">
                                    @php
                                        $tipeClass = match($soal->tipe) {
                                            'pilihan_ganda' => 'badge-primary',
                                            'essay' => 'badge-info',
                                            'benar_salah' => 'badge-warning',
                                            default => 'badge-primary'
                                        };
                                        $tipeLabel = match($soal->tipe) {
                                            'pilihan_ganda' => 'PG',
                                            'essay' => 'Essay',
                                            'benar_salah' => 'B/S',
                                            default => $soal->tipe
                                        };
                                    @endphp
                                    <span class="{{ $tipeClass }} text-xs">{{ $tipeLabel }}</span>
                                    <span class="text-xs text-gray-500">{{ $soal->poin }} poin</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p>Belum ada soal ditambahkan.</p>
                    @if($ujian->status === 'draft')
                        <a href="{{ route('guru.ujian.manage-soal', $ujian) }}" class="text-accent hover:underline mt-2 inline-block">
                            Tambah soal sekarang
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="card">
            <h2 class="text-lg font-semibold text-accent mb-4">
                <i class="fas fa-flag mr-2"></i>Status
            </h2>
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
            <span class="{{ $statusClass }} text-base px-4 py-2">{{ $statusLabel }}</span>

            @if($ujian->status === 'draft' && $ujian->soals->count() > 0)
                <form action="{{ route('guru.ujian.publish', $ujian) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn-success w-full" 
                            onclick="return confirm('Yakin ingin mempublikasikan ujian ini? Ujian tidak dapat diedit setelah dipublikasikan.')">
                        <i class="fas fa-paper-plane"></i>
                        <span>Publikasikan Ujian</span>
                    </button>
                </form>
            @endif
        </div>

        <!-- Time Info -->
        <div class="card">
            <h2 class="text-lg font-semibold text-accent mb-4">
                <i class="fas fa-calendar-alt mr-2"></i>Jadwal
            </h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Waktu Mulai</p>
                    <p class="font-medium text-gray-800">{{ $ujian->waktu_mulai->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Waktu Selesai</p>
                    <p class="font-medium text-gray-800">{{ $ujian->waktu_selesai->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Durasi</p>
                    <p class="font-medium text-gray-800">{{ $ujian->durasi }} menit</p>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="card">
            <h2 class="text-lg font-semibold text-accent mb-4">
                <i class="fas fa-cog mr-2"></i>Pengaturan
            </h2>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <i class="fas {{ $ujian->acak_soal ? 'fa-check-circle text-green-500' : 'fa-times-circle text-gray-400' }}"></i>
                    <span class="text-sm text-gray-700">Acak Urutan Soal</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas {{ $ujian->acak_opsi ? 'fa-check-circle text-green-500' : 'fa-times-circle text-gray-400' }}"></i>
                    <span class="text-sm text-gray-700">Acak Urutan Opsi</span>
                </div>
                <div class="flex items-center gap-3">
                    <i class="fas {{ $ujian->tampil_nilai ? 'fa-check-circle text-green-500' : 'fa-times-circle text-gray-400' }}"></i>
                    <span class="text-sm text-gray-700">Tampilkan Nilai</span>
                </div>
            </div>
        </div>

        <!-- Jenis -->
        <div class="card">
            <h2 class="text-lg font-semibold text-accent mb-4">
                <i class="fas fa-tag mr-2"></i>Jenis Ujian
            </h2>
            @php
                $jenisLabel = match($ujian->jenis) {
                    'ulangan_harian' => 'Ulangan Harian',
                    'uts' => 'UTS',
                    'uas' => 'UAS',
                    'try_out' => 'Try Out',
                    default => $ujian->jenis
                };
            @endphp
            <span class="badge-info text-base px-4 py-2">{{ $jenisLabel }}</span>
        </div>
    </div>
</div>
@endsection
