<x-layout>
    <form action="/books/{{ $book->id }}/request" method="POST">
        @csrf
        <input type="hidden" name="bookId" id="bookId" value="{{ $book->id }}" />
        <button type="submit">Submit</button>
    </form>
</x-layout>
