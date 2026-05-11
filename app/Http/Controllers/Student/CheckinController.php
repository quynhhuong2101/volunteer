<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Fetch all registrations for this user to get their positions in various events
        $registrations = \App\Models\Registration::where('user_id', $user->id)->get()->keyBy('event_id');
        $eventIds = $registrations->keys();

        // Fetch tasks
        $tasks = \App\Models\Task::whereIn('event_id', $eventIds)
            ->whereHas('event', function ($q) {
                $q->where('status', '!=', 'cancelled');
            })
            ->where(function($query) use ($user, $registrations) {
                $query->where('user_id', $user->id)
                      ->orWhere(function($q) use ($registrations) {
                          // This is slightly tricky in a single query if positionIds vary per event
                          // We'll fetch them all and filter in PHP or use a raw/complex query
                          // For simplicity, we'll fetch all tasks for these events and filter
                      })
                      ->orWhere(function($q) {
                          $q->whereNull('user_id')->whereNull('position_id');
                      });
            })
            ->with(['event', 'completions' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->orderBy('deadline', 'asc')
            ->get()
            ->filter(function($task) use ($user, $registrations) {
                // Individual task
                if ($task->user_id == $user->id) return true;
                
                // All task
                if (is_null($task->user_id) && is_null($task->position_id)) return true;
                
                // Group task
                $reg = $registrations->get($task->event_id);
                if ($reg && isset($reg->custom_answers['position_id']) && $reg->custom_answers['position_id'] == $task->position_id) {
                    return true;
                }
                
                return false;
            })
            ->map(function($task) use ($user) {
                $done = $task->completions->first();
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'event' => $task->event->title,
                    'deadline' => $task->deadline,
                    'status' => $done ? $done->status : 'pending',
                    'priority' => $task->priority
                ];
            });

        // Real Checkin History
        $history = \App\Models\Checkin::with('event')
            ->where('user_id', $user->id)
            ->whereNotNull('checkin_time')
            ->whereHas('event', function($q) {
                $q->where('status', '!=', 'cancelled');
            })
            ->orderBy('checkin_time', 'desc')
            ->get()
            ->map(function($checkin) {
                return [
                    'id' => $checkin->id,
                    'event' => $checkin->event ? $checkin->event->title : 'Sự kiện không xác định',
                    'location' => $checkin->event ? $checkin->event->location : 'Không xác định',
                    'timestamp' => \Carbon\Carbon::parse($checkin->checkin_time),
                    'status' => $checkin->is_verified ? 'success' : 'pending',
                    'points' => 0
                ];
            });

        return view('student.checkin.index', compact('tasks', 'history'));
    }

    public function store(Request $request)
    {
        // $request->token is the decoded QR text
        // Format: "EVENT-{id}-{secure_random}"
        // For demo, we just parse EVENT-{id}
        
        $token = $request->input('token');
        
        if (!$token || !str_starts_with($token, 'EVENT-')) {
            return response()->json(['message' => 'Mã QR không hợp lệ!'], 400);
        }
        
        // Extract Event ID
        $parts = explode('-', $token);
        $eventId = isset($parts[1]) ? $parts[1] : null;

        if (!$eventId) {
            return response()->json(['message' => 'Không tìm thấy sự kiện!'], 404);
        }

        $userId = auth()->id();
        
        // Find Checkin Record
        $checkin = \App\Models\Checkin::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->first();

        if (!$checkin) {
             return response()->json(['message' => 'Bạn chưa đăng ký sự kiện này!'], 403);
        }
        
        if ($checkin->is_verified) {
             return response()->json(['message' => 'Bạn đã điểm danh rồi!']);
        }

        $checkin->update([
            'is_verified' => true,
            'checkin_time' => now(),
             // 'location_data' => $request->location // If we implemented location
        ]);

        return response()->json(['message' => 'Điểm danh thành công!']);
    }
}
