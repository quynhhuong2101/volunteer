<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Get IDs of events already reviewed
        $reviewedEventIds = \App\Models\Review::where('user_id', $userId)->pluck('event_id')->toArray();

        // 2. Pending Reviews:
        // - User registered (Registration or Checkin)
        // - Event ended
        // - Not in reviewedEventIds
        $pendingReviews = \App\Models\Event::whereHas('registrations', function($q) use ($userId) {
                $q->where('user_id', $userId)->whereIn('status', ['confirmed', 'completed']);
            })
            ->whereNotIn('id', $reviewedEventIds)
            // ->where('end_time', '<', now()) // Temporarily disabled for debugging
            ->orderBy('end_time', 'desc')
            ->get();

        // 3. Reviewed History
        $reviewedEvents = \App\Models\Review::where('user_id', $userId)
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.reviews.index', compact('pendingReviews', 'reviewedEvents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        \App\Models\Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'event_id' => $request->event_id
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment
            ]
        );

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được ghi nhận!');
    }
}
