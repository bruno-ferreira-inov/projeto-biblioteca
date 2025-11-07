<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
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
        redirect('/books');
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

    public function show()
    {

    }

    public function destroy()
    {

    }
}
