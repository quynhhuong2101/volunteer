@extends('layouts.organization')

@section('header', 'Điểm danh')

@section('content')
<div class="max-w-7xl mx-auto space-y-8" x-data="{ search: '' }">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Điểm danh Sự kiện</h2>
            <p class="text-slate-500 mt-2 font-medium">Quản lý và theo dõi điểm danh thời gian thực cho các sự kiện đang diễn ra.</p>
        </div>
        
        <!-- Search Bar -->
        <div class="relative w-full md:w-72 group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <input type="text" x-model="search" class="block w-full pl-10 pr-3 py-2.5 border-none rounded-xl bg-white shadow-sm ring-1 ring-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-indigo-50/10 transition-all font-medium" placeholder="Tìm kiếm sự kiện...">
        </div>
    </div>

    @if(count($events) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
        <div x-show="search === '' || '{{ strtolower($event['name']) }}'.includes(search.toLowerCase())" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="group bg-white rounded-3xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_25px_-5px_rgba(0,0,0,0.1),0_10px_10px_-5px_rgba(0,0,0,0.04)] border border-slate-100 hover:border-indigo-100 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
            
            <!-- Decoration Gradient -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-full blur-2xl -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>

            <div class="relative z-10 flex flex-col h-full">
                <!-- Status & Date -->
                <div class="flex justify-between items-start mb-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $event['status'] == 'Đang diễn ra' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $event['status'] == 'Đang diễn ra' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                        {{ $event['status'] }}
                    </span>
                    <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">{{ $event['date'] }}</span>
                </div>

                <!-- Title -->
                <h3 class="text-xl font-bold text-slate-800 mb-2 line-clamp-2 leading-tight group-hover:text-indigo-600 transition-colors">{{ $event['name'] }}</h3>
                
                <!-- Location -->
                <p class="text-slate-500 flex items-start gap-2 text-sm mb-6">
                    <svg class="w-4 h-4 mt-0.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <span class="line-clamp-1">{{ $event['location'] }}</span>
                </p>

                <div class="mt-auto">
                    <!-- Progress Bar (Fake Data for Visual) -->
                    <div class="flex justify-between text-xs font-bold text-slate-500 mb-1">
                        <span>Tiến độ điểm danh</span>
                        <span class="text-indigo-600">--%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 mb-6 overflow-hidden">
                        <div class="bg-indigo-500 h-2 rounded-full w-[0%] group-hover:w-[60%] transition-all duration-1000 ease-out"></div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Đăng ký</span>
                            <span class="text-lg font-black text-slate-800">{{ $event['registered'] }} <span class="text-xs text-slate-400 font-medium normal-case">người</span></span>
                        </div>
                        <a href="{{ route('organization.attendance.show', $event['id']) }}" class="px-5 py-2.5 bg-slate-900 hover:bg-indigo-600 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-indigo-500/30 flex items-center group/btn">
                            Bắt đầu
                            <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-slate-100">
        <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Chưa có sự kiện nào</h3>
        <p class="text-slate-500 mb-6 max-w-md mx-auto">Hiện tại chưa có sự kiện nào đang diễn ra hoặc đã được duyệt để điểm danh. Vui lòng tạo sự kiện mới hoặc chờ phê duyệt.</p>
        <a href="{{ route('organization.events.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tạo sự kiện mới
        </a>
    </div>
    @endif
</div>
@endsection


