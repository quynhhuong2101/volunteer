<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = auth()->id();
        $query = \App\Models\Event::where('organizer_id', $organizerId)
            ->with(['schedules'])
            ->withCount('checkins');

        // Filter Logic
        if ($request->has('status') && $request->status != 'all') {
            if ($request->status == 'active') {
                $query->whereIn('status', ['approved']);
            } elseif ($request->status == 'pending') {
                $query->where('status', 'pending');
            } elseif ($request->status == 'rejected') {
                $query->where('status', 'rejected');
            } elseif ($request->status == 'closed') {
                 $query->whereIn('status', ['ended']);
            } elseif ($request->status == 'cancelled') {
                 $query->where('status', 'cancelled');
            }
        }

        $eventsRaw = $query->orderBy('created_at', 'desc')->get();

        // Calculate Overview Stats
        $stats = [
            'total_events' => \App\Models\Event::where('organizer_id', $organizerId)->count(),
            'active_campaigns' => \App\Models\Event::where('organizer_id', $organizerId)->where('status', 'approved')->count(),
            'pending_campaigns' => \App\Models\Event::where('organizer_id', $organizerId)->where('status', 'pending')->count(),
            'rejected_campaigns' => \App\Models\Event::where('organizer_id', $organizerId)->where('status', 'rejected')->count(),
            'cancelled_campaigns' => \App\Models\Event::where('organizer_id', $organizerId)->where('status', 'cancelled')->count(),
            'total_volunteers' => \App\Models\Checkin::whereHas('event', function($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })->distinct('user_id')->count('user_id'),
            'avg_rating' => 4.8, 
        ];

        $events = $eventsRaw->map(function($event) {
            $checkinsCount = $event->checkins_count;
            $capacity = $event->slots ?? 1; // Avoid division by zero
            $progress = ($checkinsCount / $capacity) * 100;

            return [
                'id' => $event->id,
                'name' => $event->title,
                'description' => $event->description,
                'status' => $event->status,
                'start_date' => \Carbon\Carbon::parse($event->start_time)->format('H:i d/m/Y'),
                'end_date' => \Carbon\Carbon::parse($event->end_time)->format('H:i d/m/Y'),
                'location' => $event->location,
                'registered' => $checkinsCount,
                'capacity' => $capacity,
                'progress' => min($progress, 100),
                'thumbnail' => \Illuminate\Support\Str::startsWith($event->image, 'http') ? $event->image : ($event->image ? asset($event->image) : 'https://ui-avatars.com/api/?name=' . urlencode($event->title) . '&background=random'),
                'days_left' => \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($event->start_time), false),
                'is_registration_paused' => $event->is_registration_paused,
                'is_published' => $event->is_published,
                'has_form' => \Illuminate\Support\Facades\DB::table('forms')->where('event_id', $event->id)->where('type', 'registration')->exists(),
                'scope' => $event->scope == 'trong_truong' ? 'Trong trường' : 'Ngoài trường',
                'requirements' => $event->requirements ?? [],
                'benefits' => $event->benefits ?? [],
                'contact_name' => $event->contact_name ?? 'Chưa cập nhật',
                'contact_phone' => $event->contact_phone ?? 'Chưa cập nhật',
                'schedules' => $event->schedules->map(function($s) {
                    return [
                        'id' => $s->id,
                        'date' => \Carbon\Carbon::parse($s->date)->format('d/m/Y'),
                        'start_time' => \Carbon\Carbon::parse($s->start_time)->format('H:i'),
                        'end_time' => \Carbon\Carbon::parse($s->end_time)->format('H:i'),
                        'activity' => $s->title,
                        'note' => $s->description,
                        'location' => $s->location,
                    ];
                }),
            ];
        });

        return view('organization.events.index', compact('events', 'stats'));
    }

    public function edit($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);
        return view('organization.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);
        
        $request->validate([
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required',
            'max_participants' => 'nullable|integer',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $data = $request->all();
        
        $data['requirements'] = $request->filled('requirements') ? array_values(array_filter(array_map('trim', explode("\n", $request->requirements)))) : null;
        $data['benefits'] = $request->filled('benefits') ? array_values(array_filter(array_map('trim', explode("\n", $request->benefits)))) : null;

        $event->update($data);

        return redirect()->route('organization.events.index')->with('success', 'Cập nhật sự kiện thành công!');
    }

    public function cancel($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);
        
        $event->update(['status' => 'cancelled']);
        return back()->with('success', 'Đã hủy sự kiện thành công.');
    }

    public function destroy($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);
        
        if(!in_array($event->status, ['cancelled', 'rejected'])) {
             return back()->with('error', 'Chỉ có thể xóa các sự kiện đã bị hủy hoặc từ chối.');
        }

        $event->delete();
        return back()->with('success', 'Đã xóa sự kiện thành công khỏi hệ thống.');
    }

    public function publish($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);
        
        if ($event->status !== 'approved') {
            return back()->with('error', 'Chỉ có thể công bố sự kiện đã được Ban quản trị duyệt.');
        }

        $form = \Illuminate\Support\Facades\DB::table('forms')->where('event_id', $id)->where('type', 'registration')->first();
        if (!$form) {
            return back()->with('error', 'Vui lòng thiết lập Form đăng ký trước khi công bố sự kiện.');
        }

        $event->is_published = true;
        $event->save();

        return back()->with('success', 'Đã công bố sự kiện! Sinh viên hiện có thể đăng ký tham gia.');
    }

    public function toggleRegistration($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);
        
        $event->is_registration_paused = !$event->is_registration_paused;
        $event->save();
        
        $status = $event->is_registration_paused ? 'Đã tạm dừng' : 'Đã mở lại';
        return back()->with('success', "$status đăng ký sự kiện.");
    }

    public function builder($id)
    {
         $event = \App\Models\Event::findOrFail($id);
         if($event->organizer_id != auth()->id()) abort(403);

         $form = \Illuminate\Support\Facades\DB::table('forms')->where('event_id', $id)->where('type', 'registration')->first();
         $positions = \Illuminate\Support\Facades\DB::table('event_positions')->where('event_id', $id)->get();
         
         $formData = [
            'positions' => [],
            'fields' => [],
            'policy' => ['autoClose' => true, 'cancelHours' => 3]
         ];
         
         if ($form) {
            $questions = \Illuminate\Support\Facades\DB::table('form_questions')->where('form_id', $form->id)->orderBy('order')->get();
            foreach($questions as $q) {
                $formData['fields'][] = [
                    'type' => $q->type,
                    'label' => $q->question,
                    'required' => (bool)$q->is_required,
                    'options' => json_decode($q->options, true) ?? []
                ];
            }
         } else {
             $formData['fields'] = [
                [ 'type' => 'select', 'label' => 'Size Áo', 'required' => true, 'options' => ['S', 'M', 'L', 'XL', 'XXL'] ]
             ];
         }
         
         if ($positions->count() > 0) {
             foreach($positions as $pos) {
                 $formData['positions'][] = [
                     'name' => $pos->name,
                     'qty' => $pos->quantity,
                     'desc' => $pos->description
                 ];
             }
         } else {
             $formData['positions'] = [
                [ 'name' => 'Tình nguyện viên chung', 'qty' => 10, 'desc' => 'Hỗ trợ các công việc sự kiện' ]
             ];
         }

         return view('organization.events.form-builder', [
             'id' => $id,
             'event' => $event,
             'formData' => json_encode($formData)
         ]);
    }

    public function saveForm(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);

        $data = json_decode($request->config, true);
        
        // 1. Create/Update Form
        \Illuminate\Support\Facades\DB::table('forms')->updateOrInsert(
            ['event_id' => $id, 'type' => 'registration'],
            [
                'title' => 'Form Đăng Ký: ' . $event->title,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        
        // Get form ID
        $formId = \Illuminate\Support\Facades\DB::table('forms')->where('event_id', $id)->where('type', 'registration')->value('id');

        // 2. Sync Questions
        \Illuminate\Support\Facades\DB::table('form_questions')->where('form_id', $formId)->delete();
        if (isset($data['fields'])) {
            foreach ($data['fields'] as $index => $field) {
                \Illuminate\Support\Facades\DB::table('form_questions')->insert([
                    'form_id' => $formId,
                    'type' => $field['type'],
                    'question' => $field['label'],
                    'options' => json_encode($field['options']),
                    'is_required' => $field['required'] ?? false,
                    'order' => $index,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        // 3. Sync Positions
        \Illuminate\Support\Facades\DB::table('event_positions')->where('event_id', $id)->delete();
        if (isset($data['positions'])) {
            foreach ($data['positions'] as $pos) {
                \Illuminate\Support\Facades\DB::table('event_positions')->insert([
                    'event_id' => $id,
                    'name' => $pos['name'],
                    'quantity' => $pos['qty'] ?? 1,
                    'description' => $pos['desc'] ?? '',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return back()->with('success', 'Đã lưu cấu hình đơn đăng ký thành công!');
    }

    // Feedback Form Builder
    public function feedbackBuilder($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);

        return view('organization.events.feedback-builder', compact('event'));
    }

    public function saveFeedbackForm(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        if($event->organizer_id != auth()->id()) abort(403);

        $data = json_decode($request->config, true);
        
        // 1. Create/Update Form
        $form = \Illuminate\Support\Facades\DB::table('forms')->updateOrInsert(
            ['event_id' => $id, 'type' => 'feedback'],
            [
                'title' => 'Phiếu Đánh Giá: ' . $event->title,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        
        // Get form ID
        $formId = \Illuminate\Support\Facades\DB::table('forms')->where('event_id', $id)->where('type', 'feedback')->value('id');

        // 2. Sync Questions
        \Illuminate\Support\Facades\DB::table('form_questions')->where('form_id', $formId)->delete();

        if (isset($data['fields'])) {
            foreach ($data['fields'] as $index => $field) {
                \Illuminate\Support\Facades\DB::table('form_questions')->insert([
                    'form_id' => $formId,
                    'type' => $field['type'],
                    'question' => $field['label'],
                    'options' => json_encode($field['options']),
                    'is_required' => $field['required'] ?? false,
                    'order' => $index,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return back()->with('success', 'Đã lưu phiếu đánh giá thành công!');
    }

    public function create()
    {
        return view('organization.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'scope' => 'required|in:trong_truong,ngoai_truong', 
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/events'), $filename);
            $imagePath = 'uploads/events/' . $filename;
        }

        \App\Models\Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'organizer_id' => auth()->id(),
            'status' => 'pending', // Require approval
            'max_participants' => $request->max_participants,
            'image' => $imagePath,
            'qr_token' => \Illuminate\Support\Str::random(32),
            'scope' => $request->scope,
            'requirements' => $request->filled('requirements') ? array_values(array_filter(array_map('trim', explode("\n", $request->requirements)))) : null,
            'benefits' => $request->filled('benefits') ? array_values(array_filter(array_map('trim', explode("\n", $request->benefits)))) : null,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
        ]);

        return redirect()->route('organization.events.index')->with('success', 'Đã tạo sự kiện! Vui lòng chờ Ban quản trị duyệt trước khi công khai.');
    }
    
    public function formsList()
    {
        $organizerId = auth()->id();
        $events = \App\Models\Event::where('organizer_id', $organizerId)
            ->where('status', '!=', 'ended')
            ->where('end_time', '>', now())
            ->get()->map(function($event) {
                $form = \Illuminate\Support\Facades\DB::table('forms')
                            ->where('event_id', $event->id)
                            ->where('type', 'registration')
                            ->first();
                $hasForm = $form ? true : false;
                $questionsCount = $form ? \Illuminate\Support\Facades\DB::table('form_questions')->where('form_id', $form->id)->count() : 0;
                
                return [
                    'id' => $event->id,
                    'name' => $event->title,
                    'status' => $event->status === 'approved' ? 'Đang mở' : ($event->status === 'pending' ? 'Chờ duyệt' : 'Đóng'),
                    'status_color' => $event->status === 'approved' ? 'success' : ($event->status === 'pending' ? 'warning' : 'secondary'),
                    'has_form' => $hasForm,
                    'questions_count' => $questionsCount
                ];
        });
        
        return view('organization.hr.forms', compact('events'));
    }

    public function schedule($id)
    {
        $event = \App\Models\Event::where('organizer_id', auth()->id())->findOrFail($id);
        
        if ($event->status !== 'approved') {
            return back()->with('error', 'Chỉ có thể thêm lịch trình cho sự kiện đã được DUYỆT.');
        }

        $schedules = $event->schedules()->orderBy('date')->orderBy('start_time')->get();
        
        return view('organization.events.schedule', compact('event', 'schedules'));
    }

    public function storeSchedule(\Illuminate\Http\Request $request, $id)
    {
        $event = \App\Models\Event::where('organizer_id', auth()->id())->findOrFail($id);
        
        if ($event->status !== 'approved') {
            return back()->with('error', 'Chỉ có thể thêm lịch trình cho sự kiện đã được DUYỆT.');
        }

        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'nullable',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $event->schedules()->create($request->all());

        return back()->with('success', 'Đã thêm mục lịch trình mới.');
    }

    public function destroySchedule($id, $scheduleId)
    {
        $event = \App\Models\Event::where('organizer_id', auth()->id())->findOrFail($id);
        $schedule = $event->schedules()->findOrFail($scheduleId);
        $schedule->delete();

        return back()->with('success', 'Đã xóa mục lịch trình.');
    }
}
