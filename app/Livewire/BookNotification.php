<?php

namespace App\Livewire;

use App\Mail\BookNotificationMail;
use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class BookNotification extends Component
{

    public Book $book;

    public bool $notified = false;

    public function mount(Book $book)
    {
        $this->setBook($book);

        $this->notified = DB::table('book_user_notifications')
            ->where('user_id', auth()->id())
            ->where('book_id', $this->book->id)
            ->where('notified', false)
            ->exists();
    }
    public function setBook(Book $book)
    {
        $this->book = $book;
    }
    public function render()
    {
        return view('livewire.book-notification');
    }

    public function setNotification()
    {
        $user = auth()->user();

        $this->book->notificationUsers()->syncWithoutDetaching([
            auth()->id() => ['notified' => false]
        ]);

        Mail::to($user->email)->send(new BookNotificationMail($user, $this->book));
        $this->notified = true;

        return back()->with('success', 'You will be notified when this book is availale.');


    }
}
