@extends('layouts.app')

@section('title', 'Detail Hasil Ujian')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.ujian.index') }}" class="text-gray-400 hover:text-accent">Ujian</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.ujian.hasil', $ujian) }}" class="text-gray-400 hover:text-accent">Hasil</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Detail</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
    <div>
        <h1 class="page-title">Detail Hasil Ujian</h1>
        <p class="page-subtitle">{{ $hasilUjian->siswa->nama ?? 'Siswa' }}</p>
    </div>
    <div class="flex gap-2">
        <button onclick="window.print()" class="btn-primary">
            <i class="fas fa-print"></i>
            <span>Cetak</span>
        </button>
        <a href="{{ route('guru.ujian.hasil', $ujian) }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>

<!-- Printable Content -->
<div class="print-container">
    <!-- Header untuk Print -->
    <div class="hidden print:block text-center mb-6">
        <h1 class="text-2xl font-bold">LAPORAN HASIL UJIAN</h1>
        <p class="text-gray-600">{{ config('app.name', 'CBT Online') }}</p>
    </div>

    <!-- Info Card -->
    <div class="card mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Info Siswa -->
            <div>
                <h3 class="text-lg font-semibold text-accent mb-3">
                    <i class="fas fa-user mr-2"></i>Informasi Siswa
                </h3>
                <table class="w-full text-sm">
                    <tr>
                        <td class="py-1 text-gray-500 w-1/3">Nama</td>
                        <td class="py-1 font-medium">: {{ $hasilUjian->siswa->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-500">NISN</td>
                        <td class="py-1 font-mono">: {{ $hasilUjian->siswa->nisn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-500">Kelas</td>
                        <td class="py-1">: {{ $ujian->rombel->kelas->nama ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            
            <!-- Info Ujian -->
            <div>
                <h3 class="text-lg font-semibold text-accent mb-3">
                    <i class="fas fa-clipboard-list mr-2"></i>Informasi Ujian
                </h3>
                <table class="w-full text-sm">
                    <tr>
                        <td class="py-1 text-gray-500 w-1/3">Ujian</td>
                        <td class="py-1 font-medium">: {{ $ujian->judul }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-500">Mata Pelajaran</td>
                        <td class="py-1">: {{ $ujian->pelajaran->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-500">Tanggal</td>
                        <td class="py-1">: {{ $hasilUjian->waktu_mulai ? $hasilUjian->waktu_mulai->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Nilai untuk Print Only -->
        <div class="hidden print:block mt-4 pt-4 border-t border-gray-300">
            <div class="flex justify-center gap-8 text-center">
                <div>
                    <span class="text-gray-600">Nilai:</span>
                    <span class="font-bold text-lg">{{ number_format($hasilUjian->nilai, 0) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Nilai (hidden on print) -->
        <div class="mt-6 pt-6 border-t border-secondary-200 print:hidden">
            <div class="flex items-center justify-center gap-8">
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Benar</p>
                    <p class="text-2xl font-bold text-accent">
                        {{ $hasilUjian->jawabanSiswas->where('is_benar', true)->count() }}/{{ $ujian->soals->count() }}
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Nilai</p>
                    <p class="text-4xl font-bold {{ $hasilUjian->nilai >= 75 ? 'text-green-600' : ($hasilUjian->nilai >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ number_format($hasilUjian->nilai, 0) }}
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Status</p>
                    <p class="text-2xl font-bold {{ $hasilUjian->nilai >= 75 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $hasilUjian->nilai >= 75 ? 'Hasil Yang Bagus' : 'Belajar Lebih Giat' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Jawaban (hidden on print) -->
    <div class="card print:hidden">
        <h3 class="text-lg font-semibold text-accent mb-4">
            <i class="fas fa-list-ol mr-2"></i>Rincian Jawaban
        </h3>
        
        <div class="space-y-4">
            @foreach($ujian->soals as $index => $soal)
                @php
                    $jawaban = $hasilUjian->jawabanSiswas->where('soal_id', $soal->id)->first();
                    $isBenar = $jawaban && $jawaban->is_benar;
                    $bgClass = $isBenar ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200';
                    $tipeLabel = match($soal->tipe) {
                        'pilihan_ganda' => 'PG',
                        'essay' => 'Essay',
                        'benar_salah' => 'B/S',
                        default => $soal->tipe
                    };
                @endphp
                <div class="p-4 rounded-xl border {{ $bgClass }}">
                    <div class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-full {{ $isBenar ? 'bg-green-500' : 'bg-red-500' }} text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-200 text-gray-600">{{ $tipeLabel }}</span>
                                <span class="text-xs text-gray-500">{{ $soal->poin }} poin</span>
                                @if($isBenar)
                                    <span class="text-xs text-green-600"><i class="fas fa-check-circle"></i> Benar</span>
                                @else
                                    <span class="text-xs text-red-600"><i class="fas fa-times-circle"></i> Salah</span>
                                @endif
                            </div>
                            
                            <p class="text-gray-800 mb-2">{!! nl2br(e($soal->pertanyaan)) !!}</p>
                            
                            @if($soal->gambar)
                                <img src="{{ asset('uploads/' . $soal->gambar) }}" alt="Gambar Soal" class="max-w-xs rounded-lg mb-2">
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-500">Jawaban Siswa:</p>
                                    <p class="font-medium {{ $isBenar ? 'text-green-700' : 'text-red-700' }}">
                                        {{ $jawaban->jawaban ?? 'Tidak dijawab' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Kunci Jawaban:</p>
                                    <p class="font-medium text-green-700">{{ $soal->kunci_jawaban }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer untuk Print (fixed at bottom) -->
    <div class="print-footer hidden print:block text-center text-sm text-gray-500">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        <div class="mt-4 flex justify-end">
            <div class="text-center">
                <p class="mb-8">Tanda Tangan Orang Tua</p>
                <p>_________________________</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        .print\:hidden { display: none !important; }
        .print\:block { display: block !important; }
        body { 
            background: white !important; 
            font-size: 10px !important;
            line-height: 1.3 !important;
        }
        .card { 
            box-shadow: none !important; 
            border: 1px solid #ddd !important; 
            padding: 8px !important;
            margin-bottom: 8px !important;
        }
        .page-header { display: none !important; }
        .print-container {
            max-width: 100% !important;
            padding: 0 !important;
        }
        /* Compact header */
        .print-container h1 {
            font-size: 14px !important;
            margin-bottom: 4px !important;
        }
        .print-container h3 {
            font-size: 11px !important;
            margin-bottom: 4px !important;
        }
        /* Compact tables */
        .print-container table td {
            padding: 2px 0 !important;
            font-size: 10px !important;
        }
        /* Grid layout compact */
        .print-container .grid {
            gap: 8px !important;
        }
        /* Footer compact */
        .print-container .border-t {
            margin-top: 8px !important;
            padding-top: 4px !important;
        }
        /* Make it fit half page */
        .print-container {
            max-height: 45vh !important;
            page-break-inside: avoid;
            position: relative;
        }
        /* Footer fixed at bottom */
        .print-footer {
            position: fixed;
            bottom: 10mm;
            left: 0;
            right: 0;
            padding: 0 10mm;
        }
    }
</style>
@endpush
@endsection
