@extends('layouts.student')

@section('header', 'Tạo Khiếu nại / Báo cáo')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <a href="{{ route('student.reports.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Quay lại danh sách
    </a>
    
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <div class="mb-8 border-b border-slate-100 pb-6">
            <h2 class="text-2xl font-black text-slate-800">Gửi Báo cáo Sự cố</h2>
            <p class="text-slate-500 mt-2">Nếu bạn gặp vấn đề về điểm danh, chứng nhận hoặc các sự cố khác tại sự kiện, hãy gửi báo cáo cho Ban quản trị tại đây.</p>
        </div>

        <form action="{{ route('student.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Event Selection -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Sự kiện liên quan <span class="text-red-500">*</span></label>
                <select name="event_id" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- Chọn sự kiện --</option>
                    @foreach($events as $ev)
                    <option value="{{ $ev->id }}" {{ $event_id == $ev->id ? 'selected' : '' }}>
                        {{ $ev->title }} ({{ \Carbon\Carbon::parse($ev->start_time)->format('d/m/Y') }})
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Issue Type/Title -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Vấn đề gặp phải <span class="text-red-500">*</span></label>
                <select name="title" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="Thiếu lượt check-in / Giờ công tác">Thiếu lượt check-in / Giờ công tác</option>
                    <option value="Sai thông tin chứng nhận">Sai thông tin chứng nhận</option>
                    <option value="Thái độ ban tổ chức">Thái độ ban tổ chức</option>
                    <option value="Sự cố kỹ thuật App">Sự cố kỹ thuật App</option>
                    <option value="Khác">Khác</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Mô tả chi tiết <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Vui lòng mô tả rõ ràng sự cố, thời gian và địa điểm..."></textarea>
            </div>

            <!-- Evidence Upload -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Bằng chứng đính kèm (Ảnh / PDF)</label>
                <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-8 hover:bg-slate-50 transition-colors text-center cursor-pointer group">
                    <input type="file" name="evidence_files[]" multiple class="absolute inset-0 opacity-0 cursor-pointer" onchange="document.getElementById('file-label').innerText = this.files.length + ' tệp tin đã chọn'">
                    <div class="space-y-2 pointer-events-none">
                        <svg class="w-10 h-10 text-slate-300 mx-auto group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <p id="file-label" class="text-sm font-bold text-slate-500 group-hover:text-indigo-600">Nhấn để tải lên ảnh chụp màn hình, minh chứng...</p>
                        <p class="text-xs text-slate-400">Hỗ trợ: JPG, PNG, PDF (Max 5MB)</p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 flex items-center gap-4">
                <a href="{{ route('student.reports.index') }}" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-100 transition-colors">Hủy bỏ</a>
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    Gửi Báo Cáo
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
