<?php

namespace App\Mail;

use App\Models\Book;
use App\Models\User;
use App\Models\BookRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookRequestMade extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    // public $book = Book::find($this->bookrequest->book_id);
    // public $user = User::find($this->bookrequest->user_id);
    public BookRequest $bookRequest;
    public Book $book;
    public User $user;


    public function __construct(public BookRequest $bookrequest)
    {
        $this->bookRequest = $bookrequest;
        $this->book = Book::find($this->bookRequest->book_id);
        $this->user = User::find($this->bookRequest->user_id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {


        return new Envelope(
            subject: 'Book Request Made',
            from: 'admin@biblio.com',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.book-request-made',
            with: [
                'book' => $this->book,
                'user' => $this->user,
            ]
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
