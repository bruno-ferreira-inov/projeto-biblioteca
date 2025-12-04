@props(['book', 'relatedBooks'])
<!-- Single Book Card with Image -->
<div class="max-w-4xl mx-auto my-8 bg-[#EDF6F9] p-6 rounded-lg shadow-xl flex flex-col">
    <div class="flex flex-col lg:flex-row items-center lg:items-start flex-grow space-y-6 lg:space-y-0 lg:space-x-6">
        <!-- Book Cover -->
        <div class="flex flex-col items-center space-y-4 flex-shrink-0">
            <img class="w-64 h-96 object-cover rounded-md" src="{{ asset('storage/' . $book->cover) }}"
                alt="Book Cover">

            <div class="flex flex-col gap-3 w-64">
                <a href="/books" class="btn btn-info w-full">Back to Books List</a>
                <div>
                    @auth
                        @livewire('add-to-cart-button', [$book])
                        @if ($book->current_quantity > 0 && Auth::user()->availableRequests > 0)
                            <a href="/books/{{ $book->id }}/request" class="btn btn bg-slate-300 w-full">Request</a>
                        @else
                            @livewire('book-notification', [$book])
                        @endif
                    @endauth


                </div>
                @can('admin-access')
                    <a href="/books/{{ $book->id }}/edit" class="btn btn-active btn-warning">Edit</a>
                    <button form="delete-form" class="btn btn-active btn-error">Delete</button>
                @endcan

            </div>
        </div>

        <!-- Book Details -->
        <div class="flex-grow space-y-4">
            <h1 class="text-3xl font-bold text-[#006d77]">{{ $book->title }}</h1>

            <!-- Authors -->
            <p class="text-[#006d77] text-lg">By: {{ implode(', ', $book->authors->pluck('name')->toArray()) }}</p>

            <!-- ISBN -->
            <p class="text-[#006d77] text-sm">ISBN: {{ $book->isbn }}</p>

            <!-- Price -->
            <div class="text-[#006d77] font-semibold mt-4 text-2xl">
                {{ number_format($book->price, 2) }}€
            </div>

            <!-- Description -->
            <div x-data="{ expanded: false }" class="mt-4">
                <h3 class="text-xl font-semibold text-[#006d77]">Summary</h3>

                <!-- Collapsed Version -->
                <div x-show="!expanded">
                    {!! Str::limit($book->bibliography, 750) !!}
                    @if (strlen($book->bibliography) > 750)
                        <span class="text-[#006d77] underline cursor-pointer" @click="expanded = true">
                            Read more...
                        </span>
                    @endif
                </div>

                <!-- Expanded Version -->
                <div x-show="expanded" x-cloak>
                    {!! $book->bibliography !!}
                    <span class="text-[#006d77] underline cursor-pointer" @click="expanded = false">
                        Read less
                    </span>
                </div>
            </div>

            <div class="mt-4">
                <h4 class="text-l font-semibold text-[#006d77]">Available Copies</h4>
                <p class="text-[#006d77]">{{ $book->current_quantity }}/{{ $book->total_quantity }}</p>
            </div>
        </div>
    </div>

    <div class="p-6 mt-4rounded-lg ">
        <h2 class="text-2xl font-bold text-teal-700 mb-4">Reviews</h2>

        @if ($book->reviews->count() === 0)
            <p class="text-gray-600">No reviews yet. Be the first to leave one!</p>
        @endif

        @foreach ($book->reviews as $review)
            @if ($review->approved)
                <div class="p-4 mb-3 bg-white rounded-md border">
                    <p class="font-semibold">{{ $review->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $review->created_at->format('Y-m-d') }}</p>
                    <p class="mt-2">{{ $review->review_body }}</p>
                </div>
            @else
                @can('admin-access')
                    <div class="p-4 mb-3 bg-white rounded-md border">
                        <p class="font-semibold">{{ $review->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $review->created_at->format('Y-m-d') }}</p>
                        <p class="mt-2">{{ $review->review_body }}</p>

                        @if(!$review->approved)
                            <p class="text-xs text-yellow-600 mt-1">(Awaiting approval)</p>
                        @endif
                    </div>
                @endcan
            @endif

        @endforeach
    </div>

    <div class="mt-10">
        <h2 class="text-xl font-semibold text-[#006d77] mb-4">You may also like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($relatedBooks as $rec)
                <a href="/books/{{ $rec->id }}" class="block bg-[#edf6f9] p-4 rounded shadow hover:shadow-lg">
                    <img src="{{ asset('storage/' . $rec->cover) }}" class="h-64 w-full object-cover rounded">
                    <p class="mt-5 font-semibold text-[#006d77]">{{ $rec->title }}</p>
                </a>
            @endforeach
        </div>
    </div>

    @can('admin-access')
        @if ($book->bookRequests->count() > 0)
            <div class="mt-10 bg-[#EDF6F9] p-6 rounded-lg shadow-inner">
                <h2 class="text-2xl font-bold text-[#006D77] mb-4">Book Requests</h2>

                <!-- Active Requests -->
                @php
                    $activeRequests = $book->bookRequests->where('completed', false);
                    $pastRequests = $book->bookRequests->where('completed', true);
                @endphp

                @if ($activeRequests->count() > 0)
                    <div class="space-y-3 mb-6">
                        <h3 class="text-lg font-semibold text-[#006D77]">Active Requests</h3>

                        @foreach ($activeRequests as $req)
                            @php
                                $isLate = now()->gt($req->requestEndDate);
                            @endphp

                            <div @if ($isLate) class="p-4 rounded-md border border-red-400" @else
                            class="p-4 rounded-md border  border-green-400" @endif>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <div>
                                        <a href="{{ Route('showBookRequest', $req) }}" class="font-semibold text-[#006D77]">
                                            Request No. {{ $req->id }}
                                        </a>
                                        <p class="font-semibold text-[#006D77]">
                                            Requested by: {{ $req->user->name }}
                                        </p>
                                        <p class="text-sm text-[#006D77]">
                                            From {{ $req->requestDate }}
                                            to {{ $req->requestEndDate }}
                                        </p>
                                    </div>

                                    <div @if ($isLate) class="mt-2 sm:mt-0 text-sm font-medium test-red-500" @else
                                    class="mt-2 sm:mt-0 text-sm font-medium text-green-700" @endif>

                                        {{ $isLate ? 'Overdue' : 'Active' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Past Requests -->
                @if ($pastRequests->count() > 0)
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold text-[#006D77]">Completed Requests</h3>

                        @foreach ($pastRequests as $request)
                            <div class="p-4 rounded-md border border-gray-300 bg-gray-50">
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <div>
                                        <p class="font-semibold text-[#006D77]">
                                            Requested by: {{ $request->user->name }}
                                        </p>
                                        <p class="text-sm text-[#006D77]">
                                            {{ $request->requestDate }}
                                            {{ $request->returnedDate ?? 'Not returned' }}
                                        </p>
                                    </div>
                                    <div class="mt-2 sm:mt-0 text-sm text-gray-600">
                                        Completed
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    @endcan
</div>



<form method="POST" action="/books/{{ $book->id }}" class="hidden" id="delete-form"
    onsubmit="return confirm('Delete this book?')">
    @csrf
    @method('DELETE')
</form>
