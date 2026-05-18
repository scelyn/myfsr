<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SIPEDIS' }} — Enterprise Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.default.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="h-full" style="background-color:var(--bg-app);">

{{-- ===== APP LAYOUT SHELL ===== --}}
<div
    x-data="appShell()"
    x-effect="document.body.style.overflow = (showLogoutConfirm || showSessionWarning) ? 'hidden' : ''"
    class="app-layout"
>

    {{-- ===== SIDEBAR (structural, not a card) ===== --}}
    {{-- ⚠️ Alpine state (sidebarOpen, sidebarCollapsed) must not be renamed --}}
    <aside
        :style="'width:' + sidebarWidth + '; min-width:' + sidebarWidth"
        class="app-sidebar"
        aria-label="Navigasi Utama"
    >
        {{-- ── Logo row (same height as header = 60px) ── --}}
        <div class="app-sidebar-logo">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 min-w-0 no-underline">
                <img src="{{ asset('images/logo.png') }}" alt="SIPEDIS"
                     class="w-8 h-8 object-contain shrink-0">
                <span class="sidebar-label font-black text-sm tracking-wide truncate"
                      style="color:#ffffff;"
                      x-show="!sidebarCollapsed">MyFSR</span>
            </a>
        </div>

        {{-- ── Navigation ── --}}
        <nav class="app-sidebar-nav" aria-label="Menu Navigasi">

            {{-- Dashboard --}}
            <div>
                <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <x-slot name="icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </x-slot>
                    Dashboard
                </x-nav-link-sidebar>
            </div>

            {{-- Master Data --}}
            <div>
                <p class="sidebar-label sidebar-group-title" x-show="!sidebarCollapsed">Master Data</p>
                <div class="space-y-0.5">
                    <x-nav-link-sidebar :href="route('products.index')" :active="request()->routeIs('products.*')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </x-slot>
                        Kelola Data Produk
                    </x-nav-link-sidebar>
                    <x-nav-link-sidebar :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </x-slot>
                        Kelola Data Customer
                    </x-nav-link-sidebar>
                </div>
            </div>

            {{-- Transaksi --}}
            <div>
                <p class="sidebar-label sidebar-group-title" x-show="!sidebarCollapsed">Transaksi</p>
                <div class="space-y-0.5">
                    <x-nav-link-sidebar :href="route('orders.create')" :active="request()->routeIs('orders.create')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4v16m8-8H4"/></svg>
                        </x-slot>
                        Input Pesanan Customer
                    </x-nav-link-sidebar>
                    <x-nav-link-sidebar :href="route('orders.index')" :active="request()->routeIs('orders.index') || request()->routeIs('orders.show')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </x-slot>
                        Daftar Pesanan
                    </x-nav-link-sidebar>
                    <x-nav-link-sidebar :href="route('pricing.daily')" :active="request()->routeIs('pricing.*')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                        </x-slot>
                        Finalisasi Harga Harian
                    </x-nav-link-sidebar>
                </div>
            </div>

            {{-- Keuangan --}}
            <div>
                <p class="sidebar-label sidebar-group-title" x-show="!sidebarCollapsed">Keuangan</p>
                <div class="space-y-0.5">
                    <x-nav-link-sidebar :href="route('invoices.index')" :active="request()->routeIs('invoices.*')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </x-slot>
                        Generate Nota Customer
                    </x-nav-link-sidebar>
                    <x-nav-link-sidebar :href="route('receivables.index')" :active="request()->routeIs('receivables.*')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </x-slot>
                        Kelola Piutang Customer
                    </x-nav-link-sidebar>
                </div>
            </div>

            {{-- Laporan --}}
            <div>
                <p class="sidebar-label sidebar-group-title" x-show="!sidebarCollapsed">Laporan</p>
                <div class="space-y-0.5">
                    <x-nav-link-sidebar :href="route('reports.supplier')" :active="request()->routeIs('reports.supplier*')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </x-slot>
                        Rekap Supplier
                    </x-nav-link-sidebar>
                    <x-nav-link-sidebar :href="route('reports.transactions')" :active="request()->routeIs('reports.transactions')">
                        <x-slot name="icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </x-slot>
                        Laporan Transaksi
                    </x-nav-link-sidebar>
                </div>
            </div>

        </nav>

        {{-- Sidebar Footer --}}
        <div class="app-sidebar-footer">
            <x-nav-link-sidebar :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                <x-slot name="icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </x-slot>
                Pengaturan
            </x-nav-link-sidebar>

            <button type="button"
                @click="showLogoutConfirm = true"
                class="nav-link w-full text-left"
                style="color:var(--text-on-dark-muted);"
                onmouseover="this.style.color='#fca5a5'; this.style.backgroundColor='rgba(220,38,38,0.15)'"
                onmouseout="this.style.color='var(--text-on-dark-muted)'; this.style.backgroundColor=''">
                <span class="nav-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </span>
                <span class="sidebar-label" x-show="!sidebarCollapsed">Keluar</span>
            </button>
        </div>
    </aside>

    {{-- ===== MAIN COLUMN (header + content + footer in one flow) ===== --}}
    <div class="app-main">

        {{-- ── Top Header ── --}}
        <header class="app-header" aria-label="Navigasi Atas">
            {{-- Sidebar toggle --}}
            {{-- ⚠️ Alpine click handlers must stay unchanged --}}
            <button
                @click="sidebarOpen ? (sidebarCollapsed = !sidebarCollapsed) : (sidebarOpen = true, sidebarCollapsed = false)"
                class="icon-btn" style="color:var(--text-on-dark);"
                aria-label="Toggle sidebar"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page title breadcrumb --}}
            <div class="flex-1 min-w-0">
                <h1 class="text-sm font-semibold truncate" style="color:var(--text-on-dark);">
                    {{ $header ?? 'Dashboard' }}
                </h1>
            </div>

            {{-- User chip --}}
            <div class="flex items-center gap-3 shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold" style="color:var(--text-on-dark);">{{ Auth::user()->name }}</p>
                    <p class="text-[10px]" style="color:var(--text-on-dark-muted);">Administrator</p>
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-black no-underline transition-colors"
                   style="background-color:rgba(255,255,255,0.12); color:#ffffff;"
                   title="Profil Admin">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </a>
            </div>
        </header>

        {{-- Flash messages --}}
        <x-flash-message />

        {{-- Page Content --}}
        <main class="app-content animate-fade-in" id="main-content">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="app-footer">
            <p>SIPEDIS &mdash; Enterprise Management System &copy; {{ date('Y') }}</p>
        </footer>
    </div>
    {{-- ===== LOGOUT CONFIRMATION MODAL ===== --}}
    <div x-cloak x-show="showLogoutConfirm"
         class="session-modal-backdrop"
         @click="showLogoutConfirm = false"
         @keydown.escape.window="showLogoutConfirm = false">

        <div x-show="showLogoutConfirm"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.stop
             class="session-modal-panel" style="max-width:26rem;">

            <div class="session-modal-body">
                <div class="session-modal-icon session-modal-icon--danger">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <h3 class="session-modal-title">Konfirmasi Logout</h3>
                <p class="session-modal-text">
                    Anda akan mengakhiri sesi kerja SIPEDIS.<br>
                    Pastikan semua perubahan telah disimpan.
                </p>
            </div>

            <div class="session-modal-actions">
                <button @click="showLogoutConfirm = false" class="btn btn-ghost" style="min-width:100px;">Batal</button>
                <button @click="forceLogout()" class="btn session-btn-danger" style="min-width:100px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg>
                    Logout
                </button>
            </div>
        </div>
    </div>

    {{-- ===== SESSION WARNING MODAL ===== --}}
    <div x-cloak x-show="showSessionWarning"
         class="session-modal-backdrop"
         style="z-index:9999;">

        <div x-show="showSessionWarning"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.stop
             class="session-modal-panel" style="max-width:28rem;">

            <div class="session-modal-body">
                <div class="session-modal-icon session-modal-icon--warning">
                    <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="session-modal-title">Sesi Akan Berakhir</h3>
                <p class="session-modal-text">
                    Sesi Anda akan berakhir dalam
                    <strong class="session-countdown-inline" x-text="countdown"></strong>
                    detik karena tidak ada aktivitas.
                </p>

                {{-- Circular Countdown --}}
                <div class="session-countdown-ring">
                    <svg viewBox="0 0 36 36" width="68" height="68" style="transform:rotate(-90deg);">
                        <circle cx="18" cy="18" r="15.5" fill="none" stroke="var(--border-soft)" stroke-width="2"/>
                        <circle cx="18" cy="18" r="15.5" fill="none"
                                stroke="var(--color-warning)" stroke-width="2.5" stroke-linecap="round"
                                :stroke-dasharray="97.39"
                                :stroke-dashoffset="97.39 - (97.39 * countdown / 60)"
                                style="transition:stroke-dashoffset 1s linear;"/>
                    </svg>
                    <span class="session-countdown-number" x-text="countdown"></span>
                </div>
            </div>

            <div class="session-modal-actions">
                <button @click="forceLogout()" class="btn btn-ghost" style="min-width:120px;">Logout Sekarang</button>
                <button @click="stayLoggedIn()" class="btn btn-primary" style="min-width:120px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Tetap Login
                </button>
            </div>
        </div>
    </div>

    {{-- Hidden Logout Form (POST + CSRF) --}}
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

