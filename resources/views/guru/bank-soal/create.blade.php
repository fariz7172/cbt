@extends('layouts.app')

@section('title', 'Tambah Soal')

@section('breadcrumb')
    <a href="{{ route('guru.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('guru.bank-soal.index') }}" class="text-gray-400 hover:text-accent">Bank Soal</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Tambah Soal</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Tambah Soal Baru</h1>
    <p class="page-subtitle">Buat soal baru untuk bank soal Anda</p>
</div>

<div class="card max-w-4xl">
    <form action="{{ route('guru.bank-soal.store') }}" method="POST" id="soalForm" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="pelajaran_id" class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="pelajaran_id" id="pelajaran_id" class="form-select @error('pelajaran_id') border-danger @enderror" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($pelajarans as $pelajaran)
                        <option value="{{ $pelajaran->id }}" {{ old('pelajaran_id') == $pelajaran->id ? 'selected' : '' }}>
                            {{ $pelajaran->nama }}
                        </option>
                    @endforeach
                </select>
                @error('pelajaran_id')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tingkat_kelas" class="form-label">Tingkat Kelas <span class="text-danger">*</span></label>
                <select name="tingkat_kelas" id="tingkat_kelas" class="form-select @error('tingkat_kelas') border-danger @enderror" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($tingkatKelas as $tingkat)
                        <option value="{{ $tingkat }}" {{ old('tingkat_kelas') == $tingkat ? 'selected' : '' }}>Kelas {{ $tingkat }}</option>
                    @endforeach
                </select>
                @error('tingkat_kelas')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tipe" class="form-label">Tipe Soal <span class="text-danger">*</span></label>
                <select name="tipe" id="tipe" class="form-select @error('tipe') border-danger @enderror" required>
                    <option value="">Pilih Tipe</option>
                    <option value="pilihan_ganda" {{ old('tipe') == 'pilihan_ganda' ? 'selected' : '' }}>Pilihan Ganda</option>
                    <option value="essay" {{ old('tipe') == 'essay' ? 'selected' : '' }}>Essay</option>
                    <option value="benar_salah" {{ old('tipe') == 'benar_salah' ? 'selected' : '' }}>Benar/Salah</option>
                </select>
                @error('tipe')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="pertanyaan" class="form-label">Pertanyaan <span class="text-danger">*</span></label>
            <textarea name="pertanyaan" id="pertanyaan" rows="4" 
                      class="form-input @error('pertanyaan') border-danger @enderror" 
                      placeholder="Tulis pertanyaan di sini..." required>{{ old('pertanyaan') }}</textarea>
            @error('pertanyaan')
                <p class="text-danger text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload -->
        <div class="mb-6">
            <label for="gambar" class="form-label">Gambar Soal (Opsional)</label>
            <div class="flex items-center gap-4">
                <input type="file" name="gambar" id="gambar" accept="image/*" 
                       class="form-input @error('gambar') border-danger @enderror"
                       onchange="previewImage(this)">
            </div>
            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
            @error('gambar')
                <p class="text-danger text-sm mt-1">{{ $message }}</p>
            @enderror
            <div id="imagePreview" class="mt-3 hidden">
                <img id="preview" src="#" alt="Preview" class="max-w-xs rounded-lg shadow">
            </div>
        </div>

        <!-- Opsi untuk Pilihan Ganda -->
        <div id="opsiContainer" class="mb-6 hidden">
            <label class="form-label">Opsi Jawaban</label>
            <div class="space-y-3">
                @foreach(['A', 'B', 'C', 'D', 'E'] as $index => $label)
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-accent font-semibold">{{ $label }}</span>
                        <input type="text" name="opsi[]" class="form-input flex-1" placeholder="Opsi {{ $label }}" value="{{ old('opsi.'.$index) }}">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Opsi untuk Benar/Salah -->
        <div id="benarSalahContainer" class="mb-6 hidden">
            <label class="form-label">Opsi Jawaban</label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="opsi_bs" value="Benar" class="form-radio">
                    <span>Benar</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="opsi_bs" value="Salah" class="form-radio">
                    <span>Salah</span>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="kunci_jawaban" class="form-label">Kunci Jawaban <span class="text-danger">*</span></label>
                <input type="text" name="kunci_jawaban" id="kunci_jawaban" 
                       class="form-input @error('kunci_jawaban') border-danger @enderror" 
                       placeholder="Masukkan kunci jawaban" value="{{ old('kunci_jawaban') }}" required>
                <p class="text-sm text-gray-500 mt-1">Untuk pilihan ganda, masukkan huruf (A/B/C/D/E)</p>
                @error('kunci_jawaban')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="poin" class="form-label">Poin <span class="text-danger">*</span></label>
                <input type="number" name="poin" id="poin" min="1" 
                       class="form-input @error('poin') border-danger @enderror" 
                       placeholder="Masukkan poin" value="{{ old('poin', 1) }}" required>
                @error('poin')
                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-6 border-t border-secondary-200">
            <a href="{{ route('guru.bank-soal.index') }}" class="btn-secondary">
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                <span>Simpan Soal</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Image preview function
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tipeSelect = document.getElementById('tipe');
        const opsiContainer = document.getElementById('opsiContainer');
        const benarSalahContainer = document.getElementById('benarSalahContainer');

        function toggleOpsi() {
            const tipe = tipeSelect.value;
            opsiContainer.classList.add('hidden');
            benarSalahContainer.classList.add('hidden');

            if (tipe === 'pilihan_ganda') {
                opsiContainer.classList.remove('hidden');
            } else if (tipe === 'benar_salah') {
                benarSalahContainer.classList.remove('hidden');
            }
        }

        tipeSelect.addEventListener('change', toggleOpsi);
        toggleOpsi(); // Initial check
    });
</script>
@endpush
@endsection
