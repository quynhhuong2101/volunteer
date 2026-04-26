<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();

        // 1. Detailed Statistics (Real Data)
        $activeEventsCount = \App\Models\Event::where('organizer_id', $organizerId)
            ->where('status', 'approved')
            ->where('end_time', '>', now())
            ->count();

        // Count unique volunteers across all my events
        $totalVolunteers = \App\Models\Checkin::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->distinct('user_id')->count();
        
        // Budget
        $budgetTotal = \App\Models\Budget::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->sum('total_approved');

        $budgetUsed = \App\Models\Budget::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->sum('total_spent');

        $completedEvents = \App\Models\Event::where('organizer_id', $organizerId)
            ->where('status', 'approved')
            ->where('end_time', '<', now())
            ->count();

        // 5. Task Statistics
        $totalTasks = \App\Models\Task::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->count();

        $completedTasks = \App\Models\Task::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'completed')->count();

        $taskProgress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // 6. Registration Trends (Last 6 Months)
        $registrationTrends = collect(range(5, 0))->map(function($i) use ($organizerId) {
            $month = now()->subMonths($i);
            $count = \App\Models\Registration::whereHas('event', function($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->whereYear('created_at', $month->year)
            ->whereMonth('created_at', $month->month)
            ->count();
            
            return [
                'label' => $month->format('M'),
                'count' => $count
            ];
        });

        $stats = [
            'active_events' => $activeEventsCount,
            'total_volunteers' => $totalVolunteers,
            'avg_rating' => 4.8, // Updated benchmark
            'rating_count' => 24, // Updated benchmark
            'budget_used' => $budgetUsed,
            'budget_total' => $budgetTotal,
            'completed_events' => $completedEvents,
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'task_progress' => $taskProgress,
            'trends' => $registrationTrends
        ];

        // 2. Mock Safety Alerts (SOS) - Keep existing logic (No SOS table yet)
        $sos_alerts = [
            /*
            [
                'id' => 1,
                'student_name' => 'Nguyễn Thị B',
                'event' => 'Mùa Hè Xanh 2024',
                'time' => '10:15 AM - Hôm nay',
                'location' => 'Khu A',
                'status' => 'pending'
            ]
            */ 
        ];

        // 3. Upcoming Events (Real Data)
        $upcoming_events = \App\Models\Event::where('organizer_id', $organizerId)
            ->where('end_time', '>', now())
            ->orderBy('start_time')
            ->take(5)
            ->get()
            ->map(function($event) {
                $registered = \App\Models\Checkin::where('event_id', $event->id)->count();
                $needed = $event->max_participants ?? 100; // Default if null
                
                // Calculate days left
                $daysLeft = now()->diffInDays($event->start_time, false);
                $daysLeft = $daysLeft < 0 ? 0 : (int)$daysLeft;

                return [
                    'id' => $event->id,
                    'name' => $event->title,
                    'date' => \Carbon\Carbon::parse($event->start_time)->format('d/m/Y'),
                    'time' => \Carbon\Carbon::parse($event->start_time)->format('H:i'),
                    'location' => $event->location,
                    'status' => $event->start_time <= now() && $event->end_time >= now() ? 'Đang diễn ra' : ($event->end_time < now() ? 'Đã kết thúc' : 'Sắp diễn ra'),
                    'volunteers_registered' => $registered,
                    'volunteers_needed' => $needed,
                    'days_left' => $daysLeft
                ];
            });

        // 4. Recent Activities Feed (Real Data from Checkins)
        $activities = \App\Models\Checkin::with(['user', 'event'])
            ->whereHas('event', function($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->map(function($checkin) {
                return [
                    'user' => $checkin->user->name,
                    'action' => 'đã đăng ký tham gia',
                    'target' => $checkin->event->title,
                    'time' => $checkin->created_at->diffForHumans(),
                    'avatar' => substr($checkin->user->name, 0, 1)
                ];
            });

        // Fetch active warnings
        $warnings = \App\Models\Warning::where('user_id', $organizerId)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('organization.dashboard', compact('stats', 'sos_alerts', 'upcoming_events', 'activities', 'warnings'));
    }

    public function markWarningRead($id)
    {
        $warning = \App\Models\Warning::where('user_id', auth()->id())->findOrFail($id);
        $warning->update(['is_read' => true]);
        return back()->with('success', 'Đã ẩn thông báo.');
    }
}
