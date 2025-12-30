@extends('layouts.app')

@section('title', 'Kelola Mata Pelajaran Rombel')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.rombel.index') }}" class="text-gray-400 hover:text-accent">Data Rombel</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.rombel.show', $rombel) }}" class="text-gray-400 hover:text-accent">{{ $rombel->kelas->nama }}</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Kelola Mapel</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Mata Pelajaran</h1>
    <p class="page-subtitle">{{ $rombel->kelas->nama }} - {{ $rombel->tahun_ajaran }} (Semester {{ ucfirst($rombel->semester) }})</p>
</div>

<div class="card">
    <form action="{{ route('admin.rombel.update-pelajaran', $rombel) }}" method="POST" id="form-pelajaran">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <!-- Info Alert -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-magic text-green-500 mt-0.5"></i>
                    <div>
                        <p class="text-green-800 font-medium">Auto-Assign Wali Kelas</p>
                        <p class="text-green-600 text-sm">Mata pelajaran dengan jenis "Guru Kelas" akan otomatis dipilih Wali Kelas (<strong>{{ $rombel->waliKelas->nama ?? '-' }}</strong>) sebagai pengajar.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <p class="text-gray-600">Pilih mata pelajaran dan tentukan guru pengajarnya:</p>
                <button type="button" id="add-pelajaran" class="btn-secondary btn-sm">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Mapel</span>
                </button>
            </div>

            <div id="pelajaran-container" class="space-y-4">
                @if($rombel->pelajarans->count() > 0)
                    @foreach($rombel->pelajarans as $index => $pelajaran)
                        @php
                            $assignedGuru = $rombel->gurus->where('pivot.pelajaran_id', $pelajaran->id)->first();
                        @endphp
                        <div class="pelajaran-row flex flex-col sm:flex-row gap-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex-1">
                                <label class="form-label">Mata Pelajaran</label>
                                <select name="pelajarans[{{ $index }}][pelajaran_id]" class="form-select mapel-select" required>
                                    <option value="">Pilih Mapel</option>
                                    @foreach($allPelajarans as $mapel)
                                        <option value="{{ $mapel->id }}" data-jenis="{{ $mapel->jenis }}" {{ $pelajaran->id == $mapel->id ? 'selected' : '' }}>
                                            {{ $mapel->kode }} - {{ $mapel->nama }} ({{ $mapel->jenis == 'guru_kelas' ? 'Guru Kelas' : 'Guru Mapel' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="form-label">Guru Pengajar</label>
                                <select name="pelajarans[{{ $index }}][guru_id]" class="form-select guru-select" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach($allGurus as $guru)
                                        <option value="{{ $guru->id }}" {{ $guru->id == $waliKelasId ? 'data-wali-kelas="true"' : '' }} {{ $assignedGuru && $assignedGuru->id == $guru->id ? 'selected' : '' }}>
                                            {{ $guru->nama }} ({{ $guru->jabatan_label }}){{ $guru->id == $waliKelasId ? ' ★ Wali Kelas' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="btn-danger btn-sm remove-pelajaran">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500" id="empty-state">
                        <i class="fas fa-book text-4xl mb-3"></i>
                        <p>Belum ada mata pelajaran. Klik "Tambah Mapel" untuk menambahkan.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.rombel.show', $rombel) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan</span>
            </button>
        </div>
    </form>
</div>

<!-- Template for new row -->
<template id="pelajaran-template">
    <div class="pelajaran-row flex flex-col sm:flex-row gap-4 p-4 border border-gray-200 rounded-lg">
        <div class="flex-1">
            <label class="form-label">Mata Pelajaran</label>
            <select name="pelajarans[INDEX][pelajaran_id]" class="form-select mapel-select" required>
                <option value="">Pilih Mapel</option>
                @foreach($allPelajarans as $mapel)
                    <option value="{{ $mapel->id }}" data-jenis="{{ $mapel->jenis }}">{{ $mapel->kode }} - {{ $mapel->nama }} ({{ $mapel->jenis == 'guru_kelas' ? 'Guru Kelas' : 'Guru Mapel' }})</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="form-label">Guru Pengajar</label>
            <select name="pelajarans[INDEX][guru_id]" class="form-select guru-select" required>
                <option value="">Pilih Guru</option>
                @foreach($allGurus as $guru)
                    <option value="{{ $guru->id }}" {{ $guru->id == $waliKelasId ? 'data-wali-kelas="true"' : '' }}>{{ $guru->nama }} ({{ $guru->jabatan_label }}){{ $guru->id == $waliKelasId ? ' ★ Wali Kelas' : '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="button" class="btn-danger btn-sm remove-pelajaran">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('pelajaran-container');
    const addBtn = document.getElementById('add-pelajaran');
    const template = document.getElementById('pelajaran-template');
    const emptyState = document.getElementById('empty-state');
    const waliKelasId = '{{ $waliKelasId }}';
    let rowIndex = {{ $rombel->pelajarans->count() }};

    // Hide empty state if there are rows
    function updateEmptyState() {
        const rows = container.querySelectorAll('.pelajaran-row');
        if (emptyState) {
            emptyState.style.display = rows.length === 0 ? '' : 'none';
        }
    }

    // Auto-assign wali kelas for guru_kelas subjects
    function handleMapelChange(selectEl) {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const jenis = selectedOption.dataset.jenis;
        const row = selectEl.closest('.pelajaran-row');
        const guruSelect = row.querySelector('.guru-select');
        
        if (jenis === 'guru_kelas' && waliKelasId) {
            // Auto-select wali kelas
            guruSelect.value = waliKelasId;
            guruSelect.classList.add('bg-green-50', 'border-green-300');
        } else {
            guruSelect.classList.remove('bg-green-50', 'border-green-300');
        }
    }

    // Add new row
    addBtn.addEventListener('click', function() {
        const html = template.innerHTML.replace(/INDEX/g, rowIndex);
        const div = document.createElement('div');
        div.innerHTML = html;
        const newRow = div.firstElementChild;
        container.appendChild(newRow);
        
        // Attach event listener to new mapel select
        const mapelSelect = newRow.querySelector('.mapel-select');
        if (mapelSelect) {
            mapelSelect.addEventListener('change', function() {
                handleMapelChange(this);
            });
        }
        
        rowIndex++;
        updateEmptyState();
    });

    // Remove row
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-pelajaran')) {
            e.target.closest('.pelajaran-row').remove();
            updateEmptyState();
        }
    });

    // Attach event listeners to existing mapel selects
    container.querySelectorAll('.mapel-select').forEach(select => {
        select.addEventListener('change', function() {
            handleMapelChange(this);
        });
    });

    updateEmptyState();
});
</script>
@endpush
@endsection
