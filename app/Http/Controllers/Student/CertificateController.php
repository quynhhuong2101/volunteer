<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function show($eventId)
    {
        $user = auth()->user();
        $event = Event::findOrFail($eventId);

        // 1. Check Eligibility
        // Event must be ended
        if ($event->end_time > now()) {
            abort(403, 'Sự kiện chưa kết thúc.');
        }

        // User must have checked in (or registered/approved depending on logic)
        // Using Checkin model as per previous context
        $hasCheckedIn = $event->checkins()->where('user_id', $user->id)->exists();

        if (!$hasCheckedIn) {
            abort(403, 'Bạn chưa hoàn thành sự kiện này.');
        }

        // 2. Find or Create Certificate
        $certificate = Certificate::firstOrCreate(
            [
                'user_id' => $user->id,
                'event_id' => $event->id,
            ],
            [
                'code' => 'CERT-' . strtoupper(Str::random(10)), // Simple code generation
                'issued_at' => now(),
                'template_url' => 'default', // For future use
            ]
        );

        return view('student.certificates.show', [
            'certificate' => $certificate,
            'user' => $user,
            'event' => $event
        ]);
    }
}
