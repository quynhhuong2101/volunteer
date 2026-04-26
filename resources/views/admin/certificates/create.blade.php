
@extends('layouts.admin')

@section('header', 'Cấp Chứng nhận mới')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50">
            <h2 class="text-lg font-bold text-slate-800">Thông tin chứng nhận</h2>
            <p class="text-sm text-slate-500 mt-1">Điền thông tin để cấp chứng nhận mới cho sinh viên.</p>
        </div>
        
        <form action="{{ route('admin.certificates.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="user_id" class="block text-sm font-semibold text-slate-700">Sinh viên <span class="text-red-500">*</span></label>
                    <select name="user_id" id="user_id" required class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-shadow">
                        <option value="">-- Chọn sinh viên --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                        @endforeach
                    </select>
                    @error('user_id') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="event_id" class="block text-sm font-semibold text-slate-700">Sự kiện <span class="text-red-500">*</span></label>
                    <select name="event_id" id="event_id" required class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-shadow">
                        <option value="">-- Chọn sự kiện --</option>
                        @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                        @endforeach
                    </select>
                    @error('event_id') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="code" class="block text-sm font-semibold text-slate-700">Mã chứng nhận</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-shadow font-mono text-slate-600"
                        placeholder="Để trống để tự động tạo mã">
                    <p class="text-xs text-slate-400">Ví dụ: CERT-65AD...</p>
                    @error('code') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="issued_at" class="block text-sm font-semibold text-slate-700">Ngày cấp <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="issued_at" id="issued_at" value="{{ old('issued_at', now()->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-shadow">
                    @error('issued_at') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label for="template_url" class="block text-sm font-semibold text-slate-700">URL Mẫu chứng nhận (Tùy chọn)</label>
                <input type="url" name="template_url" id="template_url" value="{{ old('template_url') }}" 
                    class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-shadow"
                    placeholder="https://...">
                @error('template_url') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4 border-t border-slate-100">
                <a href="{{ route('admin.certificates.index') }}" class="px-6 py-2.5 text-slate-600 font-medium hover:text-slate-900 transition-colors">Hủy bỏ</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                    Cấp chứng nhận
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
