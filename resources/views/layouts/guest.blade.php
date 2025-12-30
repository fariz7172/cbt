<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CBT Madrasah') }}</title>

        <!-- Fonts -->
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
                            'blob': 'blob 7s infinite',
                        },
                        keyframes: {
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
    <body class="font-sans text-slate-900 antialiased mesh-gradient min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
        
        <!-- Animated Blobs -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

        <div class="z-10 w-full flex flex-col items-center">
            <a href="/" class="mb-8 flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-bold font-display text-2xl shadow-lg">
                    C
                </div>
                <span class="font-display font-bold text-2xl text-slate-900 tracking-tight">CBT Online</span>
            </a>

            <div class="w-full sm:max-w-md px-8 py-10 glass-card shadow-2xl rounded-3xl relative">
                {{ $slot }}
            </div>

            <p class="mt-8 text-sm text-slate-500 font-medium">
                &copy; {{ date('Y') }} CBT Madrasah. Secured & Encrypted.
            </p>
        </div>
    </body>
</html>
