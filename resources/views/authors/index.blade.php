<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Authors</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($authors as $author)
                <x-authors.author-card-single :$author>

                </x-authors.author-card-single>
            @endforeach

        </div>

    </div>
</x-layout>
