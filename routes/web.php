<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Mail\BookRequestMade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;

Route::get('/', [BookController::class, 'index'])->name('books.index');

Route::get('/test', function () {


    return 'Done';
});

//# -- Books --
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/books/create', [BookController::class, 'create'])
    ->can('admin-access');

Route::get('/books/export/', [BookController::class, 'export'])
    ->can('admin-access');

Route::get('/books/{id}/request', [BookController::class, 'request']);
Route::post('/books/{id}/request', [BookController::class, 'storeRequest']);
Route::get('/books/requests/{req}', [BookController::class, 'showRequest'])->name('showBookRequest');

Route::post('/books/requests/{bookRequest}', [BookController::class, 'completeRequest'])->name('completeRequest');

Route::get('/books/{book}', [BookController::class, 'show']);
Route::get('/books/{book}/edit', [BookController::class, 'edit'])
    ->can('admin-access');

Route::patch('/books/{id}', [BookController::class, 'update'])
    ->can('admin-access');

Route::delete('/books/{id}', [BookController::class, 'destroy'])
    ->can('admin-access');

//# -- Admin --
Route::get('/admin', [AdminController::class, 'index'])
    ->can('admin-access');
Route::get('/admin/create', [AdminController::class, 'create'])
    ->can('admin-access');
Route::post('/admin', [AdminController::class, 'store'])
    ->can('admin-access');
Route::get('/admin/requests', [AdminController::class, 'requests'])
    ->can('admin-access');
Route::get('/admin/{admin}', [AdminController::class, 'show'])
    ->can('admin-access');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])
    ->can('admin-access');

//# -- Authors --
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/create', [AuthorController::class, 'create'])
    ->can('admin-access');

Route::post('/authors', [AuthorController::class, 'store'])
    ->middleware('auth')
    ->can('admin-access');

Route::get('/authors/{author}', [AuthorController::class, 'show']);
Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])
    ->can('admin-access');

Route::patch('/authors/{id}', [AuthorController::class, 'update'])
    ->can('admin-access');

Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])
    ->can('admin-access');

//# -- Publishers --
Route::get('/publishers', [PublisherController::class, 'index']);
Route::get('/publishers/create', [PublisherController::class, 'create'])
    ->can('admin-access');

Route::post('publishers', [PublisherController::class, 'store'])
    ->middleware('auth')
    ->can('admin-access');

Route::get('/publishers/{publisher}', [PublisherController::class, 'show']);
Route::get('/publishers/{publisher}/edit', [PublisherController::class, 'edit'])
    ->can('admin-access');

Route::patch('/publishers/{id}', [PublisherController::class, 'update'])
    ->can('admin-access');

Route::delete('/publishers/{id}', [PublisherController::class, 'destroy'])
    ->can('admin-access');

Route::get('/user/requests')
    ->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
