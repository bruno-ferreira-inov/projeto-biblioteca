<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $guarded = [];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function author(string $name)
    {
        $author = Author::firstOrCreate(['name' => $name]);
        $this->authors()->attach($author);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
