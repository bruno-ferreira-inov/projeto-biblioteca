<x-layout>
    <div class="max-w-4xl mx-auto px-6 py-8">

        @can('admin-access')
            <a href="/admin/requests" class="text-[#006D77] hover:underline">&larr; Back to
                Requests</a>
        @else
            <a href="/books/requests" class="text-[#006D77] hover:underline">&larr; Back to
                Requests</a>
        @endcan
        <div class="bg-white rounded-xl shadow-md border p-6 mt-4">
            <h1 class="text-2xl font-bold text-[#006D77] mb-4">
                Request #{{ $bookRequest->id }}
            </h1>

            {{-- Book Details --}}
            <div class="flex flex-col sm:flex-row gap-6 mb-6">
                <img class="w-40 h-60 object-cover rounded-md border"
                    src="{{ asset('storage/' . $bookRequest->book->cover) }}" alt="Book Cover">

                <div>
                    <h2 class="text-xl font-semibold text-[#006D77]">{{ $bookRequest->book->title }}</h2>
                    <p class="text-[#006D77] text-sm mb-1"><strong>ISBN:</strong> {{ $bookRequest->book->isbn }}</p>
                    <p class="text-[#006D77] text-sm mb-1"><strong>Price:</strong>
                        {{ $bookRequest->book->price ? '$' . number_format($bookRequest->book->price, 2) : 'Free' }}
                    </p>
                    <p class="text-[#006D77] text-sm mb-1"><strong>Publisher:</strong>
                        {{ optional($bookRequest->book->publisher)->name ?? '—' }}
                    </p>
                    @if ($bookRequest->user->id === auth()->id() && $bookRequest->completed)
                        @livewire('create-book-review', [$bookRequest->book])
                    @endif
                </div>
            </div>

            {{-- Request Details --}}
            <div class="space-y-2 mb-6">
                <h3 class="text-lg font-semibold text-[#006D77]">Request Information</h3>
                <p><strong>Requested By:</strong> {{ $bookRequest->user->name }} ({{ $bookRequest->user->email }})</p>
                <p><strong>Request Date:</strong> {{ $bookRequest->requestDate }}</p>
                <p><strong>End Date:</strong> {{ $bookRequest->requestEndDate }}</p>

                @if ($bookRequest->returnedDate)
                    <p><strong>Returned Date:</strong> {{ $bookRequest->returnedDate }}</p>
                @endif

                @php
                    $isDelayed = !$bookRequest->completed && \Carbon\Carbon::parse($bookRequest->requestEndDate)->isPast();
                @endphp
                <p>
                    <strong>Status:</strong>
                    @if ($bookRequest->completed)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded font-semibold">Completed</span>
                    @elseif ($isDelayed)
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded font-semibold">Delayed</span>
                    @else
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded font-semibold">Ongoing</span>
                    @endif
                </p>
            </div>

            {{-- Mark as returned --}}

            @if (!$bookRequest->completed)
                @can('admin-access')
                    <form action="{{ route('completeRequest', $bookRequest) }}" method="POST" class="mt-6">
                        @csrf
                        <button type="submit"
                            class="bg-[#006D77] hover:bg-[#00555d] text-white px-5 py-2 rounded-lg font-semibold">
                            Confirm Book Return
                        </button>
                    </form>
                @endcan
            @else
                <div class="p-4 bg-green-50 text-green-700 border border-green-200 rounded-lg">
                    This request was completed on <strong>{{ $bookRequest->returnedDate }}</strong>.
                </div>
            @endif

        </div>
    </div>
</x-layout>