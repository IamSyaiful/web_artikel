@extends('layouts.admin.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">
        Dashboard
    </h2>

    <p class="mt-1 text-sm text-gray-500">
        Manage your movies, genres, and users from here.
    </p>
</div>

<div class="grid gap-6 xl:grid-cols-2">

    {{-- Recent Movies --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="text-lg font-semibold text-gray-900">
                Recent Movies
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Recently added movies.
            </p>
        </div>

        <div class="overflow-x-auto p-5">

        <table id="recent-movies-table" class="w-full text-left text-sm text-gray-500">

            <thead>
                <tr>

                    <th scope="col">Movie</th>

                    <th scope="col">Genre</th>

                    <th scope="col">Year</th>

                </tr>
            </thead>

            <tbody>

                @foreach ($recentMovies as $movie)

                    <tr>

                        <td class="font-medium text-gray-900 whitespace-nowrap">
                            {{ $movie->title }}
                        </td>

                        <td>
                            {{ $movie->genres->pluck('name')->join(', ') ?: '-' }}
                        </td>

                        <td>
                            {{ $movie->release_date?->format('Y') ?? '-' }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        </div>
    </div>


    {{-- Recent Users --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-5 py-4">
            <h2 class="text-lg font-semibold text-gray-900">
                Recent Users
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Recently registered users.
            </p>
        </div>

        <div class="overflow-x-auto p-5">

        <table id="recent-users-table" class="w-full text-left text-sm text-gray-500">

            <thead>
                <tr>

                    <th scope="col">Name</th>

                    <th scope="col">Email</th>

                    <th scope="col">Role</th>

                </tr>
            </thead>

            <tbody>

                @foreach ($recentUsers as $user)

                    <tr>

                        <td class="font-medium text-gray-900 whitespace-nowrap">
                            {{ $user->name }}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>

                            <span class="rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                {{ ucfirst($user->role) }}
                            </span>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        </div>
    </div>

</div>

@endsection
