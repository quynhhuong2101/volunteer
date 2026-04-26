@extends('layouts.admin')

@section('header', 'Tra cứu & Xác thực Chứng nhận')

@section('content')
<div class="max-w-4xl mx-auto space-y-10 py-6">
    
    <!-- Search Section -->
    <div class="text-center space-y-4">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight">Xác thực Chứng chỉ</h2>
        <p class="text-slate-500 font-medium">Nhập mã số chứng chỉ do sinh viên cung cấp để kiểm tra tính xác thực.</p>
        
        <form action="{{ route('admin.certificates.index') }}" method="GET" class="relative max-w-2xl mx-auto mt-8">
            <input type="text" name="code" value="{{ $search }}" 
                class="w-full pl-14 pr-32 py-5 bg-white border-2 border-slate-200 rounded-[2rem] text-xl font-bold focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 shadow-xl transition-all placeholder:text-slate-300"
                placeholder="Ví dụ: CERT-65F..." autofocus>
            <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <button type="submit" class="absolute right-3 top-3 bottom-3 px-6 bg-indigo-600 text-white font-black rounded-[1.5rem] hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                KIỂM TRA
            </button>
        </form>
    </div>

    <!-- Result Area -->
    @if($search)
        @if($certificate)
            <!-- FOUND: Certificate Card -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl border-2 border-indigo-50 overflow-hidden animate-in fade-in zoom-in duration-500">
                <div class="p-10 border-b-8 border-indigo-600 relative overflow-hidden">
                    <!-- Decorative Background -->
                    <div class="absolute top-0 right-0 p-10 opacity-5">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    </div>

                    <div class="flex items-center justify-between mb-10">
                        <div class="flex items-center gap-3 bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full font-bold text-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            CHỨNG CHỈ HỢP LỆ
                        </div>
                        <div class="font-mono text-slate-400 font-bold tracking-widest">{{ $certificate->code }}</div>
                    </div>

                    <div class="space-y-8 relative">
                        <div class="text-center py-6 border-y-2 border-slate-50 italic text-slate-400 font-medium">Chứng nhận rằng</div>
                        
                        <div class="text-center">
                            <h3 class="text-4xl font-black text-slate-900 mb-2">{{ $certificate->user->name }}</h3>
                            <p class="text-slate-500 font-bold">Mã số sinh viên: {{ $certificate->user->student_id ?? 'N/A' }}</p>
                        </div>

                        <div class="text-center py-4">
                            <p class="text-slate-500 text-sm font-bold uppercase tracking-widest mb-3">Đã hoàn thành xuất sắc</p>
                            <h4 class="text-2xl font-black text-indigo-700 leading-tight px-10">{{ $certificate->event->title }}</h4>
                        </div>

                        <div class="flex justify-between items-end mt-12 pt-8 border-t border-slate-100">
                            <div class="text-left">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Ngày cấp</p>
                                <p class="text-lg font-black text-slate-700">{{ $certificate->issued_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('admin.certificates.edit', $certificate->id) }}" class="p-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST" onsubmit="return confirm('Xóa chứng chỉ này?');">
                                    @csrf @method('DELETE')
                                    <button class="p-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-100 transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- NOT FOUND -->
            <div class="bg-red-50 border-2 border-red-100 rounded-[2rem] p-12 text-center space-y-4 animate-in fade-in slide-in-from-top-4 duration-300">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </div>
                <h3 class="text-xl font-black text-red-800">Không tìm thấy chứng chỉ</h3>
                <p class="text-red-600 font-medium">Mã số <span class="font-mono font-bold">{{ $search }}</span> không khớp với bất kỳ dữ liệu nào trong hệ thống.</p>
                <div class="pt-4">
                    <a href="{{ route('admin.certificates.index') }}" class="inline-flex items-center gap-2 text-red-700 font-bold hover:underline"> Thử lại với mã khác </a>
                </div>
            </div>
        @endif
    @else
        <!-- INITIAL STATE: Recent Certificates -->
        <div class="space-y-6 pt-10">
            <div class="flex items-center justify-between px-2">
                <h3 class="font-black text-slate-800 text-lg uppercase tracking-wider">Cấp gần đây</h3>
                <a href="{{ route('admin.certificates.create') }}" class="flex items-center gap-2 px-4 py-2 bg-white border-2 border-slate-100 rounded-xl font-bold text-sm text-indigo-600 hover:border-indigo-200 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Cấp mới
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($recentCertificates as $cert)
                <a href="{{ route('admin.certificates.index', ['code' => $cert->code]) }}" class="group bg-white p-5 rounded-2xl border border-slate-100 hover:border-indigo-300 hover:shadow-lg transition-all flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center font-black group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            {{ substr($cert->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $cert->user->name ?? 'N/A' }}</h4>
                            <p class="text-xs text-slate-400 font-mono">{{ $cert->code }}</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
                @endforeach
            </div>
            
            @if(count($recentCertificates) == 0)
                <div class="text-center py-10 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-slate-400 font-medium">Chưa có chứng chỉ nào trong hệ thống.</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection

