<?php

namespace App\Livewire;

use App\Models\BookReview;
use Livewire\Component;

class ExamineReview extends Component
{

    public $review;
    public $reason;

    public function render()
    {
        return view('livewire.examine-review', [
            'reviews' => BookReview::with(['user', 'book'])
                ->where('approved', false)
                ->latest()
                ->paginate(20)
        ]);
    }

    public function mount($review)
    {
        $this->review = $review;

        if ($this->review->rejection_reason)
            $this->reason = $this->review->rejection_reason;
    }

    public function openReview()
    {
        $this->fullReview = $this->review->review_body;

        $this->dispatch('reviewModal');
    }

    public function rejectReview()
    {
        $this->review->approved = false;
        $this->review->rejection_reason = $this->reason;
        $this->review->save();

        return redirect()->route('reviews.index')->with('success', 'Review Rejected');
    }

    public function approveReview()
    {
        $this->review->approved = true;
        $this->review->save();

        return redirect()->route('reviews.index')->with('success', 'Review Approved');
    }
}
