<div x-data="{ open: false }" @toggle-cart.window="open = !open">
    <!-- CART BUTTON (floating or in navbar) -->
    <button @click="open = true"
        class="fixed bottom-6 right-6 bg-[#006D77] text-white px-4 py-3 rounded-full shadow-lg">
        Cart ({{ count($items) }})
    </button>

    <!-- SLIDE-IN PANEL -->
    <div x-show="open"
        class="fixed top-0 right-0 w-80 h-full bg-white shadow-xl z-50 p-4 overflow-y-auto transform transition-transform"
        x-transition:enter="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="translate-x-0"
        x-transition:leave-end="translate-x-full">
        <h2 class="text-xl font-bold mb-4">Your Cart</h2>

        @forelse ($items as $item)
            <div class="flex items-start gap-4 border-b py-3">

                <!-- Book Image -->
                <img src="{{ asset('storage/' . $item->book->cover) }}" alt="{{ $item->book->title }}"
                    class="w-16 h-24 object-cover rounded" />

                <!-- Middle section (Title + Qty buttons) -->
                <div class="flex-1 flex flex-col justify-between">

                    <!-- Title -->
                    <p class="font-semibold leading-tight">
                        {{ $item->book->title }}
                    </p>

                    <!-- Quantity Controls -->
                    <div class="flex items-center mt-3 space-x-3">

                        <button wire:click="decreaseQuant({{ $item->id }})"
                            class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded">
                            -
                        </button>

                        <span class="font-medium w-6 text-center">
                            {{ $item->quantity }}
                        </span>

                        <button wire:click="increaseQuant({{ $item->id }})"
                            class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded">
                            +
                        </button>
                    </div>

                </div>

                <!-- Price (aligned right) -->
                <p class="font-semibold whitespace-nowrap">
                    €{{ number_format($item->book->price * $item->quantity, 2) }}
                </p>

            </div>
        @empty
            <p class="text-gray-600">Your cart is empty.</p>
        @endforelse

        <div class="mt-6 font-bold text-lg">
            Total: €{{ number_format($total, 2) }}
        </div>

        <button class="mt-4 w-full bg-[#006D77] text-white py-2 rounded"
            onclick="window.location.href='{{ route('checkout') }}'">
            Checkout
        </button>

        <button class="mt-2 w-full bg-gray-200 py-2 rounded" @click="open = false">
            Close
        </button>
    </div>
</div>