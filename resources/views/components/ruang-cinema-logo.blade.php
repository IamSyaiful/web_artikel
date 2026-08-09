@props([
    'variant' => 'black',
    'alt' => 'Ruang Cinema',
    'fit' => 'contain',
])

@php
    $logo = $variant === 'white'
        ? 'logo/logo-ruangcinema-putih.png'
        : 'logo/logo-ruangcinema-hitam.png';
@endphp

<img
    src="{{ asset('storage/' . $logo) }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => 'object-' . $fit]) }}
>
