<?php

namespace App\Jobs;

use App\Mail\BookAvailableMail;
use App\Models\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Mail;

class SendBookAvailabilityNotifications implements ShouldQueue
{
    use Queueable;

    public $book;

    /**
     * Create a new job instance.
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }
    public function middleware()
    {
        return [new RateLimited('emails')];
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pendingUsers = $this->book
            ->notificationUsers()
            ->wherePivot('notified', false)
            ->get();

        foreach ($pendingUsers as $user) {
            dispatch(new SendBookAvailableEmail($user, $this->book));
        }
    }
}
