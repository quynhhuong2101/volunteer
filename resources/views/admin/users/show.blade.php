@extends('layouts.admin')

@section('header', 'Hồ sơ Chi tiết')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Profile Header -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden relative">
        <!-- Cover Art -->
        <div class="h-48 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
            <div class="absolute inset-0 opacity-30 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
            <div class="absolute bottom-4 right-6 text-white/80 text-xs font-bold uppercase tracking-widest hidden md:block">
                Member Profile #{{ $user['id'] }}
            </div>
            <a href="{{ route('admin.users.index') }}" class="absolute top-6 left-6 text-white/90 hover:text-white flex items-center gap-2 hover:bg-white/10 px-3 py-1.5 rounded-lg transition-all z-20">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                <span class="text-sm font-bold">Quay lại</span>
            </a>
        </div>

        <!-- User Info -->
        <div class="px-8 pb-8 relative">
            <div class="flex flex-col md:flex-row gap-6 relative -mt-16">
                <!-- Avatar -->
                <div class="relative group">
                    <img src="{{ $user['avatar'] }}&size=200" class="w-32 h-32 md:w-40 md:h-40 rounded-[2rem] border-4 border-white shadow-xl bg-white object-cover">
                    <div class="absolute bottom-2 right-2 w-5 h-5 rounded-full border-[3px] border-white {{ $user['status'] == 'Active' ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
                </div>

                <!-- Name & Role -->
                <div class="flex-1 pt-16 md:pt-18 md:mt-2">
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">{{ $user['name'] }}</h1>
                    <div class="flex items-center gap-3 mt-1 text-sm font-bold text-slate-500">
                        <span class="bg-slate-100 px-3 py-1 rounded-lg text-slate-600">{{ $user['role'] }}</span>
                        <span>•</span>
                        <span>{{ $user['phone'] }}</span>
                        <span>•</span>
                        <span class="text-slate-400">Tham gia {{ \Carbon\Carbon::parse($user['joined_at'])->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 md:pt-20 flex gap-3">
                     <form action="{{ route('admin.users.resetPassword', $user['id']) }}" method="POST" onsubmit="return confirm('Đặt lại mật khẩu?');">
                        @csrf
                        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:text-indigo-600 hover:border-indigo-200 rounded-xl font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                            Reset Password
                        </button>
                    </form>
                    <form action="{{ route('admin.users.toggleStatus', $user['id']) }}" method="POST">
                        @csrf
                        @if($user['status'] == 'Active')
                        <button class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Khóa
                        </button>
                        @else
                        <button class="px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-xl font-bold text-sm shadow-sm transition-all flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
                            Mở Khóa
                        </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Stats & Info -->
        <div class="space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform">
                     <p class="text-xs font-bold text-slate-400 uppercase">Sự kiện</p>
                     <p class="text-2xl font-black text-slate-800 mt-1">{{ $user['stats']['events_joined'] }}</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform">
                     <p class="text-xs font-bold text-slate-400 uppercase">Giờ làm</p>
                     <p class="text-2xl font-black text-blue-600 mt-1">{{ $user['stats']['hours_volunteered'] }}</p>
                </div>
                <div class="col-span-2 bg-gradient-to-br from-indigo-500 to-purple-600 p-5 rounded-2xl shadow-lg text-white relative overflow-hidden">
                     <div class="absolute top-0 right-0 p-4 opacity-10"><svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></div>
                     <p class="text-xs font-bold text-white/70 uppercase">Điểm tín nhiệm</p>
                     <p class="text-3xl font-black mt-1">{{ number_format($user['stats']['integrity_score']) }}</p>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Thông tin</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700 truncate">{{ $user['email'] }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500">
                             <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">{{ $user['phone'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wider">Kỹ năng</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($user['portfolio']['skills'] as $skill)
                    <span class="px-3 py-1 bg-slate-50 text-slate-600 rounded-lg text-xs font-bold border border-slate-100">
                        {{ $skill }}
                    </span>
                    @empty
                    <span class="text-xs text-slate-400 italic">Chưa cập nhật</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Timeline & Certificates -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Timeline -->
             <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                     <h3 class="font-bold text-slate-800 text-lg">Hoạt động gần đây</h3>
                     <a href="#" class="text-xs font-bold text-indigo-600 hover:underline">Xem tất cả</a>
                </div>

                <div class="relative pl-8 border-l-2 border-indigo-100 space-y-8">
                    @forelse($user['portfolio']['timeline'] as $item)
                    <div class="relative group">
                        <span class="absolute -left-[39px] top-1.5 w-5 h-5 rounded-full bg-white border-4 border-indigo-100 group-hover:border-indigo-500 transition-colors"></span>
                        <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-1">
                             <h4 class="font-bold text-slate-800 text-base group-hover:text-indigo-600 transition-colors">{{ $item['event'] }}</h4>
                             <span class="text-xs font-bold text-slate-400 whitespace-nowrap">{{ $item['date'] }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-1">{{ $item['role'] }}</p>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <p class="text-slate-400 text-sm italic">Chưa có hoạt động nào được ghi nhận.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Certificates -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 text-lg mb-6">Chứng chỉ & Giải thưởng</h3>
                <div class="space-y-4">
                     @forelse($user['portfolio']['certificates'] as $cert)
                    <div class="flex items-center gap-4 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 hover:shadow-md transition-all cursor-pointer group">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-emerald-500 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        </div>
                        <div class="flex-1">
                            <h5 class="font-bold text-slate-800">{{ $cert['name'] }}</h5>
                            <p class="text-xs text-slate-500 mt-0.5">Cấp ngày: <span class="font-bold">{{ $cert['date'] }}</span></p>
                        </div>
                        <span class="text-xs font-bold text-emerald-600 bg-white px-3 py-1 rounded-full shadow-sm">Verified</span>
                    </div>
                    @empty
                    <p class="text-slate-400 text-sm italic">Chưa có chứng chỉ nào.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
