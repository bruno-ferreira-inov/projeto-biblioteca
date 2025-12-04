<x-layout>
    <div class="max-w-3xl mx-auto py-12">
        <div class="bg-white shadow-lg rounded-xl p-8">

            {{-- Success Icon --}}
            <div class="flex justify-center mb-6">
                <div class="bg-green-100 text-green-600 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-center mb-2">Thank You for Your Purchase!</h1>
            <p class="text-center text-gray-600 mb-8">
                Your order <span class="font-semibold">#{{ $order->id }}</span> has been processed successfully.
            </p>

            {{-- Order Summary --}}
            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                <ul class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                        <li class="flex items-center justify-between py-3">

                            {{-- Book Info --}}
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $item->book->cover) }}"
                                    class="h-16 w-12 object-cover rounded shadow-sm" />

                                <div>
                                    <p class="font-semibold">{{ $item->book->title }}</p>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>

                            {{-- Price --}}
                            <span class="font-medium">
                                €{{ number_format($item->subtotal, 2) }}
                            </span>

                        </li>
                    @endforeach
                </ul>

                <div class="flex justify-between text-xl font-bold mt-6">
                    <span>Total</span>
                    <span>€{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-10 text-center">
                <a href="/"
                    class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
                    Return to Home
                </a>
            </div>

        </div>
    </div>
</x-layout>