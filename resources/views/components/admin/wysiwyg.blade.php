@props([
    'name',
    'label',
    'placeholder' => '',
    'value' => '',
])

<div>
    <label
        for="{{ $name }}"
        class="mb-2.5 block text-sm font-medium text-gray-900"
    >
        {{ $label }}
    </label>

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="8"
        placeholder="{{ $placeholder }}"
        class="block min-h-48 w-full resize-y rounded-lg border border-gray-300 bg-white px-3.5 py-3 text-sm leading-6 text-gray-900 placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>
