<x-guest-layout>
    <div class="card shadow-elevated" style="padding:2rem; border-radius:16px;">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="SIPEDIS"
                     class="h-16 w-auto object-contain">
            </div>
            <h1 class="text-xl font-black" style="color:var(--accent-primary); letter-spacing:-.02em;">MyFSR</h1>
            <p class="text-xs mt-1" style="color:var(--text-muted);">Enterprise Management System</p>
        </div>

        @if(session('status'))
            <div class="text-xs font-medium rounded-lg px-4 py-3 mb-5"
                 style="background-color:var(--color-success-bg); color:var(--color-success); border:1px solid var(--color-success-border);">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Email Admin</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                          style="color:var(--text-muted);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           placeholder="admin@sipedis.com"
                           class="form-input pl-10 {{ $errors->has('email') ? 'error' : '' }}">
                </div>
                @error('email')
                    <p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                          style="color:var(--text-muted);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           placeholder="••••••••"
                           class="form-input pl-10 {{ $errors->has('password') ? 'error' : '' }}">
                </div>
                @error('password')
                    <p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember --}}
            <label for="remember_me" class="flex items-center gap-2.5 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 rounded"
                       style="accent-color:var(--accent-primary);">
                <span class="text-sm" style="color:var(--text-secondary);">Ingat saya</span>
            </label>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary btn-lg w-full mt-2"
                    style="justify-content:center;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Masuk ke Dashboard
            </button>
        </form>

        <p class="text-center text-xs mt-6" style="color:var(--text-muted);">
            SIPEDIS &copy; {{ date('Y') }} &mdash; Admin Only Access
        </p>
    </div>
</x-guest-layout>
