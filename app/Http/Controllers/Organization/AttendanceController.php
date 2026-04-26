<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // List Active Events for Attendance
    public function index()
    {
        $organizerId = auth()->id();
        $events = \App\Models\Event::where('organizer_id', $organizerId)
            ->whereIn('status', ['approved']) // Show approved events
            ->orderBy('start_time', 'desc')
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->title,
                    'date' => \Carbon\Carbon::parse($event->start_time)->format('d/m/Y'),
                    'location' => $event->location,
                    'registered' => \App\Models\Checkin::where('event_id', $event->id)->count(),
                    'status' => \Carbon\Carbon::parse($event->end_time)->isFuture() ? 'Đang diễn ra' : 'Đã kết thúc'
                ];
            });

        return view('organization.attendance.index', compact('events'));
    }

    // Show Attendance Dashboard (QR + Manual List + Tasks)
    public function show($id)
    {
        $event = \App\Models\Event::with(['tasks.user', 'tasks.position', 'positions'])->findOrFail($id);
        
        $total_attendees = \App\Models\Checkin::where('event_id', $id)->count();
        $checked_in_count = \App\Models\Checkin::where('event_id', $id)->where('is_verified', true)->count();
        $percentage = $total_attendees > 0 ? ($checked_in_count / $total_attendees) * 100 : 0;
        
        $students = \App\Models\Checkin::where('event_id', $id)
            ->with('user')
            ->get()
            ->map(function($checkin) {
                return [
                    'id' => $checkin->user->id,
                    'checkin_id' => $checkin->id,
                    'user_id' => $checkin->user->id, // For task assignment
                    'name' => $checkin->user->name,
                    'role' => 'Thành viên',
                    'status' => $checkin->is_verified ? 'checked_in' : 'pending',
                    'time' => $checkin->is_verified ? \Carbon\Carbon::parse($checkin->checkin_time)->format('H:i:s') : null
                ];
            });

        // Get Event Tasks
        $tasks = $event->tasks()->with(['user', 'position'])->orderBy('created_at', 'desc')->get();

        $positions = $event->positions;

        return view('organization.attendance.show', compact('total_attendees', 'checked_in_count', 'percentage', 'students', 'event', 'tasks', 'positions'));
    }

    // Handle Manual Check-in
    public function store(Request $request, $id)
    {
        $checkinId = $request->input('checkin_id');
        if ($checkinId) {
            $checkin = \App\Models\Checkin::findOrFail($checkinId);
            $checkin->update([
                'is_verified' => true,
                'checkin_time' => now()
            ]);
        }
        
        return back()->with('success', 'Đã cập nhật trạng thái điểm danh thành công!');
    }

    // Create a new Task
    public function storeTask(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'position_id' => 'nullable|exists:event_positions,id',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date'
        ]);

        $task = \App\Models\Task::create([
            'event_id' => $id,
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'position_id' => $request->position_id,
            'status' => 'pending',
            'priority' => $request->priority,
            'deadline' => $request->deadline,
        ]);

        // Send Notification if assigned to a user
        if ($request->user_id) {
            $event = \App\Models\Event::find($id);
            \App\Models\Notification::create([
                'user_id' => $request->user_id,
                'title' => 'Nhiệm vụ mới',
                'message' => "Bạn được giao nhiệm vụ mới \"{$request->title}\" trong sự kiện {$event->title}",
                'type' => 'info',
                'link' => route('student.my-events.show', $id), // Will link to the new My Event Detail page
                'is_read' => false
            ]);
        }

        return back()->with('success', 'Đã thêm nhiệm vụ mới!');
    }

    public function taskDetails($eventId, $taskId)
    {
        $task = \App\Models\Task::with(['position', 'user'])->findOrFail($taskId);
        
        // Get eligible students for this task
        $studentsQuery = \App\Models\Checkin::where('event_id', $eventId)
            ->where('is_verified', true)
            ->with('user');

        if ($task->user_id) {
            $studentsQuery->where('user_id', $task->user_id);
        } elseif ($task->position_id) {
            $posId = $task->position_id;
            $studentsQuery->whereIn('user_id', function($query) use ($eventId, $posId) {
                $query->select('user_id')
                    ->from('registrations')
                    ->where('event_id', $eventId)
                    ->whereRaw("JSON_EXTRACT(custom_answers, '$.position_id') = ?", [$posId]);
            });
        }

        $completions = \App\Models\TaskCompletion::where('task_id', $taskId)->get()->keyBy('user_id');

        $eligibleStudents = $studentsQuery->get()->map(function($checkin) use ($taskId, $completions) {
            $completion = $completions->get($checkin->user_id);
            
            return [
                'user_id' => $checkin->user_id,
                'name' => $checkin->user->name,
                'status' => $completion ? $completion->status : 'pending',
                'completed_at' => $completion ? $completion->created_at->format('H:i d/m/Y') : null,
            ];
        });

        return response()->json([
            'task' => $task,
            'students' => $eligibleStudents,
        ]);
    }
    public function updateTask(Request $request, $eventId, $taskId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date'
        ]);

        $task = \App\Models\Task::findOrFail($taskId);
        $task->update($request->only(['title', 'description', 'priority', 'deadline']));

        return response()->json(['success' => true]);
    }
}
