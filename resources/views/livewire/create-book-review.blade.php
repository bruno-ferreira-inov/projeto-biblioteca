<div>
    @if (!$reviewed)
        <button class="btn" onclick="my_modal_2.showModal()">Review this Book!</button>
    @else
        <button class="btn" onclick="my_modal_2.showModal()">Update your review!</button>
    @endif

    @if ($review)
        @if ($review->user_id === auth()->id())

            <div class="mt-2 p-2 border border-teal-500 rounded
                        @if (!$review->approved)
                            text-red-900 bg-red-50
                        @else
                            bg-teal-50 text-teal-900
                        @endif
                        ">
                <h4 class="font-semibold mb-2">Your Review

                    @if (!$review->approved)
                        (Under Review from Moderation)
                    @endif
                </h4>
                <p>{{ Str::limit($review->review_body, 150) }}</p>
            </div>
        @endif
    @endif



    <dialog id="my_modal_2" class="modal w-full">
        <div class="modal-box">
            <h3 class="text-lg font-bold">You're writing a review to {{ $book->title}}!</h3>
            <textarea wire:model="reviewBody" class="w-full p-1"></textarea>
            <form wire:submit="createReview">

                <button type="submit" class="btn btn-success"> Save</button>
            </form>
            <form method="dialog">
                <button class="btn btn-error"> Cancel</button>
            </form>

        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <dialog id="my_modal_3" class="modal">

    </dialog>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', () => {
                const modal = document.getElementById('my_modal_2');
                if (modal) modal.close();
            });
        });
    </script>
</div>