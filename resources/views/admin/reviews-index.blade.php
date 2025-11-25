<x-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Pending Reviews</h1>
        </div> @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded"> {{ session('success') }} </div> @endif
        @if($reviews->count() === 0)
        <div class="p-4 bg-gray-50 rounded">No pending reviews.</div> @else <div
            class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">User</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Book</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Excerpt</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Submitted</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100"> @foreach($reviews as $review) <tr>
                        <td class="px-4 py-3 text-sm"> {{ $review->user->name }}
                            <div class="text-xs text-gray-500">{{ $review->user->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm"> <a href="{{ route('books.show', $review->book) }}"
                                class="text-teal-700 font-semibold"> {{ $review->book->title }} </a>
                            <div class="text-xs text-gray-500">ISBN: {{ $review->book->isbn }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm
                        @if (is_null($review->approved))
                            bg-yellow-100
                        @elseif ($review->approved === false)
                            bg-red-100
                        @endif
                    ">
                            <span class="cursor-pointer hover:underline"
                                onclick="reviewModal{{$review->id}}.showModal()">
                                {{ Str::limit($review->review_body, 140) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm"> {{ $review->created_at->format('Y-m-d H:i') }} </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="inline-flex gap-2">
                                <livewire:examine-review :review="$review" :key="$review->id" />
                            </div>
                        </td>
                </tr> @endforeach </tbody>
            </table>
            <div class="p-4"> {{ $reviews->links() }} </div>
        </div> @endif
    </div>
</x-layout>
