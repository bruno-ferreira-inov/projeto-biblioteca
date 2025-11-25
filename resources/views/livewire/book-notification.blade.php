<div>
    @if (!$notified)
        <button class="btn bg-slate-300 w-full" onclick="my_modal_2.showModal()">Get Notified!</button>
    @else
        <button class="btn bg-slate-300 btn-disabled w-full" onclick="my_modal_2.showModal()">Notification Set!</button>
    @endif

    <dialog id="my_modal_2" class="modal">

        <div class="modal-box">
            <form method="dialog">
                <h3 class="text-lg font-bold">Would you like to be notified about this book?</h3>
                <button wire:click="setNotification" class="btn btn-success"> Yes</button> <button
                    class="btn btn-error">
                    Cancel</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</div>