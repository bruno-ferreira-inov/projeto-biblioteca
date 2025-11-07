<x-layout>
    <div class="max-w-3xl mx-auto my-10 bg-white shadow-md rounded-lg p-8 border border-gray-200">
        <div class="flex flex-col items-center text-center space-y-6">

            <!-- Book Cover -->
            <img class="w-48 h-72 object-cover rounded-md shadow-md" src="{{ asset('storage/' . $book->cover) }}"
                alt="Book Cover">

            <!-- Book Info -->
            <div>
                <h1 class="text-3xl font-bold text-[#006D77]">{{ $book->title }}</h1>
                <p class="text-[#006D77] text-lg">By: {{ implode(', ', $book->authors->pluck('name')->toArray()) }}</p>
                <p class="text-[#006D77] text-sm">ISBN: {{ $book->isbn }}</p>
            </div>

            <!-- Confirmation Info -->
            <div class="bg-[#EDF6F9] p-4 rounded-lg shadow-inner w-full">
                <p class="text-[#006D77] mb-2">You currently have
                    <span class="font-semibold">{{ Auth::user()->availableRequests }}</span>
                    remaining request(s).
                </p>

                <p class="text-[#006D77]">
                    Are you sure you want to request
                    <span class="font-semibold">{{ $book->title }}</span>?
                </p>

                @if ($book->current_quantity <= 0)
                    <p class="text-red-600 font-semibold mt-3">Sorry, this book is currently unavailable.</p>
                @endif
            </div>

            <!-- Confirmation Form -->
            <form action="/books/{{ $book->id }}/request" method="POST" class="mt-6">
                <input type="hidden" name="bookId" id="bookId" value="{{ $book->id }}" />
                @csrf
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/books/{{ $book->id }}" class="btn btn-outline text-[#006D77] border-[#006D77]">
                        Cancel
                    </a>
                    @if ($book->current_quantity > 0 && Auth::user()->availableRequests > 0)
                        <button type="submit" class="btn bg-[#006D77] text-white hover:bg-[#004F52]">
                            Confirm Request
                        </button>
                    @else
                        <button type="button" class="btn btn-disabled cursor-not-allowed">
                            Not Available
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-layout>
