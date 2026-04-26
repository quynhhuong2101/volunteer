@extends('layouts.student')

@section('header', 'Sự kiện của tôi')

@section('content')
<div class="space-y-8" x-data="{ activeTab: 'ongoing' }">
    


    <!-- 2. Tabs Navigation -->
    <div class="flex p-1.5 bg-white rounded-2xl shadow-sm border border-slate-100 max-w-md mx-auto md:mx-0">
        <button @click="activeTab = 'ongoing'" 
                :class="activeTab === 'ongoing' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'" 
                class="flex-1 py-3 px-6 rounded-xl font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" :class="activeTab === 'ongoing' ? 'text-indigo-200' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Đang diễn ra ({{ count($ongoingEvents) }})
        </button>
        <button @click="activeTab = 'ended'" 
                :class="activeTab === 'ended' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'" 
                class="flex-1 py-3 px-6 rounded-xl font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" :class="activeTab === 'ended' ? 'text-indigo-200' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
            Đã kết thúc ({{ count($endedEvents) }})
        </button>
    </div>

    <!-- 3. Ongoing Events List -->
    <div x-show="activeTab === 'ongoing'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="space-y-4">
        
        @forelse($ongoingEvents as $event)
        <div class="group bg-white rounded-[1.5rem] border border-slate-100 p-5 shadow-[0_2px_15px_rgb(0,0,0,0.03)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:border-indigo-100 transition-all duration-300 relative overflow-hidden">
            <!-- Left Accent Bar -->
            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $event['user_status'] == 'Đã duyệt' ? 'bg-green-500' : ($event['user_status'] == 'Bị từ chối' ? 'bg-red-500' : 'bg-yellow-400') }}"></div>

            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center pl-3">
                
                <!-- Date Box -->
                <div class="flex-shrink-0 w-full md:w-20 bg-slate-50 border border-slate-100 rounded-2xl p-3 flex flex-row md:flex-col items-center justify-center gap-2 shadow-sm text-center">
                    <span class="text-2xl md:text-3xl font-black text-slate-800">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event['date'])->format('M') }}</span>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                         @if($event['user_status'] == 'Đã duyệt')
                            <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-green-100 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Đã xác nhận
                            </span>
                        @elseif($event['user_status'] == 'Bị từ chối')
                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-red-100">
                                Bị từ chối
                            </span>
                        @else
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-600 rounded-full text-[10px] font-black uppercase tracking-wider border border-yellow-100 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                Đang xử lý
                            </span>
                        @endif
                        <span class="text-slate-300 text-xs">•</span>
                        <span class="text-xs font-bold text-slate-500 uppercase">{{ $event['category'] }}</span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">
                        <a href="{{ route('student.my-events.show', $event['id']) }}">
                            {{ $event['title'] }}
                        </a>
                    </h3>

                    <div class="flex items-center gap-4 text-sm text-slate-500 font-medium">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                             {{ Str::limit($event['location'], 30) }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex-shrink-0 flex flex-col items-end gap-3 w-full md:w-auto mt-2 md:mt-0">
                    @if($event['user_status'] == 'Đã duyệt')
                         @if(isset($event['has_group']) && $event['has_group'])
                            <a href="{{ route('chat.show', $event['id']) }}" class="w-full md:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                Nhóm Chat
                            </a>
                        @endif

                        @if(isset($event['registered_at']) && \Carbon\Carbon::parse($event['registered_at'])->addHours(3)->isFuture())
                             <form action="{{ route('student.events.cancel', $event['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đăng ký?');">
                                @csrf
                                <button type="submit" class="group/cancel flex items-center gap-1.5 text-xs font-bold text-slate-400 hover:text-red-600 transition-colors px-3 py-2 rounded-lg hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Hủy đăng ký ({{ \Carbon\Carbon::parse($event['registered_at'])->addHours(3)->diffInMinutes(now()) < 60 ? \Carbon\Carbon::parse($event['registered_at'])->addHours(3)->diffInMinutes(now()).'p' : \Carbon\Carbon::parse($event['registered_at'])->addHours(3)->diffInHours(now()).'h' }})
                                </button>
                            </form>
                        @endif
                    @elseif($event['user_status'] == 'Chờ duyệt')
                        <form action="{{ route('student.events.cancel', $event['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đăng ký?');">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-slate-100 hover:bg-red-50 text-slate-500 hover:text-red-600 border border-slate-200 hover:border-red-200 font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                Hủy đăng ký
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-[2.5rem] p-12 text-center border border-slate-100 dashed-border">
            <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                <svg class="w-10 h-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Chưa có sự kiện nào</h3>
            <p class="text-slate-500 mb-6">Bạn chưa đăng ký sự kiện nào đang diễn ra.</p>
            <a href="{{ route('student.events.index') }}" class="inline-flex px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:-translate-y-1 transition-all">
                Khám phá ngay
            </a>
        </div>
        @endforelse
    </div>

    <!-- 4. Ended Events List -->
    <div x-show="activeTab === 'ended'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         style="display: none;"
         class="space-y-4">
        
        @forelse($endedEvents as $event)
        <div class="group bg-slate-50/50 rounded-[1.5rem] border border-slate-200 p-5 hover:bg-white hover:shadow-[0_10px_30px_rgb(0,0,0,0.05)] transition-all duration-300 relative overflow-hidden grayscale hover:grayscale-0">
             <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">
                
                <!-- Date Box -->
                <div class="flex-shrink-0 w-full md:w-20 bg-slate-200/50 rounded-2xl p-3 flex flex-row md:flex-col items-center justify-center gap-2 text-center">
                    <span class="text-2xl md:text-3xl font-black text-slate-400">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</span>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event['date'])->format('M') }}</span>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 bg-slate-200 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-wider">
                            Đã kết thúc
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-600 mb-2">
                        <a href="{{ route('student.events.show', $event['id']) }}" class="hover:text-indigo-600 transition-colors">
                            {{ $event['title'] }}
                        </a>
                    </h3>

                    <div class="flex items-center gap-4 text-sm text-slate-400 font-medium">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                             {{ Str::limit($event['location'], 30) }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex-shrink-0 flex flex-col items-end gap-3 w-full md:w-auto mt-2 md:mt-0 opacity-50 group-hover:opacity-100 transition-opacity">
                     <button disabled class="px-4 py-2 bg-slate-100 text-slate-400 font-bold rounded-xl text-xs cursor-not-allowed">
                        Đã đóng
                    </button>
                    <a href="{{ route('student.activities.history') }}" class="text-xs font-bold text-indigo-500 hover:text-indigo-700 flex items-center gap-1">
                        Xem lịch sử
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
         <div class="text-center py-12">
            <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <p class="text-slate-500 font-medium">Chưa có sự kiện nào đã kết thúc.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
