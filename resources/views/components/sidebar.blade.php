@php
    $user = auth()->user();
    $role = $user->role;
    $currentRoute = request()->route()->getName();
@endphp

<aside id="sidebar" class="sidebar -translate-x-full lg:translate-x-0">
    <!-- Logo -->
    <div class="px-6 py-6 border-b border-accent-600">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-primary-400 rounded-xl flex items-center justify-center">
                <i class="fas fa-graduation-cap text-accent text-xl"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg text-white">CBT Madrasah</h1>
                <p class="text-xs text-primary-300">Ujian Online</p>
            </div>
        </a>
    </div>

    <!-- User Info -->
    <div class="px-4 py-4 border-b border-accent-600">
        <div class="flex items-center gap-3 px-2">
            <div class="w-10 h-10 bg-primary-400 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-accent"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ $user->name }}</p>
                <p class="text-xs text-primary-300 capitalize">{{ $role }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-4 overflow-y-auto">
        @if($role === 'super_admin')
            <!-- Super Admin Menu -->
            <div class="px-4 mb-2">
                <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Management</p>
            </div>
            <a href="{{ route('super-admin.dashboard') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'super-admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('super-admin.sekolah.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'super-admin.sekolah') ? 'active' : '' }}">
                <i class="fas fa-school w-5"></i>
                <span>Data Sekolah</span>
            </a>
            <a href="{{ route('super-admin.admin.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'super-admin.admin') ? 'active' : '' }}">
                <i class="fas fa-user-shield w-5"></i>
                <span>Data Admin</span>
            </a>

            <div class="px-4 mt-6 mb-2">
                <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Data Multi-Sekolah</p>
            </div>
            <a href="{{ route('super-admin.data.guru.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'super-admin.data.guru') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher w-5"></i>
                <span>Semua Guru</span>
            </a>
            <a href="{{ route('super-admin.data.siswa.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'super-admin.data.siswa') ? 'active' : '' }}">
                <i class="fas fa-user-graduate w-5"></i>
                <span>Semua Siswa</span>
            </a>
            <a href="{{ route('super-admin.data.kelas.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'super-admin.data.kelas') ? 'active' : '' }}">
                <i class="fas fa-door-open w-5"></i>
                <span>Semua Kelas</span>
            </a>
            <a href="{{ route('super-admin.data.pelajaran.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'super-admin.data.pelajaran') ? 'active' : '' }}">
                <i class="fas fa-book w-5"></i>
                <span>Semua Pelajaran</span>
            </a>
            <a href="{{ route('super-admin.data.rombel.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'super-admin.data.rombel') ? 'active' : '' }}">
                <i class="fas fa-users w-5"></i>
                <span>Semua Rombel</span>
            </a>

        @elseif($role === 'admin')
            <!-- Admin Menu -->
            <div class="px-4 mb-2">
                <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Menu Utama</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>

            <div class="px-4 mt-6 mb-2">
                <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Data Master</p>
            </div>
            <a href="{{ route('admin.guru.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.guru') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher w-5"></i>
                <span>Data Guru</span>
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.siswa') ? 'active' : '' }}">
                <i class="fas fa-user-graduate w-5"></i>
                <span>Data Siswa</span>
            </a>
            <a href="{{ route('admin.kelas.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.kelas') ? 'active' : '' }}">
                <i class="fas fa-door-open w-5"></i>
                <span>Data Kelas</span>
            </a>
            <a href="{{ route('admin.pelajaran.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.pelajaran') ? 'active' : '' }}">
                <i class="fas fa-book w-5"></i>
                <span>Mata Pelajaran</span>
            </a>
            <a href="{{ route('admin.rombel.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'admin.rombel') ? 'active' : '' }}">
                <i class="fas fa-users w-5"></i>
                <span>Rombel</span>
            </a>

        @elseif($role === 'guru')
            <!-- Guru Menu -->
            <div class="px-4 mb-2">
                <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Menu Utama</p>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'guru.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>

            <div class="px-4 mt-6 mb-2">
                <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider">CBT</p>
            </div>
            <a href="{{ route('guru.bank-soal.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'guru.bank-soal') ? 'active' : '' }}">
                <i class="fas fa-question-circle w-5"></i>
                <span>Bank Soal</span>
            </a>
            <a href="{{ route('guru.ujian.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'guru.ujian') ? 'active' : '' }}">
                <i class="fas fa-file-alt w-5"></i>
                <span>Ujian</span>
            </a>

        @else
            <!-- Siswa Menu -->
            <div class="px-4 mb-2">
                <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Menu Utama</p>
            </div>
            <a href="{{ route('siswa.dashboard') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'siswa.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5"></i>
                <span>Dashboard</span>
            </a>

            <div class="px-4 mt-6 mb-2">
                <p class="text-xs font-semibold text-primary-300 uppercase tracking-wider">Ujian</p>
            </div>
            <a href="{{ route('siswa.ujian.index') }}" class="sidebar-link {{ str_starts_with($currentRoute, 'siswa.ujian') ? 'active' : '' }}">
                <i class="fas fa-file-alt w-5"></i>
                <span>Daftar Ujian</span>
            </a>
        @endif
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-accent-600">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link w-full text-danger-light hover:bg-danger hover:bg-opacity-20">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
