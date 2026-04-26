<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Show Chat Room
    public function show($eventId)
    {
        $event = \App\Models\Event::findOrFail($eventId);
        
        // Find or create chat room for this event
        $room = \App\Models\ChatRoom::firstOrCreate(
            ['event_id' => $eventId],
            ['name' => 'Thảo luận: ' . $event->title, 'type' => 'group']
        );

        $messages = \App\Models\ChatMessage::where('chat_room_id', $room->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'user_id' => $msg->user_id,
                    'user_name' => $msg->user->name,
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($msg->user->name) . '&background=random',
                    'content' => $msg->content,
                    'time' => $msg->created_at->format('H:i A'),
                    'is_me' => $msg->user_id == auth()->id(),
                    'role' => $msg->user->role ?? 'member',
                    'attachments' => $msg->attachments
                ];
            });

        // Pass simple event array for view compatibility
        $eventData = [
            'id' => $event->id,
            'name' => $event->title,
            'members_count' => \App\Models\Checkin::where('event_id', $eventId)->count(), // Count participants
            'is_active' => $event->status == 'approved',
            'has_group' => true // Since we created access
        ];

        // Check role and return appropriate view
        $role = auth()->user()->role;
        // Handle Enum or String
        $roleName = $role instanceof \App\Enums\UserRole ? $role->value : $role;
        
        if (strtolower(trim($roleName)) === 'student') {
            return view('student.chat.room', ['event' => $eventData, 'messages' => $messages]);
        }

        return view('chat.room', ['event' => $eventData, 'messages' => $messages]);
    }

    // Send Message
    // Send Message
    public function store(Request $request, $eventId)
    {
        $request->validate([
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:5120', // Max 5MB
        ]);

        if (!$request->content && !$request->hasFile('image')) {
            return response()->json(['success' => false, 'message' => 'Nội dung trống'], 422);
        }
        
        $room = \App\Models\ChatRoom::where('event_id', $eventId)->firstOrFail();
        
        \Illuminate\Support\Facades\Log::info('Chat Upload Request', [
            'has_file' => $request->hasFile('image'),
            'file_name' => $request->file('image') ? $request->file('image')->getClientOriginalName() : 'N/A',
            'content' => $request->content
        ]);

        $attachments = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Ensure directory exists
            if (!file_exists(public_path('chat/images'))) {
                mkdir(public_path('chat/images'), 0755, true);
            }
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('chat/images'), $filename);
            $attachments = ['type' => 'image', 'url' => '/chat/images/' . $filename];
        }

        $msg = \App\Models\ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => auth()->id(),
            'content' => $request->content ?? '', // Allow empty text if image exists
            'type' => $attachments ? 'image' : 'text',
            'attachments' => $attachments
        ]);

        // Return JSON for AJAX
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $msg->id,
                'content' => $msg->content,
                'user_id' => $msg->user_id,
                'user_name' => auth()->user()->name,
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random',
                'time' => $msg->created_at->format('H:i A'),
                'is_me' => true,
                'role' => $msg->user->role ?? 'member',
                'attachments' => $msg->attachments
            ]
        ]);
    }

    // Fetch New Messages (Polling)
    public function fetchNewMessages(Request $request, $eventId)
    {
        $lastId = $request->query('last_id', 0);
        $room = \App\Models\ChatRoom::where('event_id', $eventId)->firstOrFail();

        $messages = \App\Models\ChatMessage::where('chat_room_id', $room->id)
            ->where('id', '>', $lastId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'user_id' => $msg->user_id,
                    'user_name' => $msg->user->name,
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($msg->user->name) . '&background=random',
                    'content' => $msg->content,
                    'time' => $msg->created_at->format('H:i A'),
                    'is_me' => $msg->user_id == auth()->id(),
                    'role' => $msg->user->role ?? 'member',
                    'attachments' => $msg->attachments
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    // Activate Group (Organization Only)
    public function createGroup($eventId)
    {
        $event = \App\Models\Event::findOrFail($eventId);
         \App\Models\ChatRoom::firstOrCreate(
            ['event_id' => $eventId],
            ['name' => 'Thảo luận: ' . $event->title, 'type' => 'group']
        );
        return back()->with('success', 'Đã tạo nhóm thảo luận cho sự kiện thành công!');
    }

    // Deactivate/Close Group
    public function destroy($eventId)
    {
        \App\Models\ChatRoom::where('event_id', $eventId)->delete();
        return redirect()->route('organization.events.index')->with('success', 'Đã giải tán nhóm thảo luận.');
    }
}
