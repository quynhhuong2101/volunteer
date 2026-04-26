@extends('layouts.organization')

@section('header', 'Quản lý Lịch trình')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumbs -->
    <div class="mb-4">
        <a href="{{ route('organization.events.index') }}" class="text-slate-400 hover:text-indigo-600 transition-colors flex items-center gap-1 text-sm font-bold">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Quay lại danh sách
        </a>
    </div>

    <!-- Header Section -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800">{{ $event->title }}</h1>
                <p class="text-slate-500">Quản lý các mốc thời gian và nội dung công việc chi tiết cho sự kiện.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add New Item Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 sticky top-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Thêm mốc mới
                </h3>

                <form action="{{ route('organization.events.storeSchedule', $event->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Ngày</label>
                        <input type="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d')) }}" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 font-medium" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Bắt đầu</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 font-medium" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Kết thúc</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Tiêu đề ngắn</label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 font-medium" 
                            placeholder="VD: Tập trung đoàn" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Nội dung chi tiết</label>
                        <textarea name="description" rows="3" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 font-medium" 
                            placeholder="Mô tả công việc cụ thể...">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Lưu mốc này
                    </button>
                </form>
            </div>
        </div>

        <!-- Schedule List -->
        <div class="lg:col-span-2 space-y-4">
            @if($schedules->isEmpty())
                <div class="bg-white rounded-3xl border-2 border-dashed border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-400">Chưa có lịch trình</h3>
                    <p class="text-slate-400 text-sm">Hãy thêm các mốc thời gian để sinh viên nắm rõ kế hoạch.</p>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50">
                        <h3 class="font-black text-slate-800">Lịch trình chi tiết ({{ $schedules->count() }} mốc)</h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach($schedules->groupBy('date') as $date => $daySchedules)
                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-black text-sm">
                                        {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                    </div>
                                    <div class="h-px flex-1 bg-slate-100"></div>
                                </div>

                                <div class="space-y-6">
                                    @foreach($daySchedules as $item)
                                        <div class="flex gap-6 group">
                                            <div class="w-20 shrink-0">
                                                <p class="text-sm font-black text-slate-800">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</p>
                                                @if($item->end_time)
                                                    <p class="text-xs text-slate-400 font-medium mt-1">{{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}</p>
                                                @endif
                                            </div>
                                            <div class="flex-1 relative pb-6 border-l-2 border-slate-100 pl-6 last:border-0">
                                                <div class="absolute -left-[5px] top-1 w-2 h-2 rounded-full bg-slate-300 group-hover:bg-indigo-500 transition-colors"></div>
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="font-bold text-slate-800">{{ $item->title }}</h4>
                                                        @if($item->description)
                                                            <p class="text-sm text-slate-500 mt-1">{{ $item->description }}</p>
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('organization.events.destroySchedule', [$event->id, $item->id]) }}" method="POST" onsubmit="return confirm('Xóa mốc lịch trình này?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
