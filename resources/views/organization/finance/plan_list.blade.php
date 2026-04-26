@extends('layouts.organization')

@section('header', 'Quản lý Ngân sách & Dự trù')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ activeTab: 'all', search: '' }">
    
    <!-- Hero Section -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-50"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-black text-slate-800 mb-2">Danh sách Dự trù Ngân sách</h2>
            <p class="text-slate-500 max-w-xl">Quản lý và lập kế hoạch tài chính cho các chiến dịch. Theo dõi các khoản thu chi và trạng thái duyệt ngân sách.</p>
        </div>
        <div class="relative z-10 flex gap-4">
             <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center w-32">
                <span class="text-2xl font-black text-indigo-600">{{ $events->count() }}</span>
                <span class="text-xs font-bold text-slate-400 uppercase">Chiến dịch</span>
             </div>
             <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col items-center w-32">
                <span class="text-2xl font-black text-emerald-600">{{ $events->filter(function($e) { return $e->budget && $e->budget->status == 'approved'; })->count() }}</span>
                <span class="text-xs font-bold text-slate-400 uppercase">Đã duyệt</span>
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

    <!-- Events Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="p-5 font-bold">Chiến dịch / Sự kiện</th>
                        <th class="p-5 font-bold">Thời gian</th>
                        <th class="p-5 font-bold">Trạng thái Ngân sách</th>
                        <th class="p-5 font-bold text-center">Tổng dự trù</th>
                        <th class="p-5 font-bold text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($events as $event)
                    <tr class="group hover:bg-slate-50/50 transition-colors" 
                        x-show="(activeTab === 'all' || (activeTab === 'open' && '{{ $event->status }}' === 'approved') || (activeTab === 'closed' && '{{ $event->status }}' !== 'approved')) && '{{ strtolower($event->title) }}'.includes(search.toLowerCase())">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-slate-500">
                                    {{ substr($event->title, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $event->title }}</h4>
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-md {{ $event->status == 'approved' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $event->status == 'approved' ? 'Đang hoạt động' : 'Đã đóng/Chờ' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="flex flex-col text-sm">
                                <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y') }}</span>
                                <span class="text-xs text-slate-400">Bắt đầu</span>
                            </div>
                        </td>
                        <td class="p-5">
                            @php $status = $event->budget->status ?? 'draft'; @endphp
                            @if($status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-600 border border-yellow-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                Chờ duyệt
                            </span>
                            @elseif($status == 'approved')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Đã duyệt
                            </span>
                            @elseif($status == 'rejected')
                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Từ chối
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                Chưa gửi
                            </span>
                            @endif
                        </td>
                         <td class="p-5 text-center">
                            @if($event->budget && $event->budget->total_estimated > 0)
                                <span class="font-mono font-bold text-slate-600">{{ number_format($event->budget->total_estimated) }}đ</span>
                            @else
                                <span class="font-mono font-bold text-slate-400">--</span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="#" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Xem chi tiết">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                                <a href="{{ route('organization.finance.plan.detail', $event->id) }}" class="p-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white rounded-lg transition-all shadow-sm" title="Lập dự trù">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-slate-400">
                            Chưa có chiến dịch nào. Vui lòng tạo chiến dịch trước.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


