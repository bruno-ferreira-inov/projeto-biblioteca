<?php

namespace App\Livewire;

use App\Http\Requests\StoreBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Database\Seeders\AuthorSeeder;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateBookForm extends Component
{
    public $authors = [];
    public $bookAuthors = [];
    public Book $book;

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

        dump($this->bookAuthors);

        for ($i = 0; $i < count($this->bookAuthors); $i++) {
            array_push($this->authors, $this->bookAuthors[$i]);
        }

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
    }

    public function render()
    {
        // dump($this->authors);
        return view('livewire.update-book-form');
    }
}
