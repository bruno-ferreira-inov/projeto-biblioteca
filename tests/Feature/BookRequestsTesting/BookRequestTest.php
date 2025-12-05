<?php

use App\Jobs\SendBookAvailabilityNotifications;
use App\Mail\BookRequestMade;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\actingAs;

//php artisan test tests/Feature/BookRequestsTesting

it('creates user and book and allows user to request book', function () {
    Mail::fake();
    $user = User::factory()->create([
        'availableRequests' => 5,
    ]);
    $book = Book::factory()->create([
        'total_quantity' => 10,
        'current_quantity' => 10,
    ]);

    $response = $this->actingAs($user)
        ->post(route('book.request.store', ['id' => $book->id]), [
            'bookId' => $book->id
        ]);

    $this->assertDatabaseHas('book_requests', [
        'user_id' => $user->id,
        'book_id' => $book->id
    ]);

    $book->refresh();
    $user->refresh();

    $this->assertEquals(9, $book->current_quantity);
    $this->assertEquals(4, $user->availableRequests);

    Mail::assertSent(BookRequestMade::class);

    $response->assertStatus(200);

});

it("does not create a request on a book that is not valid", function () {
    Mail::fake();
    $user = User::factory()->create([
        'availableRequests' => 3,
    ]);

    $invalidBookId = 239478;

    $reponse = $this->actingAs($user)
        ->post(route('book.request.store', ['id' => $invalidBookId]), [
            'bookId' => $invalidBookId
        ]);

    $reponse->assertStatus(404);

    $this->assertDatabaseCount('book_requests', 0);

    Mail::assertNothingSent();
});

it('can successfully return the book', function () {
    Queue::fake();

    $user = User::factory()->create([
        'availableRequests' => 2,
    ]);

    $book = Book::factory()->create([
        'current_quantity' => 0,
    ]);

    $bookRequest = BookRequest::factory()->create([
        'user_id' => $user->id,
        'book_id' => $book->id,
        'completed' => false,
        'returnedDate' => null,
    ]);

    $response = $this->actingAs($user)
        ->post(route('completeRequest', $bookRequest->id));


    $book->refresh();
    $user->refresh();
    $bookRequest->refresh();

    expect($bookRequest->completed)->toEqual(true);
    expect($bookRequest->returnedDate)->not->toBeNull();

    expect($book->current_quantity)->toBe(1);
    expect($user->availableRequests)->toBe(3);

    Queue::assertPushed(SendBookAvailabilityNotifications::class);

    $response->assertRedirect('/admin/requests');
});

it('shows only the users requests', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $book1 = Book::factory()->create();
    $book2 = Book::factory()->create();
    $book3 = Book::factory()->create();

    $requestA1 = BookRequest::factory()->create([
        'user_id' => $userA->id,
        'book_id' => $book1->id,
    ]);
    $requestA2 = BookRequest::factory()->create([
        'user_id' => $userA->id,
        'book_id' => $book2->id,
    ]);
    $requestB1 = BookRequest::factory()->create([
        'user_id' => $userB->id,
        'book_id' => $book3->id,
    ]);

    $response = $this->actingAs($userA)
        ->get(route('user-requests'));

    $response->assertStatus(200);

    $response->assertSee($requestA1->book->title);
    $response->assertSee($requestA2->book->title);

    $response->assertDontSee($requestB1->book->title);
});

it('cannot create a request if a book does not have stock', function () {
    Mail::fake();

    $user = User::factory()->create();

    $book = Book::factory()->create([
        'total_quantity' => 2,
        'current_quantity' => 0,
    ]);

    $response = $this->actingAs($user)
        ->post(route('book.request.store', ['id' => $book->id]), [
            'bookId' => $book->id
        ]);

    $response->assertStatus(302);

    $this->assertDatabaseMissing('book_requests', [
        'book_id' => $book->id,
        'user_id' => $user->id,
    ]);

    Mail::assertNothingSent();
});
