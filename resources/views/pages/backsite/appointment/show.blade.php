<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointment Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('backsite.appointment.index') }}"
                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                <i class="fas fa-fw fa-arrow-left mr-2"></i>Back
            </a>

            <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-10 mt-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <th class="border px-6 py-4 text-right">Date</th>
                                <td class="border px-6 py-4">
                                    {{ \Carbon\Carbon::parse($appointment->created_at)->format('d M Y H:i:s'); }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Patient</th>
                                <td class="border px-6 py-4">
                                    {{ $appointment->user->name; }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Consultation</th>
                                <td class="border px-6 py-4">
                                    {{ $appointment->consultation->name; }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Doctor</th>
                                <td class="border px-6 py-4">
                                    {{ $appointment->doctor->name; }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Appointment Date</th>
                                <td class="border px-6 py-4">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y'); }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Appointment Time</th>
                                <td class="border px-6 py-4">
                                    {{ \Carbon\Carbon::parse($appointment->time)->toTimeString() }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Status</th>
                                <td class="border px-6 py-4">
                                    @if ($appointment->status == 1)
                                    <span
                                        class="bg-yellow-200 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Waiting
                                    </span>
                                    @else
                                    <span
                                        class="bg-green-200 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Paid</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>