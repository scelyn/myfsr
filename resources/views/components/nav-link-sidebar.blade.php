@props(['href', 'active' => false])

@php
    $classes = $active
        ? 'nav-link active'
        : 'nav-link';
@endphp

<a href="{{ $href }}" {{ $attributes->class([$classes]) }}>
    @isset($icon)
        <span class="nav-icon">{{ $icon }}</span>
    @endisset
    <span class="sidebar-label" x-show="!sidebarCollapsed">{{ $slot }}</span>
</a>
