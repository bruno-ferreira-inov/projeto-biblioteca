<?php

namespace App\Livewire;

use App\Models\CartItem;
use Livewire\Component;

class Cart extends Component
{
    public $items = [];

    public float $total = 0;

    protected $listeners = [
        'cartUpdated' => 'loadCart'
    ];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->items = CartItem::with('book')
            ->where('user_id', auth()->id())
            ->get();

        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->total = 0;

        foreach ($this->items as $i) {
            $this->total += floatval($i->book->price) * $i->quantity;
        }
    }

    public function increaseQuant($id)
    {
        $item = $this->getItem($id);
        $item->quantity++;
        $item->save();

        $this->loadCart();
    }

    public function decreaseQuant($id)
    {
        $item = $this->getItem($id);
        if ($item->quantity > 1) {

            $item->quantity--;
            $item->save();
        } else {
            $item->delete();
        }

        $this->loadCart();
    }

    public function deleteItem($id)
    {
        $item = $this->getItem($id)->delete();
        $this->loadCart();
    }


    public function getItem($id): CartItem
    {
        return CartItem::find($id);
    }
    public function render()
    {
        return view('livewire.cart');
    }
}
