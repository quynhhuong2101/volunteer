@extends('layouts.organization')

@section('header', 'Lập Dự trù Ngân sách')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 font-bold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 font-bold">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden" x-data="budgetPlan()">
        
        <!-- Header Actions -->
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                 <a href="{{ route('organization.finance.plan') }}" class="text-slate-400 hover:text-indigo-600 transition-colors flex items-center gap-1 text-xs font-bold uppercase mb-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Quay lại danh sách
                </a>
                <h3 class="font-bold text-slate-800 text-lg">{{ $currentEvent->title }}</h3>
                <div class="flex items-center gap-2 mt-1">
                    <p class="text-xs text-slate-500">Trạng thái:</p>
                    @php
                        $status = $currentEvent->budget->status ?? 'draft';
                        $statusColor = match($status) {
                            'approved' => 'bg-green-100 text-green-700',
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-600'
                        };
                        $statusText = match($status) {
                            'approved' => 'Đã duyệt',
                            'pending' => 'Chờ duyệt',
                            'rejected' => 'Bị từ chối',
                            default => 'Bản nháp'
                        };
                    @endphp
                    <span class="px-2 py-0.5 rounded text-xs font-bold uppercase {{ $statusColor }}">
                        {{ $statusText }}
                    </span>
                </div>
            </div>
            
            <template x-if="canEdit">
                <button @click="addItem()" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl text-sm hover:border-primary hover:text-primary transition-all shadow-sm">
                    + Thêm mục
                </button>
            </template>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs text-slate-500 uppercase">
                        <th class="p-4 font-bold w-12">#</th>
                        <th class="p-4 font-bold">Nội dung / Khoản chi</th>
                        <th class="p-4 font-bold w-40">Nguồn kinh phí</th>
                        <th class="p-4 font-bold w-32 text-right">Đơn giá (đ)</th>
                        <th class="p-4 font-bold w-24 text-center">SL</th>
                        <th class="p-4 font-bold w-40 text-right">Thành tiền (đ)</th>
                        <th class="p-4 font-bold w-16"></th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    <template x-for="(item, index) in items" :key="index">
                        <tr class="group hover:bg-blue-50/30 transition-colors">
                            <td class="p-4 text-slate-400 font-bold" x-text="index + 1"></td>
                            <td class="p-4">
                                <input type="text" x-model="item.name" :disabled="!canEdit" class="w-full bg-transparent border-none p-0 font-medium focus:ring-0 placeholder-slate-300 rounded disabled:cursor-not-allowed" placeholder="Nhập tên khoản chi..">
                            </td>
                            <td class="p-4">
                                <select x-model="item.source" :disabled="!canEdit" class="w-full bg-slate-100 border-none rounded-lg text-xs font-bold text-slate-600 py-1.5 px-2 cursor-pointer focus:ring-0 disabled:opacity-70 disabled:cursor-not-allowed">
                                    <option value="fund">Trường cấp</option>
                                    <option value="sponsor">Tự túc / Tài trợ</option>
                                </select>
                            </td>
                            <td class="p-4">
                                <input type="number" x-model.number="item.unit_price" :disabled="!canEdit" class="w-full bg-transparent border-none p-0 text-right text-slate-600 focus:ring-0 disabled:cursor-not-allowed" placeholder="0">
                            </td>
                            <td class="p-4">
                                <input type="number" x-model.number="item.quantity" :disabled="!canEdit" class="w-full bg-transparent border-none p-0 text-center font-bold text-slate-800 focus:ring-0 disabled:cursor-not-allowed" placeholder="1">
                            </td>
                            <td class="p-4 text-right font-bold text-slate-800" x-text="formatCurrency(item.unit_price * item.quantity)"></td>
                            <td class="p-4 text-center">
                                <template x-if="canEdit">
                                    <button @click="removeItem(index)" class="text-slate-300 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </template>
                            </td>
                        </tr>
                    </template>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 border-t border-slate-200">
                        <td colspan="5" class="p-4 text-right font-bold text-slate-800 uppercase tracking-wide">Tổng dự trù:</td>
                        <td class="p-4 text-right font-extrabold text-xl text-primary" x-text="formatCurrency(totalAmount)"></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer Actions -->
        <div class="p-6 border-t border-slate-100 bg-slate-50 flex justify-end gap-3" x-show="canEdit">
             <form action="{{ route('organization.finance.submitPlan', $currentEvent->id) }}" method="POST">
                @csrf
                <textarea name="items" :value="JSON.stringify(items)" class="hidden"></textarea>
                <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:bg-primary-dark transition-all transform hover:-translate-y-0.5">
                    Gửi Duyệt Ngân sách
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    function budgetPlan() {
        return {
            items: @json($items),
            status: '{{ $currentEvent->budget->status ?? "draft" }}',
            get canEdit() {
                return ['draft', 'rejected'].includes(this.status);
            },
            addItem() {
                this.items.push({ name: '', unit_price: 0, quantity: 1, source: 'fund' });
            },
            removeItem(index) {
                this.items.splice(index, 1);
            },
            get totalAmount() {
                return this.items.reduce((sum, item) => sum + (item.unit_price * item.quantity), 0);
            },
            formatCurrency(value) {
                if (!value) return '0 ₫';
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
            }
        }
    }
</script>
@endsection


