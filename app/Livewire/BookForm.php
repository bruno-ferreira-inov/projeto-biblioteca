<?php

namespace App\Livewire;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookForm extends Component
{
    use WithFileUploads;
    public $authors = [];

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

    public function mount()
    {
        $this->allAuthors = Author::all();
        $this->allPublishers = Publisher::all();
    }

    public function save()
    {
        //dd($this->title, $this->isbn, $this->price, $this->coverPath, $this->publisher_id, $this->bibliography);
        $this->validate();
        $this->coverPath = $this->cover->store(path: 'BookCovers');

        $book = Book::create([
            'title' => $this->title,
            'isbn' => $this->isbn,
            'price' => $this->price,
            'cover' => $this->coverPath,
            'publisher_id' => $this->publisher_id,
            'bibliography' => $this->bibliography,
        ]);

        foreach ($this->authors as $pos => $value) {
            $author = Author::find($value);
            $book->author($author->name);
        }

        redirect('/landing');
    }

    public function render()
    {
        return view('livewire.book-form');
    }
}
