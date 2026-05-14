@props(['title', 'value', 'subtitle', 'color' => 'slate', 'icon' => ''])

@php
    $bgColors = [
        'emerald' => 'bg-theme-success text-theme-text1 shadow-xl shadow-emerald-100',
        'slate' => 'bg-theme-card border border-slate-50 shadow-md shadow-sm text-theme-text1',
    ];
    $titleColors = [
        'emerald' => 'text-emerald-200',
        'slate' => 'text-theme-text2',
    ];
    $valueColors = [
        'emerald' => 'text-theme-text1',
        'slate' => 'text-theme-text1',
        'red' => 'text-rose-600',
    ];
    $subtitleColors = [
        'emerald' => 'text-emerald-100',
        'slate' => 'text-theme-text2',
        'emerald-text' => 'text-emerald-500',
    ];
    
    // Determine specific value color override based on color prop
    $valColor = $color === 'red' ? $valueColors['red'] : ($color === 'emerald' ? $valueColors['emerald'] : $valueColors['slate']);
    $baseBg = $color === 'emerald' ? $bgColors['emerald'] : $bgColors['slate'];
    $titleCol = $color === 'emerald' ? $titleColors['emerald'] : $titleColors['slate'];
    $subColor = $color === 'emerald' ? $subtitleColors['emerald'] : (str_contains($subtitle, '↑') ? $subtitleColors['emerald-text'] : $subtitleColors['slate']);
    
    // Decoration circle
    $decColors = [
        'emerald' => 'bg-theme-card/10',
        'slate' => 'bg-theme-success/20',
        'red' => 'bg-theme-error/20',
        'blue' => 'bg-blue-50',
    ];
    $decColor = $decColors[$color] ?? $decColors['slate'];
@endphp

<div class="{{ $baseBg }} p-8 rounded-2xl relative overflow-hidden group">
    <div class="absolute -right-4 -top-4 w-24 h-24 {{ $decColor }} rounded-full group-hover:scale-150 transition-transform duration-700"></div>
    <div class="relative">
        <p class="text-[10px] font-black {{ $titleCol }} uppercase tracking-widest">{{ $title }}</p>
        <div class="text-2xl font-black {{ $valColor }} mt-2">{{ $value }}</div>
        @if($subtitle)
            <p class="text-[10px] font-bold {{ $subColor }} mt-1">{{ $subtitle }}</p>
        @endif
    </div>
</div>
