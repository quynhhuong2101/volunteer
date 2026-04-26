@extends('layouts.organization')

@section('header', 'Bảng điều khiển thông minh')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-12">
    
    <!-- Hero Header -->
    <div class="relative overflow-hidden bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-accent/5 rounded-full blur-2xl"></div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Chào mừng trở lại, <span class="text-primary">{{ Auth::user()->name ?? 'Ban Tổ Chức' }}</span>! 🚀</h2>
                <p class="text-slate-500 mt-2 font-medium">Hôm nay là {{ now()->translatedFormat('l, d/m/Y') }}. Hãy xem các dự án của bạn đang tiến triển thế nào.</p>
                
                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-6">
                    <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-2xl border border-slate-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-bold text-slate-600">{{ $stats['active_events'] }} Sự kiện đang chạy</span>
                    </div>
                    <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-2xl border border-slate-100">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="text-xs font-bold text-slate-600">{{ $stats['total_tasks'] - $stats['completed_tasks'] }} Nhiệm vụ chờ xử lý</span>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('organization.events.create') }}" class="group px-6 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/25 hover:scale-105 transition-all flex items-center gap-3">
                    <div class="p-1.5 bg-white/20 rounded-lg group-hover:rotate-90 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    Tạo sự kiện mới
                </a>
            </div>
        </div>
    </div>

    <!-- Warnings & SOS Section (Conditional) -->
    @if((isset($warnings) && count($warnings) > 0) || (isset($sos_alerts) && count($sos_alerts) > 0))
    <div class="grid grid-cols-1 gap-4">
        @foreach($warnings as $warning)
        <div class="rounded-2xl p-5 border-l-4 flex items-center gap-5 shadow-sm 
            @if($warning->severity == 'ban') bg-rose-50 border-rose-500 text-rose-900
            @elseif($warning->severity == 'warning') bg-amber-50 border-amber-500 text-amber-900
            @else bg-blue-50 border-blue-500 text-blue-900 @endif">
            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm">
                @if($warning->severity == 'ban')<svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                @elseif($warning->severity == 'warning')<svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                @else<svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>@endif
            </div>
            <div class="flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-black text-sm uppercase tracking-wider opacity-60">{{ $warning->severity == 'ban' ? 'Lưu ý khẩn cấp' : 'Cảnh báo hệ thống' }}</h3>
                        <p class="font-bold text-lg mt-0.5">{{ $warning->title }}</p>
                    </div>
                    <form action="{{ route('organization.warnings.read', $warning->id) }}" method="POST">
                        @csrf
                        <button class="bg-white/50 hover:bg-white p-2 rounded-lg transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Smart KPI Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Quick Insight: Total Reach -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:border-primary/20 hover:shadow-xl hover:shadow-primary/5 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:bg-primary group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">TỔNG NHÂN SỰ</span>
                    <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full mt-1">+12%</span>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h3 class="text-4xl font-black text-slate-800 tabular-nums leading-none">{{ number_format($stats['total_volunteers']) }}</h3>
                <span class="text-slate-400 font-bold text-sm">thành viên</span>
            </div>
            <!-- Small trend chart -->
            <div class="mt-4 flex items-end gap-1 h-8">
                @foreach($stats['trends'] as $trend)
                <div class="flex-1 bg-indigo-100 rounded-t-sm group-hover:bg-primary/20 transition-all" style="height: {{ max(10, min(100, $trend['count'] * 10)) }}%"></div>
                @endforeach
            </div>
        </div>

        <!-- Quick Insight: Task Performance -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all relative overflow-hidden group">
            <div class="absolute right-0 bottom-0 p-2 opacity-[0.03] group-hover:scale-110 transition-transform">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">HIỆU SUẤT CÔNG VIỆC</span>
                    <div class="text-2xl font-black text-slate-800">{{ $stats['task_progress'] }}%</div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-amber-500 h-2 rounded-full shadow-sm" style="width: {{ $stats['task_progress'] }}%"></div>
                </div>
                <p class="text-xs text-slate-500 font-medium italic">Đã hoàn thành {{ $stats['completed_tasks'] }}/{{ $stats['total_tasks'] }} nhiệm vụ.</p>
            </div>
        </div>

        <!-- Quick Insight: Budget Health -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 transition-all group">
            <div class="flex items-center gap-4 mb-4">
                <div class="p-3 bg-cyan-50 text-cyan-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">TÀI CHÍNH DỰ ÁN</span>
                    <div class="text-2xl font-black text-slate-800">{{ number_format($stats['budget_total'] > 0 ? ($stats['budget_used'] / $stats['budget_total']) * 100 : 0, 1) }}%</div>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-tighter">Đã giải ngân:</span>
                <span class="text-lg font-black text-cyan-600">{{ number_format($stats['budget_used'], 0, ',', '.') }}đ</span>
                <span class="text-[10px] font-medium text-slate-400 italic">Tổng dự toán: {{ number_format($stats['budget_total'], 0, ',', '.') }}đ</span>
            </div>
        </div>

        <!-- Quick Insight: Satisfaction -->
        <div class="bg-slate-900 p-6 rounded-3xl shadow-2xl transition-all relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-primary/20 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-white/10 text-yellow-400 rounded-2xl">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">ĐỘ HÀI LÒNG</span>
                </div>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-black text-white leading-none">{{ $stats['avg_rating'] }}</h3>
                    <span class="text-slate-500 font-bold text-sm">/ 5.0</span>
                </div>
                <p class="text-xs text-slate-400 mt-4 font-medium italic">Vượt 0.2% so với tháng trước.</p>
            </div>
        </div>
    </div>

    <!-- Middle Section: Main Operations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Project Status Tracker -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-8 bg-primary rounded-full"></div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight">Theo dõi Dự án</h3>
                </div>
                <a href="{{ route('organization.events.index') }}" class="group text-sm font-bold text-primary flex items-center gap-2 px-4 py-2 hover:bg-primary/5 rounded-xl transition-all">
                    Tất cả sự kiện
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 gap-5">
                @foreach($upcoming_events as $event)
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all p-6 relative group overflow-hidden">
                    <div class="absolute top-0 right-0 p-4">
                        @if($event['status'] == 'Đang diễn ra')
                            <span class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-black ring-1 ring-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                TRỰC TIẾP
                            </span>
                        @else
                            <span class="px-3 py-1 bg-slate-50 text-slate-500 rounded-full text-xs font-black">SẮP DIỄN RA</span>
                        @endif
                    </div>

                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Left: Visual & Time -->
                        <div class="w-full md:w-48 flex-shrink-0">
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex flex-col items-center justify-center text-center group-hover:bg-primary/5 transition-colors">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Thời gian</span>
                                <div class="text-3xl font-black text-slate-800 tracking-tighter">{{ \Carbon\Carbon::createFromFormat('d/m/Y', $event['date'])->format('d') }}</div>
                                <div class="text-sm font-bold text-primary uppercase">{{ \Carbon\Carbon::createFromFormat('d/m/Y', $event['date'])->translatedFormat('M, Y') }}</div>
                                <div class="mt-2 text-[10px] font-bold text-slate-400 bg-white px-3 py-1 rounded-full shadow-sm">{{ $event['time'] }}</div>
                            </div>
                        </div>

                        <!-- Center: Core Info -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h4 class="text-xl font-black text-slate-800 line-clamp-1 group-hover:text-primary transition-colors">{{ $event['name'] }}</h4>
                                <div class="flex items-center gap-4 text-slate-500 mt-2">
                                    <span class="flex items-center gap-1.5 text-xs font-bold">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                        {{ $event['location'] }}
                                    </span>
                                </div>
                            </div>

                            <!-- Recruiting Progress -->
                            <div class="space-y-2">
                                <div class="flex justify-between items-end">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tiến độ tuyển dụng</span>
                                    <span class="text-sm font-black text-slate-800 tabular-nums">{{ $event['volunteers_registered'] }} <span class="text-slate-400 font-medium whitespace-nowrap">/ {{ $event['volunteers_needed'] }}</span></span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden p-0.5">
                                    <div class="bg-gradient-to-r from-primary to-indigo-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ min(100, ($event['volunteers_registered'] / $event['volunteers_needed']) * 100) }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Action -->
                        <div class="flex flex-col justify-center items-center gap-3 w-full md:w-32">
                           <a href="{{ route('organization.hr.index') }}" class="w-full py-3 px-4 bg-slate-900 text-white rounded-2xl text-xs font-black text-center shadow-lg hover:bg-primary transition-all">ĐIỀU PHỐI</a>
                           <a href="{{ route('organization.events.index') }}" class="w-full py-3 px-4 bg-white border border-slate-100 text-slate-600 rounded-2xl text-xs font-black text-center hover:border-primary hover:text-primary transition-all">CHI TIẾT</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Real-time Pulse -->
        <div class="space-y-6">
            <div class="px-2">
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Hoạt động mới nhất ⏱️</h3>
            </div>
            
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-3 space-y-2">
                @foreach($activities as $activity)
                <div class="group p-4 hover:bg-slate-50 rounded-[1.8rem] transition-all flex items-center gap-4">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary font-black text-lg group-hover:scale-110 transition-transform">
                            {{ $activity['avatar'] }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-white rounded-full flex items-center justify-center shadow-sm">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] leading-tight text-slate-600">
                            <span class="font-black text-slate-800">{{ $activity['user'] }}</span> 
                            {{ $activity['action'] }} 
                        </p>
                        <p class="text-[14px] font-bold text-primary truncate mt-0.5">{{ $activity['target'] }}</p>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1.5">{{ $activity['time'] }}</p>
                    </div>
                </div>
                @endforeach
                
                <button class="w-full py-5 text-xs font-black text-slate-400 hover:text-primary transition-colors tracking-[0.3em] uppercase">Xem thêm hoạt động</button>
            </div>

            <!-- Promotion Card -->
            <div class="group relative bg-gradient-to-br from-indigo-600 via-primary to-blue-700 rounded-[2.5rem] p-8 text-white overflow-hidden shadow-2xl">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h3 class="text-2xl font-black leading-tight mb-2">Tăng tốc dự án của bạn!</h3>
                    <p class="text-white/70 text-sm font-medium mb-8">Sử dụng các công cụ hỗ trợ thông minh để quản lý tình nguyện viên hiệu quả hơn.</p>
                    <div class="mt-auto flex flex-col gap-3">
                        <button class="w-full py-4 bg-white text-primary rounded-2xl font-black text-xs tracking-widest hover:shadow-xl transition-all">TÀI LIỆU HƯỚNG DẪN</button>
                        <button class="w-full py-4 bg-primary-dark/30 text-white border border-white/20 rounded-2xl font-black text-xs tracking-widest hover:bg-white/10 transition-all">LIÊN HỆ HỖ TRỢ</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .animate-bounce-short {
        animation: bounce-short 2s ease-in-out infinite;
    }
</style>
@endsection
