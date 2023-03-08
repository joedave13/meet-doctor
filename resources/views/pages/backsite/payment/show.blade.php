<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('backsite.payment.index') }}"
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
                                    {{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y H:i:s'); }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Code</th>
                                <td class="border px-6 py-4">
                                    {{ $payment->code; }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Consultation Fee</th>
                                <td class="border px-6 py-4">
                                    $ {{ number_format($payment->consultation_fee, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Doctor Fee</th>
                                <td class="border px-6 py-4">
                                    $ {{ number_format($payment->doctor_fee, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Hospital Fee</th>
                                <td class="border px-6 py-4">
                                    $ {{ number_format($payment->hospital_fee, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">VAT</th>
                                <td class="border px-6 py-4">
                                    $ {{ number_format($payment->vat, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Grand Total</th>
                                <td class="border px-6 py-4">
                                    $ {{ number_format($payment->total, 2, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Payment Method</th>
                                <td class="border px-6 py-4">
                                    {{ $payment->payment_method; }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>