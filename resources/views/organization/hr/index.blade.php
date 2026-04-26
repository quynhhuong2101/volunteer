@extends('layouts.organization')

@section('header', 'Quản lý Nhân sự - Chọn Chiến dịch')

@section('content')
<div class="max-w-7xl mx-auto space-y-8" x-data="{ activeTab: 'open', search: '' }">
    
    <!-- 1. HERO HEADER with Premium Gradient -->
    <div class="relative bg-gradient-to-br from-indigo-900 via-blue-900 to-indigo-800 rounded-[2.5rem] p-10 overflow-hidden shadow-2xl text-white">
        <!-- Decorative Background Elements -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-blue-500 opacity-20 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-3 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 backdrop-blur-md text-xs font-bold uppercase tracking-wider text-indigo-100 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Hệ thống Nhân sự
                </div>
                <h1 class="text-4xl font-black tracking-tight leading-tight"><span class="text-white">Quản lý</span> <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-200 to-blue-200">Tình Nguyện Viên</span></h1>
                <p class="text-indigo-100/80 text-lg">Hệ thống hợp nhất giúp bạn duyệt hồ sơ, điều phối đội nhóm và theo dõi tiến độ nhân sự của tất cả chiến dịch.</p>
            </div>
            
             <!-- Quick Stats -->
             <div class="hidden md:flex gap-4">
                 <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 flex flex-col items-center justify-center w-28">
                    <span class="text-3xl font-black">{{ count($events) }}</span>
                    <span class="text-[10px] uppercase font-bold text-indigo-200 mt-1">Chiến dịch</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar: Search & Tabs -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
        
        <!-- Search Bar -->
        <div class="relative w-full md:max-w-md group p-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" 
                   x-model="search"
                   class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl leading-5 text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 sm:text-sm transition-all duration-300" 
                   placeholder="Tìm kiếm chiến dịch..." />
        </div>

        <!-- Tab Controls -->
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl overflow-x-auto max-w-full">
            <button @click="activeTab = 'open'" :class="activeTab === 'open' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-200'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-300 flex items-center gap-2 whitespace-nowrap">
                 <span class="w-2 h-2 rounded-full" :class="activeTab === 'open' ? 'bg-emerald-500' : 'bg-slate-300'"></span>
                 Đang mở
            </button>
            <button @click="activeTab = 'closed'" :class="activeTab === 'closed' ? 'bg-white text-slate-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-300 flex items-center gap-2 whitespace-nowrap">
                 <span class="w-2 h-2 rounded-full" :class="activeTab === 'closed' ? 'bg-slate-500' : 'bg-slate-300'"></span>
                 Đã đóng
            </button>
            <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-200'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-300 whitespace-nowrap">
                 Tất cả
            </button>
        </div>
    </div>

    <!-- 2. CAMPAIGN LIST GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-20">
        @foreach($events as $event)
        
        @php
            $isOpening = $event['status'] == 'Đang mở';
            $statusColors = [
                'success' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                'secondary' => 'bg-slate-50 text-slate-600 border-slate-100',
            ];
            $badgeClass = $statusColors[$event['status_color']] ?? $statusColors['secondary'];
        @endphp

        <!-- Deluxe Card Design -->
        <div x-show="(activeTab === 'all' || (activeTab === 'open' && '{{ $event['status'] }}' === 'Đang mở') || (activeTab === 'closed' && '{{ $event['status'] }}' !== 'Đang mở')) && '{{ strtolower($event['name']) }}'.includes(search.toLowerCase())"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="group relative bg-white rounded-[2.5rem] p-1 border border-slate-100 shadow-lg hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 hover:-translate-y-1 h-full">
            
            <!-- Card Decoration -->
            <div class="absolute inset-0 bg-gradient-to-br from-white via-slate-50/30 to-indigo-50/20 rounded-[2.5rem] z-0"></div>
            
            <div class="relative z-10 flex flex-col h-full bg-white/60 backdrop-blur-sm rounded-[2.3rem] p-6">
                
                <!-- Status & Icon -->
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xl shadow-inner group-hover:scale-110 transition-transform duration-500 border border-indigo-100/50">
                        {{ substr($event['name'], 0, 1) }}
                    </div>
                     <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider border {{ $badgeClass }}">
                        {{ $event['status'] }}
                    </span>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-black text-slate-800 mb-2 leading-tight group-hover:text-indigo-700 transition-colors line-clamp-2 min-h-[3rem]">
                        {{ $event['name'] }}
                    </h3>
                    
                    <div class="flex items-center gap-2 text-slate-500 text-xs font-bold mb-6">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        {{ \Carbon\Carbon::parse($event['start_time'])->format('d/m/Y') }}
                    </div>

                    <!-- Applicant Stats Bar -->
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 mb-2 group-hover:border-indigo-100 transition-colors">
                        <div class="flex justify-between items-end mb-2">
                             <div class="flex flex-col">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nhân sự</span>
                                <span class="text-xs font-bold text-indigo-600 mt-0.5">Duyệt: {{ $event['verified_count'] }}</span>
                             </div>
                             <span class="text-2xl font-black text-slate-800">{{ $event['applicants_count'] }}</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                             <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $event['applicants_count'] > 0 ? min(($event['verified_count'] / $event['applicants_count']) * 100, 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <a href="{{ route('organization.hr.manage', ['id' => $event['id']]) }}" class="mt-4 relative w-full group/btn overflow-hidden rounded-xl p-[1px]">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-600 bg-[length:200%_100%] animate-gradient opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                    <div class="relative w-full h-full bg-slate-50 hover:bg-white group-hover/btn:bg-white rounded-[11px] px-4 py-3 flex items-center justify-center gap-2 transition-colors border border-slate-200 group-hover/btn:border-transparent">
                        <span class="font-bold text-xs text-slate-600 group-hover/btn:text-indigo-700 uppercase tracking-wide">Quản lý Nhân sự</span>
                        <svg class="w-4 h-4 text-slate-400 group-hover/btn:text-indigo-700 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </div>
                </a>

            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
