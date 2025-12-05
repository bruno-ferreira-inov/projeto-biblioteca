<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use Auditable;
    protected $guarded = [];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
