<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = auth()->id();
        
        // Fetch stats
        $orgEvents = Event::where('organizer_id', $organizerId)->get();
        $orgEventsIds = $orgEvents->pluck('id');
        
        $totalReviews = Review::whereIn('event_id', $orgEventsIds)->count();
        $avgRating = Review::whereIn('event_id', $orgEventsIds)->avg('rating') ?? 0;
        
        // Fetch reviews with Filters
        $query = Review::whereIn('event_id', $orgEventsIds)
            ->with(['user', 'event']);

        if ($request->has('event_id') && $request->event_id != 'all') {
            $query->where('event_id', $request->event_id);
        }

        if ($request->has('rating') && $request->rating != 'all') {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('organization.reviews.index', compact('reviews', 'totalReviews', 'avgRating', 'orgEvents'));
    }
}
