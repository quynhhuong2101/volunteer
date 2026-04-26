@extends('layouts.organization')

@section('header', 'Quyết toán & Báo cáo')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- Overall Summary -->
    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-50"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Tổng quan Tài chính</h2>
                <p class="text-slate-500 mt-1">Báo cáo quyết toán các chiến dịch đã kết thúc hoặc đang hoạt động</p>
            </div>
            
            <div class="flex gap-4">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 min-w-[140px] text-center">
                    <span class="block text-2xl font-black text-blue-600">{{ $events->count() }}</span>
                    <span class="text-xs font-bold text-slate-400 uppercase">Chiến dịch</span>
                </div>
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 min-w-[200px] text-center">
                     @php 
                        $totalDiff = $events->sum('diff'); 
                    @endphp
                    <span class="block text-2xl font-black {{ $totalDiff >= 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $totalDiff >= 0 ? '+' : '' }}{{ number_format($totalDiff) }}đ
                    </span>
                    <span class="text-xs font-bold text-slate-400 uppercase">Tổng thặng dư</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
        <a href="{{ route('organization.finance.settlement.detail', $event->id) }}" class="group bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        {{ substr($event->title, 0, 1) }}
                    </div>
                    @if($event->diff >= 0)
                    <span class="px-2 py-1 rounded-lg bg-green-50 text-green-700 text-xs font-bold border border-green-100">
                        Dư {{ number_format($event->diff) }}đ
                    </span>
                    @else
                    <span class="px-2 py-1 rounded-lg bg-red-50 text-red-700 text-xs font-bold border border-red-100">
                        Thâm {{ number_format(abs($event->diff)) }}đ
                    </span>
                    @endif
                </div>

                <h3 class="font-bold text-lg text-slate-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $event->title }}</h3>
                <p class="text-xs text-slate-400 font-bold mb-6 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    {{ \Carbon\Carbon::parse($event->end_time)->format('d/m/Y') }}
                </p>

                <!-- Mini Bar Chart Simulation -->
                <div class="space-y-3 mb-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Dự trù</span>
                        <span class="font-bold text-slate-700">{{ number_format($event->planned) }}đ</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div class="bg-slate-300 h-full rounded-full" style="width: 100%"></div>
                    </div>
                    
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Thực chi</span>
                        <span class="font-bold {{ $event->actual > $event->planned ? 'text-red-600' : 'text-blue-600' }}">{{ number_format($event->actual) }}đ</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        @php 
                            $percent = $event->planned > 0 ? ($event->actual / $event->planned) * 100 : 0;
                        @endphp
                        <div class="{{ $event->actual > $event->planned ? 'bg-red-500' : 'bg-blue-500' }} h-full rounded-full" style="width: {{ min($percent, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-slate-50 flex justify-end">
                <span class="text-sm font-bold text-blue-600 group-hover:translate-x-1 transition-transform flex items-center gap-1">
                    Xem chi tiết <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </span>
            </div>
        </a>
        @empty
        <div class="col-span-3 text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            <p class="text-slate-500 font-bold">Chưa có dữ liệu quyết toán nào.</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
