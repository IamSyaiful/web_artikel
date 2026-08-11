@extends('layouts.user.app')

@section('title', 'Submit Movie Article')

@section('content')
<section class="bg-gray-50 py-12">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8"><h1 class="text-3xl font-bold text-gray-950">Submit Movie Article</h1><p class="mt-2 text-gray-600">Share your movie article with the Ruang Cinema community.</p></div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">@include('pages.user.movie-submissions.form')</div>
    </div>
</section>
@endsection
