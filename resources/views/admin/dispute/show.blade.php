@extends('layouts.admin')

@section('header', 'Chi tiết Hồ sơ #' . $dispute->id)

@section('content')
<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Case File (Left) -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Header Info -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 relative overflow-hidden">
            <a href="{{ route('admin.disputes.index') }}" class="relative z-20 inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-indigo-600 mb-4 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Quay lại danh sách
            </a>

            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            </div>
            
            <div class="relative z-10">
                <span class="inline-block px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-2">
                    {{ $dispute->title }}
                </span>
                <h1 class="text-2xl font-black text-slate-800 mb-6">Tranh chấp tại sự kiện: {{ $dispute->event->title ?? 'Sự kiện không xác định' }}</h1>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Người báo cáo</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600 text-xs">
                                {{ substr($dispute->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ $dispute->user->name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500">{{ $dispute->user->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Đơn vị liên quan</p>
                        <p class="font-bold text-slate-800 text-sm">{{ $dispute->event->organizer->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description & Evidence -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                Nội dung trình bày
            </h3>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-slate-700 italic mb-6 leading-relaxed">
                "{{ $dispute->description }}"
            </div>

            @if(!empty($dispute->evidence))
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Bằng chứng kèm theo
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($dispute->evidence as $ev)
                        <div class="group relative rounded-xl overflow-hidden border border-slate-200 aspect-video bg-slate-100 flex items-center justify-center">
                            {{-- Placeholder as evidence might be just description or external link --}}
                            <div class="text-center">
                                <svg class="w-8 h-8 text-slate-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span class="text-xs text-slate-400 block mt-2 text-ellipsis overflow-hidden px-2">{{ $ev['url'] ?? $ev }}</span>
                            </div>
                            @if(isset($ev['caption']))
                            <div class="absolute inset-x-0 bottom-0 bg-black/60 p-2 backdrop-blur-sm">
                                <p class="text-white text-xs font-medium text-center">{{ $ev['caption'] }}</p>
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <!-- Actions (Right) -->
    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 sticky top-6">
             <div class="mb-6 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-lg">Xử lý Hồ sơ</h3>
                <span class="text-xs font-mono text-slate-400">#{{ $dispute->id }}</span>
             </div>

             @if($dispute->status == 'open')
                <div x-data="{ mode: 'start' }">
                    <!-- Start Options -->
                    <div x-show="mode === 'start'" class="space-y-3">
                        <p class="text-sm text-slate-500 mb-4">Chọn phương thức giải quyết:</p>
                        
                        <button @click="mode = 'accept'" class="w-full flex items-center text-left p-3 rounded-xl border border-emerald-100 bg-emerald-50/50 hover:bg-emerald-100 transition-colors group">
                            <div class="p-2 bg-white rounded-lg text-emerald-600 shadow-sm mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-emerald-800">Chấp thuận khiếu nại</p>
                                <p class="text-xs text-emerald-600/70">Điều chỉnh lại thông tin cho sinh viên</p>
                            </div>
                        </button>

                        <button @click="mode = 'dismiss'" class="w-full flex items-center text-left p-3 rounded-xl border border-red-100 bg-red-50/50 hover:bg-red-100 transition-colors group">
                            <div class="p-2 bg-white rounded-lg text-red-600 shadow-sm mr-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-red-800">Bác bỏ</p>
                                <p class="text-xs text-red-600/70">Không chấp nhận, giữ nguyên kết quả</p>
                            </div>
                        </button>
                    </div>

                    <!-- Accept Form -->
                    <div x-show="mode === 'accept'" style="display: none;">
                        <button @click="mode = 'start'" class="text-xs font-bold text-slate-400 hover:text-slate-600 mb-4 flex items-center gap-1">← Quay lại</button>
                         <form action="{{ route('admin.disputes.resolve', $dispute->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Ghi chú giải quyết</label>
                                <textarea name="note" class="w-full border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500" rows="3" placeholder="VD: Đã xác minh với tổ chức, cập nhật lại giờ..."></textarea>
                            </div>
                            <button class="w-full py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition-all">
                                Xác nhận Giải quyết
                            </button>
                        </form>
                    </div>

                    <!-- Dismiss Form -->
                    <div x-show="mode === 'dismiss'" style="display: none;">
                        <button @click="mode = 'start'" class="text-xs font-bold text-slate-400 hover:text-slate-600 mb-4 flex items-center gap-1">← Quay lại</button>
                        <form action="{{ route('admin.disputes.reject', $dispute->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Lý do bác bỏ</label>
                                <textarea name="note" class="w-full border-slate-200 rounded-xl text-sm focus:border-red-500 focus:ring-red-500" rows="3" placeholder="VD: Bằng chứng không hợp lệ..."></textarea>
                            </div>
                            <button class="w-full py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 hover:bg-red-700 transition-all">
                                Xác nhận Bác bỏ
                            </button>
                        </form>
                    </div>

                </div>
             @else
                <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <h4 class="font-bold text-slate-800">Đã hoàn tất</h4>
                    <p class="text-sm text-slate-500 mt-1">Hồ sơ này đã được đóng.</p>
                    @if($dispute->resolution_note)
                    <div class="mt-3 p-3 bg-white rounded-lg border border-slate-100 text-xs text-slate-600 italic">
                        "{{ $dispute->resolution_note }}"
                    </div>
                    @endif
                </div>
             @endif
        </div>

        <!-- Issue Warning Widget -->
        <div x-data="{ open: false }" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <button @click="open = !open" class="w-full flex items-center justify-between text-sm font-bold text-slate-800 mb-2">
                <span>Cảnh cáo Tổ chức</span>
                <svg class="w-5 h-5 text-slate-400" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <p class="text-xs text-slate-500 mb-4" x-show="!open">Gửi cảnh cáo nếu tổ chức vi phạm nhiều lần.</p>
            
            <div x-show="open" style="display: none;">
                <form action="{{ route('admin.warnings.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $dispute->event->organizer_id }}">
                    
                    <div>
                        <input type="text" name="title" placeholder="Tiêu đề (VD: Vi phạm quy tắc)" class="w-full border-slate-200 rounded-lg text-xs" required>
                    </div>
                    
                    <div>
                        <select name="severity" class="w-full border-slate-200 rounded-lg text-xs" required>
                            <option value="reminder">Nhắc nhở nhẹ</option>
                            <option value="warning">Cảnh cáo (Warning)</option>
                            <option value="ban" class="text-red-600 font-bold">Cấm hoạt động (Ban)</option>
                        </select>
                    </div>

                    <div>
                        <textarea name="content" rows="3" placeholder="Nội dung cảnh cáo..." class="w-full border-slate-200 rounded-lg text-xs" required></textarea>
                    </div>

                    <button class="w-full py-2 bg-orange-500 text-white text-xs font-bold rounded-lg hover:bg-orange-600 transition-colors">
                        Gửi Cảnh Cáo
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-800 mb-4">Lịch sử Check-in</h4>
            @if(count($checkin_logs) > 0)
                <div class="space-y-3">
                    @foreach($checkin_logs as $log)
                        <div class="flex items-center justify-between text-sm p-2 rounded hover:bg-slate-50">
                            <span class="text-slate-600 font-medium">{{ \Carbon\Carbon::parse($log->checkin_time)->format('H:i d/m') }}</span>
                            <span class="{{ $log->is_verified ? 'text-emerald-600' : 'text-orange-500' }} font-bold text-xs uppercase">{{ $log->is_verified ? 'Hợp lệ' : 'Chưa duyệt' }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400 italic">Không có dữ liệu log.</p>
            @endif
        </div>
    </div>
</div>
@endsection
