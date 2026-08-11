@php
    $rows = old('contents');

    if ($rows === null) {
        $rows = isset($page) && $page->contents->isNotEmpty()
            ? $page->contents->toArray()
            : [['section' => 'general', 'key' => '', 'value' => '', 'type' => 'text']];
    }
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    @if ($errors->any())
        <div class="mx-6 mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 sm:mx-8">
            Please check the highlighted fields and try again.
        </div>
    @endif

    <div class="grid gap-6 p-6 sm:grid-cols-2 sm:p-8">
        <x-admin.input
            name="name"
            label="Page Name"
            :value="$page->name ?? ''"
            placeholder="e.g. About"
            required
            data-slug-source="page-name"
            data-slug-target="slug"
        />

        <x-admin.input
            name="slug"
            label="Slug"
            :value="$page->slug ?? ''"
            placeholder="e.g. about"
            required
        />
    </div>

    <div class="border-t border-gray-200 px-6 py-6 sm:px-8">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Page Content</h2>
                <p class="mt-1 text-sm text-gray-500">Add flexible content fields using a section and unique key.</p>
            </div>
            <button type="button" id="add-content-row" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                <x-icon name="plus" size="16" /> Add Content
            </button>
        </div>

        <div id="content-rows" class="space-y-4">
            @foreach ($rows as $index => $content)
                <div class="content-row rounded-xl border border-gray-200 bg-gray-50 p-4" data-content-row>
                    <div class="mb-4 flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-800">Content Field <span data-row-number>{{ $loop->iteration }}</span></p>
                        <button type="button" data-remove-content class="inline-flex items-center gap-1.5 text-xs font-medium text-red-600 transition hover:text-red-700">
                            <x-icon name="trash-2" size="15" /> Remove
                        </button>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="mb-2 block text-xs font-medium text-gray-700">Section <span class="text-red-500">*</span></label>
                            <input name="contents[{{ $index }}][section]" value="{{ $content['section'] ?? '' }}" required class="block h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                        </div>
                        <div>
                            <label class="mb-2 block text-xs font-medium text-gray-700">Key <span class="text-red-500">*</span></label>
                            <input name="contents[{{ $index }}][key]" value="{{ $content['key'] ?? '' }}" required class="block h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                        </div>
                        <div>
                            <label class="mb-2 block text-xs font-medium text-gray-700">Type <span class="text-red-500">*</span></label>
                            <select name="contents[{{ $index }}][type]" required class="block h-10 w-full rounded-lg border border-gray-300 bg-white px-3 text-sm text-gray-900 focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                                @foreach (['text' => 'Text', 'textarea' => 'Textarea', 'html' => 'HTML', 'image' => 'Image URL'] as $type => $label)
                                    <option value="{{ $type }}" @selected(($content['type'] ?? 'text') === $type)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="mb-2 block text-xs font-medium text-gray-700">Value</label>
                        <textarea name="contents[{{ $index }}][value]" rows="3" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-gray-500 focus:ring-2 focus:ring-gray-200" placeholder="Enter the content value">{{ $content['value'] ?? '' }}</textarea>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-end gap-3 border-t border-gray-200 px-6 py-5 sm:px-8">
        <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
            <x-icon name="x" size="17" /> Cancel
        </a>
        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#071426] px-4 py-2.5 text-sm font-medium text-white transition hover:bg-[#111f33]">
            <x-icon name="save" size="17" /> {{ $submitLabel }}
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.querySelector('#content-rows');
        const addButton = document.querySelector('#add-content-row');
        if (!container || !addButton) return;

        const refreshNumbers = () => container.querySelectorAll('[data-row-number]').forEach((el, index) => el.textContent = index + 1);
        const bindRemoveButtons = () => container.querySelectorAll('[data-remove-content]').forEach((button) => {
            button.onclick = () => {
                const rows = container.querySelectorAll('[data-content-row]');
                if (rows.length > 1) button.closest('[data-content-row]').remove();
                else button.closest('[data-content-row]').querySelectorAll('input, textarea').forEach((input) => input.value = '');
                refreshNumbers();
            };
        });

        addButton.addEventListener('click', () => {
            const index = container.querySelectorAll('[data-content-row]').length;
            const row = container.querySelector('[data-content-row]').cloneNode(true);
            row.innerHTML = row.innerHTML.replaceAll(/contents\[\d+\]/g, `contents[${index}]`).replace(/>\d+<\/span>/, `>${index + 1}</span>`);
            row.querySelectorAll('input, textarea').forEach((input) => input.value = '');
            row.querySelector('select').value = 'text';
            container.appendChild(row);
            bindRemoveButtons();
            refreshNumbers();
        });

        bindRemoveButtons();
    });
</script>
@endpush
