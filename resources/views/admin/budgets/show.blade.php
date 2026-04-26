@extends('layouts.admin')

@section('header', 'Chi tiết Hồ sơ Tài chính')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Action Bar -->
     <div class="flex items-center justify-between">
        <a href="{{ route('admin.budgets.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-800 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Quay lại danh sách
        </a>

        @if($budget->status == 'pending')
        <div class="flex items-center gap-3">
             <form action="{{ route('admin.budgets.reject', $budget->id) }}" method="POST" onsubmit="return confirm('Xác nhận từ chối yêu cầu?');">
                @csrf
                <button class="px-4 py-2 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-50 transition-colors shadow-sm">
                    Từ chối
                </button>
            </form>
             <form action="{{ route('admin.budgets.approve', $budget->id) }}" method="POST">
                @csrf
                <button class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Phê duyệt
                </button>
            </form>
        </div>
        @else
        <div class="px-4 py-2 rounded-xl bg-slate-100 text-slate-500 font-bold text-sm cursor-not-allowed">
            Đã {{ $budget->status == 'approved' ? 'phê duyệt' : 'từ chối' }}
        </div>
        @endif
    </div>

    <!-- Invoice-style Paper -->
    <div class="bg-white p-10 rounded-xl shadow-sm border border-slate-200 relative print:shadow-none print:border-none">
        
        @if($budget->status == 'approved')
            <div class="absolute top-10 right-10 border-4 border-emerald-500 text-emerald-500 font-black text-xl px-4 py-2 -rotate-12 opacity-50 uppercase tracking-widest pointer-events-none">
                APPROVED
            </div>
        @elseif($budget->status == 'rejected')
             <div class="absolute top-10 right-10 border-4 border-red-500 text-red-500 font-black text-xl px-4 py-2 -rotate-12 opacity-50 uppercase tracking-widest pointer-events-none">
                REJECTED
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-start mb-10 pb-10 border-b border-slate-100">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Dự trù Kinh phí Tổ chức</h1>
                <p class="text-slate-500 mt-1">Ref ID: <span class="font-mono font-bold text-slate-700">#{{ $budget->id }}</span></p>
                
                <div class="mt-4 space-y-1">
                    <p class="text-sm"><span class="font-bold text-slate-700 w-24 inline-block">Đơn vị:</span> {{ $budget->event->organizer->name ?? 'N/A' }}</p>
                    <p class="text-sm"><span class="font-bold text-slate-700 w-24 inline-block">Sự kiện:</span> {{ $budget->event->title }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ngày cập nhật</p>
                <p class="text-lg font-bold text-slate-800">{{ $budget->updated_at->format('d/m/Y') }}</p>
                <div class="mt-4">
                     <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold uppercase bg-blue-100 text-blue-700">
                        Dự trù (Plan)
                     </span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="mb-10">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4">Chi tiết hạng mục</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="py-3 text-xs font-bold text-slate-500 uppercase">Hạng mục</th>
                        <th class="py-3 text-xs font-bold text-slate-500 uppercase text-center">Nguồn</th>
                        <th class="py-3 text-xs font-bold text-slate-500 uppercase text-center">Số lượng</th>
                        <th class="py-3 text-xs font-bold text-slate-500 uppercase text-right">Đơn giá</th>
                        <th class="py-3 text-xs font-bold text-slate-500 uppercase text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($budget->items as $item)
                    <tr>
                        <td class="py-4 font-bold text-slate-700">{{ $item->name }}</td>
                        <td class="py-4 text-sm text-slate-600 text-center">{{ $item->source ?? '-' }}</td>
                        <td class="py-4 text-sm text-slate-600 text-center">{{ number_format($item->quantity) }}</td>
                        <td class="py-4 text-sm text-slate-600 text-right">{{ number_format($item->unit_price) }}</td>
                        <td class="py-4 font-bold text-slate-800 text-right">{{ number_format($item->quantity * $item->unit_price) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-slate-100">
                        <td colspan="4" class="py-4 text-right text-sm font-bold text-slate-500 uppercase pr-8">Tổng cộng</td>
                        <td class="py-4 text-right text-2xl font-black text-indigo-600">
                            {{ number_format($budget->total_estimated) }} <span class="text-lg font-bold text-slate-400">VND</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Evidence/Notes -->
        <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
            <h4 class="font-bold text-slate-700 mb-3 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                Ghi chú / Tài liệu
            </h4>
            @if($budget->admin_note)
            <p class="text-slate-600 italic mb-4">{{ $budget->admin_note }}</p>
            @endif
            <ul class="space-y-2">
                 <li class="flex items-center gap-2 text-sm text-slate-400 italic">
                    (Chưa có tài liệu đính kèm hệ thống)
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
