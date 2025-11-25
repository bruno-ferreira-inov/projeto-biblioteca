<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\BookReview;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateBookReview extends Component
{

    public Book $book;

    public BookReview $review;

    #[Validate('required')]
    public string $reviewBody;
    public float $reviewScore;
    public bool $reviewed;
    public function render()
    {
        return view('livewire.create-book-review');
    }

    public function mount(Book $book)
    {
        $this->setBook($book);

        $this->reviewed = BookReview::where('user_id', auth()->id())
            ->where('book_id', $this->book->id)
            ->exists();

        if ($this->reviewed) {
            $this->setReview();
        }
    }

    public function setBook(Book $book)
    {
        $this->book = $book;
    }

    public function setReview()
    {
        $this->review = BookReview::where(
            'user_id',
            auth()->id()
        )->where('book_id', $this->book->id)
            ->first();

        $this->reviewBody = $this->review->review_body;
    }

    public function createReview()
    {

        $this->validate();

        if (!$this->reviewed) {
            $this->review = BookReview::create([
                'user_id' => Auth()->id(),
                'book_id' => $this->book->id,
                'review_body' => $this->reviewBody,
            ]);
            $this->reviewed = true;
        } else {
            $this->review->update([
                'review_body' => $this->reviewBody,
                'approved' => false,
            ]);
        }

        $this->dispatch('close-modal');
        $this->dispatch('$review-update');
    }

    #[On('review-update')]
    public function updatePage()
    {
        $this->review = $this->review = BookReview::where(
            'user_id',
            auth()->id()
        )->where('book_id', $this->book->id)
            ->first();
    }
}
