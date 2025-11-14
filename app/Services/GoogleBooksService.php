<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleBooksService
{
    protected string $endpoint;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.google_books.endpoint');
        $this->apiKey = config('services.google_books.key');
    }

    public function search(string $query, int $maxResults = 10)
    {
        $response = Http::get($this->endpoint, [
            'q' => $query,
            'maxResults' => $maxResults,
            'key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            return [];
        }

        return $response->json('items', []);
    }

    public function getById(string $volumeId)
    {
        $response = Http::get(
            "{$this->endpoint}/{$volumeId}",
            ['key' => $this->apiKey,]
        );

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

}
