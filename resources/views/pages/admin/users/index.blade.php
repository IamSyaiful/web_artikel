@extends('layouts.admin.app')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-sm font-medium text-gray-500">Users <span class="mx-2 text-gray-300">/</span> Management</p>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Users</h1>
                <p class="mt-2 text-sm text-gray-500">Manage users of Ruang Cinema.</p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#071426] px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#111f33]">
                <x-icon name="plus" size="18" />
                Add User
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-200 p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                        <x-icon name="users" size="20" />
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">User List</h2>
                        <p class="mt-1 text-sm text-gray-500">Search and manage registered users.</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto p-5 sm:p-6">
                <table id="users-table" class="w-full text-left text-sm text-gray-500">
                    <thead>
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Role</th>
                            <th scope="col">Email</th>
                            <th scope="col">Joined At</th>
                            <th scope="col" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b border-gray-200 bg-white">
                                <td class="px-4 py-4 font-medium text-gray-900">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-xs font-semibold uppercase text-gray-600">
                                            {{ substr($user->name, 0, 2) }}
                                        </span>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="rounded-md px-2.5 py-1 text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700' : 'bg-blue-50 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">{{ $user->email }}</td>
                                <td class="whitespace-nowrap px-4 py-4">{{ $user->created_at?->format('d M Y, H:i') ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50">
                                            <x-icon name="pencil" size="15" /> Edit
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-user-form" data-user-name="{{ $user->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50">
                                                <x-icon name="trash-2" size="15" /> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('submit', (event) => {
        const form = event.target.closest('.delete-user-form');
        if (!form) return;

        event.preventDefault();

        window.showConfirmAlert(
            'Hapus user?',
            `Apakah Anda yakin ingin menghapus user "${form.dataset.userName}"? Data yang dihapus tidak dapat dikembalikan.`
        ).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
@endpush
