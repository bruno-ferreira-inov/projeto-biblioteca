<x-layout>
    <div class="space-y-4">
        @foreach ($books as $book)
            <a href="/books/{{ $book->id }}" class="block px-4 pxy-6">
                <x-books.BookCard :$book>

                </x-books.BookCard>
            </a>
        @endforeach
    </div>
</x-layout>
