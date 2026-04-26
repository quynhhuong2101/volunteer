@extends('layouts.organization')

@section('header', 'Cấu hình Đơn đăng ký')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- 1. Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Quản lý Đơn đăng ký</h1>
            <p class="text-slate-500 mt-1">Thiết lập câu hỏi và quy trình tuyển dụng cho các sự kiện.</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="relative group">
                <input type="text" placeholder="Tìm kiếm sự kiện..." class="pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 w-64 transition-all shadow-sm group-hover:shadow">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <a href="{{ route('organization.events.create') }}" class="px-5 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-dark hover:shadow-xl transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span>Tạo sự kiện</span>
            </a>
        </div>
    </div>

    <!-- 2. Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
        <div class="group bg-white rounded-2xl p-1 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="h-full bg-slate-50/50 rounded-xl p-5 flex flex-col relative overflow-hidden">
                
                <!-- Status Badge -->
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide {{ $event['status'] == 'Đang mở' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-slate-200 text-slate-600 border border-slate-300' }}">
                        @if($event['status'] == 'Đang mở')
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                        @endif
                        {{ $event['status'] }}
                    </span>
                </div>

                <!-- Event Info -->
                <div class="mb-6 mt-2">
                     <div class="w-14 h-14 rounded-2xl bg-white text-primary border border-slate-100 shadow-sm flex items-center justify-center font-black text-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                        {{ substr($event['name'], 0, 1) }}
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 line-clamp-2 min-h-[3.5rem] group-hover:text-primary transition-colors">
                        {{ $event['name'] }}
                    </h3>
                </div>

                <!-- Metrics -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Câu hỏi</span>
                        <div class="flex items-center gap-2 text-slate-700 font-bold">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            <span>{{ $event['questions_count'] }}</span>
                        </div>
                    </div>
                     <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ứng viên</span>
                        <div class="flex items-center gap-2 text-slate-700 font-bold">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            <span>--</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-auto pt-4 border-t border-slate-200/60">
                    @if($event['has_form'])
                        <a href="{{ route('organization.events.builder', ['id' => $event['id']]) }}" class="flex items-center justify-center w-full py-3 bg-indigo-50 border-2 border-indigo-100 hover:border-indigo-300 text-indigo-600 hover:text-indigo-700 font-bold rounded-xl transition-all shadow-sm group/btn">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover/btn:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Xem Form
                        </a>
                    @else
                        <a href="{{ route('organization.events.builder', ['id' => $event['id']]) }}" class="flex items-center justify-center w-full py-3 bg-white border-2 border-slate-100 hover:border-primary text-slate-600 hover:text-primary font-bold rounded-xl transition-all shadow-sm hover:shadow-md group/btn">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover/btn:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Thiết lập Form
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-100 border-dashed">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Chưa có sự kiện nào</h3>
            <p class="text-slate-500 mt-2 mb-6 max-w-sm mx-auto">Hãy tạo sự kiện mới để bắt đầu thiết lập quy trình tuyển dụng tình nguyện viên.</p>
            <a href="{{ route('organization.events.create') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tạo sự kiện ngay
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
