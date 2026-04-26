<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private function getMockEvent($id)
    {
        // Mock data matching the Organization's configuration
        return [
            'id' => $id,
            'name' => 'Chiến dịch Mùa Hè Xanh 2024',
            'date' => '15/07 - 25/07/2024',
            'location' => 'Xã Bình Lợi, Huyện Bình Chánh',
            'thumbnail' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=800&auto=format&fit=crop&q=60',
            'is_full' => false,
            // Mock Configuration from Organization
            'positions' => [
                ['id' => 1, 'name' => 'Đội hình Dạy học', 'needed' => 15, 'registered' => 5, 'desc' => 'Dạy toán, tiếng việt cho trẻ em', 'status' => 'Open'],
                ['id' => 2, 'name' => 'Đội hình Xây dựng', 'needed' => 25, 'registered' => 25, 'desc' => 'Bê tông hóa đường quê', 'status' => 'Full'],
                ['id' => 3, 'name' => 'Đội hình Hậu cần', 'needed' => 10, 'registered' => 2, 'desc' => 'Nấu ăn, chuẩn bị vật dụng', 'status' => 'Open'],
            ],
            'custom_fields' => [
                ['type' => 'select', 'label' => 'Size Áo', 'required' => true, 'options' => ['S', 'M', 'L', 'XL', 'XXL']],
                ['type' => 'text', 'label' => 'Kỹ năng đặc biệt', 'required' => false],
                ['type' => 'checkbox', 'label' => 'Bạn có thể mang theo laptop?', 'required' => false, 'options' => ['Có', 'Không']],
            ],
            'policy' => [
                'cancel_hours' => 3,
                'auto_close' => true
            ]
        ];
    }

    public function create($id)
    {
        $event = $this->getMockEvent($id);
        
        // Check if user already registered (Mock)
        $isRegistered = false; 

        if ($event['is_full']) {
             return redirect()->route('student.events.show', $id)->with('error', 'Sự kiện đã đủ số lượng tình nguyện viên.');
        }

        return view('student.events.register', compact('event', 'isRegistered'));
    }

    public function store(Request $request, $id)
    {
        // Validation logic would go here
        
        // Mock success
        return redirect()->route('student.events.show', $id)->with('success', 'Đăng ký tham gia thành công! Vui lòng kiểm tra email để xem thông tin chi tiết.');
    }
}
