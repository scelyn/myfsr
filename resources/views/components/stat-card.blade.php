@props([
    'title'   => '',
    'value'   => '',
    'caption' => null,
    'color'   => 'default',
    'icon'    => null,
])

@php
    $colorMap = [
        'success' => ['wrap' => 'stat-success', 'icon' => 'icon-success'],
        'danger'  => ['wrap' => 'stat-danger',  'icon' => 'icon-danger'],
        'warning' => ['wrap' => 'stat-warning',  'icon' => 'icon-warning'],
        'info'    => ['wrap' => 'stat-info',     'icon' => 'icon-info'],
        'default' => ['wrap' => '',              'icon' => ''],
    ];
    $c = $colorMap[$color] ?? $colorMap['default'];
@endphp

<article class="stat-card-wrap {{ $c['wrap'] }}">
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0 flex-1">
            <p class="form-label mb-2">{{ $title }}</p>
            <p class="text-2xl font-black" style="color:var(--text-primary); line-height:1.1;">{{ $value }}</p>
            @if($caption)
                <p class="text-xs mt-1" style="color:var(--text-muted);">{{ $caption }}</p>
            @endif
        </div>
        @if($icon)
            <div class="stat-icon-wrap {{ $c['icon'] }}">{!! $icon !!}</div>
        @endif
    </div>
</article>
