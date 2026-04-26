@extends('layouts.organization')

@section('header', 'Chi tiết Quyết toán')

@section('content')
@extends('layouts.organization')

@section('header', 'Chi tiết Quyết toán')

@section('content')
<!-- SCREEN VIEW ONLY -->
<div class="max-w-5xl mx-auto space-y-8 print:hidden">

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
        
        <!-- Header Report -->
        <div class="bg-slate-900 text-white p-10 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/10 to-transparent"></div>
            
            <a href="{{ route('organization.finance.settlement') }}" class="absolute top-6 left-6 text-white/50 hover:text-white transition-colors flex items-center gap-1 text-xs font-bold uppercase z-20">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Quay lại
            </a>

            <div class="relative z-10">
                <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-white/80 text-[10px] font-bold uppercase tracking-wider mb-4 backdrop-blur-sm">Báo cáo Tài chính</span>
                <h2 class="text-3xl font-black uppercase tracking-widest">{{ $event->title }}</h2>
                <p class="text-slate-400 text-sm mt-2 font-bold uppercase tracking-widest">Ngày lập: {{ now()->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-slate-100 border-b border-slate-100">
            <div class="p-8 text-center bg-slate-50">
                <p class="text-xs font-bold text-slate-400 uppercase mb-2">Tổng Dự Trù</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($planned) }}đ</p>
            </div>
            <div class="p-8 text-center bg-slate-50">
                <p class="text-xs font-bold text-slate-400 uppercase mb-2">Tổng Thực Chi</p>
                <p class="text-2xl font-black text-blue-600">{{ number_format($actual) }}đ</p>
            </div>
             <div class="p-8 text-center {{ $surplus >= 0 ? 'bg-green-50' : 'bg-red-50' }}">
                <p class="text-xs font-bold {{ $surplus >= 0 ? 'text-green-600' : 'text-red-600' }} uppercase mb-2">Chênh lệch (Dư/Thiếu)</p>
                <p class="text-2xl font-black {{ $surplus >= 0 ? 'text-green-700' : 'text-red-700' }}">
                    {{ $surplus >= 0 ? '+' : '' }}{{ number_format($surplus) }}đ
                </p>
            </div>
        </div>

        <!-- Comparison Sections -->
        <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left: Budget Breakdown -->
            <div>
                <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2 pb-4 border-b border-slate-100">
                    <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </span>
                    Kế hoạch (Dự trù)
                </h3>
                <div class="space-y-4">
                    @if($event->budget && $event->budget->items->count() > 0)
                        @foreach($event->budget->items as $item)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">{{ $item->name }} (x{{ $item->quantity }})</span>
                            <span class="font-bold text-slate-800">{{ number_format($item->unit_price * $item->quantity) }}đ</span>
                        </div>
                        @endforeach
                    @else
                        <p class="text-sm text-slate-400 italic">Không có dữ liệu dự trù chi tiết.</p>
                    @endif
                </div>
            </div>

            <!-- Right: Actual Expenses -->
            <div>
                 <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2 pb-4 border-b border-slate-100">
                    <span class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </span>
                    Thực tế Chi tiêu
                </h3>
                <div class="space-y-4">
                    @foreach($event->expenses as $expense)
                    <div class="flex justify-between items-center text-sm group">
                        <div class="flex flex-col">
                            <span class="text-slate-700 font-medium group-hover:text-blue-600 transition-colors">{{ $expense->title }}</span>
                            <span class="text-[10px] text-slate-400">{{ $expense->occurred_at->format('d/m') }} • {{ $expense->user->name ?? 'N/A' }}</span>
                        </div>
                        <span class="font-bold text-slate-800">{{ number_format($expense->amount) }}đ</span>
                    </div>
                    @endforeach
                    @if($event->expenses->count() == 0)
                         <p class="text-sm text-slate-400 italic">Chưa phát sinh chi phí nào.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Footer / Action -->
        <div class="bg-slate-50 p-8 flex justify-center">
            <button onclick="window.print()" class="flex items-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-slate-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Xuất Báo cáo PDF / In
            </button>
        </div>
    </div>
</div>

