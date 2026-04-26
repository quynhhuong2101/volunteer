@extends('layouts.student')

@section('header', 'Lịch sử hoạt động')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'all', selectedYear: '{{ date('Y') }}' }">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-slate-800 tracking-tight">Lịch sử hoạt động</h2>
            <p class="text-slate-500 font-medium mt-2 text-lg">Hành trình tình nguyện đầy ý nghĩa của bạn</p>
        </div>
        <div class="flex gap-3">

        </div>
    </div>



    <!-- Main Content: Filter & Timeline -->
    <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/50 border border-slate-100">
        
        <!-- Controls -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4 border-b border-slate-100 pb-6">
            <div class="flex items-center gap-2 p-1 bg-slate-100/80 rounded-2xl w-full md:w-auto">
                <button @click="activeTab = 'all'" 
                        :class="activeTab === 'all' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:bg-slate-200/50'"
                        class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 flex-1 md:flex-none">
                    Tất cả
                </button>
                <button @click="activeTab = 'completed'" 
                        :class="activeTab === 'completed' ? 'bg-white text-green-700 shadow-sm' : 'text-slate-500 hover:bg-slate-200/50'"
                         class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 flex-1 md:flex-none">
                    Hoàn thành
                </button>
                <button @click="activeTab = 'cancelled'" 
                        :class="activeTab === 'cancelled' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-500 hover:bg-slate-200/50'"
                        class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 flex-1 md:flex-none">
                    Đã hủy
                </button>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select x-model="selectedYear" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500/20 bg-slate-50 hover:bg-white transition-colors cursor-pointer">
                    <option value="{{ date('Y') }}">Năm nay ({{ date('Y') }})</option>
                    <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                    <option value="{{ date('Y') - 2 }}">{{ date('Y') - 2 }}</option>
                </select>
            </div>
        </div>

        <!-- Timeline List -->
        <div class="space-y-8 relative">
            <!-- Connector Line -->
            <div class="absolute left-4 md:left-[9.5rem] top-4 bottom-4 w-0.5 bg-slate-100"></div>

            @forelse($events as $event)
                <!-- Event Item -->
                <div class="relative flex flex-col md:flex-row gap-6 md:gap-10 group" 
                     x-show="(activeTab === 'all' || (activeTab === 'completed' && '{{ $event->status }}' != 'cancelled') || (activeTab === 'cancelled' && '{{ $event->status }}' == 'cancelled')) && '{{ $event->end_time->format('Y') }}' == selectedYear"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    
                    <!-- Date Badge -->
                    <div class="flex md:flex-col items-center md:text-right md:w-[8rem] flex-shrink-0 gap-3 md:gap-1 mt-1 pl-12 md:pl-0 z-10">
                        <span class="text-2xl md:text-xl font-black text-slate-800 leading-none">{{ $event->end_time->format('d/m') }}</span>
                        <span class="text-sm font-bold text-slate-400 uppercase tracking-wide">{{ $event->end_time->format('Y') }}</span>
                        <span class="md:hidden text-xs font-bold bg-slate-100 px-2 py-1 rounded text-slate-500 ml-auto">{{ $event->end_time->format('H:i') }}</span>
                    </div>

                    <!-- Marker Dot -->
                    <div class="absolute left-3 md:left-[9.15rem] top-2 z-20 w-3 h-3 rounded-full border-2 border-white shadow-sm
                         {{ $event->status == 'cancelled' ? 'bg-red-500' : 'bg-green-500' }}"></div>

                    <!-- Card -->
                    <div class="flex-1 bg-slate-50/50 hover:bg-white border boundary-card hover:border-blue-100 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg hover:shadow-blue-900/5 group-hover:-translate-y-1">
                        <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold leading-none bg-blue-100 text-blue-700 uppercase tracking-wide">
                                        {{ $event->category ?? 'Hoạt động' }}
                                    </span>
                                    @if($event->status == 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold leading-none bg-red-100 text-red-700 uppercase tracking-wide">
                                            Đã hủy
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold leading-none bg-emerald-100 text-emerald-700 uppercase tracking-wide">
                                            <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                            Hoàn thành
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">
                                    <a href="{{ route('student.events.show', $event->id) }}">
                                        {{ $event->title }}
                                    </a>
                                </h3>
                                
                                <div class="flex items-center gap-4 text-sm font-medium text-slate-500 mb-4">
                                    <div class="flex items-center gap-1.5" title="Đơn vị tổ chức">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        {{ $event->organizer->name ?? 'Ban Tổ Chức' }}
                                    </div>
                                    <div class="flex items-center gap-1.5" title="Thời lượng">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $event->start_time->diffInHours($event->end_time) }} giờ
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex flex-col items-end gap-3 w-full md:w-auto">
                                @if($event->status !== 'cancelled')
                                    <a href="{{ route('student.certificates.show', $event->id) }}" target="_blank" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Xem chứng nhận
                                    </a>
                                    <span class="text-xs font-bold text-slate-400">Đã tích lũy</span>
                                @else
                                    <span class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-400 cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Không hoàn thành
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto shadow-sm mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Chưa có hoạt động nào</h3>
                    <p class="text-slate-500 text-sm mt-1">Các hoạt động bạn tham gia sẽ xuất hiện ở đây.</p>
                    <a href="{{ route('student.events.index') }}" class="inline-block mt-4 text-sm font-bold text-blue-600 hover:underline">Khám phá hoạt động ngay</a>
                </div>
            @endforelse
        </div>
        
        <!-- Load More (Optional) -->
        @if($events->count() > 10)
            <div class="mt-10 text-center">
                <button class="px-6 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-500 hover:text-slate-800 hover:border-slate-300 transition-all shadow-sm">
                    Xem các hoạt động cũ hơn
                </button>
            </div>
        @endif
    </div>
    
    <div class="h-12"></div>
</div>
@endsection
