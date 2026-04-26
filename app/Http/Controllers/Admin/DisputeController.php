<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class DisputeController extends Controller
{
    public function index()
    {
        $disputes = Report::with(['user', 'event.organizer'])->orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total' => $disputes->count(),
            'open' => $disputes->where('status', 'open')->count(),
            'resolved' => $disputes->where('status', 'resolved')->count(),
        ];

        return view('admin.dispute.index', compact('disputes', 'stats'));
    }

    public function show($id)
    {
        $dispute = Report::with(['user', 'event.organizer'])->findOrFail($id);
        
        // Context: Fetch check-in logs if related to an event
        $checkin_logs = [];
        if ($dispute->event_id && $dispute->user_id) {
            $checkin_logs = \App\Models\Checkin::where('user_id', $dispute->user_id)
                ->where('event_id', $dispute->event_id)
                ->get();
        }

        return view('admin.dispute.show', compact('dispute', 'checkin_logs'));
    }

    public function resolve(Request $request, $id)
    {
        $dispute = Report::findOrFail($id);
        
        $dispute->update([
            'status' => 'resolved',
            'resolution_note' => $request->input('note', 'Đã xử lý và giải quyết thỏa đáng.')
        ]);

        return back()->with('success', 'Đã giải quyết khiếu nại.');
    }

    public function reject(Request $request, $id)
    {
        $dispute = Report::findOrFail($id);
        
        $dispute->update([
            'status' => 'rejected', // Or 'closed' / 'dismissed'
            'resolution_note' => $request->input('note', 'Không đủ cơ sở để giải quyết hoặc không vi phạm.')
        ]);

        return back()->with('success', 'Đã từ chối/đóng khiếu nại.');
    }
}
