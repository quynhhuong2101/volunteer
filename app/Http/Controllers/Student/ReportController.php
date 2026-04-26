<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Event;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', auth()->id())
            ->with(['event'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.reports.index', compact('reports'));
    }

    public function create(Request $request)
    {
        $event_id = $request->query('event_id');
        $events = auth()->user()->checkins()->with('event')->get()->pluck('event')->unique('id');
        
        // Use checkins to filter only participated events, or fetch all if general report?
        // Let's allow reporting for any event they interacted with (registered/checked-in).
        // For simplicity, fetch all events this user has registered or checked in.
        // Actually, easiest is to just let them select from Active/Recent events.
        
        // Better: Fetch events from Registrations + Checkins
        $registrationEvents = \App\Models\Registration::where('user_id', auth()->id())->with('event')->get()->pluck('event');
        $events = $registrationEvents->unique('id');

        return view('student.reports.create', compact('events', 'event_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_id' => 'nullable|exists:events,id',
            'evidence_files.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf'
        ]);

        $evidence = [];
        if ($request->hasFile('evidence_files')) {
            foreach ($request->file('evidence_files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/reports'), $filename);
                $evidence[] = [
                    'url' => 'uploads/reports/' . $filename,
                    'caption' => $file->getClientOriginalName(),
                    'type' => 'file'
                ];
            }
        }

        Report::create([
            'user_id' => auth()->id(),
            'event_id' => $request->event_id,
            'title' => $request->title,
            'description' => $request->description,
            'evidence' => $evidence, // Model casts to array/json automatically
            'status' => 'open'
        ]);

        return redirect()->route('student.reports.index')->with('success', 'Đã gửi báo cáo thành công.');
    }
}
