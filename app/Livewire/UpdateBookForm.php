<?php

namespace App\Livewire;

use App\Http\Requests\StoreBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Database\Seeders\AuthorSeeder;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateBookForm extends Component
{
    use WithFileUploads;
    public $authors = [];
    public $bookAuthors = [];
    public Book $book;

    public $showDropdown = false;

    #[Validate('required')]
    public string $title;
    #[Validate('required')]
    public string $isbn;
    #[Validate('required')]
    public string $price;
    #[Validate('required')]
    public $publisher_id;
    #[Validate('required')]
    public $bibliography;

    #[Validate('required')]
    public $quantity;

    #[Validate('image|max:2048')] //2MB Max size image
    public $cover;
    public string $coverPath;

    public $allAuthors;
    public $allPublishers;

    public function mount(Book $book)
    {
        $this->allAuthors = Author::all();
        $this->allPublishers = Publisher::all();
        $this->bookAuthors = $book->authors;

        $this->authors = $book->authors->pluck('id')->toArray();


        // array_merge($this->authors, $this->bookAuthors);
        // dd($this->authors);
        $this->setBook($book);
        // dd($this->authors);
    }
    public function setBook(Book $book)
    {
        $this->book = $book;
        $this->title = $book->title;
        $this->isbn = $book->isbn;
        $this->price = $book->price;
        $this->publisher_id = $book->publisher_id;
        $this->bibliography = $book->bibliography;
        $this->cover = $book->coverPath;
        $this->quantity = $book->current_quantity;
    }

    public function render()
    {
        return view('livewire.update-book-form');
    }
}
