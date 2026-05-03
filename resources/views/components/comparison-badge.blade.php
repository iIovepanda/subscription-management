@php
    $style = $diff > 0
        ? 'text-orange-600 bg-orange-100'
        : ($diff < 0 ? 'text-primary-600 bg-primary-100' : 'text-gray-500 bg-gray-100');

    $icon = $diff > 0
        ? '↗'
        : ($diff < 0 ? '↘' : '→');
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $style }}">
    {{ $icon }} {{ $label }} {{ $diff > 0 ? '+' : '' }} {{ $prefix }}{{ number_format($diff) }}{{ $suffix }}
    ( {{ $rate > 0 ? '+' : '' }} {{ number_format($rate) }}% )
</span>
