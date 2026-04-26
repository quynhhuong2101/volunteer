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

        // Logic to store SOS alert and notify organizers/team leaders
        // e.g., Alert::create([...]); notify(new SOSAlert($user, $location));

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

        // Logic to store incident report
        // e.g., Incident::create([...]);

        return redirect()->back()->with('success', 'Báo cáo sự cố đã được gửi thành công. Ban tổ chức sẽ xử lý sớm nhất.');
    }
}
