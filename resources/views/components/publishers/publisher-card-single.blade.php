@props(['publisher'])
<div class="bg-gray-200 rounded-xl shadow-md hover:shadow-lg transition p-4 flex flex-col h-full">
    <div class="flex flex-col flex-grow justify-between">
        <!-- Clickable name + image -->
        <h1 class="text-2xl font-bold text-black group-hover:text-indigo-600 transition">
            {{ $publisher->name }}
        </h1>

        <img class="w-64 h-96 object-cover rounded-md mt-3 mb-2 border border-gray-200 group-hover:opacity-90 transition"
            src="{{ asset('storage/' . $publisher->logo) }}" alt="{{ $publisher->name }}">

        <!-- Action buttons -->
        <div class="flex gap-3 mt-3">
            <a href="/publishers/{{ $publisher->id }}/edit" class="btn btn-warning text-black px-3 py-1 rounded-md text-sm font-medium hover:brightness-110
                transition">
                Edit
            </a>

            <form action="/publishers/{{ $publisher->id }}" method="POST"
                onsubmit="return confirm('Delete this publisher?')">
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
