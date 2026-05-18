@props(['title' => null, 'subtitle' => null, 'actions' => null])

<section {{ $attributes->class(['card shadow-card']) }}>
    @if($title || $actions)
        <div class="card-header">
            <div>
                @if($title)
                    <h3>{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $subtitle }}</p>
                @endif
            </div>
            @if($actions)
                <div class="flex items-center gap-2">{{ $actions }}</div>
            @endif
        </div>
    @endif
    {{ $slot }}
</section>
