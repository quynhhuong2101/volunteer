@extends('layouts.organization')

@section('header', 'Quản lý Chiến dịch')

@section('content')
<div class="max-w-7xl mx-auto space-y-8" x-data="{ 
    currentTab: '{{ request('status', 'all') }}',
    selectedEvent: null
}">
    
    <!-- Hero Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="p-4 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Tổng chiến dịch</p>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['total_events'] }}</p>
            </div>
        </div>
        <!-- Stat 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl">
                 <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Đang hoạt động</p>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['active_campaigns'] }}</p>
            </div>
        </div>
        <!-- Stat 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="p-4 bg-orange-50 text-orange-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Đang chờ duyệt</p>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['pending_campaigns'] }}</p>
            </div>
        </div>
        <!-- Stat 4 -->
         <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="p-4 bg-red-50 text-red-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Đã hủy / Từ chối</p>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['rejected_campaigns'] + $stats['cancelled_campaigns'] }}</p>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <!-- Tabs -->
        <div class="bg-white p-1.5 rounded-xl shadow-sm border border-slate-100 inline-flex overflow-x-auto max-w-full">
            <a href="{{ route('organization.events.index', ['status' => 'all']) }}" class="px-5 py-2.5 text-sm font-bold rounded-lg transition-all {{ request('status', 'all') == 'all' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Tất cả</a>
            <a href="{{ route('organization.events.index', ['status' => 'active']) }}" class="px-5 py-2.5 text-sm font-bold rounded-lg transition-all {{ request('status') == 'active' ? 'bg-indigo-50 text-indigo-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Đang hoạt động</a>
            <a href="{{ route('organization.events.index', ['status' => 'pending']) }}" class="px-5 py-2.5 text-sm font-bold rounded-lg transition-all {{ request('status') == 'pending' ? 'bg-orange-50 text-orange-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Chờ duyệt <span class="ml-1 px-1.5 py-0.5 text-xs bg-orange-200 text-orange-800 rounded-full">{{ $stats['pending_campaigns'] }}</span></a>
            <a href="{{ route('organization.events.index', ['status' => 'rejected']) }}" class="px-5 py-2.5 text-sm font-bold rounded-lg transition-all {{ request('status') == 'rejected' ? 'bg-red-50 text-red-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Bị từ chối</a>
            <a href="{{ route('organization.events.index', ['status' => 'cancelled']) }}" class="px-5 py-2.5 text-sm font-bold rounded-lg transition-all {{ request('status') == 'cancelled' ? 'bg-red-50 text-red-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Đã hủy</a>
            <a href="{{ route('organization.events.index', ['status' => 'closed']) }}" class="px-5 py-2.5 text-sm font-bold rounded-lg transition-all {{ request('status') == 'closed' ? 'bg-slate-100 text-slate-700 shadow-sm' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} whitespace-nowrap">Đã kết thúc</a>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 w-full md:w-auto">
             <div class="relative w-full md:w-64">
                <input type="text" placeholder="Tìm kiếm chiến dịch..." class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm font-medium">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
            <a href="{{ route('organization.events.create') }}" class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-indigo-500/40 transition-all transform active:scale-95 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tạo mới
            </a>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach($events as $event)
        <div class="group relative bg-white rounded-2xl shadow-sm border {{ $event['status'] == 'rejected' ? 'border-red-200 bg-red-50/30' : 'border-slate-100' }} overflow-hidden hover:shadow-xl transition-all duration-300">
            
            @if($event['status'] == 'rejected')
            <div class="absolute top-0 left-0 w-1.5 h-full bg-red-500"></div>
            @endif

            <div class="p-6">
                <!-- Header -->
                <div class="flex gap-5 mb-5 cursor-pointer group/card" @click="selectedEvent = {{ json_encode($event) }}">
                    <!-- Thumbnail -->
                    <div class="w-32 h-32 rounded-2xl overflow-hidden shrink-0 shadow-sm group-hover/card:shadow-md transition-all">
                        <img src="{{ $event['thumbnail'] }}" alt="{{ $event['name'] }}" class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-500">
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                             <h3 class="font-bold {{ $event['status'] == 'rejected' ? 'text-red-700' : 'text-slate-800' }} text-xl line-clamp-1 group-hover/card:text-indigo-600 transition-colors" title="{{ $event['name'] }}">{{ $event['name'] }}</h3>
                             @if($event['status'] == 'approved')
                                <span class="flex-shrink-0 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Hoạt động
                                </span>
                             @elseif($event['status'] == 'pending')
                                <span class="flex-shrink-0 px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-600 border border-orange-100">Chờ duyệt</span>
                             @elseif($event['status'] == 'rejected')
                                <span class="flex-shrink-0 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">Bị từ chối</span>
                             @elseif($event['status'] == 'cancelled')
                                <span class="flex-shrink-0 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">Đã hủy</span>
                             @else
                                <span class="flex-shrink-0 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">Đã kết thúc</span>
                             @endif
                        </div>
                        
                        <div class="flex flex-col gap-1.5 mt-2">
                             <div class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ $event['start_date'] }}
                             </div>
                             <div class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                <span class="line-clamp-1">{{ $event['location'] }}</span>
                             </div>
                        </div>
                    </div>
                </div>

                @if($event['status'] == 'rejected')
                <!-- Rejected Alert -->
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 flex gap-3 mb-4">
                    <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <div>
                        <h4 class="text-sm font-bold text-red-800">Yêu cầu chỉnh sửa / Từ chối</h4>
                        <p class="text-xs text-red-600 mt-1">Chiến dịch này chưa đạt yêu cầu. Vui lòng kiểm tra lại nội dung và chỉnh sửa.</p>
                    </div>
                </div>
                @else
                <!-- Metrics -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-indigo-50/50 p-3 rounded-xl border border-indigo-50">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-indigo-400 uppercase">Tiến độ tuyển</span>
                            <span class="text-sm font-black text-indigo-700">{{ $event['registered'] }}/{{ $event['capacity'] }}</span>
                        </div>
                        <div class="w-full bg-indigo-100 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-1000" style="width: {{ $event['progress'] }}%"></div>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                         <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-slate-400 uppercase">Ngân sách</span>
                            <span class="text-sm font-black text-slate-700">0đ</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="bg-slate-400 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Footer Actions -->
            <div class="{{ $event['status'] == 'rejected' ? 'bg-red-50 border-t border-red-100' : 'bg-slate-50/80 border-t border-slate-100' }} px-6 py-4 flex justify-between items-center backdrop-blur-sm">
                
                @if($event['status'] == 'rejected')
                    <span class="text-xs font-bold text-red-500 italic">Cần thao tác lại</span>
                    <div class="flex gap-3">
                        <a href="#" class="px-4 py-2 border border-red-200 text-red-600 font-bold text-sm rounded-lg hover:bg-white transition-colors">Xóa bỏ</a>
                        <a href="{{ route('organization.events.edit', $event['id']) }}" class="px-4 py-2 bg-red-600 text-white font-bold text-sm rounded-lg hover:bg-red-700 shadow-lg shadow-red-500/20 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Sửa lại
                        </a>
                    </div>
                @else
                    <!-- Participants Preview -->
                     <div class="flex -space-x-2">
                        <img class="w-8 h-8 rounded-full border-2 border-white ring-1 ring-slate-100" src="https://ui-avatars.com/api/?name=User+A&background=random" alt="">
                        <img class="w-8 h-8 rounded-full border-2 border-white ring-1 ring-slate-100" src="https://ui-avatars.com/api/?name=User+B&background=random" alt="">
                        @if($event['registered'] > 2)
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 ring-1 ring-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">+{{ $event['registered'] - 2 }}</div>
                        @endif
                    </div>

                    <!-- Primary Actions -->
                    <div class="flex gap-2">
                        <a @click.stop href="{{ route('organization.events.edit', $event['id']) }}" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-white hover:shadow-sm rounded-lg transition-all" title="Chỉnh sửa thông tin">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                        </a>

                        @if($event['status'] == 'ended' || $event['status'] == 'completed')
                        <a @click.stop href="{{ route('organization.events.feedbackBuilder', $event['id']) }}" class="p-2 text-slate-500 hover:text-amber-600 hover:bg-white hover:shadow-sm rounded-lg transition-all" title="Thiết lập Phiếu Đánh Giá">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        </a>
                        @endif

                        @if($event['status'] == 'approved')
                        <a @click.stop href="{{ route('organization.events.schedule', $event['id']) }}" class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-white hover:shadow-sm rounded-lg transition-all" title="Quản lý Lịch trình">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </a>
                        @endif
                        
                        <a @click.stop href="#" class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-white hover:shadow-sm rounded-lg transition-all" title="Duyệt nhân sự">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </a>

                        @if($event['id'])
                        <a @click.stop href="{{ route('chat.show', $event['id']) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg shadow-md shadow-indigo-200 hover:bg-indigo-700 transition-all flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            Thảo luận
                        </a>
                        @endif

                        @if($event['status'] != 'cancelled' && $event['status'] != 'ended')
                        <form @click.stop action="{{ route('organization.events.toggleRegistration', $event['id']) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-slate-500 {{ $event['is_registration_paused'] ? 'hover:text-green-600' : 'hover:text-orange-600' }} hover:bg-white hover:shadow-sm rounded-lg transition-all" title="{{ $event['is_registration_paused'] ? 'Mở lại đăng ký' : 'Tạm dừng đăng ký' }}">
                                @if($event['is_registration_paused'])
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @endif
                            </button>
                        </form>

                        <form @click.stop action="{{ route('organization.events.cancel', $event['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy sự kiện này? Hành động này không thể hoàn tác.');" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-white hover:shadow-sm rounded-lg transition-all" title="Hủy sự kiện">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    @if($events->isEmpty())
    <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 border-dashed">
        <div class="bg-indigo-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Chưa có chiến dịch nào</h3>
        <p class="text-slate-500 mb-6 max-w-sm mx-auto">Hãy bắt đầu tạo chiến dịch thiện nguyện đầu tiên của bạn để lan tỏa giá trị tốt đẹp.</p>
        <a href="{{ route('organization.events.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tạo chiến dịch ngay
        </a>
    </div>
    @endif

    <!-- Event Detail Modal -->
    <template x-if="selectedEvent">
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             @click.self="selectedEvent = null"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col"
                 @click.stop
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                
                <!-- Modal Header -->
                <div class="relative h-48 shrink-0">
                    <img :src="selectedEvent.thumbnail" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    <button @click="selectedEvent = null" class="absolute top-4 right-4 p-2 bg-white/20 hover:bg-white/40 text-white rounded-full backdrop-blur-md transition-all">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    <div class="absolute bottom-6 left-8 right-8 text-white">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-wider" x-text="selectedEvent.status"></span>
                            <span class="text-sm font-medium opacity-80" x-text="selectedEvent.scope"></span>
                        </div>
                        <h2 class="text-3xl font-black leading-tight" x-text="selectedEvent.name"></h2>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Left Column: Info -->
                        <div class="md:col-span-2 space-y-8">
                            <section>
                                <h3 class="text-lg font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <div class="w-1.5 h-5 bg-indigo-500 rounded-full"></div>
                                    Mô tả chiến dịch
                                </h3>
                                <div class="text-slate-600 leading-relaxed whitespace-pre-line" x-html="selectedEvent.description"></div>
                            </section>

                            <!-- Schedule -->
                            <template x-if="selectedEvent.schedules && selectedEvent.schedules.length > 0">
                                <section>
                                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                        <div class="w-1.5 h-5 bg-indigo-500 rounded-full"></div>
                                        Lịch trình sự kiện
                                    </h3>
                                    <div class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-100">
                                        <template x-for="item in selectedEvent.schedules">
                                            <div class="relative pl-8 group/item">
                                                <!-- Dot -->
                                                <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-white border-2 border-indigo-500 ring-4 ring-indigo-50 flex items-center justify-center transition-transform group-hover/item:scale-110">
                                                    <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                                                </div>
                                                
                                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 group-hover/item:border-indigo-200 group-hover/item:bg-indigo-50/30 transition-all">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <span class="px-2.5 py-1 bg-white rounded-lg border border-slate-200 text-[10px] font-black text-slate-500 uppercase tracking-wider" x-text="item.date"></span>
                                                        <span class="text-xs font-bold text-indigo-600" x-text="`${item.start_time} - ${item.end_time}`"></span>
                                                    </div>
                                                    <h4 class="font-black text-slate-800" x-text="item.activity"></h4>
                                                    <p class="text-xs text-slate-500 mt-2 line-clamp-2" x-text="item.note || 'Không có mô tả chi tiết'"></p>
                                                    <div class="flex items-center gap-3 mt-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-if="item.location">
                                                        <div class="flex items-center gap-1">
                                                            <span x-text="item.location"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </section>
                            </template>

                            <section>
                                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <div class="w-1.5 h-5 bg-indigo-500 rounded-full"></div>
                                    Yêu cầu & Quyền lợi
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="p-4 bg-orange-50 rounded-2xl border border-orange-100">
                                        <h4 class="text-sm font-black text-orange-700 uppercase mb-3 tracking-wider">Yêu cầu</h4>
                                        <ul class="space-y-2">
                                            <template x-for="req in selectedEvent.requirements">
                                                <li class="flex items-start gap-2 text-sm text-orange-800">
                                                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" /></svg>
                                                    <span x-text="req"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                                        <h4 class="text-sm font-black text-emerald-700 uppercase mb-3 tracking-wider">Quyền lợi</h4>
                                        <ul class="space-y-2">
                                            <template x-for="benefit in selectedEvent.benefits">
                                                <li class="flex items-start gap-2 text-sm text-emerald-800">
                                                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                    <span x-text="benefit"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Right Column: Sidebar -->
                        <div class="space-y-6">
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Thời gian bắt đầu</p>
                                    <p class="text-sm font-bold text-slate-700" x-text="selectedEvent.start_date"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Thời gian kết thúc</p>
                                    <p class="text-sm font-bold text-slate-700" x-text="selectedEvent.end_date"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Địa điểm</p>
                                    <p class="text-sm font-bold text-slate-700 leading-tight" x-text="selectedEvent.location"></p>
                                </div>
                                <div class="pt-4 border-t border-slate-200">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Đăng ký tham gia</p>
                                    <div class="relative w-full bg-slate-200 h-2 rounded-full overflow-hidden mb-2">
                                        <div class="absolute h-full bg-indigo-500 rounded-full" :style="`width: ${selectedEvent.progress}%`"></div>
                                    </div>
                                    <div class="flex justify-between text-xs font-black">
                                        <span class="text-indigo-600" x-text="selectedEvent.registered"></span>
                                        <span class="text-slate-400" x-text="selectedEvent.capacity"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-sm space-y-4">
                                <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">Thông tin liên hệ</h4>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900" x-text="selectedEvent.contact_name"></p>
                                        <p class="text-[10px] text-slate-400">Điều phối viên</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900" x-text="selectedEvent.contact_phone"></p>
                                        <p class="text-[10px] text-slate-400">Số điện thoại</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 shrink-0">
                    <button @click="selectedEvent = null" class="px-6 py-2.5 font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">Đóng</button>
                    <a :href="'{{ route('organization.events.edit', ':id') }}'.replace(':id', selectedEvent.id)" class="px-6 py-2.5 font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all">Chỉnh sửa</a>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection


