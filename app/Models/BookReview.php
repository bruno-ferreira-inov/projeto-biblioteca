<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    use Auditable;
    //
    protected $guarded = [];

    protected $casts = [
        'approved' => 'boolean',
    ];

    public function listPending($query)
    {
        return $query->where('approved', false);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
