@extends('layouts.app')

@section('title', 'Tambah Soal Batch')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.bank-soal.index') }}" class="text-gray-400 hover:text-accent">Bank Soal</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Tambah Batch</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Soal Sekaligus</h1>
    <p class="page-subtitle">Buat banyak soal dalam satu form dengan cepat (bisa campur tipe)</p>
</div>

<form action="{{ route('guru.bank-soal.store-batch') }}" method="POST" id="batchForm">
    @csrf
    
    <!-- Common Settings -->
    <div class="card mb-6">
        <h2 class="text-lg font-semibold text-accent mb-4">
            <i class="fas fa-cog mr-2"></i>Pengaturan Umum
        </h2>
        <p class="text-sm text-gray-500 mb-4">Pilih pengaturan yang berlaku untuk semua soal</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="pelajaran_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="pelajaran_id" id="pelajaran_id" class="form-select" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($pelajarans as $pelajaran)
                        <option value="{{ $pelajaran->id }}">{{ $pelajaran->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tingkat_kelas" class="form-label">Tingkat Kelas <span class="text-danger">*</span></label>
                <select name="tingkat_kelas" id="tingkat_kelas" class="form-select" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($tingkatKelas as $tingkat)
                        <option value="{{ $tingkat }}">Kelas {{ $tingkat }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Questions Section -->
    <div class="card mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-accent">
                <i class="fas fa-list-ol mr-2"></i>Daftar Soal
            </h2>
            <div class="flex gap-2">
                <button type="button" class="add-question btn-primary" data-type="pilihan_ganda">
                    <i class="fas fa-plus"></i>
                    <span>+ Pilihan Ganda</span>
                </button>
                <button type="button" class="add-question btn-info" data-type="essay">
                    <i class="fas fa-plus"></i>
                    <span>+ Essay</span>
                </button>
                <button type="button" class="add-question btn-warning" data-type="benar_salah">
                    <i class="fas fa-plus"></i>
                    <span>+ Benar/Salah</span>
                </button>
            </div>
        </div>

        <div id="questionsContainer" class="space-y-4">
            <!-- Question rows will be added here dynamically -->
        </div>

        <div id="emptyState" class="text-center py-12 text-gray-400">
            <i class="fas fa-question-circle text-4xl mb-3"></i>
            <p>Belum ada soal. Klik tombol di atas untuk menambah soal.</p>
        </div>
    </div>

    <!-- Submit -->
    <div class="flex items-center justify-between">
        <a href="{{ route('guru.bank-soal.index') }}" class="btn-secondary">
            <i class="fas fa-times"></i>
            <span>Batal</span>
        </a>
        <div class="flex gap-2 items-center">
            <div id="questionSummary" class="text-sm text-gray-500 mr-4">
                <span id="pgCount">0</span> PG, 
                <span id="essayCount">0</span> Essay, 
                <span id="bsCount">0</span> B/S
            </div>
            <button type="submit" class="btn-primary" id="submitBtn" disabled>
                <i class="fas fa-save"></i>
                <span>Simpan Semua Soal</span>
            </button>
        </div>
    </div>
</form>

<!-- Templates -->
<template id="pgTemplate">
    <div class="question-row bg-blue-50 border border-blue-200 rounded-xl p-4" data-index="__INDEX__" data-type="pilihan_ganda">
        <input type="hidden" name="soals[__INDEX__][tipe]" value="pilihan_ganda">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 flex flex-col items-center gap-2">
                <span class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold question-number">__NUM__</span>
                <span class="badge-primary text-xs">PG</span>
            </div>
            <div class="flex-1 space-y-3">
                <div>
                    <label class="text-sm font-semibold text-blue-700 question-label">Soal PG ke-__NUM__</label>
                    <textarea name="soals[__INDEX__][pertanyaan]" rows="2" class="form-input mt-1" placeholder="Tulis pertanyaan pilihan ganda ke-__NUM__..." required></textarea>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-2">
                    <input type="text" name="soals[__INDEX__][opsi][]" class="form-input text-sm" placeholder="A">
                    <input type="text" name="soals[__INDEX__][opsi][]" class="form-input text-sm" placeholder="B">
                    <input type="text" name="soals[__INDEX__][opsi][]" class="form-input text-sm" placeholder="C">
                    <input type="text" name="soals[__INDEX__][opsi][]" class="form-input text-sm" placeholder="D">
                    <input type="text" name="soals[__INDEX__][opsi][]" class="form-input text-sm" placeholder="E">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <input type="text" name="soals[__INDEX__][kunci_jawaban]" class="form-input" placeholder="Kunci (A/B/C/D/E)" required>
                    </div>
                    <div>
                        <input type="number" name="soals[__INDEX__][poin]" class="form-input" value="1" min="1" placeholder="Poin" required>
                    </div>
                </div>
            </div>
            <button type="button" class="remove-question w-10 h-10 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center" title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</template>

<template id="essayTemplate">
    <div class="question-row bg-green-50 border border-green-200 rounded-xl p-4" data-index="__INDEX__" data-type="essay">
        <input type="hidden" name="soals[__INDEX__][tipe]" value="essay">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 flex flex-col items-center gap-2">
                <span class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold question-number">__NUM__</span>
                <span class="badge-success text-xs">Essay</span>
            </div>
            <div class="flex-1 space-y-3">
                <div>
                    <label class="text-sm font-semibold text-green-700 question-label">Soal Essay ke-__NUM__</label>
                    <textarea name="soals[__INDEX__][pertanyaan]" rows="2" class="form-input mt-1" placeholder="Tulis pertanyaan essay ke-__NUM__..." required></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <textarea name="soals[__INDEX__][kunci_jawaban]" rows="2" class="form-input" placeholder="Kunci jawaban / rubrik penilaian..." required></textarea>
                    </div>
                    <div>
                        <input type="number" name="soals[__INDEX__][poin]" class="form-input" value="5" min="1" placeholder="Poin" required>
                    </div>
                </div>
            </div>
            <button type="button" class="remove-question w-10 h-10 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center" title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</template>

<template id="bsTemplate">
    <div class="question-row bg-yellow-50 border border-yellow-200 rounded-xl p-4" data-index="__INDEX__" data-type="benar_salah">
        <input type="hidden" name="soals[__INDEX__][tipe]" value="benar_salah">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 flex flex-col items-center gap-2">
                <span class="w-10 h-10 rounded-full bg-yellow-500 text-white flex items-center justify-center font-bold question-number">__NUM__</span>
                <span class="badge-warning text-xs">B/S</span>
            </div>
            <div class="flex-1 space-y-3">
                <div>
                    <label class="text-sm font-semibold text-yellow-700 question-label">Soal B/S ke-__NUM__</label>
                    <textarea name="soals[__INDEX__][pertanyaan]" rows="2" class="form-input mt-1" placeholder="Tulis pernyataan benar/salah ke-__NUM__..." required></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <select name="soals[__INDEX__][kunci_jawaban]" class="form-select" required>
                            <option value="">Pilih Kunci</option>
                            <option value="Benar">Benar</option>
                            <option value="Salah">Salah</option>
                        </select>
                    </div>
                    <div>
                        <input type="number" name="soals[__INDEX__][poin]" class="form-input" value="1" min="1" placeholder="Poin" required>
                    </div>
                </div>
            </div>
            <button type="button" class="remove-question w-10 h-10 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center" title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('questionsContainer');
    const emptyState = document.getElementById('emptyState');
    const submitBtn = document.getElementById('submitBtn');
    const pgCount = document.getElementById('pgCount');
    const essayCount = document.getElementById('essayCount');
    const bsCount = document.getElementById('bsCount');
    
    let questionIndex = 0;

    function updateUI() {
        const rows = container.querySelectorAll('.question-row');
        const count = rows.length;
        
        emptyState.style.display = count === 0 ? 'block' : 'none';
        submitBtn.disabled = count === 0;
        
        // Update numbers
        rows.forEach((row, idx) => {
            row.querySelector('.question-number').textContent = idx + 1;
        });
        
        // Update counts by type
        pgCount.textContent = container.querySelectorAll('[data-type="pilihan_ganda"]').length;
        essayCount.textContent = container.querySelectorAll('[data-type="essay"]').length;
        bsCount.textContent = container.querySelectorAll('[data-type="benar_salah"]').length;
    }

    function addQuestion(type) {
        let template;
        if (type === 'pilihan_ganda') {
            template = document.getElementById('pgTemplate');
        } else if (type === 'essay') {
            template = document.getElementById('essayTemplate');
        } else {
            template = document.getElementById('bsTemplate');
        }
        
        const html = template.innerHTML
            .replace(/__INDEX__/g, questionIndex)
            .replace(/__NUM__/g, container.querySelectorAll('.question-row').length + 1);
        
        const div = document.createElement('div');
        div.innerHTML = html;
        const newRow = div.firstElementChild;
        
        container.appendChild(newRow);
        questionIndex++;
        
        newRow.querySelector('.remove-question').addEventListener('click', function() {
            newRow.remove();
            updateUI();
        });
        
        updateUI();
        newRow.querySelector('textarea').focus();
    }

    // Add question buttons
    document.querySelectorAll('.add-question').forEach(btn => {
        btn.addEventListener('click', function() {
            addQuestion(this.dataset.type);
        });
    });
});
</script>
@endpush
@endsection
