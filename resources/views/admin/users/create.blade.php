@extends('layouts.admin')

@section('header', 'Cấp tài khoản mới')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 mb-6 flex items-start gap-4">
        <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
            <h4 class="font-bold text-indigo-900 text-sm">Lưu ý quan trọng</h4>
            <p class="text-sm text-indigo-700 mt-1">Chức năng này chỉ dùng để tạo tài khoản cho <strong>Ban Tổ Chức (BTC)</strong> hoặc <strong>Quản trị viên</strong>. Sinh viên sẽ đăng ký tự động qua hệ thống SSO của trường.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-6">
                <!-- Name -->
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors" placeholder="Nhập tên đầy đủ (VD: CLB Tình nguyện UIT)" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email công vụ <span class="text-red-500">*</span></label>
                    <input type="email" name="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors" placeholder="user@domain.edu.vn" required>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Số điện thoại</label>
                    <input type="tel" name="phone" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors" placeholder="09xxxxxxx">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Vai trò hệ thống <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        <option value="organization">Tổ chức / CLB (Organizer)</option>
                        <option value="admin">Quản trị viên (Admin)</option>
                    </select>
                </div>

                <!-- Department -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Đơn vị / Khoa</label>
                    <input type="text" name="department" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors" placeholder="VD: Phòng Công tác Sinh viên">
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6">
                 <label class="block text-sm font-bold text-slate-700 mb-2">Mật khẩu khởi tạo</label>
                 <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-center justify-between">
                     <code class="text-lg font-mono font-bold text-slate-800">Volunteer@2024</code>
                     <span class="text-xs text-yellow-700 font-medium">Mặc định</span>
                 </div>
                 <p class="text-xs text-slate-400 mt-2">* Người dùng sẽ được yêu cầu đổi mật khẩu trong lần đăng nhập đầu tiên.</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-colors">Hủy bỏ</a>
                <button type="submit" class="px-6 py-3 rounded-xl font-bold text-white bg-indigo-600 shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Tạo tài khoản
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
