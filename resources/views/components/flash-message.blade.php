{{-- Flash toast notifications (Phase B component — light palette) --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="animate-toast-in"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-8"
         class="toast toast-success">
        <div class="shrink-0 w-5 h-5 rounded-full flex items-center justify-center mt-0.5"
             style="background-color:var(--color-success-bg);">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 style="color:var(--color-success);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-bold" style="color:var(--text-primary);">Berhasil</p>
            <p class="text-xs mt-0.5" style="color:var(--text-secondary);">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="shrink-0 ml-1 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         class="toast toast-error">
        <div class="shrink-0 w-5 h-5 rounded-full flex items-center justify-center mt-0.5"
             style="background-color:var(--color-danger-bg);">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 style="color:var(--color-danger);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-bold" style="color:var(--text-primary);">Terjadi Kesalahan</p>
            <p class="text-xs mt-0.5" style="color:var(--text-secondary);">{{ session('error') }}</p>
        </div>
        <button @click="show = false" class="shrink-0 ml-1 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if(session('warning'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4500)"
         class="toast toast-warning">
        <div class="shrink-0 w-5 h-5 rounded-full flex items-center justify-center mt-0.5"
             style="background-color:var(--color-warning-bg);">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 style="color:var(--color-warning);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-xs font-bold" style="color:var(--text-primary);">Peringatan</p>
            <p class="text-xs mt-0.5" style="color:var(--text-secondary);">{{ session('warning') }}</p>
        </div>
        <button @click="show = false" class="shrink-0 ml-1 text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif
