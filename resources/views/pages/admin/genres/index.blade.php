@extends('layouts.admin.app')

@section('title', 'Genres')
@section('page-title', 'Genres')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">Genres <span class="mx-2 text-gray-300">/</span> Management</p>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Genres</h1>
                <p class="mt-2 text-sm text-gray-500">Manage movie genres in Ruang Cinema.</p>
            </div>

            <a
                href="{{ route('admin.genres.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#071426] px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#111f33]"
            >
                <x-icon name="plus" size="18" />
                Add Genre
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                        <x-icon name="tags" size="20" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">Genre List</h2>
                        <p class="mt-1 text-sm text-gray-500">Search and manage all movie genres.</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto p-5 sm:p-6">
                <table id="genres-table" class="w-full text-left text-sm text-gray-500">
                    <thead>
                        <tr>
                            <th scope="col">Genre Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($genres as $genre)
                            <tr class="border-b border-gray-200 bg-white">
                                <td class="px-4 py-4 font-medium text-gray-900">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                                            <x-icon name="tag" size="16" />
                                        </span>
                                        {{ $genre->name }}
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">
                                        {{ $genre->slug }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route('admin.genres.edit', $genre) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                        >
                                            <x-icon name="pencil" size="15" />
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.genres.destroy', $genre) }}"
                                            method="POST"
                                            class="delete-genre-form"
                                            data-genre-name="{{ $genre->name }}"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                            >
                                                <x-icon name="trash-2" size="15" />
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500">No genres found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('submit', (event) => {
        const form = event.target.closest('.delete-genre-form');

        if (!form) return;

        event.preventDefault();

        const genreName = form.dataset.genreName;

        window.showConfirmAlert(
            'Hapus genre?',
            `Apakah Anda yakin ingin menghapus genre "${genreName}"? Data yang dihapus tidak dapat dikembalikan.`
        ).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
@endpush
