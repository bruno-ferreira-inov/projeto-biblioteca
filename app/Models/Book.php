<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    use Auditable;

    protected $guarded = [];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function setPublisher(string $name)
    {
        $publisher = Publisher::first(['name' => $name]);
        $this->publisher_id = $publisher->id;
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

    public function bookRequests()
    {
        return $this->hasMany(BookRequest::class);
    }

    public function notificationUsers()
    {
        return $this->belongsToMany(User::class, 'book_user_notifications')
            ->withPivot('notified')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    public function recommendedBooks($limit = 5)
    {
        $book = $this;

        // Split title safely into words
        $titleParts = collect(explode(' ', $book->title))
            ->filter() // remove empty parts
            ->values(); // reindex

        // Prepare our scoring segments
        $orderSegments = [];
        $bindings = [];

        // 1. Score full title match highest
        $orderSegments[] = "(CASE WHEN title LIKE ? THEN 5 ELSE 0 END)";
        $bindings[] = '%' . $book->title . '%';

        // 2. Score each title word, decreasing weight
        $weight = 4;
        foreach ($titleParts as $part) {
            $orderSegments[] = "(CASE WHEN title LIKE ? THEN {$weight} ELSE 0 END)";
            $bindings[] = '%' . $part . '%';
            $weight--;
            if ($weight <= 1)
                break;
        }

        // 3. Score summary similarity (keywords from summary)
        $summaryParts = collect(explode(' ', $book->bibliography))
            ->filter(fn($w) => strlen($w) > 4)
            ->take(4);

        foreach ($summaryParts as $part) {
            $orderSegments[] = "(CASE WHEN bibliography LIKE ? THEN 1 ELSE 0 END)";
            $bindings[] = '%' . $part . '%';
        }

        return Book::query()
            ->where('id', '!=', $book->id)
            ->orderByRaw(implode(' + ', $orderSegments) . ' DESC', $bindings)
            ->limit($limit)
            ->get();
    }
}
