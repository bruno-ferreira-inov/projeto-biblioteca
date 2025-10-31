<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use Illuminate\Validation\Rules\File;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::all()->sortBy('name');
        return view(
            'publishers.index',
            ['publishers' => $publishers]
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
    public function store(StorePublisherRequest $request)
    {
        $request->validate([
            'name' => ['required'],
            'logo' => ['required', File::types(['png', 'jpg', 'webp'])],
        ]);

        $logoPath = $request->logo->store('PublisherLogos');

        Publisher::create([
            'name' => request('name'),
            'logo' => $logoPath
        ]);

        $publishers = Publisher::all()->sortBy('name');
        return view(
            'publishers.index',
            ['publishers' => $publishers]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Publisher $publisher)
    {
        return view('publishers.show', ['publisher' => $publisher]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $publisher = Publisher::find($id);
        return view('publishers.edit', ['publisher' => $publisher]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublisherRequest $request, $id)
    {
        $publisher = Publisher::find($id);
        request()->validate([
            'name' => ['required'],
        ]);
        // dump($author);
        if (request('logo')) {
            $logoPath = $request->logo->store('PublisherLogos');

            $publisher->update([
                'name' => request('name'),
                'logo' => $logoPath,
            ]);
        } else {
            $publisher->update([
                'name' => request('name'),
            ]);
        }

        $publishers = Publisher::all()->sortBy('name');
        return view(
            'publishers.index',
            ['publishers' => $publishers]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Publisher::findOrFail($id)->delete();

        return redirect('/publishers');
    }
}
