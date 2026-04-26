<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = \App\Models\Event::with('organizer')->orderBy('created_at', 'desc')->get()->map(function($event) {
             return [
                'id' => $event->id,
                'name' => $event->title,
                'organizer' => $event->organizer->name ?? 'Không xác định',
                'location' => $event->location,
                'submitted_at' => $event->created_at->format('d/m/Y'),
                'date' => \Carbon\Carbon::parse($event->start_time)->format('d/m/Y'),
                'status' => $event->status,
                'description' => $event->description,
                'budget' => number_format(rand(5000000, 20000000)) . ' VNĐ', // Mock Budget for now if not fetched
                'participants' => $event->max_participants,
                'plan_file' => '#'
            ];
        });
        
        $stats = [
            'total' => $events->count(),
            'pending' => $events->where('status', 'pending')->count(),
            'approved' => $events->where('status', 'approved')->count(),
            'rejected' => $events->where('status', 'rejected')->count(),
        ];

        return view('admin.events.index', compact('events', 'stats'));
    }

    public function show($id)
    {
        $eventModel = \App\Models\Event::with('organizer')->findOrFail($id);
        
        $event = [
                'id' => $eventModel->id,
                'name' => $eventModel->title,
                'organizer' => $eventModel->organizer->name ?? 'Không xác định',
                'location' => $eventModel->location,
                'submitted_at' => $eventModel->created_at->format('Y-m-d'),
                'date' => \Carbon\Carbon::parse($eventModel->start_time)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($eventModel->end_time)->format('d/m/Y'),
                'status' => $eventModel->status,
                'description' => $eventModel->description,
                'budget' => 'Chưa cập nhật',
                'participants' => $eventModel->max_participants,
                'plan_file' => '#'
        ];

        return view('admin.events.show', compact('event'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        // ...
    }

    // Demo actions: just notify success
    public function approve($id)
    {
        \App\Models\Event::where('id', $id)->update(['status' => 'approved']);
        return back()->with('success', 'Đã duyệt sự kiện thành công.');
    }

    public function requestChanges(Request $request, $id)
    {
        \App\Models\Event::where('id', $id)->update(['status' => 'rejected']);
        return back()->with('success', 'Đã từ chối/yêu cầu chỉnh sửa.');
    }

    public function destroy($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $event->delete();
        
        return redirect()->route('admin.events.index')
            ->with('success', 'Đã xóa sự kiện thành công.');
    }
}
