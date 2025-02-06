@extends('welcome')

@section('content')
<div class="mx-auto my-6 px-2">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white text-center py-4">
            <h1 class="text-xl sm:text-2xl font-bold">Transaction History (Last 24 Hours)</h1>
        </div>

        <!-- Content -->
        <div class="p-4 sm:p-6">
            @if (!empty($message))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded">
                    <p class="font-semibold text-sm sm:text-base">{{ $message }}</p>
                </div>
            @endif

            @if ($transactions && count($transactions) > 0)
                <!-- Mobile-First Design -->
                <div class="space-y-4 sm:hidden">
                    @foreach ($transactions as $index => $transaction)
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">#:</span> {{ $index + 1 }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Email:</span> {{ $transaction->email }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Amount:</span> R{{ number_format($transaction->amount, 2) }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Item:</span> {{ $transaction->item_name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Status:</span> 
                                <span class="px-2 py-1 rounded text-sm font-medium 
                                    {{ $transaction->payment_status === 'Completed' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Date:</span> {{ $transaction->created_at->format('Y-m-d H:i:s') }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <!-- Standard Table for Larger Screens -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-left table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="px-4 py-2 border text-gray-600 font-medium">#</th>
                                <th class="px-4 py-2 border text-gray-600 font-medium">Email</th>
                                <th class="px-4 py-2 border text-gray-600 font-medium">Amount</th>
                                <th class="px-4 py-2 border text-gray-600 font-medium">Item</th>
                                <th class="px-4 py-2 border text-gray-600 font-medium">Status</th>
                                <th class="px-4 py-2 border text-gray-600 font-medium">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $index => $transaction)
                                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} border-b">
                                    <td class="px-4 py-2 border text-gray-800">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border text-gray-800">{{ $transaction->email }}</td>
                                    <td class="px-4 py-2 border text-gray-800">R{{ number_format($transaction->amount, 2) }}</td>
                                    <td class="px-4 py-2 border text-gray-800">{{ $transaction->item_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border text-gray-800">
                                        <span class="px-2 py-1 rounded text-sm font-medium 
                                            {{ $transaction->payment_status === 'Completed' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border text-gray-800">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    <p class="font-semibold text-sm sm:text-base">No transactions found in the last 24 hours.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
