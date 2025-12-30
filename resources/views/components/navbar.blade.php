<header class="navbar">
    <div class="flex items-center justify-between">
        <!-- Left: Mobile menu toggle & Breadcrumb -->
        <div class="flex items-center gap-4">
            <button id="sidebar-toggle" class="lg:hidden p-2 rounded-xl hover:bg-primary-100 text-gray-600">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <nav class="hidden sm:flex items-center gap-2 text-sm">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-accent">
                    <i class="fas fa-home"></i>
                </a>
                @hasSection('breadcrumb')
                    <span class="text-gray-300">/</span>
                    @yield('breadcrumb')
                @endif
            </nav>
        </div>

        <!-- Right: User dropdown -->
        <div class="flex items-center gap-4">
            <!-- Notifications (placeholder) -->
            <button class="p-2 rounded-xl hover:bg-primary-100 text-gray-600 relative">
                <i class="fas fa-bell text-lg"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-danger rounded-full"></span>
            </button>

            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-3 p-2 rounded-xl hover:bg-primary-100 transition-colors">
                    <div class="w-8 h-8 bg-primary-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-accent text-sm"></i>
                    </div>
                    <span class="hidden sm:block text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                </button>

                <div x-show="open" @click.away="open = false" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-secondary-200 py-2 z-50">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-primary-50">
                        <i class="fas fa-user-cog w-4"></i>
                        <span>Profil</span>
                    </a>
                    <hr class="my-2 border-secondary-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-2 text-sm text-danger hover:bg-danger-light w-full text-left">
                            <i class="fas fa-sign-out-alt w-4"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
