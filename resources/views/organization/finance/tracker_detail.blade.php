@extends('layouts.organization')

@section('header', 'Theo dõi Chi tiêu')

@section('content')
@section('content')
<div class="max-w-5xl mx-auto space-y-8" x-data="expenseTracker()">
    
    <!-- Header with Back Button -->
    <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
        <a href="{{ route('organization.finance.tracker') }}" class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all group" title="Quay lại danh sách">
            <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div class="h-8 w-px bg-slate-100"></div>
        <div>
            <h1 class="text-xl font-black text-slate-800 leading-tight">{{ $currentEvent->title }}</h1>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-wider">Theo dõi Chi tiêu</span>
                <span>{{ \Carbon\Carbon::parse($currentEvent->start_time)->format('Y') }}</span>
            </div>
        </div>
    </div>

    <!-- 1. Progress & Alert -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden">
        
        @if($budget_used > $budget_total)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl animate-pulse">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-red-700">CẢNH BÁO: Đã chi vượt quá ngân sách được duyệt!</p>
                </div>
            </div>
        </div>
        @endif

        <div class="flex justify-between items-end mb-4">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Ngân sách hiện tại</h3>
                <p class="text-sm text-slate-500">Đã dùng: <span class="font-bold text-slate-800">{{ number_format($budget_used) }}đ</span> / {{ number_format($budget_total) }}đ</p>
            </div>
            <span class="font-extrabold text-2xl {{ $percent > 100 ? 'text-red-500' : 'text-primary' }}">{{ round($percent, 1) }}%</span>
        </div>

        <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden">
            <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $percent > 100 ? 'bg-red-500' : 'bg-primary' }}" style="width: {{ $percent > 100 ? 100 : $percent }}%"></div>
        </div>
    </div>

    <!-- 2. Actions & History -->
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Left: Action Button -->
        <div class="md:w-1/3">
             <button @click="modalOpen = true" class="w-full bg-white border-2 border-dashed border-primary/50 rounded-3xl p-8 flex flex-col items-center justify-center text-primary hover:bg-blue-50 transition-all cursor-pointer group">
                <div class="w-16 h-16 rounded-full bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mb-4 transition-colors">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
                <span class="font-bold text-lg">Thêm khoản chi mới</span>
                <span class="text-xs text-slate-500 mt-2">Yêu cầu ảnh chụp hóa đơn</span>
            </button>
        </div>

        <!-- Right: Recent Expenses -->
        <div class="flex-1 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">Lịch sử chi tiêu</h3>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($expenses as $expense)
                <div class="p-6 flex items-center justify-between hover:bg-slate-50 transition-colors cursor-pointer group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $expense->title }}</h4>
                            <p class="text-xs text-slate-500">{{ $expense->user->name ?? 'Người dùng' }} • {{ $expense->occurred_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-slate-800">-{{ number_format($expense->amount) }}đ</div>
                        <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-all" title="Xem chứng từ">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Add Expense -->
    <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" @click="modalOpen = false"></div>

            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                
                <form action="{{ route('organization.finance.storeExpense') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $currentEvent->id }}">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">Nhập khoản chi mới</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Nội dung chi</label>
                                <input type="text" name="title" class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-sm font-medium focus:ring-2 focus:ring-primary/20" placeholder="VD: Mua nước suối...">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Số tiền (VNĐ)</label>
                                <input type="number" name="amount" class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-sm font-medium focus:ring-2 focus:ring-primary/20" placeholder="0">
                            </div>

                            <!-- Upload Area -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Hình ảnh hóa đơn <span class="text-red-500">*</span></label>
                                
                                <!-- Preview Container -->
                                <div x-show="previewUrl" class="mb-2 relative rounded-lg overflow-hidden border border-slate-200">
                                    <img :src="previewUrl" class="w-full h-48 object-cover">
                                    <button type="button" @click="clearImage()" class="absolute top-2 right-2 bg-black/50 text-white rounded-full p-1 hover:bg-red-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>

                                <!-- Upload Input -->
                                <div x-show="!previewUrl" class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:bg-slate-50 transition-colors relative">
                                    <input type="file" name="proof_image" @change="fileChosen" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-1 text-sm text-slate-600">Click hoặc kéo ảnh vào đây</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                         <button type="submit" :disabled="!previewUrl" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed sm:ml-3 sm:w-auto sm:text-sm transition-all">
                            Lưu Khoản Chi
                        </button>
                        <button type="button" @click="modalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function expenseTracker() {
        return {
            modalOpen: false,
            previewUrl: null,
            fileChosen(event) {
                const file = event.target.files[0];
                if (file) {
                    this.previewUrl = URL.createObjectURL(file);
                }
            },
            clearImage() {
                this.previewUrl = null;
                // Reset input (optional, requires ref)
            }
        }
    }
</script>
@endsection


