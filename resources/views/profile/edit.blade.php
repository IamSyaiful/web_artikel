@extends('layouts.profile')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
    <div class="mx-auto max-w-[1100px] space-y-5">
        @if (auth()->user()->role !== 'admin')
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 transition hover:text-gray-950">
                <x-icon name="arrow-left" size="18" />
                Back to home
            </a>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-7">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-7">
            @include('profile.partials.update-password-form')
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-7">
            @include('profile.partials.delete-user-form')
        </div>

        @if (auth()->user()->role === 'admin')
            <footer class="border-t border-gray-200 pt-7 text-sm text-gray-500">
                &copy; {{ now()->year }} Ruang Cinema. All rights reserved.
            </footer>
        @endif
    </div>
@endsection
