<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SafetyController extends Controller
{
    public function sos(Request $request)
    {
        // Validation
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $user = auth()->user();
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');
        $mapLink = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";

        // Notify all admins and organizers
        $receivers = \App\Models\User::whereIn('role', ['admin', 'organizer'])->get();

        foreach ($receivers as $receiver) {
            \Illuminate\Support\Facades\DB::table('notifications_table')->insert([
                'user_id' => $receiver->id,
                'title' => '🚨 TÍN HIỆU KHẨN CẤP (SOS)',
                'message' => "Sinh viên {$user->name} vừa gửi tín hiệu SOS từ vị trí: {$lat}, {$lng}. Vui lòng kiểm tra ngay!",
                'type' => 'danger',
                'is_read' => false,
                'link' => $mapLink,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi tín hiệu khẩn cấp! Đội cứu hộ đang di chuyển đến vị trí của bạn.'
        ]);
    }

    public function report(Request $request)
    {
        // Validation
        $request->validate([
            'type' => 'required',
            'description' => 'required|string|max:500',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $user = auth()->user();
        
        $typeMap = [
            'health' => 'Vấn đề sức khỏe / Tai nạn',
            'harassment' => 'Bị quấy rối / Đe dọa',
            'lost' => 'Đi lạc / Mất phương hướng',
            'logistics' => 'Vấn đề hậu cần / Di chuyển',
            'other' => 'Khác',
        ];
        
        $title = $typeMap[$request->input('type')] ?? 'Báo cáo sự cố';
        
        $evidence = [];
        if ($request->filled('latitude') && $request->filled('longitude')) {
            $evidence['location'] = [
                'lat' => $request->input('latitude'),
                'lng' => $request->input('longitude')
            ];
        }

        \App\Models\Report::create([
            'user_id' => $user->id,
            'event_id' => null, // Tùy chọn, nếu có event hiện tại thì truyền vào
            'title' => $title,
            'description' => $request->input('description'),
            'evidence' => $evidence,
            'status' => 'open',
        ]);
        
        // Notify organizers about the report
        $organizers = \App\Models\User::whereIn('role', ['admin', 'organizer'])->get();
        foreach ($organizers as $org) {
            \Illuminate\Support\Facades\DB::table('notifications_table')->insert([
                'user_id' => $org->id,
                'title' => 'Báo cáo sự cố mới',
                'message' => "Sinh viên {$user->name} đã gửi báo cáo sự cố: {$title}.",
                'type' => 'warning',
                'is_read' => false,
                'link' => '#',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Báo cáo sự cố đã được gửi thành công. Ban tổ chức sẽ xử lý sớm nhất.');
    }
}
