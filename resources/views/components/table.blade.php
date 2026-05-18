@props(['class' => ''])

<div class="card shadow-card overflow-hidden {{ $class }}">
    <div class="overflow-x-auto">
        <table class="data-table">
            {{ $slot }}
        </table>
    </div>
    @isset($footer)
        <div class="px-5 py-3 border-t" style="border-color:rgba(74,92,106,0.3); background:rgba(6,20,27,0.3);">
            {{ $footer }}
        </div>
    @endisset
</div>
