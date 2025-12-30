@extends('layouts.app')

@section('title', 'Kelola Siswa Rombel')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-accent">Dashboard</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.rombel.index') }}" class="text-gray-400 hover:text-accent">Data Rombel</a>
    <span class="text-gray-300">/</span>
    <a href="{{ route('admin.rombel.show', $rombel) }}" class="text-gray-400 hover:text-accent">{{ $rombel->kelas->nama }}</a>
    <span class="text-gray-300">/</span>
    <span class="text-gray-600 font-medium">Kelola Siswa</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Kelola Siswa</h1>
    <p class="page-subtitle">{{ $rombel->kelas->nama }} - {{ $rombel->tahun_ajaran }} (Semester {{ ucfirst($rombel->semester) }})</p>
</div>

<div class="card">
    <form action="{{ route('admin.rombel.update-siswa', $rombel) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <!-- Info Alert -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                    <div>
                        <p class="text-blue-800 font-medium">Filter Siswa Berdasarkan Kelas</p>
                        <p class="text-blue-600 text-sm">Hanya menampilkan siswa yang terdaftar di <strong>Kelas {{ $rombel->kelas->nama }}</strong>. Untuk menambah siswa ke kelas ini, edit data siswa dan pilih kelas yang sesuai.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <p class="text-gray-600">Pilih siswa yang akan dimasukkan ke rombel ini:</p>
                <div class="text-sm text-gray-500">
                    <span id="selected-count">{{ count($assignedIds) }}</span> siswa terpilih dari {{ $allSiswas->count() }} siswa
                </div>
            </div>

            <!-- Search -->
            <div class="mb-4">
                <input type="text" id="search-siswa" placeholder="Cari siswa..." class="form-input">
            </div>

            <!-- Select All -->
            <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-200">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="select-all" class="form-checkbox">
                    <span class="font-medium">Pilih Semua</span>
                </label>
                <button type="button" id="clear-all" class="text-sm text-danger hover:underline">
                    Hapus Semua Pilihan
                </button>
            </div>

            <!-- Siswa List -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-96 overflow-y-auto" id="siswa-list">
                @foreach($allSiswas as $siswa)
                    <label class="siswa-item flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition {{ in_array($siswa->id, $assignedIds) ? 'bg-accent/5 border-accent' : '' }}" data-nama="{{ strtolower($siswa->nama) }}" data-nisn="{{ $siswa->nisn }}">
                        <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" 
                               {{ in_array($siswa->id, $assignedIds) ? 'checked' : '' }}
                               class="siswa-checkbox form-checkbox">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 truncate">{{ $siswa->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $siswa->nisn }} · {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </label>
                @endforeach
            </div>

            @if($allSiswas->count() == 0)
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-user-slash text-4xl mb-3"></i>
                    <p>Belum ada data siswa.</p>
                    <a href="{{ route('admin.siswa.create') }}" class="btn-primary btn-sm mt-3">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Siswa</span>
                    </a>
                </div>
            @endif
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-siswa');
    const siswaItems = document.querySelectorAll('.siswa-item');
    const checkboxes = document.querySelectorAll('.siswa-checkbox');
    const selectAllCheckbox = document.getElementById('select-all');
    const clearAllBtn = document.getElementById('clear-all');
    const selectedCount = document.getElementById('selected-count');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        siswaItems.forEach(item => {
            const nama = item.dataset.nama;
            const nisn = item.dataset.nisn;
            if (nama.includes(query) || nisn.includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Update count
    function updateCount() {
        const checked = document.querySelectorAll('.siswa-checkbox:checked').length;
        selectedCount.textContent = checked;
    }

    // Checkbox change handler
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const item = this.closest('.siswa-item');
            if (this.checked) {
                item.classList.add('bg-accent/5', 'border-accent');
            } else {
                item.classList.remove('bg-accent/5', 'border-accent');
            }
            updateCount();
        });
    });

    // Select all
    selectAllCheckbox.addEventListener('change', function() {
        checkboxes.forEach(cb => {
            if (cb.closest('.siswa-item').style.display !== 'none') {
                cb.checked = this.checked;
                const item = cb.closest('.siswa-item');
                if (this.checked) {
                    item.classList.add('bg-accent/5', 'border-accent');
                } else {
                    item.classList.remove('bg-accent/5', 'border-accent');
                }
            }
        });
        updateCount();
    });

    // Clear all
    clearAllBtn.addEventListener('click', function() {
        checkboxes.forEach(cb => {
            cb.checked = false;
            cb.closest('.siswa-item').classList.remove('bg-accent/5', 'border-accent');
        });
        selectAllCheckbox.checked = false;
        updateCount();
    });
});
</script>
@endpush
@endsection
