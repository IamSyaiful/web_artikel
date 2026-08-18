@extends('layouts.admin.app')

@section('title', 'Movie Submissions')
@section('page-title', 'Movie Submissions')

@section('content')
<div class="space-y-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Movie Submissions</h1>
            <p class="mt-1 text-sm text-gray-500">Review movie articles submitted by users.</p>
        </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Submitter</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Submitted</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>@forelse ($submissions as $submission)
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $submission->title }}</td>
                                <td class="px-6 py-4">{{ $submission->author->name }}</td>
                                <td class="px-6 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $submission->status === 'approved' ? 'bg-green-100 text-green-700' : ($submission->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($submission->status) }}</span></td>
                                <td class="px-6 py-4">{{ $submission->created_at->format('d M Y') }}</td><td class="px-6 py-4 text-right"><a href="{{ route('admin.movie-submissions.show', $submission) }}" class="rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700">Review</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">No submissions found.</td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div>{{ $submissions->links() }}</div>
</div>
@endsection
