@extends('layouts.admin.app')

@section('title', 'Edit Page')
@section('page-title', 'Edit Page')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit Page</h1>
        <p class="mt-2 text-sm text-gray-500">Update the page metadata and content fields below.</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center gap-4 border-b border-gray-200 px-6 py-6 sm:px-8">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-600"><x-icon name="file-pen" size="22" /></div>
            <div><h2 class="text-lg font-semibold text-gray-900">Page Information</h2><p class="mt-1 text-sm text-gray-500">Update the page identity and managed content.</p></div>
        </div>
        @include('pages.admin.pages._form', ['action' => route('admin.pages.update', $page), 'method' => 'PUT', 'submitLabel' => 'Update Page'])
    </div>
@endsection
