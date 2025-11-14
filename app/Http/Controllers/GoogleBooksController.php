<?php

namespace App\Http\Controllers;

use App\Services\GoogleBooksImporter;
use Illuminate\Http\Request;
use App\Services\GoogleBooksService;

class GoogleBooksController extends Controller
{
    public function searchPage()
    {
        return view('books.search-import');
    }

    public function search(Request $request, GoogleBooksService $googleBooks)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json(['message' => 'Missing query paramenter'], 400);
        }

        $results = $googleBooks->search($query);

        return response()->json($results);
    }

    public function import(Request $request, GoogleBooksService $googleBooks, GoogleBooksImporter $bookImporter)
    {
        $volumeId = $request->input('volume_id');
        $quantity = $request->input('quantity') ?? 1;
        if (!$volumeId) {
            return response()->json(['message' => 'Missing volume_id'], 400);
        }

        $data = $googleBooks->getById($volumeId);
        if (!$data) {
            return response()->json(['message' => 'Book not Found'], 400);
        }

        $book = $bookImporter->importBookData($data, $quantity);

        return response()->json([
            'message' => 'Book imported successfully',
            'book' => $book->load(['authors', 'publisher'])
        ]);
    }
}
