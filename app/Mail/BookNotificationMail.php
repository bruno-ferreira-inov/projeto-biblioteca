<?php

namespace App\Mail;

use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $book;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Book $book)
    {
        $this->user = $user;
        $this->book = $book;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "You have subscribed to a notification for: {$this->book->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.notify-book',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
