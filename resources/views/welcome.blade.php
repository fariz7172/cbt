<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CBT Madrasah') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800|plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#A8D8B9',
                        accent: '#2D5A3D',
                        dark: '#0F172A',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }
        @media (min-width: 768px) {
            .bento-grid {
                grid-template-columns: repeat(3, 1fr);
                grid-template-rows: repeat(2, minmax(200px, auto));
            }
            .bento-item-1 { grid-column: span 2; }
            .bento-item-2 { grid-column: span 1; }
            .bento-item-3 { grid-column: span 1; }
            .bento-item-4 { grid-column: span 2; }
        }
        
        .mesh-gradient {
            background-color: #F8FAF9;
            background-image: 
                radial-gradient(at 0% 0%, rgba(168, 216, 185, 0.4) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(45, 90, 61, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 216, 185, 0.2) 0px, transparent 50%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="antialiased text-slate-800 font-sans mesh-gradient min-h-screen">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 top-0 left-0" id="navbar">
        <div class="max-w-screen-xl mx-auto px-6 py-6">
            <div class="glass-card rounded-full px-6 py-3 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-accent text-white flex items-center justify-center font-bold font-display text-lg">
                        C
                    </div>
                    <span class="font-display font-bold text-lg text-slate-900 tracking-tight">CBT Online</span>
                </div>
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-medium text-sm px-5 py-2.5 rounded-full bg-slate-900 text-white hover:bg-slate-800 transition-all">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-medium text-sm px-5 py-2.5 rounded-full bg-slate-900 text-white hover:bg-slate-800 hover:scale-105 transition-all flex items-center gap-2 group">
                                Masuk 
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="pt-32 pb-16 px-6">
        <div class="max-w-screen-xl mx-auto">
            <!-- Header Text -->
            <div class="text-center max-w-4xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-slate-200 text-xs font-semibold text-slate-500 mb-6 uppercase tracking-wider shadow-sm animate-fade-in-up">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Ujian Madrasah 2.0
                </div>
                <h1 class="font-display text-5xl md:text-7xl font-bold tracking-tighter text-slate-900 mb-6 leading-[1.1]">
                    Ujian Digital <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent to-emerald-500">Masa Depan.</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed font-medium">
                    Platform CBT yang dirancang untuk kecepatan, keamanan, dan pengalaman pengguna yang seamless. Kelola ujian tanpa ribet.
                </p>
                
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-slate-900 text-white font-semibold hover:bg-slate-800 transition-all hover:-translate-y-1 shadow-lg shadow-slate-900/20">
                        Mulai Sekarang
                    </a>
                    <a href="#fitur" class="w-full sm:w-auto px-8 py-4 rounded-full bg-white text-slate-700 font-semibold border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all">
                        Pelajari Fitur
                    </a>
                </div>
            </div>

            <!-- Bento Grid Features -->
            <div id="fitur" class="bento-grid relative">
                <!-- Blob Backgrounds -->
                <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob"></div>
                <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-blob animation-delay-2000"></div>
                
                <!-- Feature 1: Large Card -->
                <div class="bento-item-1 glass-card rounded-3xl p-8 relative overflow-hidden group hover:shadow-xl transition-all duration-300 ring-1 ring-slate-900/5">
                    <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-layer-group text-9xl text-accent"></i>
                    </div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl mb-6">
                                <i class="fas fa-th-large"></i>
                            </div>
                            <h3 class="font-display text-2xl font-bold text-slate-900 mb-3">Bank Soal Terintegrasi</h3>
                            <p class="text-slate-500 leading-relaxed max-w-md">
                                Kelola ribuan soal dengan sistem tagging cerdas. Dukungan penuh untuk soal Essay, Pilihan Ganda, dan Benar/Salah dalam satu repositori terpusat.
                            </p>
                        </div>
                        <div class="mt-8 flex gap-2">
                            <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold">Import Word</span>
                            <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold">Acak Soal</span>
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Tall Card -->
                <div class="bento-item-2 bg-slate-900 rounded-3xl p-8 text-white relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 to-slate-800"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white text-xl mb-6 backdrop-blur-sm">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3 class="font-display text-xl font-bold mb-3">Real-time Grading</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-6">
                            Nilai keluar detik itu juga. Analisis butir soal otomatis untuk evaluasi pembelajaran yang lebih akurat.
                        </p>
                        <div class="w-full bg-slate-700/50 rounded-full h-2 mb-2 overflow-hidden">
                            <div class="bg-emerald-400 h-full w-[85%]"></div>
                        </div>
                        <div class="flex justify-between text-xs text-slate-400">
                            <span>Indexing</span>
                            <span>85% Faster</span>
                        </div>
                    </div>
                </div>

                <!-- Feature 3: Standard Card -->
                <div class="bento-item-3 glass-card rounded-3xl p-8 hover:shadow-xl transition-all duration-300 ring-1 ring-slate-900/5 flex flex-col justify-center items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-2xl mb-4 shadow-sm animate-float">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold text-slate-900 mb-2">Anti-Cheat System</h3>
                    <p class="text-slate-500 text-sm">
                        Proteksi ganda dengan token dinamis dan timer server-side untuk integritas ujian.
                    </p>
                </div>

                <!-- Feature 4: Wide Card -->
                <div class="bento-item-4 glass-card rounded-3xl p-8 flex flex-col md:flex-row items-center gap-8 hover:shadow-xl transition-all duration-300 ring-1 ring-slate-900/5">
                    <div class="flex-1">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 text-xl mb-6">
                            <i class="fas fa-mobile-screen"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold text-slate-900 mb-3">Mobile First Design</h3>
                        <p class="text-slate-500 leading-relaxed">
                            Akses ujian dari perangkat apa saja. Tampilan responsif yang menyesuaikan otomatis dengan layar Smartphone, Tablet, maupun Desktop.
                        </p>
                    </div>
                    <div class="flex-1 w-full flex justify-center">
                        <div class="w-48 h-32 bg-slate-100 rounded-2xl shadow-inner border border-slate-200 flex items-center justify-center relative overflow-hidden">
                            <i class="fas fa-desktop text-4xl text-slate-300 absolute -right-4 -bottom-4"></i>
                            <i class="fas fa-mobile-alt text-4xl text-slate-400 z-10"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-20 border-t border-slate-200 pt-10 pb-10 flex flex-col md:flex-row justify-between items-center gap-6">
                 <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-sm">
                        C
                    </div>
                    <span class="font-bold text-slate-700">CBT Online</span>
                </div>
                <div class="flex gap-6 text-sm text-slate-500 font-medium">
                    <a href="#" class="hover:text-slate-900 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-slate-900 transition-colors">Terms</a>
                    <a href="#" class="hover:text-slate-900 transition-colors">Help</a>
                </div>
                <div class="text-sm text-slate-400">
                    &copy; {{ date('Y') }} All rights reserved.
                </div>
            </div>
        </div>
    </main>

</body>
</html>
