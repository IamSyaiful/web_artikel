@props([
    'name',
    'label',
    'help' => null,
    'required' => false,
])

<div>
    <label
        for="{{ $name }}"
        class="mb-2.5 block text-sm font-medium text-gray-900"
    >
        {{ $label }}

        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="file"
        accept="image/jpeg,image/png,image/webp"
        @required($required)
        data-image-preview-input="{{ $name }}"
        {{ $attributes->merge(['class' => 'sr-only']) }}
    >

    <label
        for="{{ $name }}"
        class="flex min-h-28 cursor-pointer items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 py-5 text-center transition hover:border-gray-400 hover:bg-gray-100"
    >
        <span id="{{ $name }}-upload-placeholder" class="flex flex-col items-center gap-2 text-gray-500">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white text-gray-400 shadow-sm">
                <x-icon name="image-plus" size="18" />
            </span>
            <span class="text-sm font-medium text-gray-700">Click to upload or drag and drop</span>
            <span class="text-xs text-gray-500">JPG, JPEG, PNG, WEBP · Maximum 10MB</span>
        </span>

        <span id="{{ $name }}-preview" class="hidden items-center gap-4">
            <img
                src=""
                alt="Poster preview"
                class="h-24 w-16 rounded-md object-cover shadow-sm"
            >
            <span class="text-left">
                <span class="block text-sm font-medium text-gray-900" data-image-preview-name></span>
                <span class="mt-1 block text-xs text-gray-500">Click to choose another image</span>
            </span>
        </span>
    </label>

    @if ($help)
        <p class="mt-2 text-xs text-gray-500">
            {{ $help }}
        </p>
    @endif

    @error($name)
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>
