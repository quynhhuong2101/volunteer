<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Map model attributes to what the view expects
        $student = [
            'name' => $user->name,
            'id' => $user->student_id ?? 'N/A',
            'major' => 'Sinh viên tình nguyện', // Default if no major column
            'bio' => 'Tự hào là một sinh viên tích cực tham gia các hoạt động cộng đồng và phong trào tình nguyện.',
            'avatar' => $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random&size=128'
        ];

        // 1. Thay thế Huy hiệu bằng Thống kê Hoạt động (Stats)
        $totalEvents = \App\Models\Registration::where('user_id', $user->id)->where('status', 'approved')->count();
        $totalCertificates = \App\Models\Certificate::where('user_id', $user->id)->count();
        $totalCheckins = \App\Models\Checkin::where('user_id', $user->id)->count();

        $statsList = [
            ['name' => 'Sự kiện', 'value' => $totalEvents, 'icon' => '🌟', 'color' => 'orange'],
            ['name' => 'Điểm danh', 'value' => $totalCheckins, 'icon' => '🎯', 'color' => 'green'],
            ['name' => 'Chứng nhận', 'value' => $totalCertificates, 'icon' => '🏆', 'color' => 'blue'],
        ];

        // 2. Mock Skills (Since we don't have a skills table, just return names without levels)
        $skills = [
            ['name' => 'Làm việc nhóm'],
            ['name' => 'Sơ cấp cứu'],
            ['name' => 'Tổ chức sự kiện'],
            ['name' => 'Giao tiếp'],
            ['name' => 'Giải quyết vấn đề']
        ];

        // 3. Lịch sử hoạt động (Timeline)
        $registrations = \App\Models\Registration::where('user_id', $user->id)
            ->where('status', 'approved')
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->get();

        $timeline = [];
        foreach ($registrations as $reg) {
            if ($reg->event) {
                $timeline[] = [
                    'title' => $reg->event->title,
                    'description' => $reg->event->category ?? 'Hoạt động gắn kết cộng đồng',
                    'date' => \Carbon\Carbon::parse($reg->event->start_time)->format('m/Y')
                ];
            }
        }

        // 4. Chứng nhận (Certificates)
        $userCerts = \App\Models\Certificate::where('user_id', $user->id)
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->get();

        $certificates = [];
        foreach ($userCerts as $cert) {
            $certificates[] = [
                'name' => $cert->event ? 'Chứng nhận Mùa Hè Xanh: ' . $cert->event->title : 'Giấy chứng nhận hoạt động',
                'date' => \Carbon\Carbon::parse($cert->issued_at ?? $cert->created_at)->format('d/m/Y')
            ];
        }

        // Thêm dữ liệu fallback nếu chưa có event nào để view đỡ trống
        if (empty($timeline)) {
            $timeline[] = [
                'title' => 'Bắt đầu hành trình',
                'description' => 'Tham gia cộng đồng tình nguyện viên VWA',
                'date' => $user->created_at->format('m/Y')
            ];
        }

        return view('student.portfolio.index', compact('user', 'student', 'skills', 'statsList', 'timeline', 'certificates'));
    }

    public function exportPdf()
    {
        // Logic to generate PDF using DomPDF
        return back()->with('info', 'Tính năng tải CV đang được phát triển.');
    }
}
