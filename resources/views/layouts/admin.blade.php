<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MyFSR') }} - {{ $title ?? 'Dashboard' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tom Select CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-theme-bg text-theme-text1 antialiased" x-data="{ sidebarOpen: false, sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" x-init="$watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val))">
    
    <!-- Sidebar for Mobile -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-40 lg:hidden" role="dialog" aria-modal="true" x-cloak>
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="sidebarOpen = false"></div>
        
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 flex w-full max-w-xs flex-col bg-theme-sidebar shadow-xl">
            <div class="flex items-center justify-between px-6 py-6 border-b border-theme-border">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="MyFSR Logo" class="h-10 w-auto object-contain drop-shadow-md">
                    </div>
                    <span class="text-xl font-bold tracking-tight text-theme-text1 ml-2">MyFSR</span>
                </div>
                <button @click="sidebarOpen = false" class="text-theme-text2 hover:text-theme-text1 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <nav class="flex-1 space-y-1 px-3 py-6 overflow-y-auto">
                <x-nav-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="dashboard">Dashboard</x-nav-link-sidebar>
                
                <div class="pt-6 pb-2 px-3 text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap">Master Data</div>
                <x-nav-link-sidebar href="{{ route('products.index') }}" :active="request()->routeIs('products.*')" icon="products">Data Produk</x-nav-link-sidebar>
                <x-nav-link-sidebar href="{{ route('customers.index') }}" :active="request()->routeIs('customers.*')" icon="customers">Data Customer</x-nav-link-sidebar>
                
                <div class="pt-6 pb-2 px-3 text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap">Operasional & Keuangan</div>
                <x-nav-link-sidebar href="{{ route('orders.index') }}" :active="request()->routeIs('orders.*')" icon="orders">Transaksi Pesanan</x-nav-link-sidebar>
                <x-nav-link-sidebar href="{{ route('reports.supplier') }}" :active="request()->routeIs('reports.supplier')" icon="reports">Laporan Supplier</x-nav-link-sidebar>
                <x-nav-link-sidebar href="{{ route('pricing.daily') }}" :active="request()->routeIs('pricing.*')" icon="reports">Finalisasi Harga</x-nav-link-sidebar>
                <x-nav-link-sidebar href="{{ route('invoices.index') }}" :active="request()->routeIs('invoices.*')" icon="receivables">Invoice Customer</x-nav-link-sidebar>
                <x-nav-link-sidebar href="{{ route('invoices.index') }}" :active="request()->routeIs('invoices.*')" icon="receivables">Pembayaran Piutang</x-nav-link-sidebar>
                
                <div class="pt-6 pb-2 px-3 text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap">Sistem</div>
                <x-nav-link-sidebar href="{{ route('reports.transactions') }}" :active="request()->routeIs('reports.transactions')" icon="reports">Riwayat Transaksi</x-nav-link-sidebar>
                <x-nav-link-sidebar href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.*')" icon="dashboard">Pengaturan Sistem</x-nav-link-sidebar>
            </nav>
        </div>
    </div>

    <!-- Static Sidebar for Desktop -->
    <div :class="sidebarCollapsed ? 'lg:w-20' : 'lg:w-72'" class="hidden lg:fixed lg:inset-y-0 lg:flex lg:flex-col lg:border-r lg:border-theme-border lg:bg-theme-sidebar transition-all duration-300 ease-in-out z-40 overflow-hidden">
        <div class="flex items-center gap-3 h-16 shrink-0 border-b border-theme-border transition-all duration-300 ease-in-out" :class="sidebarCollapsed ? 'justify-center px-0' : 'px-6'">
            <div class="w-10 h-10 flex items-center justify-center shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="MyFSR Logo" class="h-10 w-auto object-contain drop-shadow-md">
            </div>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="text-xl font-bold tracking-tight text-theme-text1 whitespace-nowrap">MyFSR</span>
        </div>
        
        <nav class="flex-1 space-y-1 px-3 py-6 overflow-y-auto overflow-x-hidden">
            <x-nav-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="dashboard">Dashboard</x-nav-link-sidebar>
            
            <div class="pt-6 pb-2 px-3 flex items-center h-10" :class="sidebarCollapsed ? 'lg:justify-center' : ''">
                <span class="text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap lg:hidden">Master Data</span>
                <span x-show="!sidebarCollapsed" class="text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap hidden lg:block">Master Data</span>
                <div x-show="sidebarCollapsed" class="w-6 border-b border-[#253745] hidden lg:block"></div>
            </div>
            <x-nav-link-sidebar href="{{ route('products.index') }}" :active="request()->routeIs('products.*')" icon="products">Data Produk</x-nav-link-sidebar>
            <x-nav-link-sidebar href="{{ route('customers.index') }}" :active="request()->routeIs('customers.*')" icon="customers">Data Customer</x-nav-link-sidebar>
            
            <div class="pt-6 pb-2 px-3 flex items-center h-10" :class="sidebarCollapsed ? 'lg:justify-center' : ''">
                <span class="text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap lg:hidden">Operasional & Keuangan</span>
                <span x-show="!sidebarCollapsed" class="text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap hidden lg:block">Operasional & Keuangan</span>
                <div x-show="sidebarCollapsed" class="w-6 border-b border-[#253745] hidden lg:block"></div>
            </div>
            <x-nav-link-sidebar href="{{ route('orders.index') }}" :active="request()->routeIs('orders.*')" icon="orders">Transaksi Pesanan</x-nav-link-sidebar>
            <x-nav-link-sidebar href="{{ route('reports.supplier') }}" :active="request()->routeIs('reports.supplier')" icon="reports">Laporan Supplier</x-nav-link-sidebar>
            <x-nav-link-sidebar href="{{ route('pricing.daily') }}" :active="request()->routeIs('pricing.*')" icon="reports">Finalisasi Harga</x-nav-link-sidebar>
            <x-nav-link-sidebar href="{{ route('invoices.index') }}" :active="request()->routeIs('invoices.*')" icon="receivables">Invoice Customer</x-nav-link-sidebar>
            <x-nav-link-sidebar href="{{ route('invoices.index') }}" :active="request()->routeIs('invoices.*')" icon="receivables">Pembayaran Piutang</x-nav-link-sidebar>
            
            <div class="pt-6 pb-2 px-3 flex items-center h-10" :class="sidebarCollapsed ? 'lg:justify-center' : ''">
                <span class="text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap lg:hidden">Sistem</span>
                <span x-show="!sidebarCollapsed" class="text-[10px] font-bold text-[#4A5C6A] uppercase tracking-[0.1em] whitespace-nowrap hidden lg:block">Sistem</span>
                <div x-show="sidebarCollapsed" class="w-6 border-b border-[#253745] hidden lg:block"></div>
            </div>
            <x-nav-link-sidebar href="{{ route('reports.transactions') }}" :active="request()->routeIs('reports.transactions')" icon="reports">Riwayat Transaksi</x-nav-link-sidebar>
            <x-nav-link-sidebar href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.*')" icon="dashboard">Pengaturan Sistem</x-nav-link-sidebar>
        </nav>
        
        <div class="p-4 border-t border-theme-border flex justify-center">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-3 py-2.5 text-sm font-medium text-[#9BA8AB] hover:text-[#F8FAFC] hover:bg-white/5 rounded-xl transition-all duration-200 group" :class="sidebarCollapsed ? 'lg:justify-center' : ''" title="Keluar Sistem">
                    <svg class="w-5 h-5 shrink-0 opacity-70 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="whitespace-nowrap lg:hidden">Keluar Sistem</span>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.200ms class="whitespace-nowrap hidden lg:block">Keluar Sistem</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-72'" class="transition-all duration-300 ease-in-out flex flex-col min-h-screen">
        <!-- Header -->
        <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-x-4 border-b border-theme-border bg-[#06141B]/90 backdrop-blur-md px-6 sm:gap-x-6 lg:px-8">
            <!-- Mobile Sidebar Toggle -->
            <button @click="sidebarOpen = true" class="lg:hidden text-[#9BA8AB] hover:text-[#F8FAFC] transition-colors shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            
            <!-- Desktop Sidebar Toggle -->
            <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:flex items-center justify-center w-8 h-8 rounded-lg text-[#9BA8AB] hover:text-[#F8FAFC] hover:bg-white/5 transition-colors shrink-0 mr-2 group">
                <svg class="w-5 h-5 transition-transform duration-300 ease-in-out" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
            </button>
            
            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <div class="flex flex-1 items-center gap-2">
                    <span class="text-sm font-medium text-[#4A5C6A] hidden sm:block">MyFSR /</span>
                    <h2 class="text-base font-bold text-[#F8FAFC]">{{ $header ?? 'Beranda' }}</h2>
                </div>
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <!-- Profile -->
                    <div class="flex items-center gap-3 cursor-pointer hover:bg-white/5 p-1.5 rounded-lg transition-colors">
                        <div class="flex flex-col items-end hidden sm:flex">
                            <span class="text-sm font-semibold text-[#F8FAFC] leading-none">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] font-bold text-[#9BA8AB] mt-1 uppercase">Administrator</span>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-[#253745] flex items-center justify-center text-[#F8FAFC] font-bold border border-[#4A5C6A] shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="py-10 px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            <x-flash-message />
            
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
