@extends('layouts.admin')

@section('header', 'Chi tiết Sự kiện')

@section('content')
<div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left: Event Info -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-indigo-600 mb-4 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Quay lại danh sách
                </a>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-indigo-600 font-bold tracking-wide text-xs uppercase mb-2 block">Sự kiện Sinh viên</span>
                        <h1 class="text-2xl font-black text-slate-800 leading-tight mb-2">{{ $event['name'] }}</h1>
                        <p class="text-slate-500 font-medium">Đơn vị: <span class="text-slate-700 font-bold">{{ $event['organizer'] }}</span></p>
                    </div>
                     @php
                        $statusClasses = [
                            'pending' => 'bg-orange-100 text-orange-600',
                            'approved' => 'bg-emerald-100 text-emerald-600',
                            'rejected' => 'bg-red-100 text-red-600',
                        ];
                        $statusLabels = [
                            'pending' => 'Đang chờ duyệt',
                            'approved' => 'Đã duyệt',
                            'rejected' => 'Đã từ chối',
                        ];
                    @endphp
                    <span class="{{ $statusClasses[$event['status']] ?? 'bg-slate-100' }} px-4 py-2 rounded-xl text-sm font-bold shadow-sm whitespace-nowrap">
                        {{ $statusLabels[$event['status']] ?? ucfirst($event['status']) }}
                    </span>
                </div>
            </div>

            <div class="p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                    Mô tả chi tiết
                </h3>
                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed bg-slate-50 p-6 rounded-xl border border-slate-100 mb-8">
                    {{ $event['description'] }}
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Thời gian</p>
                            <p class="font-bold text-slate-700">{{ $event['date'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Địa điểm</p>
                            <p class="font-bold text-slate-700">{{ $event['location'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Kinh phí dự kiến</p>
                            <p class="font-bold text-slate-700">{{ $event['budget'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                        <div class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Quy mô</p>
                            <p class="font-bold text-slate-700">{{ $event['participants'] }} người tham gia</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-100">
                    <h4 class="text-sm font-bold text-slate-800 mb-3">Tài liệu đính kèm</h4>
                    <a href="#" class="inline-flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl hover:bg-white hover:border-indigo-300 hover:shadow-md transition-all group w-full sm:w-auto">
                        <div class="p-2 bg-white rounded-lg border border-slate-100 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" opacity="0.25"/><path d="M14 2v6h6" opacity="0.5"/><path d="M16 11.2l-3.2 3.2-1.4-1.4-1.4 1.4 2.8 2.8 4.2-4.2-1-1.8z" fill="none"/></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-slate-700 group-hover:text-indigo-700 transition-colors">{{ $event['plan_file'] }}</p>
                            <p class="text-xs text-slate-400">PDF Document • 2.5 MB</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Action Panel -->
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 sticky top-6">
            <h3 class="font-bold text-slate-800 text-lg mb-6">Thao tác Phê duyệt</h3>
            
            <div x-data="{ mode: 'start' }">
                
                <!-- Initial State -->
                <div x-show="mode === 'start'" class="grid grid-cols-1 gap-3">
                    <button @click="mode = 'approve'" class="flex items-center justify-between p-4 rounded-xl border border-emerald-100 bg-emerald-50/50 hover:bg-emerald-100 text-emerald-700 font-bold transition-all group">
                        <span>Duyệt hồ sơ</span>
                        <svg class="w-5 h-5 opacity-50 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </button>
                    
                    <button @click="mode = 'request_changes'" class="flex items-center justify-between p-4 rounded-xl border border-orange-100 bg-orange-50/50 hover:bg-orange-100 text-orange-700 font-bold transition-all group">
                        <span>Yêu cầu chỉnh sửa</span>
                        <svg class="w-5 h-5 opacity-50 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                    </button>

                    <button @click="mode = 'reject'" class="flex items-center justify-between p-4 rounded-xl border border-red-100 bg-red-50/50 hover:bg-red-100 text-red-700 font-bold transition-all group">
                        <span>Từ chối</span>
                        <svg class="w-5 h-5 opacity-50 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    
                    <div class="pt-4 border-t border-slate-100 mt-2">
                        <form action="{{ route('admin.events.destroy', $event['id']) }}" method="POST" onsubmit="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa sự kiện này? Hành động này sẽ xóa vĩnh viễn dữ liệu.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center gap-2 p-3 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-xl transition-colors text-sm font-bold opacity-80 hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                Xóa vĩnh viễn sự kiện
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Approve Mode -->
                <div x-show="mode === 'approve'" style="display: none;">
                    <button @click="mode = 'start'" class="text-xs font-bold text-slate-400 hover:text-slate-600 mb-4 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        Quay lại
                    </button>
                    <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 mb-4">
                        <p class="text-sm text-emerald-800 font-medium">Bạn đang xác nhận duyệt sự kiện này. Sự kiện sẽ được công khai ngay lập tức.</p>
                    </div>
                    <form action="{{ route('admin.events.approve', $event['id']) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all flex items-center justify-center gap-2">
                           <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                           Xác nhận Duyệt
                        </button>
                    </form>
                </div>

                <!-- Request Changes Mode -->
                <div x-show="mode === 'request_changes'" style="display: none;">
                    <button @click="mode = 'start'" class="text-xs font-bold text-slate-400 hover:text-slate-600 mb-4 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        Quay lại
                    </button>
                    <form action="{{ route('admin.events.request_changes', $event['id']) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nội dung cần sửa</label>
                            <textarea name="comment" class="w-full bg-slate-50 border-slate-200 text-sm p-3 rounded-xl focus:ring-orange-500 focus:border-orange-500 outline-none transition-all" rows="5" placeholder="Ví dụ: Cần bổ sung chi tiết dự toán kinh phí..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-3.5 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 shadow-lg shadow-orange-500/30 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            Gửi Yêu cầu
                        </button>
                    </form>
                </div>

                 <!-- Reject Mode -->
                <div x-show="mode === 'reject'" style="display: none;">
                    <button @click="mode = 'start'" class="text-xs font-bold text-slate-400 hover:text-slate-600 mb-4 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        Quay lại
                    </button>
                    <form action="{{ route('admin.events.request_changes', $event['id']) }}" method="POST" class="space-y-4">
                        @csrf
                         <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Lý do từ chối</label>
                            <textarea name="reason" class="w-full bg-red-50 border-red-200 text-sm p-3 rounded-xl focus:ring-red-500 focus:border-red-500 outline-none transition-all placeholder-red-300 text-red-800" rows="5" placeholder="Nhập lý do từ chối hồ sơ này..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-3.5 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 shadow-lg shadow-red-500/30 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            Xác nhận Từ chối
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
