<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use Illuminate\Validation\Rules\File;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all()->sortBy('name');
        //dd($a);
        return view(
            'authors.index',
            ['authors' => $authors]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $request->validate([
            'name' => ['required'],
            'photo' => ['required', File::types(['png,', 'jpg', 'webp'])],
        ]);

        $photoPath = $request->photo->store('AuthorPhotos');

        Author::create([
            'name' => request('name'),
            'photo' => $photoPath
        ]);

        $authors = Author::all()->sortBy('name');
        //dd($a);
        return view(
            'authors.index',
            ['authors' => $authors]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return view('authors.show', ['author' => $author]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $author = Author::find($id);
        return view('authors.edit', ['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, $id)
    {
        $author = Author::find($id);
        request()->validate([
            'name' => ['required'],
        ]);
        // dump($author);
        if (request('photo')) {
            $photoPath = $request->photo->store('AuthorPhotos');

            $author->update([
                'name' => request('name'),
                'photo' => $photoPath,
            ]);
        } else {
            $author->update([
                'name' => request('name'),
            ]);
        }

        $authors = Author::all()->sortBy('name');
        return view(
            'authors.index',
            ['authors' => $authors]
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Author::findOrFail($id)->delete();

        return redirect('/authors');
    }
}
