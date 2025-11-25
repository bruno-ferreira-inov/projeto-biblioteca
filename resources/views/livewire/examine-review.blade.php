<div>
    <button class="px-3 py-1 bg-yellow-300 rounded hover:bg-yellow-400"
        onclick="reviewModal{{ $review->id }}.showModal()">Manage</button>

    <dialog id="reviewModal{{ $review->id }}" class="modal">
        <div class="modal-box max-w-2xl p-6 rounded-lg">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Full Review</h3>

                <form method="dialog">
                    <button class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
                </form>
            </div>

            {{-- Review Content --}}
            <div class="max-h-64 overflow-y-auto p-3 border rounded bg-gray-50 text-gray-800">
                {{ $review->review_body }}
            </div>

            {{-- Rejection Reason --}}
            <div class="mt-5">
                <label class="block text-sm font-medium mb-2">Rejection Reason (optional)</label>
                <input type="text" wire:model="reason"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                    placeholder="Explain why this review may be rejected..." />
            </div>

            {{-- Actions --}}
            <div class="mt-6 flex justify-between items-center gap-3">

                {{-- Approve --}}
                <form wire:submit="approveReview">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 shadow-sm">
                        Approve
                    </button>
                </form>

                {{-- Reject --}}
                <form wire:submit="rejectReview">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 shadow-sm">
                        Reject
                    </button>
                </form>

                {{-- Close --}}
                <form method="dialog">
                    <button class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                        Close
                    </button>
                </form>

            </div>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</div>