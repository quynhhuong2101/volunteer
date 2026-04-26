<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $email = $request->input('email');

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            if ($user->status === 'locked') {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.',
                ]);
            }

            if ($user->hasRole(UserRole::ADMIN)) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole(UserRole::ORGANIZER)) {
                return redirect()->route('organization.dashboard');
            }

            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    /**
     * Placeholder for Social Login.
     */
    public function socialLogin()
    {
        // In reality, use Laravel Socialite here.
        // return Socialite::driver('google')->redirect();
        return redirect()->intended(route('student.events.index'));
    }
}
