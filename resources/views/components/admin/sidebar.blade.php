<aside
    class="fixed inset-y-0 left-0 z-40 hidden w-64 flex-col bg-[#071426] text-white lg:flex">

    {{-- Logo --}}
    <div class="flex h-20 items-center px-6">

        <x-ruang-cinema-logo variant="white" fit="contain" class="h-12 w-40 object-center" />

    </div>


    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6">

        <p class="mb-3 px-3 text-xs font-medium uppercase tracking-wider text-gray-500">
            Main
        </p>

        <div class="space-y-1">

            {{-- Dashboard --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-white/10 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

                <x-icon name="layout-dashboard" size="19" />

                <span>Dashboard</span>

            </a>


            {{-- Movies --}}
            <a
                href="{{ route('admin.movies.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('admin.movies.*')
                    ? 'bg-white/10 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

                <x-icon name="clapperboard" size="19" />

                <span>Movies</span>
            </a>

            <a
                href="{{ route('admin.movie-submissions.index') }}"
                class="flex items-center justify-between rounded-lg px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('admin.movie-submissions.*')
                    ? 'bg-white/10 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <span class="flex items-center gap-3">
                    <x-icon name="inbox" size="19" />
                    <span>Movie Submissions</span>
                </span>
                @if (isset($pendingSubmissionCount) && $pendingSubmissionCount > 0)
                    <span class="rounded-full bg-amber-400 px-2 py-0.5 text-[11px] font-bold text-gray-950">{{ $pendingSubmissionCount }}</span>
                @endif
            </a>


            {{-- Genres --}}
            <a
                href="{{ route('admin.genres.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('admin.genres.*')
                    ? 'bg-white/10 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

                <x-icon name="tags" size="19" />

                <span>Genres</span>
            </a>


            {{-- Users --}}
            <a
                href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('admin.users.*')
                    ? 'bg-white/10 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

                <x-icon name="users" size="19" />

                <span>Users</span>
            </a>

            {{-- Pages --}}
            <a
                href="{{ route('admin.pages.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition
                {{ request()->routeIs('admin.pages.*')
                    ? 'bg-white/10 text-white'
                    : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

                <x-icon name="file-text" size="19" />

                <span>Pages</span>
            </a>

        </div>


        {{-- Account --}}
        <p class="mb-3 mt-8 px-3 text-xs font-medium uppercase tracking-wider text-gray-500">
            Account
        </p>

        <a
            href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium transition
            {{ request()->routeIs('profile.*')
                ? 'bg-white/10 text-white'
                : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">

            <x-icon name="user-round" size="19" />

            <span>Profile</span>

        </a>

    </nav>


    {{-- Logout --}}
    <div class="border-t border-white/10 p-4">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-lg bg-white/5 px-3 py-3 text-sm font-medium text-gray-300 transition hover:bg-white/10 hover:text-white">

                <x-icon name="log-out" size="19" />

                <span>Logout</span>

            </button>

        </form>

    </div>

</aside>
