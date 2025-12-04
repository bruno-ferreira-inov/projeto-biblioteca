<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMAny(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
