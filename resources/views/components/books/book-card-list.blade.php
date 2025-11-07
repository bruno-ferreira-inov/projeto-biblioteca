<div class="relative bg-white rounded-xl shadow-md border hover:shadow-lg transition p-4 flex flex-col h-full">
    @php
        $availabilityColor = 'bg-green-500';
        if ($book->current_quantity === 0) {
            $availabilityColor = 'bg-red-500';
        } elseif ($book->current_quantity < ($book->total_quantity / 2)) {
            $availabilityColor = 'bg-yellow-400';
        }
    @endphp
    <div class="absolute top-2 right-2">
        <span class="block w-4 h-4 rounded-full {{ $availabilityColor }}" title="
            @if ($book->current_quantity === 0)
                Currently Unavailable
            @elseif ($book->current_quantity <= ($book->total_quantity / 2))
                Low Volume Available
            @else
                In Inventory
            @endif
        "></span>
    </div>
    <!-- Cover image -->
    <div class="flex justify-center">
        <img class="w-64 h-96 object-cover rounded-md" src="{{ asset('storage/' . $book->cover) }}" alt="Book Cover">
    </div>

    <!-- Book info -->
    <div class="flex flex-col flex-grow justify-between">
        <!-- Title and Author -->
        <div class="text-center">

            <h2 class="text-lg font-semibold text-[#006D77] mb-1 line-clamp-2">
                {{ $book->title }}
            </h2>
            <p class="text-[#006D77] text-lg">By: {{ implode(', ', $book->authors->pluck('name')->toArray()) }}</p>

            <!-- Description -->
            <p class="text-[#006D77] text-sm mb-4 line-clamp-3">
                {{ $book->description }}
            </p>
        </div>

        <!-- Price and ISBN -->
        <div class="mt-auto flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
            <span class="text-indigo-600 font-bold shrink-0">
                {{ $book->price ? '$' . number_format($book->price, 2) : 'Free' }}
            </span>
            <span class="text-sm text-[#006D77] break-all">
                ISBN: {{ $book->isbn }}
            </span>
        </div>
    </div>
</div>
