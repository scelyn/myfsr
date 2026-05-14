<x-guest-layout>
    <div class="bg-slate-900/80 backdrop-blur-xl border border-slate-700/50 rounded-2xl shadow-2xl shadow-black/50 p-8">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="mb-6 flex justify-center w-full">
                <img src="{{ asset('images/logo.png') }}" alt="MyFSR Logo" class="h-24 w-auto object-contain drop-shadow-2xl">
            </div>
            <h1 class="text-2xl font-bold text-theme-text1 tracking-tight">MyFSR</h1>
            <p class="text-theme-text2 text-sm mt-1">Enterprise Management System</p>
        </div>

        @if (session('status'))
            <div class="mb-5 p-3 bg-theme-success/200/10 border border-emerald-500/20 rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
                <span class="text-sm text-emerald-600">{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email Admin</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-theme-text2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@MyFSR.com"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-800/60 border {{ $errors->has('email') ? 'border-red-500/60' : 'border-slate-700/60' }} rounded-xl text-theme-text1 placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/60 transition-all duration-200">
                </div>
                @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-theme-text2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                    </span>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-800/60 border {{ $errors->has('password') ? 'border-red-500/60' : 'border-slate-700/60' }} rounded-xl text-theme-text1 placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500/60 transition-all duration-200">
                </div>
                @error('password')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            {{-- Remember --}}
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-600 bg-slate-800 text-emerald-500 focus:ring-emerald-500/30 focus:ring-offset-0">
                <span class="text-sm text-theme-text2">Ingat saya</span>
            </label>

            {{-- Submit --}}
            <button type="submit"
                class="w-full py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-theme-text1 font-semibold text-sm rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                Masuk ke Dashboard
            </button>
        </form>

        <p class="text-center text-xs text-theme-text1 mt-6">MyFSR &copy; {{ date('Y') }} — Admin Only Access</p>
    </div>
</x-guest-layout>
