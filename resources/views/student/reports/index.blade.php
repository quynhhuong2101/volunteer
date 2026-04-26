@extends('layouts.student')

@section('header', 'Lịch sử Khiếu nại')

@section('content')
<div class="space-y-6">
    
    <!-- Header Action -->
    <div class="flex justify-between items-center">
        <p class="text-slate-500">Danh sách các vấn đề bạn đã báo cáo cho Ban quản trị.</p>
        <a href="{{ route('student.reports.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tạo khiếu nại mới
        </a>
    </div>

    <!-- Reports List -->
    @if($reports->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($reports as $report)
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:border-indigo-200 transition-all group relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
            </div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-3">
                    <span class="inline-block px-2 py-1 rounded-md text-xs font-bold uppercase {{ $report->status == 'open' ? 'bg-orange-100 text-orange-600' : ($report->status == 'resolved' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600') }}">
                        {{ $report->status == 'open' ? 'Đang xử lý' : ($report->status == 'resolved' ? 'Đã giải quyết' : 'Đã từ chối') }}
                    </span>
                    <span class="text-xs text-slate-400 font-bold">{{ $report->created_at->format('d/m/Y') }}</span>
                </div>
                
                <h3 class="text-lg font-black text-slate-800 mb-1 group-hover:text-indigo-600 transition-colors">{{ $report->title }}</h3>
                <p class="text-xs font-bold text-slate-500 uppercase mb-3 line-clamp-1">
                    {{ $report->event->title ?? 'Sự kiện: Không xác định' }}
                </p>
                
                <p class="text-sm text-slate-600 line-clamp-2 mb-4">
                    {{ $report->description }}
                </p>

                @if($report->resolution_note)
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs text-slate-600 italic">
                    <span class="font-bold not-italic text-slate-400 uppercase mr-1">Phản hồi:</span>
                    "{{ $report->resolution_note }}"
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-3xl border border-slate-100 border-dashed">
        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Không có khiếu nại nào</h3>
        <p class="text-slate-500 text-sm mt-1">Bạn chưa gửi báo cáo sự cố nào gần đây.</p>
    </div>
    @endif
</div>
@endsection
