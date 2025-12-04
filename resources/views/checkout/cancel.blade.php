<x-layout>
    <div class="max-w-lg mx-auto py-16">
        <div class="bg-white p-10 rounded-xl shadow-lg">

            {{-- Cancel Icon --}}
            <div class="flex justify-center mb-6">
                <div class="bg-red-100 text-red-600 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-center mb-2">Payment Cancelled</h1>

            <p class="text-center text-gray-600 mb-8">
                Your payment was not completed. You have not been charged.

                Your cart will remain with it's items.
            </p>

            <div class="text-center">
                <a href="/"
                    class="inline-block bg-gray-700 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-800 transition">
                    Return to Home
                </a>
            </div>

        </div>
    </div>
</x-layout>