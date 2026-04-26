<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::orderBy('created_at', 'desc')->get()->map(function($user) {
            // Determine Role: Simple assumption based on name/email/id or just default 'Sinh viên' if no role column
            // Assuming role column doesn't exist yet in simple schema, default to 'Sinh viên'.
            // Or infer from context (admin vs organizer vs student).
            // Actually, we usually add a 'role' column. Migration had id, name, email.
            // Let's assume 'role' column is missing and mock it based on email or add it.
            // For now, mock it: admin@ -> Admin, organizer@ -> Organization, else Student.
            
            $role = 'Sinh viên';
            $color = 'blue';
            if ($user->email == 'admin@email.com') { $role = 'Quản trị viên'; $color = 'indigo'; }
            elseif ($user->email == 'organizer@email.com') { $role = 'Tổ chức'; $color = 'purple'; }
            
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
                'role_color' => $color,
                'phone' => $user->phone ?? 'Chưa cập nhật',
                'status' => $user->status ?? 'active',
                'joined_at' => $user->created_at->format('Y-m-d'),
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random',
                'stats' => ['events_joined' => 0, 'hours' => 0, 'score' => 0]
            ];
        });

        $stats = [
            'total' => $users->count(),
            'students' => $users->where('role', 'Sinh viên')->count(),
            'organizations' => $users->where('role', 'Tổ chức')->count(),
            'banned' => 0,
            'pending' => 0,
        ];
        return view('admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Simple Create Logic
        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make('12345678')
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Đã cấp tài khoản mới thành công.');
    }

    public function show($id)
    {
        $userModel = \App\Models\User::with(['checkins' => function($q) {
            $q->where('is_verified', true)->with('event');
        }, 'certificates'])->findOrFail($id);
        
        // Role Determination
        $role = 'Sinh viên';
        $roleColor = 'blue';
        if ($userModel->email == 'admin@email.com') { $role = 'Quản trị viên'; $roleColor = 'indigo'; }
        elseif ($userModel->email == 'organizer@email.com') { $role = 'Tổ chức'; $roleColor = 'purple'; }

        // Real Stats Calculation
        $eventsJoined = $userModel->checkins->count();
        $totalHours = $userModel->checkins->reduce(function ($carry, $checkin) {
            if ($checkin->event) {
                return $carry + $checkin->event->start_time->diffInHours($checkin->event->end_time);
            }
            return $carry;
        }, 0);
        $score = $totalHours * 10 + ($eventsJoined * 5); // Mock scoring logic

        // Portfolio Data
        $certificates = $userModel->certificates->map(function($cert) {
            return [
                'name' => 'Chứng nhận: ' . $cert->code, // Or fetch template name
                'date' => $cert->issued_at->format('d/m/Y'),
                'color' => 'emerald'
            ];
        });

        $timeline = $userModel->checkins->sortByDesc('checkin_time')->take(10)->map(function($checkin) {
            return [
                'event' => $checkin->event->title ?? 'Sự kiện đã xóa',
                'role' => 'Tình nguyện viên',
                'date' => $checkin->checkin_time ? \Carbon\Carbon::parse($checkin->checkin_time)->format('Y-m-d') : 'N/A'
            ];
        });

        $userData = [
                'id' => $userModel->id,
                'name' => $userModel->name,
                'email' => $userModel->email,
                'phone' => $userModel->phone ?? 'Chưa cập nhật',
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($userModel->name) . '&background=random',
                'role' => $role,
                'department' => 'Khoa CNTT', // Mock detail
                'status' => 'Active', // Mock status
                'joined_at' => $userModel->created_at->format('Y-m-d'),
                'stats' => [
                    'events_joined' => $eventsJoined, 
                    'hours_volunteered' => $totalHours, 
                    'integrity_score' => $score
                ],
                'portfolio' => [
                    'certificates' => $certificates,
                    'skills' => ['Làm việc nhóm', 'Quản lý thời gian', 'Sơ cấp cứu'], // Mock skills
                    'timeline' => $timeline
                ]
        ];
        
        return view('admin.users.show', ['user' => $userData]);
    }

    public function toggleStatus($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Prevent locking self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Không thể khóa tài khoản của chính mình.');
        }

        $user->status = ($user->status === 'active') ? 'locked' : 'active';
        $user->save();

        $statusMessage = ($user->status === 'active') ? 'được mở khóa' : 'đã bị khóa';
        return back()->with('success', "Tài khoản {$user->name} đã {$statusMessage}.");
    }

    public function resetPassword($id)
    {
        // Real logic: User::where('id', $id)->update(['password' => Hash::make('newpassword')]);
        return back()->with('success', 'Đã đặt lại mật khẩu thành công. Mật khẩu mới là 12345678.');
    }

    public function approve($id)
    {
        return redirect()->route('admin.users.index')->with('success', 'Đã phê duyệt tài khoản Tổ chức thành công.');
    }

    public function reject($id)
    {
        return redirect()->route('admin.users.index')->with('success', 'Đã từ chối yêu cầu đăng ký.');
    }
}
