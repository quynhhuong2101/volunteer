@extends('layouts.admin')

@section('header', 'Kiểm soát Tài chính')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    @foreach($requests as $req)
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" x-data="{ expanded: false, approvedAmount: {{ $req['total_requested'] }} }">
        <div class="p-6 flex items-center justify-between cursor-pointer hover:bg-slate-50 transition-colors" @click="expanded = !expanded">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg">
                    $
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">{{ $req['event'] }}</h3>
                    <p class="text-xs text-slate-500">{{ $req['organizer'] }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-slate-500">Yêu cầu cấp</p>
                <p class="text-xl font-extrabold text-indigo-600">{{ number_format($req['total_requested']) }} đ</p>
            </div>
        </div>

        <!-- Detail Panel -->
        <div x-show="expanded" class="border-t border-slate-100 bg-slate-50/50 p-6" style="display: none;">
            <table class="w-full text-sm mb-6">
                <thead class="text-slate-500 font-bold border-b border-slate-200">
                    <tr>
                        <th class="text-left py-2">Hạng mục</th>
                        <th class="text-right py-2">Số tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($req['details'] as $detail)
                    <tr>
                        <td class="py-3 text-slate-800">{{ $detail['item'] }}</td>
                        <td class="py-3 text-right font-mono">{{ number_format($detail['amount']) }} đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Partial Approval Control -->
            <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-slate-800">Phê duyệt Ngân sách</h4>
                    <p class="text-xs text-slate-500">Bạn có thể điều chỉnh số tiền thực tế được cấp.</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="number" x-model="approvedAmount" class="pl-4 pr-12 py-2 border-2 border-indigo-100 rounded-lg font-bold text-indigo-700 focus:ring-indigo-500 focus:border-indigo-500 text-right w-48">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">đ</span>
                    </div>
                    <button class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 shadow-sm transition-colors">
                        Xác nhận Cấp
                    </button>
                </div>
            </div>
            
             <div x-show="approvedAmount < {{ $req['total_requested'] }}" class="mt-3 text-right text-xs font-bold text-orange-600">
                * Đang duyệt thấp hơn yêu cầu (Cắt giảm {{ number_format($req['total_requested']) }} đ)
            </div>

        </div>
    </div>
    @endforeach
</div>
@endsection
