<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Checkin;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    /**
     * List events for HR management
     */
    public function index()
    {
        $organizerId = auth()->id();

        $events = Event::where('organizer_id', $organizerId)
            ->withCount(['checkins', 'registrations'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->title,
                    'start_time' => $event->start_time,
                    'status' => $event->status == 'approved' ? 'Đang mở' : 'Đóng',
                    'status_color' => $event->status == 'approved' ? 'success' : 'secondary',
                    'applicants_count' => $event->registrations_count,
                    'verified_count' => $event->checkins()->where('is_verified', true)->count(),
                    'image' => $event->images[0] ?? null
                ];
            });

        return view('organization.hr.index', compact('events'));
    }

    /**
     * Unified Personnel Management Dashboard
     */
    public function manage($id)
    {
        $event = Event::with('positions')->findOrFail($id);
        
        $registrations = Registration::where('event_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $positions = $event->positions;
        $positionsMap = $positions->keyBy('id');

        $volunteers = $registrations->map(function($reg) use ($positionsMap, $event) {
            $positionName = 'Chưa xác định';
            $teamId = 'all';
            $regPosId = $reg->custom_answers['position_id'] ?? null;

            if ($regPosId && $pos = $positionsMap->get($regPosId)) {
                $positionName = $pos->name;
                $teamId = 'pos_' . $regPosId;
            }

            return [
                'registration_id' => $reg->id,
                'user_id' => $reg->user->id,
                'name' => $reg->user->name,
                'student_id' => 'SV' . $reg->user->id,
                'faculty' => 'Đại học Sài Gòn',
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($reg->user->name) . '&background=random',
                'role' => 'Thành viên',
                'position' => $positionName,
                'position_id' => $regPosId,
                'team_id' => $teamId,
                'status' => $reg->status, // pending, approved, rejected
                'applied_at' => $reg->created_at->diffForHumans(),
                'answers' => $reg->custom_answers['answers'] ?? []
            ];
        });

        return view('organization.hr.manage', compact('event', 'volunteers', 'positions'));
    }

    /**
     * Update Registration Status (Approve/Reject)
     */
    public function updateStatus(Request $request)
    {
        $reg = Registration::findOrFail($request->registration_id);
        $reg->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Đã cập nhật trạng thái thành công']);
    }

    /**
     * Update Volunteer Position/Group
     */
    public function updatePosition(Request $request)
    {
        $reg = Registration::findOrFail($request->registration_id);
        $custom_answers = $reg->custom_answers;
        $custom_answers['position_id'] = $request->position_id;
        
        $reg->update(['custom_answers' => $custom_answers]);

        return response()->json(['success' => true, 'message' => 'Đã chuyển nhóm thành công']);
    }
}
