<x-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-[#006D77] mb-6">Book Requests Overview</h1>

        {{-- === Summary Counters === --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white shadow-md border rounded-xl p-4 flex flex-col items-center">
                <p class="text-sm text-gray-500">Active Requests</p>
                <p class="text-2xl font-bold text-[#006D77]">{{ $ongoingRequests->count() }}</p>
            </div>
            <div class="bg-white shadow-md border rounded-xl p-4 flex flex-col items-center">
                <p class="text-sm text-gray-500">Requests (Last 30 Days)</p>
                <p class="text-2xl font-bold text-[#006D77]">{{$recentCount}}</p>
            </div>
            <div class="bg-white shadow-md border rounded-xl p-4 flex flex-col items-center">
                <p class="text-sm text-gray-500">Fulfilled Today</p>
                <p class="text-2xl font-bold text-[#006D77]">{{ $fulfilledToday }}</p>
            </div>
        </div>

        {{-- === Search === --}}
        <form method="GET" action="" class="flex justify-end  mt-4">
            <input type="text" name="search" value="" placeholder="Search by Request ID"
                class="border rounded-l-md px-3 py-2 focus:ring-2 focus:ring-[#006D77] outline-none">
            <button type="submit" class="bg-[#006D77] text-white px-4 rounded-r-md hover:bg-[#00555d]">Search</button>
        </form>

        {{-- Ongoing Requests --}}
        <div class="mb-10">
            <h2 class="text-xl font-semibold text-[#006D77] mb-3">Ongoing Requests</h2>
            <div class="bg-white rounded-xl shadow-md border p-6">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-[#006D77] text-white">
                        <tr>
                            <th class="p-3 text-left">Id</th>
                            <th class="p-3 text-left">Book</th>
                            <th class="p-3 text-left">User</th>
                            <th class="p-3 text-left">Request Date</th>
                            <th class="p-3 text-left">End Date</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ongoingRequests as $req)
                            @php
                                $isDelayed = \Carbon\Carbon::parse($req->requestEndDate)->isPast();
                                $statusColor = $isDelayed ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800';
                                $statusText = $isDelayed ? 'Delayed' : 'Ongoing';
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $req->id }}</td>
                                <td class="p-3">{{ $req->book->title }}</td>
                                <td class="p-3">{{ $req->user->name }}</td>
                                <td class="p-3">{{ $req->requestDate }}</td>
                                <td class="p-3">{{ $req->requestEndDate }}</td>
                                <td class="p-3 text-center">
                                    <span
                                        class="px-2 py-1 rounded font-semibold {{ $statusColor }}">{{ $statusText }}</span>
                                </td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('showBookRequest', $req) }}"
                                        class="text-indigo-600 hover:text-indigo-800">View →</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">No ongoing requests</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
            </div>
        </div>

        {{-- Completed Requests --}}
        <div>
            <h2 class="text-xl font-semibold text-[#006D77] mb-3">Completed Requests</h2>
            <div class="bg-white rounded-xl shadow-md border p-6">
                <table class="w-full text-sm border-collapse">
                    <thead class="bg-gray-700 text-white">
                        <tr>
                            <th class="p-3 text-left">Id</th>
                            <th class="p-3 text-left">Book</th>
                            <th class="p-3 text-left">User</th>
                            <th class="p-3 text-left">Returned</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($completedRequests as $req)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $req->id }}</td>
                                <td class="p-3">{{ $req->book->title }}</td>
                                <td class="p-3">{{ $req->user->name }}</td>
                                <td class="p-3">{{ $req->returnedDate ?? '—' }}</td>
                                <td class="p-3 text-center">
                                    <span
                                        class="px-2 py-1 rounded bg-green-100 text-green-800 font-semibold">Completed</span>
                                </td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('showBookRequest', $req) }}"
                                        class="text-indigo-600 hover:text-indigo-800">View →</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">No completed requests</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
            </div>
        </div>
    </div>
</x-layout>
