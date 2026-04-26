@extends('layouts.admin')

@section('header', 'Quản lý Phê duyệt Sự kiện')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ currentTab: 'all' }">
    
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tổng Sự Kiện</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['total'] }}</h4>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Chờ Duyệt</p>
                <h4 class="text-2xl font-black text-orange-500 mt-1">{{ $stats['pending'] }}</h4>
            </div>
            <div class="p-3 bg-orange-50 text-orange-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Đã Duyệt</p>
                <h4 class="text-2xl font-black text-emerald-500 mt-1">{{ $stats['approved'] }}</h4>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Từ chối</p>
                <h4 class="text-2xl font-black text-red-500 mt-1">{{ $stats['rejected'] }}</h4>
            </div>
            <div class="p-3 bg-red-50 text-red-500 rounded-xl">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Filters & Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Custom Tabs -->
        <div class="bg-slate-100 p-1 rounded-xl flex space-x-1 w-full md:w-auto overflow-x-auto">
            @foreach(['all' => 'Tất cả', 'pending' => 'Chờ duyệt', 'approved' => 'Đã duyệt', 'rejected' => 'Từ chối'] as $key => $label)
            <button 
                @click="currentTab = '{{ $key }}'"
                :class="currentTab === '{{ $key }}' ? 'bg-white text-indigo-600 shadow-sm shadow-indigo-100' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-200/50'"
                class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap"
            >
                {{ $label }}
            </button>
            @endforeach
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative w-full md:w-64 group">
                <input type="text" placeholder="Tìm kiếm sự kiện..." class="w-full pl-10 pr-4 py-2.5 bg-white border-transparent focus:bg-white border focus:border-indigo-200 rounded-xl text-sm font-medium transition-all focus:ring-4 focus:ring-indigo-500/10 placeholder-slate-400 group-hover:bg-white group-hover:shadow-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Events List -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Thông tin Sự kiện</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Đơn vị tổ chức</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Thời gian</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Tác vụ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($events as $event)
                <tr 
                    x-show="currentTab === 'all' || currentTab === '{{ $event['status'] }}'"
                    class="hover:bg-indigo-50/30 transition-colors group"
                >
                    <td class="px-6 py-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-lg bg-indigo-100/50 flex items-center justify-center text-indigo-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $event['name'] }}</h4>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-1">Kinh phí: {{ $event['budget'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-semibold text-slate-700">{{ $event['organizer'] }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-slate-500 font-medium block">{{ $event['date'] }}</span>
                        <span class="text-xs text-slate-400">Gửi: {{ $event['submitted_at'] }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-orange-100 text-orange-600 border-orange-200',
                                'approved' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                'rejected' => 'bg-red-100 text-red-600 border-red-200',
                            ];
                            $statusLabels = [
                                'pending' => 'Chờ duyệt',
                                'approved' => 'Đã duyệt',
                                'rejected' => 'Đã từ chối',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClasses[$event['status']] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ $statusLabels[$event['status']] ?? ucfirst($event['status']) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.events.show', $event['id']) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:border-indigo-300 hover:text-indigo-600 text-slate-600 text-xs font-bold rounded-lg transition-all shadow-sm hover:shadow-md">
                            Xem chi tiết
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event['id']) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sự kiện này? Hành động này không thể hoàn tác.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-100 hover:text-red-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Empty State (Shows when no items match filter) -->
        <div x-show="$el.previousElementSibling.querySelectorAll('tr[x-show=\'true\']').length === 0" style="display: none;" class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
            </div>
            <h3 class="text-slate-800 font-bold mb-1">Không tìm thấy sự kiện nào</h3>
            <p class="text-slate-500 text-sm">Thử thay đổi bộ lọc hoặc tìm kiếm khác.</p>
        </div>
    </div>

</div>
@endsection