{{-- ===== Enterprise Session Manager ===== --}}
<script>
function appShell() {
    return {
        /* ── Sidebar State ── */
        sidebarOpen: window.innerWidth >= 1024,
        sidebarCollapsed: false,
        get sidebarWidth() {
            if (!this.sidebarOpen) return '0px';
            return this.sidebarCollapsed ? '64px' : '240px';
        },

        /* ── Session Manager State ── */
        showLogoutConfirm: false,
        showSessionWarning: false,
        idleMinutes: 0,
        countdown: 60,
        _idleInterval: null,
        _countdownInterval: null,
        _throttled: false,

        /* ── Lifecycle ── */
        init() {
            this._idleInterval = setInterval(() => {
                this.idleMinutes++;
                if (this.idleMinutes === 14 && !this.showSessionWarning) {
                    this.showSessionWarning = true;
                    this.countdown = 60;
                    this._startCountdown();
                }
                if (this.idleMinutes >= 15) {
                    this.forceLogout();
                }
            }, 60000);

            ['mousemove','click','keydown','scroll','touchstart'].forEach(evt => {
                window.addEventListener(evt, () => this._onActivity(), { passive: true });
            });
        },

        /* ── Activity Detection (throttled 2s) ── */
        _onActivity() {
            if (this._throttled) return;
            this._throttled = true;
            setTimeout(() => this._throttled = false, 2000);

            this.idleMinutes = 0;
            if (this.showSessionWarning) {
                this.showSessionWarning = false;
                this._stopCountdown();
            }
        },

        /* ── Countdown Timer ── */
        _startCountdown() {
            this._stopCountdown();
            this._countdownInterval = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) this.forceLogout();
            }, 1000);
        },
        _stopCountdown() {
            if (this._countdownInterval) {
                clearInterval(this._countdownInterval);
                this._countdownInterval = null;
            }
        },

        /* ── Actions ── */
        stayLoggedIn() {
            this.showSessionWarning = false;
            this.idleMinutes = 0;
            this.countdown = 60;
            this._stopCountdown();
        },
        forceLogout() {
            this._stopCountdown();
            if (this._idleInterval) clearInterval(this._idleInterval);
            document.getElementById('logout-form').submit();
        }
    };
}
</script>

@stack('scripts')
</body>
</html>
