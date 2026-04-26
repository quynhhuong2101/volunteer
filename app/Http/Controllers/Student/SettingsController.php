<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function account()
    {
        $user = Auth::user();

        // Ensure we always have an avatar fallback
        if (empty($user->avatar)) {
            $name = urlencode($user->name ?? 'Student');
            $user->avatar = "https://ui-avatars.com/api/?name={$name}&background=random&size=128";
        }

        return view('student.settings.account', compact('user'));
    }

    public function password()
    {
        return view('student.settings.password');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|string|in:Nam,Nữ,Khác',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            // Avatar logic can be added later if needed via file upload
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Thông tin tài khoản đã được cập nhật thành công!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        // Check if user is logged in (mock data doesn't use Auth::user() but for password change we must rely on real auth or simulated)
        // Since we are adding logic, let's assume Auth::user() works or falls back to a fail-safe.
        // For this task, strict Auth is required for password change.
        if (!$user) {
             return redirect()->back()->withErrors(['current_password' => 'Vui lòng đăng nhập để thực hiện chức năng này.']);
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }
}
