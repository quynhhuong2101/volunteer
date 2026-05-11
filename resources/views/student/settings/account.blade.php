@extends('layouts.student')

@section('header', 'Cài đặt Tài khoản')

@section('content')
<div class="max-w-[1000px] mx-auto space-y-8 animate-fade-in-up">
    
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl p-4 flex items-center gap-3">
        <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 text-rose-600 rounded-2xl p-4 flex flex-col gap-2">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="font-medium">Có lỗi xảy ra, vui lòng kiểm tra lại:</p>
        </div>
        <ul class="list-disc pl-11 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-xl border border-white/50 overflow-hidden relative">
        <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 opacity-20"></div>

        <form action="{{ route('student.settings.update') }}" method="POST" enctype="multipart/form-data" class="relative z-10 p-8 md:p-10">
            @csrf
            
            <!-- Avatar Upload -->
            <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6 mb-12 -mt-2">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full p-1 bg-gradient-to-tr from-blue-500 to-purple-500 shadow-lg group-hover:scale-105 transition-transform duration-300">
                        @if($user->avatar && (str_starts_with($user->avatar, 'http') || file_exists(public_path($user->avatar))))
                            <img src="{{ $user->avatar_url }}" alt="Profile" class="w-full h-full rounded-full object-cover border-4 border-white bg-white">
                        @else
                            <div class="w-full h-full rounded-full bg-slate-200 border-4 border-white flex items-center justify-center text-slate-600 font-bold text-5xl shadow-inner">
                                {{ substr($user->name ?? 'U', 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <label for="avatar_upload" class="absolute bottom-1 right-1 bg-primary hover:bg-blue-600 text-white p-2.5 rounded-full shadow-lg cursor-pointer transition-colors transform hover:scale-110">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </label>
                    <input type="file" id="avatar_upload" name="avatar" class="hidden" accept="image/*">
                </div>
                <div class="text-center sm:text-left mb-2">
                     <h2 class="font-extrabold text-slate-800 text-2xl tracking-tight">{{ $user->name }}</h2>

                </div>
            </div>

            <!-- Section 1: Personal Info -->
            <div class="mb-12">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    Thông tin cá nhân
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Họ và tên</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Giới tính</label>
                        <select name="gender" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" {{ old('gender', $user->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gender', $user->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gender', $user->gender) == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Ngày sinh</label>
                        <input type="date" name="dob" value="{{ old('dob', $user->dob) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Số điện thoại</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm">
                    </div>
                    
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700">Email liên hệ</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700">Địa chỉ hiện tại</label>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm" placeholder="VD: 123 Đường ABC, Quận X, TP.HCM">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700">Giới thiệu bản thân</label>
                        <textarea name="bio" rows="4" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm resize-none" placeholder="Viết một chút về sở thích, kỹ năng hoặc mục tiêu của bạn...">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </div>
            </div>



            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 border-t border-slate-100 pt-8">
                <a href="{{ route('student.dashboard') }}" class="w-full sm:w-auto text-center px-6 py-3 rounded-xl font-bold text-slate-600 hover:bg-slate-100 transition-colors">Hủy bỏ</a>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-0.5 relative overflow-hidden group">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Lưu thay đổi
                    </span>
                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                </button>
            </div>

        </form>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>
@endsection
