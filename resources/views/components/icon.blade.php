@props([
    'name',
    'size' => 20,
    'strokeWidth' => 1.8,
])

<i
    data-lucide="{{ $name }}"
    width="{{ $size }}"
    height="{{ $size }}"
    stroke-width="{{ $strokeWidth }}"
    {{ $attributes }}
></i>
