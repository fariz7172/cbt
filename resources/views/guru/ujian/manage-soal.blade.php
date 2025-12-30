@extends('layouts.app')

@section('title', 'Kelola Soal Ujian')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.ujian.index') }}" class="text-gray-400 hover:text-accent">Ujian</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Kelola Soal</span>
@endsection

@section('content')
<div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="page-title">Kelola Soal Ujian</h1>
        <p class="page-subtitle">{{ $ujian->judul }}</p>
    </div>
    <a href="{{ route('guru.ujian.show', $ujian) }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Soal dalam Ujian -->
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-accent">
                <i class="fas fa-check-circle mr-2"></i>Soal dalam Ujian ({{ $ujian->soals->count() }})
            </h2>
        </div>

        @if($ujian->soals->count() > 0)
            <div class="space-y-3 max-h-[500px] overflow-y-auto">
                @foreach($ujian->soals as $index => $soal)
                    <div class="flex items-start gap-3 p-3 bg-secondary-100 rounded-xl group">
                        <span class="w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-semibold text-sm">{{ $index + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-gray-700 text-sm">{{ Str::limit(strip_tags($soal->pertanyaan), 60) }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                @php
                                    $badgeClass = match($soal->tipe) {
                                        'pilihan_ganda' => 'bg-blue-100 text-blue-700',
                                        'essay' => 'bg-green-100 text-green-700',
                                        'benar_salah' => 'bg-yellow-100 text-yellow-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                    $tipeLabel = match($soal->tipe) {
                                        'pilihan_ganda' => 'PG',
                                        'essay' => 'Essay',
                                        'benar_salah' => 'B/S',
                                        default => $soal->tipe
                                    };
                                @endphp
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $badgeClass }}">{{ $tipeLabel }}</span>
                                <span class="text-xs text-gray-500">{{ $soal->poin }} poin</span>
                            </div>
                        </div>
                        <form action="{{ route('guru.ujian.remove-soal', [$ujian, $soal]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-ghost btn-sm text-danger" onclick="return confirm('Hapus soal ini?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t text-sm flex justify-between">
                <span class="text-gray-500">Total Poin:</span>
                <span class="font-bold text-accent">{{ $ujian->soals->sum('poin') }}</span>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-inbox text-4xl mb-3"></i>
                <p>Belum ada soal.</p>
            </div>
        @endif
    </div>

    <!-- Bank Soal Tersedia -->
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-accent">
                <i class="fas fa-database mr-2"></i>Soal Tersedia ({{ $availableSoals->count() }})
            </h2>
        </div>

        @if($availableSoals->count() > 0)
            <!-- Search & Filter -->
            <div class="flex gap-2 mb-4">
                <input type="text" id="searchSoal" placeholder="Cari pertanyaan..." class="form-input flex-1 text-sm">
                <select id="filterTipe" class="form-select w-32 text-sm">
                    <option value="">Semua Tipe</option>
                    <option value="pilihan_ganda">PG</option>
                    <option value="essay">Essay</option>
                    <option value="benar_salah">B/S</option>
                </select>
            </div>

            <form action="{{ route('guru.ujian.add-soal', $ujian) }}" method="POST">
                @csrf
                <div id="soalList" class="space-y-3 max-h-[400px] overflow-y-auto mb-4">
                    @foreach($availableSoals as $soal)
                        <label class="soal-item flex items-start gap-3 p-3 bg-secondary-100 rounded-xl cursor-pointer hover:bg-primary-50" 
                               data-tipe="{{ $soal->tipe }}" 
                               data-pertanyaan="{{ strtolower(strip_tags($soal->pertanyaan)) }}">
                            <input type="checkbox" name="soal_ids[]" value="{{ $soal->id }}" class="form-checkbox mt-1">
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-700 text-sm">{{ Str::limit(strip_tags($soal->pertanyaan), 60) }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    @php
                                        $badgeClass = match($soal->tipe) {
                                            'pilihan_ganda' => 'bg-blue-100 text-blue-700',
                                            'essay' => 'bg-green-100 text-green-700',
                                            'benar_salah' => 'bg-yellow-100 text-yellow-700',
                                            default => 'bg-gray-100 text-gray-700'
                                        };
                                        $tipeLabel = match($soal->tipe) {
                                            'pilihan_ganda' => 'PG',
                                            'essay' => 'Essay',
                                            'benar_salah' => 'B/S',
                                            default => $soal->tipe
                                        };
                                    @endphp
                                    <span class="text-xs px-2 py-0.5 rounded-full {{ $badgeClass }}">{{ $tipeLabel }}</span>
                                    <span class="text-xs text-gray-500">{{ $soal->poin }} poin</span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                <div id="noResults" class="hidden text-center py-4 text-gray-500">
                    <i class="fas fa-search text-2xl mb-2"></i>
                    <p>Tidak ada soal yang cocok</p>
                </div>
                <button type="submit" class="btn-primary w-full">
                    <i class="fas fa-plus"></i>
                    <span>Tambahkan Soal Terpilih</span>
                </button>
            </form>

            @push('scripts')
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchSoal');
                const filterTipe = document.getElementById('filterTipe');
                const soalItems = document.querySelectorAll('.soal-item');
                const noResults = document.getElementById('noResults');

                function filterSoal() {
                    const search = searchInput.value.toLowerCase();
                    const tipe = filterTipe.value;
                    let visibleCount = 0;

                    soalItems.forEach(item => {
                        const matchSearch = item.dataset.pertanyaan.includes(search);
                        const matchTipe = !tipe || item.dataset.tipe === tipe;
                        
                        if (matchSearch && matchTipe) {
                            item.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            item.classList.add('hidden');
                        }
                    });

                    noResults.classList.toggle('hidden', visibleCount > 0);
                }

                searchInput.addEventListener('input', filterSoal);
                filterTipe.addEventListener('change', filterSoal);
            });
            </script>
            @endpush
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-check-circle text-4xl mb-3 text-green-400"></i>
                <p>Semua soal sudah ditambahkan!</p>
                <a href="{{ route('guru.bank-soal.create') }}" class="text-accent hover:underline mt-2 inline-block">Buat soal baru</a>
            </div>
        @endif
    </div>
</div>
@endsection
