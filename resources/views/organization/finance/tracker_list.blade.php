@extends('layouts.organization')

@section('header', 'Theo dõi Chi tiêu')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ activeTab: 'all', search: '' }">
    
    <!-- Hero Section -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-orange-50 opacity-50"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-black text-slate-800 mb-2">Sổ Thu Chi Chiến dịch</h2>
            <p class="text-slate-500 max-w-xl">Theo dõi chi tiết các khoản chi tiêu thực tế, tải lên hóa đơn chứng từ và kiểm soát ngân sách theo thời gian thực.</p>
        </div>
        <div class="relative z-10 flex gap-4">
             <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center w-40">
                <span class="text-2xl font-black text-blue-600">{{ $events->count() }}</span>
                <span class="text-xs font-bold text-slate-400 uppercase">Đang theo dõi</span>
             </div>
        </div>
    </div>

    <!-- Toolbar: Search & Tabs -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
        
        <!-- Search Bar -->
        <div class="relative w-full md:max-w-md group p-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" 
                   x-model="search"
                   class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl leading-5 text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-400 sm:text-sm transition-all duration-300" 
                   placeholder="Tìm kiếm chiến dịch..." />
        </div>

        <!-- Tab Controls -->
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl overflow-x-auto max-w-full">
            <button @click="activeTab = 'open'" :class="activeTab === 'open' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-500 hover:text-blue-600 hover:bg-slate-200'" class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-300 flex items-center gap-2 whitespace-nowrap">
                 <span class="w-2 h-2 rounded-full" :class="activeTab === 'open' ? 'bg-blue-500' : 'bg-slate-300'"></span>
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

    <!-- Events Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="p-5 font-bold">Chiến dịch / Sự kiện</th>
                        <th class="p-5 font-bold">Tiến độ Ngân sách</th>
                        <th class="p-5 font-bold text-center">Đã chi</th>
                        <th class="p-5 font-bold text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($events as $event)
                    <tr class="group hover:bg-slate-50/50 transition-colors" 
                        x-show="(activeTab === 'all' || (activeTab === 'open' && '{{ $event->status }}' === 'approved') || (activeTab === 'closed' && '{{ $event->status }}' !== 'approved')) && '{{ strtolower($event->title) }}'.includes(search.toLowerCase())">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                    {{ substr($event->title, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $event->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-bold px-2 py-0.5 rounded-md {{ $event->status == 'approved' ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $event->status == 'approved' ? 'Đang hoạt động' : 'Đã đóng' }}
                                        </span>
                                        <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 w-1/3">
                            <!-- Real Spending Progress -->
                            @php 
                                $budgetTotal = $event->budget ? $event->budget->total_approved : 0;
                                $budgetUsed = $event->expenses_sum_amount ?? 0;
                                $progress = $budgetTotal > 0 ? ($budgetUsed / $budgetTotal) * 100 : 0;
                            @endphp
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-500">Đã dùng {{ round($progress, 1) }}%</span>
                                    <span class="text-slate-800">{{ number_format($budgetTotal) }}đ</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                     <div class="h-full rounded-full {{ $progress > 100 ? 'bg-red-500' : 'bg-orange-500' }}" style="width: {{ min($progress, 100) }}%"></div>
                                </div>
                            </div>
                        </td>
                         <td class="p-5 text-center">
                            <span class="font-bold text-slate-700">{{ number_format($budgetUsed) }}đ</span>
                        </td>
                        <td class="p-5 text-right">
                            <a href="{{ route('organization.finance.tracker.detail', $event->id) }}" class="p-2 bg-orange-50 text-orange-600 hover:bg-orange-100 rounded-lg transition-all shadow-sm" title="Theo dõi">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-slate-400">
                            Chưa có chiến dịch nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


