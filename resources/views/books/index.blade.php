<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Books</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($books as $book)
                <a href="/books/{{ $book->id }}" class="block px-4 py-6">
                    <x-books.book-card-list :$book>

                    </x-books.book-card-list>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
