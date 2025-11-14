<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GoogleBooksImporter
{
    public function importBookData($googleData, $quantity)
    {
        return DB::transaction(function () use ($googleData, $quantity) {
            $volume = $googleData['volumeInfo'] ?? [];

            $publisher = null;
            if (!empty($volume['publisher'])) {
                $publisher = Publisher::firstOrCreate(['name' => $volume['publisher']]);
            }

            $isbn13 = null;
            $isbn10 = null;

            if (!empty($volume['industryIdentifiers'])) {
                foreach ($volume['industryIdentifiers'] as $identifier) {
                    if ($identifier['type'] === 'ISBN_13') {
                        $isbn13 = $identifier['identifier'];
                    } elseif ($identifier['type'] === 'ISBN_10') {
                        $isbn10 = $identifier['identifier'];
                    }
                }
            }

            $price = null;

            $saleInfo = $googleData['saleInfo'] ?? [];

            if (!empty($saleInfo['listPrice']['amount'])) {
                $price = $saleInfo['listPrice']['amount'];
            } elseif (!empty($saleInfo['retailPrice']['amount'])) {
                $price = $saleInfo['retailPrice']['amount'];
            }

            if (!empty($isbn13)) {
                $thumbnailPath = $this->storeBookCover($this->getBookCover($volume), $isbn13);
            } else {
                $thumbnailPath = $this->storeBookCover($this->getBookCover($volume), $isbn10);
            }

            $book = Book::updateOrCreate(
                [
                    'google_books_id' => $googleData['id']
                ],
                [
                    'title' => $volume['title'] ?? null,
                    'bibliography' => $volume['description'] ?? "placeholder information, couldn't load description",
                    //,
                    'isbn' => $isbn13 ?? $isbn10,
                    'cover' => $thumbnailPath,
                    'total_quantity' => $quantity,
                    'price' => $price,
                    'current_quantity' => $quantity,
                    'publisher_id' => $publisher?->id,
                ]
            );

            if (!empty([$volume['authors']])) {
                $authorsIds = collect($volume['authors'])
                    ->map(fn($name) => Author::firstOrCreate(['name' => $name])->id)
                    ->toArray();

                $book->authors()->syncWithoutDetaching($authorsIds);
            }

            return $book;
        });
    }

    public function getBookCover(array $BookInformation)
    {
        $thumbnailPath = 'bookcovers/default.jpg';
        $imageLinks = Arr::get($BookInformation, 'imageLinks');
        if (!is_array($imageLinks) || empty($imageLinks)) {
            return null;
        }

        foreach (['extraLarge', 'large', 'medium', 'small', 'thumbnail', 'smallThumbnail'] as $size) {
            if (!empty($imageLinks[$size]))
                return (string) $imageLinks[$size];
        }
        return null;
    }

    public function storeBookCover(string $imageLink, $isbn)
    {
        try {
            $response = Http::timeout(10)
                ->retry(2, 200)
                ->get($imageLink);

            if (!$response->ok()) {
                return null;
            }

            $fileType = str_contains((string) $response->header('Content-Type'), 'png') ? 'png' : 'jpg';
            $fileName = 'bookcovers/' . $isbn . '.' . $fileType;
            Storage::disk('public')->put($fileName, $response->body());

            return $fileName;
        } catch (Throwable $exc) {
            return null;
        }
    }
}
