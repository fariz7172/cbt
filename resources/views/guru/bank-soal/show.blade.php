@extends('layouts.app')

@section('title', 'Detail Soal')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.bank-soal.index') }}" class="text-gray-400 hover:text-accent">Bank Soal</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Detail Soal</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Detail Soal</h1>
        <p class="page-subtitle">Lihat informasi lengkap soal</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('guru.bank-soal.edit', $soal) }}" class="btn-secondary">
            <i class="fas fa-edit"></i>
            <span>Edit</span>
        </a>
        <a href="{{ route('guru.bank-soal.index') }}" class="btn-ghost">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <div class="card">
            <h2 class="text-lg font-semibold text-accent mb-4">
                <i class="fas fa-question-circle mr-2"></i>Pertanyaan
            </h2>
                {!! nl2br(e($soal->pertanyaan)) !!}
                @if($soal->gambar)
                    <div class="mt-4">
                        <img src="{{ asset('uploads/' . $soal->gambar) }}" alt="Gambar Soal" class="max-w-md rounded-lg shadow">
                    </div>
                @endif
            </div>
        </div>

        @if($soal->tipe === 'pilihan_ganda' && $soal->opsi)
            <div class="card">
                <h2 class="text-lg font-semibold text-accent mb-4">
                    <i class="fas fa-list-ul mr-2"></i>Opsi Jawaban
                </h2>
                <div class="space-y-3">
                    @foreach($soal->opsi as $index => $opsi)
                        @php
                            $label = chr(65 + $index); // A, B, C, D, E
                            $isCorrect = strtoupper($soal->kunci_jawaban) === $label;
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-xl {{ $isCorrect ? 'bg-green-50 border border-green-200' : 'bg-secondary-100' }}">
                            <span class="w-8 h-8 rounded-full {{ $isCorrect ? 'bg-green-500 text-white' : 'bg-primary-100 text-accent' }} flex items-center justify-center font-semibold">
                                {{ $label }}
                            </span>
                            <span class="{{ $isCorrect ? 'text-green-700 font-medium' : 'text-gray-700' }}">{{ $opsi }}</span>
                            @if($isCorrect)
                                <i class="fas fa-check-circle text-green-500 ml-auto"></i>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if($soal->tipe === 'benar_salah')
            <div class="card">
                <h2 class="text-lg font-semibold text-accent mb-4">
                    <i class="fas fa-check-double mr-2"></i>Opsi Jawaban
                </h2>
                <div class="flex gap-4">
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ strtolower($soal->kunci_jawaban) === 'benar' ? 'bg-green-50 border border-green-200' : 'bg-secondary-100' }}">
                        <span class="w-8 h-8 rounded-full {{ strtolower($soal->kunci_jawaban) === 'benar' ? 'bg-green-500 text-white' : 'bg-primary-100 text-accent' }} flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </span>
                        <span>Benar</span>
                        @if(strtolower($soal->kunci_jawaban) === 'benar')
                            <i class="fas fa-check-circle text-green-500"></i>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ strtolower($soal->kunci_jawaban) === 'salah' ? 'bg-green-50 border border-green-200' : 'bg-secondary-100' }}">
                        <span class="w-8 h-8 rounded-full {{ strtolower($soal->kunci_jawaban) === 'salah' ? 'bg-green-500 text-white' : 'bg-primary-100 text-accent' }} flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </span>
                        <span>Salah</span>
                        @if(strtolower($soal->kunci_jawaban) === 'salah')
                            <i class="fas fa-check-circle text-green-500"></i>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if($soal->tipe === 'essay')
            <div class="card">
                <h2 class="text-lg font-semibold text-accent mb-4">
                    <i class="fas fa-key mr-2"></i>Kunci Jawaban
                </h2>
                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                    {!! nl2br(e($soal->kunci_jawaban)) !!}
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <div class="card">
            <h2 class="text-lg font-semibold text-accent mb-4">
                <i class="fas fa-info-circle mr-2"></i>Informasi
            </h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Mata Pelajaran</p>
                    <p class="font-medium text-gray-800">{{ $soal->pelajaran->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tingkat Kelas</p>
                    <p class="font-medium text-gray-800">Kelas {{ $soal->tingkat_kelas }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tipe Soal</p>
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
                </div>
                <div>
                    <p class="text-sm text-gray-500">Poin</p>
                    <p class="text-2xl font-bold text-accent">{{ $soal->poin }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dibuat</p>
                    <p class="font-medium text-gray-800">{{ $soal->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Terakhir Diperbarui</p>
                    <p class="font-medium text-gray-800">{{ $soal->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="card bg-danger-light border border-danger-light">
            <h2 class="text-lg font-semibold text-danger mb-4">
                <i class="fas fa-exclamation-triangle mr-2"></i>Hapus Soal
            </h2>
            <p class="text-sm text-gray-600 mb-4">Tindakan ini tidak dapat dibatalkan. Pastikan soal ini tidak digunakan dalam ujian.</p>
            <form action="{{ route('guru.bank-soal.destroy', $soal) }}" method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus soal ini? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full">
                    <i class="fas fa-trash"></i>
                    <span>Hapus Soal</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
