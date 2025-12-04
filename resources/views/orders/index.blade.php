<x-layout>
    <div class="max-w-7xl mx-auto px-6 py-8">

        <h1 class="text-3xl font-bold mb-6">Orders</h1>

        {{-- Tabs --}}
        <div class="flex space-x-4 mb-6 border-b">
            <a href="?status=pending"
                class="pb-2 border-b-2 {{ request('status', 'pending') === 'pending' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600' }}">
                Pending
            </a>
            <a href="?status=paid"
                class="pb-2 border-b-2 {{ request('status') === 'paid' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-600' }}">
                Paid
            </a>
            <a href="?status=canceled"
                class="pb-2 border-b-2 {{ request('status') === 'canceled' ? 'border-red-600 text-red-600' : 'border-transparent text-gray-600' }}">
                Cancelled
            </a>
        </div>

        {{-- Orders Table --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="py-3 px-4 font-semibold">Order #</th>
                        <th class="py-3 px-4 font-semibold">Customer</th>
                        <th class="py-3 px-4 font-semibold">Email</th>
                        <th class="py-3 px-4 font-semibold">Total</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold">Date</th>
                        <th class="py-3 px-4 font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $order->id }}</td>
                            <td class="py-3 px-4">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $order->user->email ?? 'N/A' }}</td>
                            <td class="py-3 px-4 font-semibold">${{ number_format($order->total, 2) }}</td>

                            <td class="py-3 px-4">
                                @if ($order->status === 'paid')
                                    <span class="px-2 py-1 text-sm rounded bg-green-100 text-green-700">Paid</span>
                                @elseif ($order->status === 'pending')
                                    <span class="px-2 py-1 text-sm rounded bg-yellow-100 text-yellow-700">Pending</span>
                                @else
                                    <span class="px-2 py-1 text-sm rounded bg-red-100 text-red-700">Cancelled</span>
                                @endif
                            </td>

                            <td class="py-3 px-4">{{ $order->created_at->format('Y-m-d H:i') }}</td>

                            <td class="py-3 px-4">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-500">
                                No {{ request('status', 'pending') }} orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    </div>
</x-layout>
