<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="font-display text-3xl font-bold text-slate-900 mb-2">Create Account</h2>
        <p class="text-slate-500 text-sm">Bergabunglah untuk pengalaman ujian yang lebih baik</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-slate-900 focus:ring-0 transition-all duration-300 placeholder-slate-400 font-medium text-slate-900"
                placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-slate-900 focus:ring-0 transition-all duration-300 placeholder-slate-400 font-medium text-slate-900"
                placeholder="nama@sekolah.sch.id">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-slate-900 focus:ring-0 transition-all duration-300 placeholder-slate-400 font-medium text-slate-900"
                placeholder="Min. 8 characters">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-slate-900 focus:ring-0 transition-all duration-300 placeholder-slate-400 font-medium text-slate-900"
                placeholder="Repeat password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full py-3.5 rounded-xl bg-slate-900 text-white font-bold text-sm hover:bg-slate-800 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-lg shadow-slate-900/20">
            Create Account
        </button>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-slate-900 hover:underline">Masuk disini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
