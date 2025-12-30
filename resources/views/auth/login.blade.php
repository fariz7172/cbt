<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="font-display text-3xl font-bold text-slate-900 mb-2">Welcome Back</h2>
        <p class="text-slate-500 text-sm">Masuk untuk melanjutkan aktivitas belajar</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-slate-900 focus:ring-0 transition-all duration-300 placeholder-slate-400 font-medium text-slate-900"
                placeholder="nama@sekolah.sch.id">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-slate-600 hover:text-slate-900 font-medium transition-colors" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-slate-900 focus:ring-0 transition-all duration-300 placeholder-slate-400 font-medium text-slate-900"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-300 text-slate-900 shadow-sm focus:ring-slate-900/50 transition-colors" name="remember">
                <span class="ms-2 text-sm text-slate-600 group-hover:text-slate-900 transition-colors font-medium">Keep me logged in</span>
            </label>
        </div>

        <button type="submit" class="w-full py-3.5 rounded-xl bg-slate-900 text-white font-bold text-sm hover:bg-slate-800 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-slate-900/20">
            Sign In to Account
        </button>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-slate-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-slate-900 hover:underline">Buat Akun Baru</a>
            </p>
        </div>
    </form>
</x-guest-layout>
