@extends('layouts.admin.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit User</h1>
        <p class="mt-2 text-sm text-gray-500">Update the user account information.</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center gap-4 border-b border-gray-200 px-6 py-6 sm:px-8">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 text-gray-600"><x-icon name="user-pen" size="22" /></div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">User Information</h2>
                <p class="mt-1 text-sm text-gray-500">Update the information below.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="grid gap-6 p-6 sm:grid-cols-2 sm:p-8">
                <x-admin.input name="name" label="Full Name" :value="$user->name" required />
                <x-admin.input name="email" label="Email Address" type="email" :value="$user->email" required />
                <x-admin.input name="password" label="New Password" type="password" placeholder="Leave empty to keep current password" />
                <div>
                    <label for="role" class="mb-2.5 block text-sm font-medium text-gray-900">Role <span class="text-red-500">*</span></label>
                    <select id="role" name="role" required class="block h-11 w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-2 focus:ring-gray-200">
                        <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </select>
                    @error('role')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="flex justify-end gap-3 border-t border-gray-200 px-6 py-5 sm:px-8">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"><x-icon name="x" size="17" /> Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#071426] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#111f33]"><x-icon name="save" size="17" /> Update User</button>
            </div>
        </form>
    </div>
@endsection
