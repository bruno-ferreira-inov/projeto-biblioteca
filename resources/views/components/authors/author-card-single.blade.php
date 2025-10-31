@props(['author'])

<div class="bg-gray-200 rounded-xl shadow-md hover:shadow-lg transition p-4 flex flex-col h-full">
    <div class="flex flex-col flex-grow justify-between">
        <!-- Clickable name + image -->
        <a href="/authors/{{ $author->id }}" class="group block">
            <h1 class="text-2xl font-bold text-black group-hover:text-indigo-600 transition">
                {{ $author->name }}
            </h1>

            <img class="w-64 h-96 object-cover rounded-md mt-3 mb-2 border border-gray-200 group-hover:opacity-90 transition"
                src="{{ asset('storage/' . $author->photo) }}" alt="{{ $author->name }}">
        </a>

        <!-- Action buttons -->
        <div class="flex gap-3 mt-3">
            <button class="btn btn-warning text-black px-3 py-1 rounded-md text-sm font-medium hover:brightness-110
                transition">
                Edit
            </button>

            <form action="/authors/{{ $author->id }}" method="POST" onsubmit="return confirm('Delete this author?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="btn btn-error text-black px-3 py-1 rounded-md text-sm font-medium hover:brightness-110 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
