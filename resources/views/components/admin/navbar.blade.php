<header class="sticky top-0 z-30 border-b border-gray-200 bg-white">

    <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- Page Title --}}
        <div>

            <h1 class="text-xl font-bold text-gray-900">
                @yield('page-title', 'Dashboard')
            </h1>

            <p class="mt-0.5 text-sm text-gray-500">
                Welcome back, {{ auth()->user()->name }}
            </p>

        </div>


        {{-- Admin --}}
        <div class="flex items-center gap-3">

            <div class="hidden text-right sm:block">

                <p class="text-sm font-semibold text-gray-900">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-gray-500">
                    Administrator
                </p>

            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">

                <x-icon
                    name="user-round"
                    size="20"
                    class="text-gray-500"
                />

            </div>

        </div>

    </div>

</header>
