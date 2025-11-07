@props(['book'])
<!-- Single Book Card with Image on Left and Information on Right (Responsive) -->
@php
    dump(Auth::user()->availableRequests)
 @endphp
<div class="max-w-4xl mx-auto my-8 bg-[#EDF6F9] p-6 rounded-lg shadow-xl flex flex-col">
    <div class="flex flex-col lg:flex-row items-center lg:items-start flex-grow space-y-6 lg:space-y-0 lg:space-x-6">
        <!-- Book Cover (Image on the Left) -->
        <div class="flex justify-center lg:justify-start flex-shrink-0">
            <img class="w-64 h-96 object-cover rounded-md" src="{{ asset('storage/' . $book->cover) }}"
                alt="Book Cover">
        </div>

        <!-- Book Details (Info on the Right) -->
        <div class="flex-grow space-y-4">
            <h1 class="text-3xl font-bold text-[#006d77]">{{ $book->title }}</h1>

            <!-- Authors -->
            <p class="text-[#006d77] text-lg">By: {{ implode(', ', $book->authors->pluck('name')->toArray()) }}</p>

            <!-- ISBN -->
            <p class="text-[#006d77] text-sm">ISBN: {{ $book->isbn }}</p>

            <!-- Price -->
            <div class="text-[#006d77] font-semibold mt-4 text-2xl">
                ${{ number_format($book->price, 2) }}
            </div>

            <!-- Description -->
            <div class="mt-4">
                <h3 class="text-xl font-semibold text-[#006d77]">Summary</h3>
                <p class="text-[#006d77]">{{ $book->bibliography }}</p>

            </div>
            <div class="mt-4">
                <h4 class="text-l font-semibold text-[#006d77]">Available Copies</h4>
                <p class="text-[#006d77]">{{ $book->current_quantity }}/{{ $book->total_quantity }}</p>
            </div>

            <!-- Back Button -->

            <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-start pt-22 ">
                <a href="/books" class="btn btn-info">Back to Books List</a>
                @if ($book->current_quantity > 0 && Auth::user()->availableRequests > 0)
                    <a href="/books/{{ $book->id }}/request" class="btn btn">Request</a>
                @else
                    <a href="/books/{{ $book->id }}/request" class="btn btn-disabled">Request</a>
                @endif

                @can('admin-access')
                    <a href="/books/{{ $book->id }}/edit" class="btn btn-active btn-warning">Edit</a>
                    <button form="delete-form" class="btn btn-active btn-error">Delete</button>
                @endcan

            </div>
        </div>
    </div>
</div>

<form method="POST" action="/books/{{ $book->id }}" class="hidden" id="delete-form"
    onsubmit="return confirm('Delete this author?')">
    @csrf
    @method('DELETE')
</form>