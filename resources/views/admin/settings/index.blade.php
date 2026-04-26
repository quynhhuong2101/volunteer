@extends('layouts.admin')

@section('header', 'Cài đặt chung')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 relative" role="alert">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <!-- Preferences -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 space-y-8">
            
            <!-- Language & Region -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Ngôn ngữ & Khu vực
                </h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="font-bold text-sm text-slate-600">Ngôn ngữ hiển thị</label>
                            <select name="language" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all font-medium text-slate-800 bg-white">
                                <option value="vi">Tiếng Việt</option>
                                <option value="en">English (US)</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-sm text-slate-600">Múi giờ</label>
                            <select name="timezone" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all font-medium text-slate-800 bg-white">
                                <option value="Asia/Ho_Chi_Minh">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                <option value="UTC">(GMT+00:00) UTC</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            <!-- Notifications -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    Cài đặt thông báo
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Thông báo email</h4>
                            <p class="text-xs text-slate-500">Nhận email về hoạt động sự kiện mới</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Thông báo trình duyệt</h4>
                            <p class="text-xs text-slate-500">Hiển thị popup khi có đơn đăng ký mới</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            <!-- Privacy -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Riêng tư & Hiển thị
                </h3>
                <div class="space-y-4">
                     <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Yêu cầu xác thực hai bước (2FA)</h4>
                            <p class="text-xs text-slate-500">Tăng cường bảo mật cho tài khoản quản trị</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
                </div>
            </div>
            
            <div class="border-t border-slate-100"></div>

            <!-- Security -->
            <div>
                 <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Bảo mật
                </h3>
            </div>
            
        </div>
    </form>

    <!-- Password Change Form Separate -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
        <h4 class="font-bold text-slate-800 text-sm mb-4">Đổi mật khẩu</h4>
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4"> 
            <!-- Note: route('admin.settings.update') in web.php might need to distinguish password update vs settings update or use separate route. 
                 Wait, I implemented updatePassword in Controller but didn't add specific route for it in web.php yet, 
                 or did I? I added 'settings' POST. Let me check web.php again. 
                 Ah, I need a specific route for password or handle both in one. 
                 Best practice: Separate route. 
                 Checking web.php... I added post 'settings' to 'update'. 
                 I should add post 'settings/password' to 'updatePassword'. 
            -->
            @csrf
            <div class="space-y-1">
                <label class="font-bold text-sm text-slate-600">Mật khẩu hiện tại</label>
                <input type="password" name="current_password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="font-bold text-sm text-slate-600">Mật khẩu mới</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="font-bold text-sm text-slate-600">Nhập lại mật khẩu mới</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all">
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" formaction="{{ route('admin.settings.password') }}" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-slate-700 transition-all shadow-lg shadow-slate-500/30">
                    Đổi mật khẩu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
