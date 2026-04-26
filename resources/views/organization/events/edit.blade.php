@extends('layouts.organization')

@section('header', 'Chỉnh sửa Sự kiện')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
    <div class="mb-6">
        <a href="{{ route('organization.events.index') }}" class="text-slate-400 hover:text-indigo-600 transition-colors flex items-center gap-1 text-sm font-bold">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Quay lại danh sách
        </a>
    </div>
    <form action="{{ route('organization.events.update', $event->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-2">
            <label class="font-bold text-slate-700">Tên sự kiện</label>
            <input type="text" name="title" value="{{ $event->title }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="font-bold text-slate-700">Thời gian bắt đầu</label>
                <input type="datetime-local" name="start_time" value="{{ \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">
            </div>
            <div class="space-y-2">
                <label class="font-bold text-slate-700">Thời gian kết thúc</label>
                <input type="datetime-local" name="end_time" value="{{ \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">
            </div>
        </div>

        <div class="space-y-2">
            <label class="font-bold text-slate-700">Địa điểm</label>
            <input type="text" name="location" value="{{ $event->location }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">
        </div>
        
        <div class="space-y-2">
            <label class="font-bold text-slate-700">Mô tả</label>
            <textarea name="description" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">{{ $event->description }}</textarea>
        </div>

        <div class="space-y-2">
            <label class="font-bold text-slate-700">Yêu cầu tham gia</label>
            <textarea name="requirements" rows="4" placeholder="Mỗi dòng 1 yêu cầu" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">{{ is_array($event->requirements) ? implode("\n", $event->requirements) : $event->requirements }}</textarea>
        </div>

        <div class="space-y-2">
            <label class="font-bold text-slate-700">Quyền lợi tình nguyện viên</label>
            <textarea name="benefits" rows="4" placeholder="Mỗi dòng 1 quyền lợi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">{{ is_array($event->benefits) ? implode("\n", $event->benefits) : $event->benefits }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-6">
             <div class="space-y-2">
                <label class="font-bold text-slate-700">Người phụ trách</label>
                <input type="text" name="contact_name" value="{{ $event->contact_name }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">
            </div>
             <div class="space-y-2">
                <label class="font-bold text-slate-700">Hotline liên hệ</label>
                <input type="text" name="contact_phone" value="{{ $event->contact_phone }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500">
            </div>
        </div>

        <div class="flex justify-end gap-4 pt-4 border-t border-slate-100">
            <a href="{{ route('organization.events.index') }}" class="px-6 py-2.5 rounded-xl font-bold text-slate-500 hover:bg-slate-50">Hủy</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700">Lưu thay đổi</button>
        </div>
    </form>
</div>
@endsection


