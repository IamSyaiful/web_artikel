@props([
    'name',
    'value',
    'label',
    'checked' => false,
])

<div class="flex items-center">
    <input
        id="{{ $name }}_{{ $value }}"
        type="checkbox"
        name="{{ $name }}[]"
        value="{{ $value }}"
        @checked($checked)
        {{ $attributes->merge([
            'class' => 'h-4 w-4 rounded border-gray-300 bg-gray-100 text-gray-900 focus:ring-2 focus:ring-gray-300'
        ]) }}
    >

    <label
        for="{{ $name }}_{{ $value }}"
        class="ms-2 text-sm font-medium text-gray-900"
    >
        {{ $label }}
    </label>
</div>
