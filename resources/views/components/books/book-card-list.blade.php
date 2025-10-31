<div class="bg-gray-500 rounded-xl shadow-md hover:shadow-lg transition p-4 flex flex-col h-full">
    <!-- Cover image -->
    <img class="w-64 h-96 object-cover rounded-md" src="{{ asset('storage/' . $book->cover) }}" alt="Book Cover">

    <!-- Book info -->
    <div class="flex flex-col flex-grow justify-between">
        <!-- Title and Author -->
        <div>
            <h2 class="text-lg font-semibold text-white mb-1 line-clamp-2">
                {{ $book->title }}
            </h2>
            <p class="text-white text-lg">By: {{ implode(', ', $book->authors->pluck('name')->toArray()) }}</p>

            <!-- Description -->
            <p class="text-gray-700 text-sm mb-4 line-clamp-3">
                {{ $book->description }}
            </p>
        </div>

        <!-- Price and ISBN -->
        <div class="mt-auto flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
            <span class="text-indigo-600 font-bold shrink-0">
                {{ $book->price ? '$' . number_format($book->price, 2) : 'Free' }}
            </span>
            <span class="text-sm text-gray-500 break-all">
                ISBN: {{ $book->isbn }}
            </span>
        </div>
    </div>
</div>
