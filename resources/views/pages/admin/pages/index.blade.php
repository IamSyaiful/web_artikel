@extends('layouts.admin.app')

@section('title', 'Pages')
@section('page-title', 'Pages')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">Pages <span class="mx-2 text-gray-300">/</span> Management</p>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Pages</h1>
                <p class="mt-2 text-sm text-gray-500">Manage website pages and their content in Ruang Cinema.</p>
            </div>

            <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#071426] px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#111f33]">
                <x-icon name="plus" size="18" />
                Add Page
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                        <x-icon name="file-text" size="20" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">Page List</h2>
                        <p class="mt-1 text-sm text-gray-500">View and update the pages managed by the administrator.</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm text-gray-500">
                    <thead class="border-b border-gray-200 bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-4 font-semibold">#</th>
                            <th class="px-5 py-4 font-semibold">Page Name</th>
                            <th class="px-5 py-4 font-semibold">Slug</th>
                            <th class="px-5 py-4 font-semibold">Content</th>
                            <th class="px-5 py-4 font-semibold">Last Updated</th>
                            <th class="px-5 py-4 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pages as $page)
                            <tr class="bg-white transition hover:bg-gray-50">
                                <td class="px-5 py-5 font-medium text-gray-500">{{ $pages->firstItem() + $loop->index }}</td>
                                <td class="px-5 py-5">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-600">
                                            <x-icon name="file-text" size="19" />
                                        </span>
                                        <span class="font-semibold text-gray-900">{{ $page->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-5">
                                    <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">{{ $page->slug }}</span>
                                </td>
                                <td class="px-5 py-5">{{ $page->contents_count }} {{ $page->contents_count === 1 ? 'item' : 'items' }}</td>
                                <td class="px-5 py-5">
                                    <span class="font-medium text-gray-800">{{ $page->updated_at->format('d M Y') }}</span>
                                    <span class="mt-1 block text-xs text-gray-500">{{ $page->updated_at->format('H:i') }}</span>
                                </td>
                                <td class="px-5 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                                            <x-icon name="pencil" size="15" />
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="delete-page-form" data-page-name="{{ $page->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white p-2 text-red-600 transition hover:bg-red-50" aria-label="Delete {{ $page->name }}">
                                                <x-icon name="trash-2" size="15" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-14 text-center text-sm text-gray-500">No pages found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pages->hasPages())
                <div class="border-t border-gray-200 px-5 py-4 sm:px-6">{{ $pages->links() }}</div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('submit', (event) => {
        const form = event.target.closest('.delete-page-form');
        if (!form) return;
        event.preventDefault();
        window.showConfirmAlert('Hapus halaman?', `Apakah Anda yakin ingin menghapus halaman "${form.dataset.pageName}" beserta seluruh kontennya?`)
            .then((result) => { if (result.isConfirmed) form.submit(); });
    });
</script>
@endpush
