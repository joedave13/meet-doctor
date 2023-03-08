<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="payment-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Code</th>
                                <th>Grand Total</th>
                                <th>Payment Method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            var datatable = $('#payment-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: '5%',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: $.fn.dataTable.render.number('.', ',', 2, '$ ' )
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '25%'
                    }
                ],
                columnDefs: [
                    {
                        "targets": [0, 3, 4, 5],
                        "className": "text-center"
                    }
                ]
            });
        </script>
    </x-slot>
</x-app-layout>