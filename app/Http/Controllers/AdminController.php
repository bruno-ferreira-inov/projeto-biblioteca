<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use App\Models\BookReview;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'picture' => ['required', File::types(['png', 'jpg', 'webp'])],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => 'password',
            'role' => 'Admin',
        ]);
        return redirect()->route('books.index');
    }

    public function requests(Request $request)
    {
        $now = Carbon::now();

        $search = $request->input('search');

        $query = BookRequest::with(['book', 'user'])
            ->when($search, fn($q) => $q->where('id', $search));

        $ongoingRequests = (clone $query)
            ->where('completed', false)
            ->orderByDesc('requestEndDate')
            ->get();

        $completedRequests = (clone $query)
            ->where('completed', true)
            ->orderByDesc('returnedDate')
            ->get();

        $recentCount = BookRequest::where('created_at', '>=', $now->copy()->subDays(30))->count();

        $fulfilledToday = BookRequest::where('completed', true)
            ->whereDate('returnedDate', $now->toDateString())
            ->count();

        return view('admin.requests', compact(
            'ongoingRequests',
            'completedRequests',
            'recentCount',
            'fulfilledToday',
            'search'
        ));

    }

    public function reviewIndex(Request $request)
    {
        $reviews = BookReview::with(['user', 'book'])
            ->where(function ($query) {
                $query->where('approved', false)
                    ->orWhereNull('approved');
            })
            ->latest()
            ->paginate(20);

        return view('admin.reviews-index', compact('reviews'));
    }


    public function approveReview(BookReview $review)
    {
        $review->approved = true;
        $review->save();

        return redirect()->route('reviews.index')->with('success', 'Review Approved');
    }

    public function rejectReview(BookReview $review)
    {
        $review->approved = false;
        $review->save();

        return redirect()->route('reviews.index')->with('success', 'Review Rejected');
    }
    public function show()
    {
    }

    public function destroy()
    {

    }
}
