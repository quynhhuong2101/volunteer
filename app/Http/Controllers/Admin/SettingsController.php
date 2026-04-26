<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        // Mock saving settings
        $request->validate([
            'language' => 'required|in:vi,en',
            'timezone' => 'required',
        ]);

        return back()->with('success', 'Cập nhật cài đặt thành công!');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
