<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Notification;
use App\Models\Event;

class TaskController extends Controller
{
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $user = auth()->user();
        
        // Authorization logic for different task types
        $isAuthorized = false;
        
        // 1. Individual Task
        if ($task->user_id == $user->id) {
            $isAuthorized = true;
        } 
        // 2. Group/Collective Task
        elseif (is_null($task->user_id)) {
            // Check if it's a specific position (Group Task)
            if ($task->position_id) {
                $registration = \App\Models\Registration::where('user_id', $user->id)
                    ->where('event_id', $task->event_id)
                    ->first();
                
                if ($registration && isset($registration->custom_answers['position_id']) && $registration->custom_answers['position_id'] == $task->position_id) {
                    $isAuthorized = true;
                }
            } 
            // 3. All Task
            else {
                // Must be registered for the event
                $isRegistered = \App\Models\Registration::where('user_id', $user->id)
                    ->where('event_id', $task->event_id)
                    ->exists();
                if ($isRegistered) $isAuthorized = true;
            }
        }

        if (!$isAuthorized) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,completed'
        ]);

        // Record individual completion
        \App\Models\TaskCompletion::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => $user->id],
            ['status' => $request->status]
        );

        // Update main task status if it's an individual task
        if ($task->user_id) {
            $task->update(['status' => $request->status]);
        }

        // Notify Organizer if task is completed
        if ($request->status === 'completed') {
            $event = $task->event; 
            $studentName = $user->name;
            
            Notification::create([
                'user_id' => $event->organizer_id,
                'title' => 'Nhiệm vụ hoàn thành',
                'message' => "{$studentName} đã hoàn thành nhiệm vụ \"{$task->title}\"",
                'type' => 'success',
                'link' => route('organization.attendance.show', $event->id),
                'is_read' => false
            ]);
        }

        return response()->json(['success' => true]);
    }
}
