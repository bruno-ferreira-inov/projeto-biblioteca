<?php

namespace App\Jobs;

use App\Mail\BookAvailableMail;
use App\Models\Book;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendBookAvailableEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public Book $book)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user)->send(new BookAvailableMail($this->book));

        $this->book->notificationUsers()
            ->updateExistingPivot($this->user->id, [
                'notified' => true
            ]);
    }


}
