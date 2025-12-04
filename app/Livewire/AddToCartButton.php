<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\CartItem;
use Livewire\Component;

class AddToCartButton extends Component
{

    public Book $book;

    public function mount(Book $book)
    {
        $this->book = $book;
    }

    public function addToCart($bookId)
    {
        $item = CartItem::firstOrCreate([
            'user_id' => auth()->id(),
            'book_id' => $bookId,
        ]);

        $item->quantity++;
        $this->dispatch('cartUpdated');
    }
    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
