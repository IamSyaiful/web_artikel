@extends('layouts.user.app')

@section('title', 'Edit Movie Submission')

@section('content')
<section class="bg-gray-50 py-12">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8"><h1 class="text-3xl font-bold text-gray-950">Edit Movie Submission</h1><p class="mt-2 text-gray-600">Update the rejected article and submit it again.</p></div>
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5"><p class="text-sm font-semibold text-red-900">Rejection reason</p><p class="mt-1 text-sm text-red-800">{{ $submission->rejection_reason }}</p></div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">@include('pages.user.movie-submissions.form')</div>
    </div>
</section>
@endsection
