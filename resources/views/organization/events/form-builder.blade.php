@extends('layouts.organization')

@section('header', 'Thiết lập Đăng ký - ' . ($event->title ?? 'Sự kiện'))

@section('content')
<div class="flex flex-col gap-6" x-data="formBuilder({{ $formData }})">
    
    <!-- Top Bar: Back Button & Title -->
    <div class="flex items-center justify-between shrink-0 bg-white/50 backdrop-blur-sm p-4 rounded-2xl border border-white/50 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="{{ route('organization.hr.forms') }}" class="group flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-all">
                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:border-indigo-200 group-hover:bg-indigo-50 transition-all">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Quay lại</span>
                    <span class="font-bold text-sm">Quản lý Form</span>
                </div>
            </a>
            <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-800 tracking-tight">Thiết lập Đăng ký</h1>
                <p class="text-xs text-indigo-600 font-semibold flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Sự kiện: {{ $event->title }}
                </p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
             <div class="px-4 py-2 bg-indigo-50 border border-indigo-100 rounded-xl">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Trạng thái:</span>
                <span class="text-xs font-bold text-slate-700 ml-1">{{ $event->status == 'approved' ? 'Đã duyệt' : 'Chờ duyệt' }}</span>
             </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- LEFT: Settings & Targets -->
        <div class="w-full lg:w-80 flex flex-col gap-6">
            
            <!-- 1. Recruitment Positions -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 flex flex-col overflow-hidden group/panel hover:shadow-md transition-shadow">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-indigo-200 shadow-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        Vị trí Đăng ký
                    </h3>
                    <button @click="addPosition()" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-slate-200 text-indigo-600 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </button>
                </div>
                
                <div class="p-5 space-y-4 flex flex-col custom-scrollbar">
                    <template x-for="(pos, index) in positions" :key="index">
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 relative group shrink-0 hover:border-indigo-300 transition-all hover:shadow-sm">
                            <button @click="positions.splice(index, 1)" class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-white border border-slate-200 text-slate-300 hover:text-red-500 hover:border-red-200 shadow-sm flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 scale-90 group-hover:scale-100" x-show="positions.length > 1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Tên vị trí</label>
                                    <input type="text" x-model="pos.name" class="w-full bg-slate-50/50 border border-slate-100 rounded-xl px-3 py-2 text-sm font-bold text-slate-700 placeholder:font-normal focus:outline-none focus:border-indigo-500 focus:bg-white transition-all" placeholder="VD: Hậu cần">
                                </div>
                                <div class="flex flex-col gap-2">
                                    <div class="flex gap-3">
                                        <div class="w-24">
                                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Số lượng</label>
                                            <input type="number" x-model="pos.qty" class="w-full bg-slate-50/50 border border-slate-100 rounded-xl px-3 py-2 text-sm font-bold text-center text-indigo-600 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
                                        </div>
                                        <div class="flex-1">
                                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Ghi chú</label>
                                            <input type="text" x-model="pos.desc" class="w-full bg-slate-50/50 border border-slate-100 rounded-xl px-3 py-2 text-[11px] focus:outline-none focus:border-indigo-500 focus:bg-white transition-all" placeholder="Mô tả ngắn...">
                                        </div>
                                    </div>
                                    <div class="px-1">
                                        <input type="range" x-model="pos.qty" min="1" max="100" step="1" 
                                               class="w-full h-1.5 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="p-4 bg-slate-900 text-white flex justify-between items-center shrink-0">
                    <span class="text-xs font-medium text-slate-400">Tổng chỉ tiêu:</span>
                    <span class="text-lg font-black text-indigo-400" x-text="positions.reduce((acc, curr) => acc + parseInt(curr.qty || 0), 0) + ' TNV'"></span>
                </div>
            </div>

            <!-- 2. Policies -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden shrink-0 hover:shadow-md transition-shadow">
                 <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                         <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-blue-200 shadow-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        Cài đặt chung
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Auto Close Toggle -->
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <label class="font-bold text-slate-700 text-sm block">Tự động đóng đơn</label>
                            <p class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">Đóng đơn khi đủ số lượng cho từng vị trí.</p>
                        </div>
                        <button @click="policy.autoClose = !policy.autoClose" 
                                :class="policy.autoClose ? 'bg-indigo-600' : 'bg-slate-200'" 
                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 focus:outline-none">
                            <span :class="policy.autoClose ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                    
                    <div class="h-[1px] bg-slate-100"></div>

                    <!-- Cancellation Deadline -->
                     <div>
                        <label class="font-bold text-slate-700 text-sm block mb-2">Hạn chót hủy đơn</label>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="relative flex-1">
                                    <input type="number" x-model="policy.cancelHours" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-indigo-600 focus:outline-none focus:border-indigo-500 focus:bg-white transition-all pr-12">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-400 uppercase">Giờ</span>
                                </div>
                            </div>
                            <!-- Range Slider -->
                            <div class="px-1">
                                <input type="range" x-model="policy.cancelHours" min="0" max="72" step="1" 
                                       class="w-full h-2 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                <div class="flex justify-between mt-1 px-0.5">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">0h</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase">72h</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-2 italic leading-relaxed">TNV không thể hủy đăng ký sau khoảng thời gian này kể từ khi nộp đơn.</p>
                    </div>
                </div>
            </div>

             <form action="{{ route('organization.events.saveForm', ['id' => $id]) }}" method="POST" class="shrink-0">
                @csrf
                <input type="hidden" name="config" :value="JSON.stringify({positions: positions, policy: policy, fields: fields})">
                <button type="submit" class="w-full group relative overflow-hidden bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Lưu Cấu hình
                </button>
            </form>
        </div>

        <!-- RIGHT: Form Questions Builder -->
        <div class="flex-1 flex flex-col bg-white rounded-[32px] shadow-sm border border-slate-200/60 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-3">
                     <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-indigo-200 shadow-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Câu hỏi khảo sát</h3>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest">Tùy chỉnh form đăng ký dành cho TNV</p>
                    </div>
                </div>
                <div class="flex gap-2">
                     <button @click="addField('text')" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:border-indigo-500 hover:text-indigo-600 transition-all shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                        + Văn bản
                     </button>
                     <button @click="addField('select')" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:border-indigo-500 hover:text-indigo-600 transition-all shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        + Dropdown
                     </button>
                </div>
            </div>
            
            <div class="p-8 space-y-8 bg-slate-50/30">
                <!-- Default Fields Group --> 
                <div class="relative">
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-start">
                        <span class="bg-slate-50 pr-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Thông tin mặc định</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="group p-5 bg-white rounded-2xl border border-slate-200/60 shadow-sm flex justify-between items-center hover:shadow-md transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div>
                               <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nhân thân</span>
                               <span class="font-bold text-slate-700 text-sm">Họ tên & MSSV</span>
                            </div>
                        </div>
                        <span class="text-[10px] font-black bg-indigo-50 px-2.5 py-1 rounded-lg text-indigo-500 uppercase tracking-tighter">Hệ thống</span>
                    </div>
                    <div class="group p-5 bg-white rounded-2xl border border-slate-200/60 shadow-sm flex justify-between items-center hover:shadow-md transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                               <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Liên lạc</span>
                               <span class="font-bold text-slate-700 text-sm">Email & Số điện thoại</span>
                            </div>
                        </div>
                        <span class="text-[10px] font-black bg-blue-50 px-2.5 py-1 rounded-lg text-blue-500 uppercase tracking-tighter">Hệ thống</span>
                    </div>
                </div>

                <!-- Custom Fields Group -->
                <div class="relative mt-12">
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-start">
                        <span class="bg-slate-50 pr-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Câu hỏi tùy chỉnh</span>
                    </div>
                </div>

                <div class="space-y-6 pb-12">
                    <template x-for="(field, index) in fields" :key="index">
                        <div class="bg-white p-7 rounded-3xl border border-slate-200/60 hover:border-indigo-200 transition-all shadow-sm hover:shadow-xl relative group/card overflow-hidden">
                            <!-- Field Type Badge -->
                            <div class="absolute top-0 left-0 h-1 w-full" :class="{
                                'bg-indigo-500': field.type === 'text',
                                'bg-purple-500': field.type === 'select',
                                'bg-amber-500': field.type === 'checkbox'
                            }"></div>

                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow-lg" :class="{
                                        'bg-indigo-500 shadow-indigo-100': field.type === 'text',
                                        'bg-purple-500 shadow-purple-100': field.type === 'select',
                                        'bg-amber-500 shadow-amber-100': field.type === 'checkbox'
                                    }">
                                        <svg x-show="field.type === 'text'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                                        <svg x-show="field.type === 'select'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        <svg x-show="field.type === 'checkbox'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-0.5">Câu hỏi #<span x-text="index + 1"></span></span>
                                        <span class="font-extrabold text-slate-700 text-sm" x-text="field.type === 'text' ? 'Văn bản ngắn' : (field.type === 'select' ? 'Menu thả xuống' : 'Hộp kiểm')"></span>
                                    </div>
                                </div>
                                <button @click="removeField(index)" class="w-8 h-8 rounded-full bg-slate-50 text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                <div class="md:col-span-8">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Tiêu đề câu hỏi</label>
                                    <input type="text" x-model="field.label" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 font-bold text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm" placeholder="Nhập nội dung câu hỏi...">
                                </div>
                                <div class="md:col-span-4 flex items-center h-full pb-3">
                                     <label class="flex items-center space-x-3 cursor-pointer group/toggle">
                                        <div class="relative">
                                            <input type="checkbox" x-model="field.required" class="sr-only">
                                            <div @click="field.required = !field.required" :class="field.required ? 'bg-indigo-600' : 'bg-slate-200'" class="block w-10 h-6 rounded-full transition-colors duration-200"></div>
                                            <div @click="field.required = !field.required" :class="field.required ? 'translate-x-4' : 'translate-x-0'" class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200"></div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-600 group-hover/toggle:text-indigo-600 transition-colors">Bắt buộc</span>
                                    </label>
                                </div>
                            </div>

                            <div x-show="field.type === 'select' || field.type === 'checkbox'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="mt-6 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
                                <div class="flex justify-between items-center mb-3">
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest">Các lựa chọn</label>
                                    <span class="text-[9px] font-medium text-slate-400">Ngăn cách bởi dấu phẩy (,)</span>
                                </div>
                                <input type="text" 
                                       :value="field.options.join(', ')" 
                                       @input="field.options = $event.target.value.split(',').map(s => s.trim()).filter(s => s !== '')" 
                                       class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-500 transition-all font-medium text-slate-600" 
                                       placeholder="Lựa chọn 1, Lựa chọn 2, Lựa chọn 3...">
                                <div class="mt-3 flex flex-wrap gap-1.5">
                                    <template x-for="opt in field.options" :key="opt">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-[10px] font-bold text-indigo-600 shadow-sm" x-text="opt"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="fields.length === 0" class="flex flex-col items-center justify-center py-16 border-2 border-dashed border-slate-200 rounded-[32px] bg-slate-50/20">
                        <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center text-slate-300 mb-4 shadow-sm">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-400">Chưa có câu hỏi bổ sung nào</p>
                        <p class="text-[11px] text-slate-400 mt-1 uppercase tracking-widest">Sử dụng các nút phía trên để thêm câu hỏi mới</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #4f46e5;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #4338ca;
    }
    
    /* Custom Range Slider Style */
    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: #4f46e5;
        cursor: pointer;
        box-shadow: 0 0 5px rgba(79, 70, 229, 0.3);
        margin-top: -4px;
        border: 2px solid white;
    }
    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 8px;
        cursor: pointer;
        background: #f1f5f9;
        border-radius: 10px;
    }
</style>

<script>
    function formBuilder(initialData) {
        return {
            // Data for Recruitment Configuration
            positions: initialData?.positions || [
                { name: 'Hậu cần', qty: 10, desc: 'Chuẩn bị vật dụng' },
                { name: 'Truyền thông', qty: 5, desc: 'Chụp ảnh, viết bài' }
            ],
            policy: initialData?.policy || {
                autoClose: true,
                cancelHours: 3
            },
            
            // Data for Form Questions
            fields: initialData?.fields || [],
            
            // Methods
            addPosition() {
                this.positions.push({ name: '', qty: 5, desc: '' });
            },
            addField(type) {
                this.fields.push({
                    type: type,
                    label: 'Câu hỏi mới',
                    required: false,
                    options: type === 'text' ? [] : ['Lựa chọn 1', 'Lựa chọn 2']
                });
            },
            removeField(index) {
                if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
                    this.fields.splice(index, 1);
                }
            }
        }
    }
</script>
@endsection
