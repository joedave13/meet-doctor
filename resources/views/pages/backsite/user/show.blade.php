<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('backsite.user.index') }}"
                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                <i class="fas fa-fw fa-arrow-left mr-2"></i>Back
            </a>

            <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-10 mt-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <th class="border px-6 py-4 text-right">Full Name</th>
                                <td class="border px-6 py-4">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Email Address</th>
                                <td class="border px-6 py-4">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">User Type</th>
                                <td class="border px-6 py-4">{{ $user->user_detail->user_type->name }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Age</th>
                                <td class="border px-6 py-4">{{ $user->user_detail->age ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Contact</th>
                                <td class="border px-6 py-4">{{ $user->user_detail->contact ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Address</th>
                                <td class="border px-6 py-4">{{ $user->user_detail->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Photo</th>
                                <td class="border px-6 py-4">
                                    <img src="{{ $user->user_detail->photo ? Storage::disk('public')->url($user->user_detail->photo) : asset('images/default_photo_user.jpg') }}"
                                        class="w-20" alt="user-photo">
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Role</th>
                                <td class="border px-6 py-4">
                                    {{ implode(', ', $user->roles->pluck('name')->toArray()) ?? '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>