@extends('layouts.user.app')

@section('title', 'My Submissions')

@section('content')
<section class="bg-gray-50 py-12">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"><div><h1 class="text-3xl font-bold text-gray-950">My Submissions</h1><p class="mt-2 text-gray-600">Track your movie article submissions.</p></div><a href="{{ route('submissions.create') }}" class="rounded-lg bg-gray-950 px-4 py-2.5 text-sm font-medium text-white">Submit movie article</a></div>
        <div class="space-y-4">
            @forelse ($submissions as $submission)
                <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div><h2 class="font-semibold text-gray-950">{{ $submission->title }}</h2>
                            <p class="mt-1 text-sm text-gray-500">Submitted {{ $submission->created_at->format('d M Y, H:i') }}</p>
                        </div><span class="w-fit rounded-full px-3 py-1 text-xs font-semibold {{ $submission->status === 'approved' ? 'bg-green-100 text-green-700' : ($submission->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($submission->status) }}</span>
                    </div>
                        @if ($submission->rejection_reason)
                            <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-800"><strong>Reason:</strong> {{ $submission->rejection_reason }}</div>
                        @endif

                        @if ($submission->status === 'rejected')
                            <a href="{{ route('submissions.edit', $submission) }}" class="mt-4 inline-flex rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700">Edit and resubmit</a>
                        @elseif ($submission->approvedMovie)<div class="mt-4 flex flex-wrap gap-3">
                            <a href="{{ route('movies.show', $submission->approvedMovie) }}" class="inline-flex rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700">View published article</a>
                            <form action="{{ route('movies.destroy', $submission->approvedMovie) }}" method="POST" data-delete-form>
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-700">Delete published article</button>
                            </form>
                    </div>
                    @endif
                </article>
            @empty
                <div class="rounded-xl border border-dashed border-gray-300 bg-white p-12 text-center"><h2 class="font-semibold text-gray-950">No submissions yet</h2><p class="mt-2 text-sm text-gray-500">Your movie article submissions will appear here.</p></div>
            @endforelse
        </div>
        <div class="mt-6">{{ $submissions->links() }}</div>
    </div>
</section>
@endsection
