<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warning;
use App\Models\User;

class WarningController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'severity' => 'required|in:reminder,warning,ban',
        ]);

        Warning::create($request->all());

        return back()->with('success', 'Đã gửi cảnh cáo/nhắc nhở thành công.');
    }
}
