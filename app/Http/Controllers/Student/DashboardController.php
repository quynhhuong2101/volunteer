<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // 1. Calculate Stats
        $checkins = \App\Models\Checkin::where('user_id', $user->id)->with('event')->get();
        
        $totalHours = $checkins->sum(function($checkin) {
            $start = \Carbon\Carbon::parse($checkin->event->start_time);
            $end = \Carbon\Carbon::parse($checkin->event->end_time);
            return $end->diffInHours($start);
        });

        $eventsJoined = $checkins->count();
        
        // Mock Target
        $targetHours = 60;
        $progress = min(($totalHours / $targetHours) * 100, 100);

        // 2. Upcoming Events (Registered & Future)
    $ongoingEvents = \App\Models\Event::whereHas('checkins', function($q) use ($user) {
        $q->where('user_id', $user->id);
    })->where('start_time', '<=', now())
      ->where('end_time', '>=', now())
      ->get();

    $upcomingEvents = \App\Models\Event::whereHas('checkins', function($q) use ($user) {
        $q->where('user_id', $user->id);
    })->where('start_time', '>', now())
      ->orderBy('start_time', 'asc')
      ->take(5)
      ->get();

        // 3. Suggested Events (Active, Future, Popular - Top 4)
    $suggestedEvents = \App\Models\Event::withCount('checkins')
        ->whereDoesntHave('checkins', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->where('status', 'approved')
        ->where('start_time', '>', now())
        ->orderByDesc('checkins_count')
        ->orderBy('start_time')
        ->take(4)
        ->get();

    // Fallback: If no strict matches, show ANY events the user hasn't joined (ignoring status/time for demo purposes)
    if ($suggestedEvents->isEmpty()) {
        $suggestedEvents = \App\Models\Event::whereDoesntHave('checkins', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->take(4)
        ->get();
    }

        // 4. Recent Activities (From Checkins)
        $recentActivities = $checkins->sortByDesc('created_at')->take(5)->map(function($checkin) {
            return [
                'type' => 'event',
                'content' => 'Bạn đã đăng ký tham gia sự kiện "' . $checkin->event->title . '"',
                'time' => $checkin->created_at->diffForHumans()
            ];
        });

        // 5. Monthly Activity (Last 6 Months)
        $monthlyActivity = collect(range(5, 0))->map(function($i) use ($checkins) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $count = $checkins->filter(function($checkin) use ($date) {
                return $checkin->created_at->format('Y-m') === $date->format('Y-m');
            })->count();
            
            return ['month' => $monthName, 'count' => $count];
        });

        // Mock Weekly Tasks
        $weeklyTasks = [
            ['task' => 'Cập nhật hồ sơ cá nhân', 'completed' => true],
            ['task' => 'Đăng ký 1 sự kiện mới', 'completed' => ($eventsJoined > 0)],
            ['task' => 'Tham gia khảo sát', 'completed' => false],
        ];

        // Category Pie Chart Data
        $categoryColors = ['#f59e0b', '#3b82f6', '#10b981', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#f43f5e'];
        $categoriesData = collect();
        if ($eventsJoined > 0) {
            $counts = $checkins->map(function($checkin) {
                return $checkin->event->category ?? 'Khác';
            })->countBy()->sortDesc();
            
            $colorIndex = 0;
            $currentPerc = 0;
            foreach ($counts as $name => $count) {
                $perc = ($count / $eventsJoined) * 100;
                $categoriesData->push([
                    'name' => $name,
                    'count' => $count,
                    'percentage' => round($perc, 1),
                    'color' => $categoryColors[$colorIndex % count($categoryColors)],
                    'start' => round($currentPerc, 2),
                    'end' => round($currentPerc + $perc, 2)
                ]);
                $currentPerc += $perc;
                $colorIndex++;
            }
        }

        $certificatesCount = \App\Models\Certificate::where('user_id', $user->id)->count();

    return view('student.dashboard', compact(
        'user', 
        'totalHours', 
        'targetHours', 
        'progress', 
        'eventsJoined', 
        'certificatesCount',
        'ongoingEvents',
        'upcomingEvents', 
        'suggestedEvents', 
        'recentActivities',
        'weeklyTasks',
        'monthlyActivity',
        'categoriesData'
    ));
    }
}
