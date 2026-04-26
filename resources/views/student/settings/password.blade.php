@extends('layouts.student')

@section('header', 'Đổi Mật khẩu')

@section('content')
<div class="max-w-[800px] mx-auto">
    
    <div class="bg-white rounded-[2.5rem] p-8 shadow-card border border-slate-100">
        <h2 class="text-2xl font-extrabold text-slate-800 mb-8 flex items-center gap-3">
             <span class="bg-red-100 text-red-600 p-2.5 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </span>
            Bảo mật & Mật khẩu
        </h2>

        <form action="{{ route('student.settings.updatePassword') }}" method="POST">
            @csrf
            
            <div class="space-y-6 mb-8">
                
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Mật khẩu hiện tại</label>
                    <div class="relative">
                        <input type="password" name="current_password" class="w-full bg-slate-50 border-none rounded-xl px-5 py-3 text-slate-700 font-bold focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all shadow-inner" placeholder="••••••••">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Mật khẩu mới</label>
                    <div class="relative">
                        <input type="password" name="password" class="w-full bg-slate-50 border-none rounded-xl px-5 py-3 text-slate-700 font-bold focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all shadow-inner" placeholder="Tối thiểu 8 ký tự">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Xác nhận mật khẩu mới</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" class="w-full bg-slate-50 border-none rounded-xl px-5 py-3 text-slate-700 font-bold focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all shadow-inner" placeholder="••••••••">
                    </div>
                </div>

                <div class="bg-blue-50 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-bold mb-1">Yêu cầu mật khẩu:</p>
                        <ul class="list-disc list-inside space-y-0.5 opacity-80">
                            <li>Ít nhất 8 ký tự</li>
                            <li>Bao gồm chữ hoa và chữ thường</li>
                            <li>Bao gồm số hoặc ký tự đặc biệt</li>
                        </ul>
                    </div>
                </div>

            </div>

             <div class="flex items-center justify-end gap-4 border-t border-slate-100 pt-6">
                <button type="button" onclick="history.back()" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-50 transition-colors">Hủy bỏ</button>
                <button type="submit" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-700 shadow-lg shadow-slate-900/20 transition-all transform hover:-translate-y-1">Đổi mật khẩu</button>
            </div>

        </form>
    </div>
</div>
@endsection
