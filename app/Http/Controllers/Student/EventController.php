<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        $scope = $request->input('scope');

        $events = Event::query();

        // Filter Logic
        if ($scope && $scope !== 'Tất cả') {
             if ($scope == 'Trong trường') {
                 $events->where('scope', 'trong_truong');
             } elseif ($scope == 'Ngoài trường') {
                 $events->where('scope', 'ngoai_truong');
             }
        }

        if ($category && $category !== 'Tất cả') {
            $events->where('category', $category);
        }

        if ($query) {
            $events->where('title', 'like', "%{$query}%");
        }
        
        // Show only active events
        $events->where('status', 'approved')
               ->where('is_published', true)
               ->where('end_time', '>', now());

        $events = $events->orderBy('start_time', 'asc')->paginate(9);

        return view('student.events.index', ['events' => $events]);
    }

    public function show($id)
    {
        $event = Event::with('schedules')->findOrFail($id);
        $registration = null;
        if(auth()->check()) {
            $registration = \App\Models\Checkin::where('user_id', auth()->id())
                                    ->where('event_id', $id)
                                    ->first();
        }

        $form = \Illuminate\Support\Facades\DB::table('forms')->where('event_id', $id)->whereIn('type', ['registration', 'recruitment'])->first();
        $fields = $form ? \Illuminate\Support\Facades\DB::table('form_questions')->where('form_id', $form->id)->orderBy('order')->get() : collect([]);
        $positions = \Illuminate\Support\Facades\DB::table('event_positions')->where('event_id', $id)->get();
        
        foreach($positions as $pos) {
            $registeredCount = \Illuminate\Support\Facades\DB::table('registrations')->where('event_position_id', $pos->id)->count();
            $pos->remaining = max(0, $pos->quantity - $registeredCount);
        }
        
        $participants = \App\Models\Checkin::with('user')->where('event_id', $id)->latest()->take(12)->get();

        return view('student.events.show', [
            'event' => $event, 
            'registration' => $registration,
            'form' => $form,
            'fields' => $fields,
            'positions' => $positions,
            'participants' => $participants
        ]);
    }

    public function schedule()
    {
        $userId = auth()->id();
        
        // Get events user has registered for
        $registeredEvents = Event::whereHas('checkins', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', '!=', 'cancelled')->with('schedules')->get();

        $calendarItems = collect();

        foreach ($registeredEvents as $event) {
            // Add the event itself as a block if it has no detailed schedule
            if ($event->schedules->isEmpty()) {
                $calendarItems->push([
                    'id' => $event->id,
                    'title' => $event->title,
                    'dateString' => $event->start_time->format('Y-m-d'),
                    'time' => $event->start_time->format('H:i'),
                    'endTime' => $event->end_time->format('H:i'),
                    'location' => $event->location,
                    'category' => $event->category,
                    'isFuture' => $event->start_time->isFuture(),
                    'dateFormatted' => $event->start_time->format('d/m/Y'),
                    'startHour' => (int)$event->start_time->format('H') + ((int)$event->start_time->format('i')/60),
                    'endHour' => (int)$event->end_time->format('H') + ((int)$event->end_time->format('i')/60),
                ]);
            } else {
                // Add each detailed schedule item
                foreach ($event->schedules as $item) {
                    $itemStartTime = \Carbon\Carbon::parse($item->start_time);
                    $itemEndTime = $item->end_time ? \Carbon\Carbon::parse($item->end_time) : $itemStartTime->copy()->addHour();
                    
                    $calendarItems->push([
                        'id' => $event->id,
                        'title' => '[' . $event->title . '] ' . $item->title,
                        'dateString' => $item->date instanceof \Carbon\Carbon ? $item->date->format('Y-m-d') : $item->date,
                        'time' => $itemStartTime->format('H:i'),
                        'endTime' => $itemEndTime->format('H:i'),
                        'location' => $event->location,
                        'category' => $event->category,
                        'isFuture' => \Carbon\Carbon::parse($item->date . ' ' . $item->start_time)->isFuture(),
                        'dateFormatted' => \Carbon\Carbon::parse($item->date)->format('d/m/Y'),
                        'startHour' => (int)$itemStartTime->format('H') + ((int)$itemStartTime->format('i')/60),
                        'endHour' => (int)$itemEndTime->format('H') + ((int)$itemEndTime->format('i')/60),
                    ]);
                }
            }
        }

        return view('student.activities.schedule', ['calendarItems' => $calendarItems]);
    }

    public function registered()
    {
        $userId = auth()->id();
        $events = Event::whereHas('checkins', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', '!=', 'cancelled')->with(['checkins' => function($q) use ($userId) {
            $q->where('user_id', $userId);
        }])->orderBy('start_time')->get();
        
        // Manually append 'user_status' for view compatibility if needed
        foreach($events as $event) {
            $event->user_status = 'Đã duyệt'; // Auto-approved
            $event->has_group = true; // Auto-enable chat
            $checkin = $event->checkins->first();
            $event->registered_at = $checkin ? $checkin->created_at : null;
        }

        // Split events into Ongoing and Ended
        $ongoingEvents = $events->filter(function ($event) {
            return \Carbon\Carbon::parse($event->end_time)->isFuture();
        })->values();

        $endedEvents = $events->filter(function ($event) {
            return \Carbon\Carbon::parse($event->end_time)->isPast();
        })->values();

        return view('student.events.registered', [
            'ongoingEvents' => $ongoingEvents, 
            'endedEvents' => $endedEvents,
            'events' => $events // Keep for total count stats if needed
        ]);
    }

    public function history()
    {
        $userId = auth()->id();
        
        // Fetch events the user has checked in to and are ended
        $events = Event::with('organizer')
            ->whereHas('checkins', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('status', '!=', 'cancelled')
            ->where('end_time', '<', now())
            ->orderBy('end_time', 'desc')
            ->get();

        // Calculate Total Hours (Duration of all events attended)
        $totalHours = $events->reduce(function ($carry, $event) {
            $duration = $event->end_time->diffInHours($event->start_time);
            return $carry + $duration;
        }, 0);

        // Calculate Average Rating from User's Reviews
        // Assuming there is a Review model linked to User
        $avgRating = \App\Models\Review::where('user_id', $userId)->avg('rating') ?? 0;
        $avgRating = number_format($avgRating, 1);

        return view('student.activities.history', [
            'events' => $events,
            'totalHours' => $totalHours,
            'avgRating' => $avgRating
        ]);
    }

    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        // Check if already registered (Check both tables for robustness)
        $alreadyRegistered = \App\Models\Registration::where('user_id', $user->id)->where('event_id', $event->id)->exists() 
            || \App\Models\Checkin::where('user_id', $user->id)->where('event_id', $event->id)->exists();

        if ($alreadyRegistered) {
            return back()->with('info', 'Bạn đã đăng ký sự kiện này rồi.');
        }

        if ($event->status === 'cancelled') {
            return back()->with('error', 'Sự kiện này đã bị hủy, không thể đăng ký.');
        }

        if ($event->is_registration_paused) {
            return back()->with('error', 'Sự kiện đang tạm dừng đăng ký. Vui lòng quay lại sau.');
        }

        // Time Check
        if (now()->gt($event->end_time)) {
            return back()->with('error', 'Sự kiện đã kết thúc, không thể đăng ký.');
        }

        // Check slots
        $currentCount = \App\Models\Checkin::where('event_id', $event->id)->count();
        if ($event->max_participants && $currentCount >= $event->max_participants) {
            return back()->with('error', 'Sự kiện đã đủ số lượng tình nguyện viên.');
        }
        
        $positionId = $request->input('position_id');
        $customAnswers = json_encode($request->input('custom_answers', []));

        // Create the real Registration record to hold form answers
        \Illuminate\Support\Facades\DB::table('registrations')->insert([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => 'approved', // Auto-approved as per user request
            'custom_answers' => json_encode(['position_id' => $positionId, 'answers' => json_decode($customAnswers, true)]),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Auto-Approve / Register (Legacy support using Checkin)
        \App\Models\Checkin::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'checkin_time' => now(), // Set to current time to avoid NOT NULL violation
            'is_verified' => false
        ]);
        
        // Decrement position quantity if we want to track it
        if($positionId) {
             \Illuminate\Support\Facades\DB::table('event_positions')->where('id', $positionId)->decrement('quantity');
        }
        
        return back()->with('success', 'Đăng ký thành công! Hệ thống đã ghi nhận thông tin của bạn.');
    }
    public function cancel($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        // Find registration
        $checkin = \App\Models\Checkin::where('user_id', $user->id)
                                    ->where('event_id', $event->id)
                                    ->first();

        if (!$checkin) {
            return back()->with('error', 'Bạn chưa đăng ký sự kiện này.');
        }

        // Check time window (3 hours)
        $registrationTime = \Carbon\Carbon::parse($checkin->created_at);
        if (now()->gt($event->start_time)) {
             return back()->with('error', 'Sự kiện đã bắt đầu, không thể hủy đăng ký.');
        }
        
        if (now()->diffInHours($registrationTime) > 3) {
            return back()->with('error', 'Đã quá thời gian được phép hủy đăng ký (3 giờ).');
        }

        $checkin->delete();
        \App\Models\Registration::where('user_id', $user->id)->where('event_id', $event->id)->delete();

        return back()->with('success', 'Đã hủy đăng ký thành công.');
    }
    public function myEventDetail($id)
    {
        $event = Event::findOrFail($id);
        $user = auth()->user();

        // Ensure user is registered
        $checkin = \App\Models\Checkin::where('user_id', $user->id)
                                    ->where('event_id', $event->id)
                                    ->firstOrFail();

        // Find position from registration
        $registration = \App\Models\Registration::where('user_id', $user->id)
                            ->where('event_id', $event->id)
                            ->first();
        
        $positionId = ($registration && isset($registration->custom_answers['position_id'])) 
                      ? $registration->custom_answers['position_id'] 
                      : null;

        // Fetch tasks and include completion status
        $tasks = \App\Models\Task::where('event_id', $id)
                    ->where(function($query) use ($user, $positionId) {
                        $query->where('user_id', $user->id)
                              ->orWhere('position_id', $positionId)
                              ->orWhere(function($q) {
                                  $q->whereNull('user_id')->whereNull('position_id');
                              });
                    })
                    ->with(['completions' => function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    }])
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function($task) {
                        $done = $task->completions->first();
                        $task->status = $done ? $done->status : 'pending';
                        return $task;
                    });
                    
        return view('student.events.my_event_detail', compact('event', 'tasks', 'checkin'));
    }
}
