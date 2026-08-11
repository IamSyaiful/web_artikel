@extends('layouts.admin.app')

@section('title', 'Add Page')
@section('page-title', 'Add Page')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Add Page</h1>
        <p class="mt-2 text-sm text-gray-500">Create a new managed page and define its content fields.</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center gap-4 border-b border-gray-200 px-6 py-6 sm:px-8">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-600"><x-icon name="file-plus-2" size="22" /></div>
            <div><h2 class="text-lg font-semibold text-gray-900">Page Information</h2><p class="mt-1 text-sm text-gray-500">Set the page identity and content fields.</p></div>
        </div>
        @include('pages.admin.pages._form', ['action' => route('admin.pages.store'), 'method' => 'POST', 'submitLabel' => 'Save Page'])
    </div>
@endsection
