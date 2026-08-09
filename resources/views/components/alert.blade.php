@props([
    'type' => 'success',
    'message' => null,
    'id' => 'user-alert',
])

@php
    $styles = [
        'success' => [
            'wrapper' => 'border-green-200 bg-green-50 text-green-800',
            'icon' => 'text-green-600',
        ],
        'error' => [
            'wrapper' => 'border-red-200 bg-red-50 text-red-800',
            'icon' => 'text-red-600',
        ],
        'warning' => [
            'wrapper' => 'border-yellow-200 bg-yellow-50 text-yellow-800',
            'icon' => 'text-yellow-600',
        ],
        'info' => [
            'wrapper' => 'border-blue-200 bg-blue-50 text-blue-800',
            'icon' => 'text-blue-600',
        ],
    ];

    $style = $styles[$type] ?? $styles['success'];
@endphp

@if ($message)

    <div
        id="{{ $id }}"
        class="mx-auto mb-6 flex max-w-6xl items-center gap-3 rounded-xl border px-4 py-3 text-sm {{ $style['wrapper'] }}"
        role="alert"
    >

        {{-- Icon --}}
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.8"
            stroke="currentColor"
            class="h-5 w-5 shrink-0 {{ $style['icon'] }}"
        >
            @if ($type === 'success')

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />

            @elseif ($type === 'error')

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3h.008M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />

            @elseif ($type === 'warning')

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3h.008M10.29 3.86l-7.4 12.82A1.5 1.5 0 0 0 4.19 19h15.62a1.5 1.5 0 0 0 1.3-2.32l-7.4-12.82a1.5 1.5 0 0 0-2.6 0Z"
                />

            @else

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M11.25 11.25h1.5v5.25h-1.5v-5.25ZM12 7.5h.008v.008H12V7.5ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />

            @endif
        </svg>


        {{-- Message --}}
        <p class="flex-1 font-medium">
            {{ $message }}
        </p>


        {{-- Close Button --}}
        <button
            type="button"
            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition hover:bg-black/5"
            data-dismiss-target="#{{ $id }}"
            aria-label="Close"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-4 w-4"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18 18 6M6 6l12 12"
                />
            </svg>

        </button>

    </div>

@endif
