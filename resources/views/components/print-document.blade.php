{{--
   <x-print-document> — Universal Print Component
   Wraps printable content with automatic print isolation.
   Integrates with the Universal Print Engine in app.css.

   Usage:
     <x-print-document>                            (defaults to a4)
     <x-print-document size="thermal80">           (thermal 80mm)
     <x-print-document size="letter" class="p-8">  (extra classes)

   Supported sizes: a4, letter, thermal80, thermal58
--}}

@props([
    'size' => 'a4',
    'title' => null,
])

@php
    $validSizes = ['a4', 'letter', 'thermal80', 'thermal58'];
    $printSize = in_array($size, $validSizes) ? $size : 'a4';
@endphp

<div
    {{ $attributes->class(['print-document']) }}
    style="-webkit-print-color-adjust: exact; print-color-adjust: exact;"
    x-data
    x-init="document.body.classList.add('print-{{ $printSize }}')"
>
    @if($title)
    <div class="print-only hidden print:block text-center mb-4">
        <h1 class="text-lg font-bold" style="color:#000;">{{ $title }}</h1>
    </div>
    @endif

    {{ $slot }}
</div>
