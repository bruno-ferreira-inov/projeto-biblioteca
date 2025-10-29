<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;

Route::get('/', function () {
    return view('landing');
});

Route::get('/books/create', [BookController::class, 'create']);
Route::get('/books/{book}', [BookController::class, 'show']);
Route::get('/books/{book}/edit', [BookController::class, 'edit']);
Route::get('/books', [BookController::class, 'index']);

Route::delete('/books/{id}', [BookController::class, 'destroy']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
