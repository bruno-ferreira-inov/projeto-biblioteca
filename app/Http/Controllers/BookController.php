<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Validation\Rules\File;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('authors');

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('isbn', 'like', "%{$search}%")
                ->orWhereHas('authors', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $sortField = $request->input('sort', 'title');
        $sortDirection = $request->input('direction', 'asc');

        $books = $query
            ->orderByRaw("LOWER($sortField) $sortDirection")
            ->paginate(9);

        return view('books.index', compact('books', 'sortField', 'sortDirection', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    public function export()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $authors = [];
        foreach ($request->all() as $param => $text) {
            if (str_contains($param, "author")) {
                array_push($authors, $text);
            }
        }

        foreach ($authors as $pos => $value) {
            $author = Author::find($value);
            //$book->author($author->name);
        }
        dd($authors);

        $attributes = $request->validate([
            'title' => ['required'],
            'isbn' => ['required'],
            'bibliography' => ['required'],
            'publisher' => ['nullable'],
            'price' => ['required'],
            'cover' => ['nullable', File::types(['png', 'jpg', 'webp'])],
            'authors' => ['nullable']
        ]);

        $coverPath = $request->cover->store('BookCovers');

        $book = Book::create([
            'title' => request('title'),
            'isbn' => request('isbn'),
            'bibliography' => request('bibliography'),
            'price' => request('price'),
            'cover' => $coverPath,
        ]);

        if ($attributes['publisher'] ?? false) {
            $book->setPublisher($attributes['publisher']);
        }

        if ($attributes['authors'] ?? false) {
            foreach (explode(',', $attributes['authors']) as $authors) {
                $book->author($authors);
            }
        }

        return redirect()->route('books.index', [
            'sort' => 'title',
            'direction' => 'asc'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {

        //dd($book);
        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $book = Book::with('authors')->find($id);

        return view('books.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::find($id);

        request()->validate([
            'title' => ['required'],
            'isbn' => ['required'],
            'price' => ['required'],
            'bibliography' => ['required'],
            'publisher_id' => ['required'],
            'authors' => ['nullable']
        ]);

        if (request('cover')) {
            $coverPath = $request->cover->store('bookcovers');

            $book->update([
                'title' => $request->title,
                'isbn' => $request->isbn,
                'price' => $request->price,
                'publisher_id' => $request->publisher_id,
                'bibliography' => $request->bibliography,
                'cover' => $coverPath,
            ]);
        } else {
            $book->update([
                'title' => $request->title,
                'isbn' => $request->isbn,
                'price' => $request->price,
                'publisher_id' => $request->publisher_id,
                'bibliography' => $request->bibliography,
            ]);
        }
        // dd($book->authors);
        $book->authors()->sync($request->authors ?? []);

        return view('books.show', ['book' => $book]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Book::findOrFail($id)->delete();

        return redirect('/books');
    }
}
