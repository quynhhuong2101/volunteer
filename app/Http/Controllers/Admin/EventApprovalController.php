<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventApprovalController extends Controller
{
    public function index()
    {
        // Mock Pending Events
        $events = [
            [
                'id' => 1,
                'organizer' => 'CLB Tình Nguyện Xung Kích',
                'name' => 'Mùa Hè Xanh 2024',
                'submitted_at' => '2024-05-20',
                'status' => 'pending'
            ],
            [
                'id' => 2,
                'organizer' => 'Đội Công Tác Xã Hội',
                'name' => 'Xuân Tình Nguyện',
                'submitted_at' => '2024-05-21',
                'status' => 'pending'
            ]
        ];

        return view('admin.events.index', compact('events'));
    }

    public function show($id)
    {
        // Mock Event Detail
        $event = [
            'id' => 1,
            'organizer' => 'CLB Tình Nguyện Xung Kích',
            'name' => 'Mùa Hè Xanh 2024',
            'description' => 'Chiến dịch tình nguyện lớn nhất trong năm...',
            'location' => 'Mặt trận Bình Phước',
            'budget_requested' => 15000000,
            'plan_file' => 'ke_hoach_mhx_2024.pdf'
        ];

        return view('admin.events.show', compact('event'));
    }
}
