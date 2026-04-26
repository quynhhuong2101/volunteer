<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        // Mock Budget Requests
        $requests = [
            [
                'id' => 1,
                'event' => 'Mùa Hè Xanh 2024',
                'organizer' => 'CLB Tình Nguyện Xung Kích',
                'total_requested' => 15000000,
                'details' => [
                    ['item' => 'Xe di chuyển', 'amount' => 5000000],
                    ['item' => 'Ăn uống', 'amount' => 5000000],
                    ['item' => 'Vật phẩm', 'amount' => 5000000],
                ],
                'status' => 'pending'
            ]
        ];

        return view('admin.finance.index', compact('requests'));
    }
}
