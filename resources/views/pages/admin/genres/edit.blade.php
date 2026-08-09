@extends('layouts.admin.app')

@section('title', 'Edit Genre')
@section('page-title', 'Edit Genre')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit Genre</h1>
        <p class="mt-2 text-sm text-gray-500">Update the movie genre information.</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center gap-4 border-b border-gray-200 px-6 py-6 sm:px-8">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-600">
                <x-icon name="tag" size="22" />
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Genre Information</h2>
                <p class="mt-1 text-sm text-gray-500">Update the genre name below.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.genres.update', $genre) }}">
            @csrf
            @method('PUT')
            <div class="grid gap-6 p-6 sm:grid-cols-2 sm:p-8">
                <x-admin.input
                    name="name"
                    label="Genre Name"
                    :value="$genre->name"
                    placeholder="e.g. Action"
                    required
                    data-slug-source="genre-name"
                    data-slug-target="slug"
                />

                <x-admin.input
                    name="slug"
                    label="Slug"
                    :value="$genre->slug"
                    placeholder="Generated automatically"
                    disabled
                    class="cursor-not-allowed bg-gray-100 text-gray-500"
                />
            </div>
            <div class="flex justify-end gap-3 border-t border-gray-200 px-6 py-5 sm:px-8">
                <a href="{{ route('admin.genres.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <x-icon name="x" size="17" /> Cancel
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#071426] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#111f33]">
                    <x-icon name="save" size="17" /> Update Genre
                </button>
            </div>
        </form>
    </div>
@endsection
