<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Books</h1>
        <form method="GET" class="flex gap-4 mb-6">
            <input type="text" name="search" placeholder="Search books..." value="{{ request('search') }}"
                class="input input-bordered" />

            <select name="sort" class="select select-bordered">
                <option value="title" @selected(request('sort') === 'title')>Title</option>
                <option value="price" @selected(request('sort') === 'price')>Price</option>
                <option value="isbn" @selected(request('sort') === 'isbn')>ISBN</option>
            </select>

            <select name="direction" class="select select-bordered">
                <option value="asc" @selected(request('direction') === 'asc')>Asc</option>
                <option value="desc" @selected(request('direction') === 'desc')>Desc</option>
            </select>

            <button type="submit" class="btn text-white bg-[#006D77]">Apply</button>
        </form>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($books as $book)
                <a href="/books/{{ $book->id }}" class="block px-4 py-6">
                    <x-books.book-card-list :$book>

                    </x-books.book-card-list>
                </a>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
</x-layout>