<!-- PRINT VIEW ONLY (PROFESSIONAL A4 LAYOUT) -->
<div class="hidden print:block font-serif text-black bg-white p-0">
    <!-- Official Header -->
    <div class="flex justify-between items-start mb-8 pb-4 border-b-2 border-black/50">
        <div class="text-center w-5/12">
            <h3 class="font-bold uppercase text-xs mb-1">{{ $event->organizer->name ?? 'ĐƠN VỊ TỔ CHỨC' }}</h3>
            <p class="font-bold uppercase text-xs">BAN TÀI CHÍNH</p>
            <div class="w-16 h-[1px] bg-black mx-auto my-1"></div>
            <p class="text-[10px] italic mt-1">Số: Quyết toán/{{ $event->id }}</p>
        </div>
        <div class="text-center w-7/12">
            <h3 class="font-bold uppercase text-sm mb-1">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h3>
            <p class="font-bold text-sm">Độc lập - Tự do - Hạnh phúc</p>
            <div class="w-32 h-[1px] bg-black mx-auto my-1"></div>
            <p class="text-[11px] italic mt-2">Đà Nẵng, ngày {{ now()->day }} tháng {{ now()->month }} năm {{ now()->year }}</p>
        </div>
    </div>

    <!-- Report Title -->
    <div class="text-center mb-10">
        <h1 class="text-2xl font-bold uppercase mb-2 leading-tight">BÁO CÁO KINH PHÍ</h1>
        <h2 class="text-lg font-bold uppercase text-black/80">SỰ KIỆN: {{ $event->title }}</h2>
    </div>

    <!-- General Info Section -->
    <div class="mb-8">
        <p class="mb-2"><span class="font-bold">1. Đơn vị tổ chức:</span> {{ $event->organizer->name ?? 'N/A' }}</p>
        <p class="mb-2"><span class="font-bold">2. Thời gian:</span> {{ now()->format('d/m/Y H:i') }}</p>
        <p class="mb-2"><span class="font-bold">3. Tổng quan tài chính:</span></p>
        
        <table class="w-full text-sm mt-3 border-collapse border border-black mb-6">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-black px-3 py-2 text-center w-1/3">TỔNG DỰ TRÙ (Kế hoạch)</th>
                    <th class="border border-black px-3 py-2 text-center w-1/3">TỔNG THỰC CHI (Thực tế)</th>
                    <th class="border border-black px-3 py-2 text-center w-1/3">CHÊNH LỆCH (Còn lại)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-black px-3 py-4 text-center text-lg font-bold">{{ number_format($planned) }} đ</td>
                    <td class="border border-black px-3 py-4 text-center text-lg font-bold">{{ number_format($actual) }} đ</td>
                    <td class="border border-black px-3 py-4 text-center text-lg font-bold">
                        {{ $surplus >= 0 ? '+' : '' }}{{ number_format($surplus) }} đ
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Detailed Expense Tables -->
    <div class="mb-8">
        <h4 class="font-bold uppercase text-sm mb-4 border-b border-black inline-block">2. Chi tiết hạng mục chi tiêu</h4>
        
        <table class="w-full text-sm border-collapse border border-black mb-2">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-black px-2 py-1 text-center w-12">STT</th>
                    <th class="border border-black px-2 py-1 text-left">Nội dung chi</th>
                    <th class="border border-black px-2 py-1 text-center">Thời gian</th>
                    <th class="border border-black px-2 py-1 text-center">Người thực hiện</th>
                    <th class="border border-black px-2 py-1 text-right">Thành tiền (VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($event->expenses as $index => $expense)
                <tr>
                    <td class="border border-black px-2 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="border border-black px-2 py-1">{{ $expense->title }}</td>
                    <td class="border border-black px-2 py-1 text-center">{{ $expense->occurred_at->format('d/m/Y') }}</td>
                    <td class="border border-black px-2 py-1 text-center">{{ $expense->user->name ?? 'N/A' }}</td>
                    <td class="border border-black px-2 py-1 text-right">{{ number_format($expense->amount) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="border border-black px-2 py-4 text-center italic">Không có dữ liệu chi tiêu.</td>
                </tr>
                @endforelse
                <!-- Total Row -->
                <tr class="font-bold bg-gray-50">
                    <td colspan="4" class="border border-black px-2 py-2 text-right uppercase">Tổng cộng</td>
                    <td class="border border-black px-2 py-2 text-right">{{ number_format($actual) }}</td>
                </tr>
            </tbody>
        </table>
        
        <p class="text-xs italic mt-2 text-justify">
            * Báo cáo này được trích xuất tự động từ hệ thống Volunteer Connect. Mọi khoản chi đều đã được kiểm tra và đối chiếu với chứng từ gốc. Đơn vị tổ chức chịu hoàn toàn trách nhiệm về tính chính xác của số liệu.
        </p>
    </div>

    <!-- Signatures -->
    <div class="mt-12 flex justify-between px-4 page-break-inside-avoid">
        <div class="text-center w-1/3">
            <h5 class="font-bold uppercase text-xs mb-1">Người lập biểu</h5>
            <p class="text-[10px] italic mb-16">(Ký và ghi rõ họ tên)</p>
            <p class="font-bold mt-8">................................................</p>
        </div>
        <div class="text-center w-1/3">
            <h5 class="font-bold uppercase text-xs mb-1">Kế toán trưởng</h5>
            <p class="text-[10px] italic mb-16">(Ký và ghi rõ họ tên)</p>
            <p class="font-bold mt-8">................................................</p>
        </div>
        <div class="text-center w-1/3">
            <h5 class="font-bold uppercase text-xs mb-1">Thủ trưởng đơn vị</h5>
            <p class="text-[10px] italic mb-16">(Ký và đóng dấu)</p>
            <p class="font-bold mt-8">................................................</p>
        </div>
    </div>
</div>

<style>
    /* Remove web font import to ensure stability */
    
    @media print {
        @page {
            size: A4;
            margin: 1.5cm;
        }
        body {
            background: white !important;
            /* Use system Times New Roman which has full Vietnamese support */
            font-family: "Times New Roman", Times, serif !important;
            color: black !important;
        }
        .print\:hidden {
            display: none !important;
        }
        .print\:block {
            display: block !important;
        }
        /* Ensure borders print */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            border-color: black !important;
        }
    }
</style>
@endsection
@endsection
