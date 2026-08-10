<section>
    <header>
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 max-w-3xl space-y-5">
        @csrf
        @method('put')

        <div class="grid gap-2 sm:grid-cols-[200px_minmax(0,1fr)] sm:items-center">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm text-gray-600" />
            <div x-data="{ show: false }" class="relative">
            <x-text-input id="update_password_current_password" name="current_password" x-bind:type="show ? 'text' : 'password'" class="block h-11 w-full rounded-md border-gray-300 px-3 pr-11 text-sm shadow-none focus:border-blue-500 focus:ring-blue-500" autocomplete="current-password" />
            <button type="button" x-on:click="show = !show" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-gray-500" aria-label="Toggle password visibility"><x-icon name="eye" size="18" /></button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="grid gap-2 sm:grid-cols-[200px_minmax(0,1fr)] sm:items-center">
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm text-gray-600" />
            <div x-data="{ show: false }" class="relative">
            <x-text-input id="update_password_password" name="password" x-bind:type="show ? 'text' : 'password'" class="block h-11 w-full rounded-md border-gray-300 px-3 pr-11 text-sm shadow-none focus:border-blue-500 focus:ring-blue-500" autocomplete="new-password" />
            <button type="button" x-on:click="show = !show" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-gray-500" aria-label="Toggle password visibility"><x-icon name="eye" size="18" /></button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="grid gap-2 sm:grid-cols-[200px_minmax(0,1fr)] sm:items-center">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-sm text-gray-600" />
            <div x-data="{ show: false }" class="relative">
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" x-bind:type="show ? 'text' : 'password'" class="block h-11 w-full rounded-md border-gray-300 px-3 pr-11 text-sm shadow-none focus:border-blue-500 focus:ring-blue-500" autocomplete="new-password" />
            <button type="button" x-on:click="show = !show" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-gray-500" aria-label="Toggle password visibility"><x-icon name="eye" size="18" /></button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-md bg-[#071b49] px-6 py-2.5 text-xs hover:bg-[#102a63]">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
