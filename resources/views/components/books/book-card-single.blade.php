@props(['book'])
<!-- Single Book Card with Image on Left and Information on Right (Responsive) -->
<div class="max-w-4xl mx-auto my-8 bg-gray-500 p-6 rounded-lg shadow-xl">
    <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-6 lg:space-y-0 lg:space-x-6">
        <!-- Book Cover (Image on the Left) -->
        <div class="flex-shrink-0">
            <img class="w-64 h-96 object-cover rounded-md" src="{{ asset('storage/' . $book->cover) }}"
                alt="Book Cover">
        </div>

        <!-- Book Details (Info on the Right) -->
        <div class="flex-grow space-y-4">
            <h1 class="text-3xl font-bold text-gray-800">{{ $book->title }}</h1>

            <!-- Authors -->
            <p class="text-gray-600 text-lg">By: {{ implode(', ', $book->authors->pluck('name')->toArray()) }}</p>

            <!-- ISBN -->
            <p class="text-gray-500 text-sm">ISBN: {{ $book->isbn }}</p>

            <!-- Price -->
            <div class="text-gray-800 font-semibold mt-4 text-2xl">
                ${{ number_format($book->price, 2) }}
            </div>

            <!-- Description -->
            <div class="mt-4">
                <h3 class="text-xl font-semibold text-gray-800">Description</h3>
                <p class="text-gray-700">{{ $book->bibliography }}</p>

            </div>

            <!-- Back Button -->
            <div class="mt-6 justify-end">
                <a href="/books{{ $book->id}}/edit" class="text-blue-500 hover:text-blue-700">Back to Books List</a>
                <a href="/books/{{ $book->id }}/edit" class="btn btn-active btn-warning">Edit</a>
                <button form="delete-form" class="btn btn-active btn-error">Delete</button>

            </div>
        </div>
    </div>
</div>

<form method="POST" action="/books/{{ $book->id }}" class="hidden" id="delete-form">
    @csrf
    @method('DELETE')
</form>
