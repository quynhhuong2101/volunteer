@extends('layouts.admin')

@section('header', 'Giải quyết Tranh chấp & Khiếu nại')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ currentTab: 'all' }">

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tổng khiếu nại</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total'] }}</h4>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Chưa xử lý</p>
                <h4 class="text-2xl font-black text-orange-500 mt-1">{{ $stats['open'] }} case</h4>
            </div>
            <div class="p-3 bg-orange-50 text-orange-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Đã giải quyết</p>
                <h4 class="text-2xl font-black text-emerald-500 mt-1">{{ $stats['resolved'] }} case</h4>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-slate-100 p-1 rounded-xl flex space-x-1 w-full md:w-auto inline-flex">
        @foreach(['all' => 'Tất cả', 'open' => 'Chưa xử lý', 'resolved' => 'Đã giải quyết'] as $key => $label)
        <button 
            @click="currentTab = '{{ $key }}'"
            :class="currentTab === '{{ $key }}' ? 'bg-white text-indigo-600 shadow-sm shadow-indigo-100' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'"
            class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap"
        >
            {{ $label }}
        </button>
        @endforeach
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Mã hồ sơ</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Người báo cáo</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Vấn đề</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Ngày gửi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 text-right"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($disputes as $dispute)
                <tr 
                    x-show="currentTab === 'all' || currentTab === '{{ $dispute->status }}'"
                    class="hover:bg-slate-50 transition-colors group cursor-pointer"
                    onclick="window.location='{{ route('admin.disputes.show', $dispute->id) }}'"
                >
                    <td class="px-6 py-4 font-mono text-slate-500 font-bold">#{{ $dispute->id }}</td>
                    <td class="px-6 py-4">
                        <div>
                            <span class="block font-bold text-slate-700">{{ $dispute->user->name ?? 'Người dùng xóa' }}</span>
                            <span class="text-xs text-slate-400">{{ $dispute->user->email ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="block font-bold text-slate-800">{{ $dispute->title }}</span>
                        <span class="text-xs text-slate-500 line-clamp-1">{{ $dispute->event->title ?? 'Sự kiện không xác định' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $dispute->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($dispute->status == 'open')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-600 border border-orange-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                Cần xử lý
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600 border border-emerald-200">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                Đã xong
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Empty State -->
        <div x-show="$el.previousElementSibling.querySelectorAll('tr[x-show=\'true\']').length === 0" style="display: none;" class="p-12 text-center">
            <p class="text-slate-400 text-sm">Không có dữ liệu phù hợp.</p>
        </div>
    </div>
</div>
@endsection
