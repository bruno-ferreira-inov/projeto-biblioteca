<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $guarded = [];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
