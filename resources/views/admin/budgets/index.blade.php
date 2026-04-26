@extends('layouts.admin')

@section('header', 'Kiểm soát Tài chính')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ currentTab: 'all' }">
    
    <!-- Financial Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-xl shadow-indigo-600/20">
            <div class="flex items-start justify-between">
                <div>
                   <p class="text-indigo-200 text-xs font-bold uppercase tracking-wider">Tổng ngân sách đã duyệt</p>
                   <h3 class="text-3xl font-black mt-2">{{ number_format($stats['approved_amount']) }}<span class="text-lg font-medium opacity-50">đ</span></h3>
                </div>
                <div class="p-3 bg-white/10 rounded-xl">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm relative overflow-hidden">
             <div class="flex items-start justify-between relative z-10">
                <div>
                   <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Đang chờ phê duyệt</p>
                   <h3 class="text-3xl font-black text-slate-800 mt-2">{{ number_format($stats['pending_amount']) }}<span class="text-lg font-medium text-slate-400">đ</span></h3>
                   <p class="text-xs font-bold text-yellow-600 mt-2 bg-yellow-50 px-2 py-1 rounded inline-block">{{ $stats['pending_count'] }} yêu cầu mới</p>
                </div>
                 <div class="p-3 bg-yellow-50 rounded-xl">
                     <svg class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                 </div>
            </div>
            <!-- Decor -->
            <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-yellow-400/10 rounded-full blur-xl"></div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
             <div class="flex items-start justify-between">
                <div>
                   <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Tổng số yêu cầu</p>
                   <h3 class="text-3xl font-black text-slate-800 mt-2">{{ $stats['total_requests'] }}</h3>
                </div>
                 <div class="p-3 bg-slate-50 rounded-xl">
                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                 </div>
            </div>
        </div>
    </div>

    <!-- Tabs & Filter -->
    <div class="flex items-center gap-4 border-b border-slate-200 pb-1">
        <button @click="currentTab = 'all'" :class="currentTab === 'all' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold transition-all">Tất cả</button>
        <button @click="currentTab = 'pending'" :class="currentTab === 'pending' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold transition-all flex items-center gap-2">
            Chờ xử lý
            @if($stats['pending_count'] > 0) <span class="w-2 h-2 rounded-full bg-red-500"></span> @endif
        </button>
        <button @click="currentTab = 'approved'" :class="currentTab === 'approved' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold transition-all">Đã duyệt</button>
        <button @click="currentTab = 'rejected'" :class="currentTab === 'rejected' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold transition-all">Từ chối</button>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Mã / Hồ sơ</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Đơn vị / Sự kiện</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Loại hình</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Số tiền</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Trạng thái</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($budgets as $item)
                <tr 
                    x-show="currentTab === 'all' || currentTab === '{{ $item->status }}'"
                    class="hover:bg-slate-50 transition-colors group cursor-pointer"
                    onclick="window.location='{{ route('admin.budgets.show', $item->id) }}'"
                >
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs">
                                #{{ $item->id }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Dự trù kinh phí</h4>
                                <p class="text-xs text-slate-500">Cập nhật: {{ $item->updated_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-sm text-slate-700">{{ $item->event->organizer->name ?? 'Tổ chức' }}</p>
                        <p class="text-xs text-slate-500">{{ $item->event->title }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">Dự trù</span>
                    </td>
                    <td class="px-6 py-4 text-right font-mono font-bold text-slate-700">
                        {{ number_format($item->total_estimated) }} đ
                    </td>
                    <td class="px-6 py-4 text-center">
                         @if($item->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-600 animate-pulse"></span> Chờ duyệt
                            </span>
                        @elseif($item->status == 'approved')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Chấp thuận
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg> Từ chối
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
