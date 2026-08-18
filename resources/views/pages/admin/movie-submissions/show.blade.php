@extends('layouts.admin.app')

@section('title', 'Review Movie Submission')
@section('page-title', 'Review Movie Submission')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $submission->title }}</h1>
            <p class="mt-1 text-sm text-gray-500">Submitted by {{ $submission->author->name }} on {{ $submission->created_at->format('d M Y, H:i') }}</p>
        </div>
        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $submission->status === 'approved' ? 'bg-green-100 text-green-700' : ($submission->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($submission->status) }}</span>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        <dl class="grid gap-5 sm:grid-cols-2">
            <div>
                <dt class="text-xs uppercase text-gray-500">Slug</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->slug }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase text-gray-500">Release</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->release_date?->format('d M Y') ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase text-gray-500">Director</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->director ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase text-gray-500">Duration</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->duration ? $submission->duration.' minutes' : '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase text-gray-500">Rating</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ number_format($submission->rating, 1) }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase text-gray-500">Genres</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->genres->pluck('name')->join(', ') ?: '-' }}</dd>
            </div>
        </dl>
        <div class="mt-8 border-t border-gray-200 pt-6">
            <h2 class="font-semibold text-gray-900">Synopsis</h2>
            <div class="rich-content mt-2 max-w-none text-gray-700">{!! app(\App\Services\RichTextSanitizer::class)->clean($submission->synopsis) !!}</div>
            <h2 class="mt-6 font-semibold text-gray-900">Review</h2>
            <div class="rich-content mt-2 max-w-none text-gray-700">{!! app(\App\Services\RichTextSanitizer::class)->clean($submission->review) !!}</div>
        </div>
    </div>
    @if ($submission->status === 'pending')
        <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:flex-row sm:items-start sm:justify-between">
            <form method="POST" action="{{ route('admin.movie-submissions.approve', $submission) }}">
                @csrf
                <button class="rounded-lg bg-green-700 px-4 py-2.5 text-sm font-medium text-white">Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.movie-submissions.reject', $submission) }}" class="flex w-full max-w-xl gap-3">
                @csrf
                <textarea name="rejection_reason" required rows="2" placeholder="Rejection reason" class="min-w-0 flex-1 rounded-lg border-gray-300 text-sm"></textarea>
                <button class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white">Reject</button>
            </form>
        </div>
    @elseif ($submission->note)
        <div class="rounded-xl border border-red-200 bg-red-50 p-5 text-sm text-red-800"><strong>Rejection reason:</strong> {{ $submission->note }}</div>
    @endif
</div>
@endsection
