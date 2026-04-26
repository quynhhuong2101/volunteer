<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Key Performance Indicators (KPIs)
        $totalStudents = \App\Models\User::where('role', 'student')->count();
        $totalOrganizers = \App\Models\User::where('role', 'organizer')->count();
        $pendingEvents = \App\Models\Event::where('status', 'pending')->count();
        $activeEvents = \App\Models\Event::where('status', 'approved')->count();
        $totalHours = \App\Models\Checkin::count() * 4; 
        $budgetUsed = \App\Models\Budget::sum('total_spent');

        $stats = [
            'total_students' => [
                'value' => $totalStudents,
                'growth' => 12.5,
                'label' => 'Tổng sinh viên',
                'icon' => 'users',
                'color' => 'blue'
            ],
            'total_organizers' => [
                'value' => $totalOrganizers,
                'growth' => 5.2,
                'label' => 'Tổ chức hoạt động',
                'icon' => 'office-building',
                'color' => 'indigo'
            ],
            'active_events' => [
                'value' => $activeEvents,
                'growth' => 8.2, 
                'label' => 'Sự kiện đang chạy',
                'icon' => 'calendar',
                'color' => 'emerald'
            ],
            'pending_actions' => [
                'value' => $pendingEvents,
                'growth' => -2.4,
                'label' => 'Đang chờ duyệt',
                'icon' => 'clock',
                'color' => 'orange'
            ]
        ];

        // 2. Chart Data (Real Data: Last 30 Days)
        $days = 30;
        $dates = collect(range($days - 1, 0))->map(fn($d) => now()->subDays($d));
        
        $chartData = [
            'labels' => $dates->map(fn($d) => $d->format('d/m'))->toArray(),
            'participation' => $dates->map(function($date) {
                return \App\Models\Checkin::whereDate('created_at', $date)->count();
            })->toArray(),
            'tasks_completed' => $dates->map(function($date) {
                return \App\Models\Task::where('status', 'completed')
                    ->whereDate('updated_at', $date)
                    ->count();
            })->toArray(),
        ];

        // 3. Recent Activities
        $recentActivities = \App\Models\Checkin::with(['user', 'event'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function($checkin) {
                return [
                    'user' => $checkin->user->name,
                    'action' => 'đã điểm danh tại',
                    'target' => $checkin->event->title,
                    'time' => $checkin->created_at->diffForHumans(),
                    'icon' => 'check-circle',
                    'color' => 'emerald'
                ];
            });

        // 4. Pending Tasks (Actionable Items)
        $pendingTasks = collect();

        // Pending Events
        $pendingEventsList = \App\Models\Event::where('status', 'pending')->latest()->take(5)->get();
        foreach($pendingEventsList as $ev) {
            $pendingTasks->push([
                'title' => 'Phê duyệt sự kiện: ' . $ev->title,
                'department' => 'Sự kiện',
                'deadline' => $ev->created_at->diffForHumans(),
                'urgent' => true,
                'link' => route('admin.events.index', ['status' => 'pending'])
            ]);
        }

        // Pending Budgets
        $pendingBudgets = \App\Models\Budget::where('status', 'pending')->with('event')->take(3)->get();
        foreach($pendingBudgets as $bg) {
            $pendingTasks->push([
                'title' => 'Duyệt ngân sách: ' . ($bg->event->title ?? 'Sự kiện'),
                'department' => 'Tài chính',
                'deadline' => $bg->updated_at->diffForHumans(),
                'urgent' => true,
                'link' => route('admin.budgets.index')
            ]);
        }
        
        $pendingTasks = $pendingTasks->sortByDesc('urgent')->take(6);

        // 5. Top Organizations
        $topOrganizers = \App\Models\User::where('role', 'organizer')
            ->withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'chartData', 'recentActivities', 'pendingTasks', 'topOrganizers'));
    }
}
