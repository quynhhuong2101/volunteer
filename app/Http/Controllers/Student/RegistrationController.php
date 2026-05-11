<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create($id)
    {
        $event = \App\Models\Event::findOrFail($id);

        if (!$event->is_published || $event->status !== 'approved') {
            return redirect()->route('student.events.index')->with('error', 'Sự kiện này chưa mở đăng ký.');
        }

        if ($event->is_registration_paused) {
             return redirect()->route('student.events.show', $id)->with('error', 'Sự kiện đang tạm dừng đăng ký.');
        }

        if ($event->max_participants && $event->registered >= $event->max_participants) {
             return redirect()->route('student.events.show', $id)->with('error', 'Sự kiện đã đủ số lượng tình nguyện viên.');
        }

        // Check if user already registered
        $isRegistered = \App\Models\Registration::where('user_id', auth()->id())->where('event_id', $event->id)->exists() 
            || \App\Models\Checkin::where('user_id', auth()->id())->where('event_id', $event->id)->exists();

        $form = \Illuminate\Support\Facades\DB::table('forms')->where('event_id', $id)->where('type', 'registration')->first();
        $fields = $form ? \Illuminate\Support\Facades\DB::table('form_questions')->where('form_id', $form->id)->orderBy('order')->get() : collect([]);
        $positions = \Illuminate\Support\Facades\DB::table('event_positions')->where('event_id', $id)->get();
        
        foreach($positions as $pos) {
            $registeredCount = \Illuminate\Support\Facades\DB::table('registrations')->where('event_position_id', $pos->id)->count();
            $pos->remaining = max(0, $pos->quantity - $registeredCount);
        }

        return view('student.events.register', compact('event', 'isRegistered', 'fields', 'positions'));
    }

    public function store(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $user = auth()->user();

        // Safety Checks
        if (!$event->is_published || $event->status !== 'approved' || $event->is_registration_paused) {
            return back()->with('error', 'Sự kiện hiện không nhận đăng ký.');
        }

        $alreadyRegistered = \App\Models\Registration::where('user_id', $user->id)->where('event_id', $event->id)->exists() 
            || \App\Models\Checkin::where('user_id', $user->id)->where('event_id', $event->id)->exists();

        if ($alreadyRegistered) {
            return back()->with('info', 'Bạn đã đăng ký sự kiện này rồi.');
        }

        if ($event->max_participants && $event->registered >= $event->max_participants) {
            return back()->with('error', 'Sự kiện đã đủ số lượng tình nguyện viên.');
        }

        $positionId = $request->input('position_id');
        $customAnswers = [];
        
        // Extract form answers
        foreach($request->all() as $key => $val) {
            if (str_starts_with($key, 'field_')) {
                $customAnswers[$key] = is_array($val) ? json_encode($val) : $val;
            }
        }

        // Create Registration record
        $regId = \Illuminate\Support\Facades\DB::table('registrations')->insertGetId([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'event_position_id' => $positionId,
            'status' => 'approved',
            'custom_answers' => json_encode($customAnswers),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Legacy checkin
        \App\Models\Checkin::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'checkin_time' => now(),
            'is_verified' => false
        ]);

        return redirect()->route('student.events.show', $id)->with('success', 'Đăng ký tham gia thành công! Chúc bạn có một trải nghiệm tuyệt vời.');
    }
}
