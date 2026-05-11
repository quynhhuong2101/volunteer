@extends('layouts.student')

@section('header', 'Dashboard')

@section('content')
    <!-- Top Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Certificates -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-gray-500 font-medium mb-1">Chứng nhận đã nhận</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $certificatesCount }} <span class="text-lg text-gray-400 font-normal">chứng chỉ</span></h3>
                <div class="mt-4 flex items-center text-indigo-500 text-sm font-bold bg-indigo-50 w-max px-2 py-1 rounded-lg">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Đã xác thực
                </div>
            </div>
            <div class="absolute top-4 right-4 text-indigo-50 opacity-50">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
            </div>
        </div>

        <!-- Card 2: Events Joined -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
            <div>
                <p class="text-gray-500 font-medium mb-1">Sự kiện đã tham gia</p>
                <h3 class="text-4xl font-bold text-gray-800">{{ $eventsJoined }} <span class="text-lg text-gray-400 font-normal">hoạt động</span></h3>
            </div>
            <div class="mt-4">
                 <span class="inline-flex items-center text-orange-600 bg-orange-50 text-xs font-bold px-2 py-1 rounded-lg">
                    {{ $upcomingEvents->count() }} sự kiện sắp tới
                 </span>
            </div>
             <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-orange-100 rounded-full opacity-20"></div>
        </div>

        <!-- Card 3: Ongoing Activities -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden">
            <div class="flex items-center gap-2 mb-4">
                <span class="bg-green-100 p-1.5 rounded-lg text-green-600">
                    <svg class="w-5 h-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </span>
                <p class="text-gray-800 font-bold">Hoạt động đang diễn ra</p>
            </div>
            
            <div class="flex-1 overflow-y-auto space-y-3 custom-scrollbar max-h-[140px]">
                @forelse($ongoingEvents as $event)
                <div class="bg-green-50/50 rounded-xl p-3 border border-green-100">
                    <h4 class="font-bold text-gray-800 text-sm line-clamp-1">{{ $event->title }}</h4>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-xs font-bold text-green-600 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            {{ $event->location }}
                        </span>
                        <a href="{{ route('student.checkin.view') }}" class="text-[10px] bg-green-600 text-white px-2 py-0.5 rounded shadow-sm hover:bg-green-700">Điểm danh</a>
                    </div>
                </div>
                @empty
                <div class="h-full flex flex-col items-center justify-center text-center text-gray-400">
                    <p class="text-xs">Hiện không có hoạt động nào đang diễn ra.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Card 4: Action (Blue) -->
        <div class="bg-blue-600 rounded-3xl p-6 shadow-lg shadow-blue-200 text-white relative overflow-hidden flex flex-col justify-between">
            <div class="relative z-10">
                <p class="text-blue-100 font-medium text-sm mb-1">ĐIỂM DANH NHANH</p>
                <h3 class="text-xl font-bold leading-tight mb-4">Sẵn sàng cho sự kiện?</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('student.checkin.view') }}" class="w-full bg-white text-blue-600 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-50 transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        Quét mã QR
                    </a>
                </div>
            </div>
            <!-- Decorative Pattern -->
            <div class="absolute right-0 bottom-0 opacity-10">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h4v4H4zm12 0h4v4h-4zM4 16h4v4H4zm6 6h2v-2h2v-2h-2v-2h2v-2h-2v2h-2v2h-2v2h2z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Left Column: Monthly Activity -->
        <!-- Left Column: Monthly Activity & Skills -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between h-full space-y-8">
            
            <!-- Activity Chart -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 self-start mb-6">Hoạt động 6 tháng</h3>
                <div class="w-full h-32 flex items-end justify-between px-2 gap-2">
                    @foreach($monthlyActivity as $data)
                    <div class="flex flex-col items-center w-full group">
                        <div class="relative w-full flex items-end justify-center h-24 bg-slate-50 rounded-lg overflow-hidden">
                            @php $height = $data['count'] > 0 ? min(($data['count'] / 5) * 100, 100) : 0; @endphp
                            <div class="w-full bg-indigo-500 rounded-t-lg transition-all duration-1000 group-hover:bg-indigo-600 relative" style="height: {{ $height }}%">
                                <div class="absolute -top-6 inset-x-0 text-center text-xs font-bold text-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{ $data['count'] }}
                                </div>
                            </div>
                        </div>
                        <span class="text-[10px] text-slate-400 font-bold mt-2 uppercase">{{ $data['month'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Divider -->
            <div class="h-px w-full bg-slate-100 border-t border-dashed border-slate-200"></div>

            <!-- Category Pie Chart -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Thể loại đã tham gia</h3>
                </div>
                
                @if($categoriesData->isEmpty())
                    <div class="text-center py-6 text-slate-400 text-sm italic">
                        Chưa có dữ liệu tham gia sự kiện.
                    </div>
                @else
                    <div class="flex items-center gap-6">
                        <!-- Pie Chart -->
                        @php
                            $gradientLines = [];
                            foreach($categoriesData as $cat) {
                                $gradientLines[] = "{$cat['color']} {$cat['start']}% {$cat['end']}%";
                            }
                            $gradientStr = implode(', ', $gradientLines);
                        @endphp
                        <div class="flex-shrink-0 relative w-32 h-32 sm:w-28 sm:h-28 rounded-full shadow-inner" style="background: conic-gradient({{ $gradientStr }});">
                            <!-- Inner circle for donut chart effect (optional) -->
                            <div class="absolute inset-0 m-auto w-16 h-16 sm:w-14 sm:h-14 bg-white rounded-full shadow-sm flex items-center justify-center">
                                <span class="font-bold text-slate-700 text-sm">{{ $eventsJoined }}</span>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="flex-1 space-y-2">
                            @foreach($categoriesData as $cat)
                                <div class="flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $cat['color'] }};"></span>
                                        <span class="font-medium text-slate-700 line-clamp-1 truncate" title="{{ $cat['name'] }}">{{ $cat['name'] }}</span>
                                    </div>
                                    <span class="font-bold text-slate-500 whitespace-nowrap ml-2">{{ $cat['count'] }} ({{ $cat['percentage'] }}%)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="w-full bg-slate-50 p-3 rounded-xl border border-dashed border-slate-200 text-center mt-auto">
                 <p class="text-xs text-slate-500">Tổng cộng <span class="font-bold text-indigo-600">{{ $eventsJoined }}</span> hoạt động đã tham gia.</p>
            </div>
        </div>

        <!-- Right Column: Suggested Events (Carousel/Grid) -->
        <div class="lg:col-span-2">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Gợi ý cho bạn</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($suggestedEvents as $event)
                <div class="bg-white rounded-3xl p-4 shadow-sm border border-gray-100 flex flex-col group hover:shadow-md transition-all">
                    <div class="relative h-40 rounded-2xl overflow-hidden mb-3">
                         <img src="{{ $event->image ?? 'https://placehold.co/400x200' }}" alt="{{ $event->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                         <span class="absolute top-2 left-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded-lg text-gray-700">
                             {{ $event->category ?? 'Hoạt động' }}
                         </span>
                    </div>
                    <h4 class="text-lg font-bold text-gray-800 mb-1 line-clamp-1 group-hover:text-blue-600 transition-colors">{{ $event->title }}</h4>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-3">{{ $event->description }}</p>
                    <div class="mt-auto flex items-center justify-between">
                        <div></div>
                        <a href="{{ route('student.events.show', $event->id) }}" class="bg-blue-600 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-sm hover:bg-blue-700 transition-colors">
                            Đăng ký ngay
                        </a>
                    </div>
                </div>
                @empty
                 <div class="col-span-2 bg-gray-50 rounded-3xl p-8 text-center border border-dashed border-gray-300">
                    <p class="text-gray-500">Hiện tại chưa có sự kiện gợi ý nào mới.</p>
                 </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Timeline -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">Lịch trình hôm nay</h3>
                <a href="{{ route('student.activities.schedule') }}" class="text-sm text-blue-600 font-bold hover:underline">Xem tất cả</a>
            </div>

            <div class="space-y-6 relative ml-2">
                 <!-- Vertical Guide -->
                <div class="absolute left-3.5 top-0 bottom-0 w-0.5 bg-gray-100"></div>

                @forelse($upcomingEvents->take(3) as $event)
                <div class="relative pl-10">
                    <!-- Connector Dot -->
                    <div class="absolute left-0 top-1 w-7 h-7 bg-blue-50 rounded-full border-2 border-blue-500 z-10 flex items-center justify-center">
                        <div class="w-2.5 h-2.5 bg-blue-500 rounded-full"></div>
                    </div>
                    
                    <div class="group">
                        <h4 class="text-base font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $event->title }}</h4>
                         <p class="text-xs text-gray-500 font-medium mb-1">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                        </p>
                        <p class="text-sm text-gray-500 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->location }}
                        </p>
                    </div>
                </div>
                @empty
                <div class="relative pl-10">
                    <div class="absolute left-0 top-1 w-7 h-7 bg-gray-100 rounded-full border-2 border-gray-300 z-10 flex items-center justify-center">
                         <div class="w-2.5 h-2.5 bg-gray-300 rounded-full"></div>
                    </div>
                    <p class="text-gray-500 text-sm italic">Không có sự kiện nào hôm nay.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Idea Box & Recent Activity -->
        <div class="lg:col-span-2 space-y-6">
             <!-- Idea Box -->
            <div class="bg-orange-50 rounded-3xl p-6 border border-orange-100 flex items-center justify-between shadow-sm border-dashed">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-orange-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-200 mr-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-800">Bạn có ý tưởng mới?</h4>
                        <p class="text-gray-600 text-sm mt-1">Sự kiện lớn bắt đầu từ ý tưởng nhỏ. Chia sẻ ngay!</p>
                    </div>
                </div>
                <a href="{{ route('student.community.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md transition-all">
                    Gửi đề xuất ngay
                </a>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Hoạt động gần đây</h3>
                <div class="space-y-4">
                    @forelse($recentActivities as $item)
                    <div class="flex items-start p-3 hover:bg-gray-50 rounded-xl transition-colors">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mt-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-800 text-sm font-medium">{{ $item['content'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item['time'] }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm p-4 text-center">Chưa có hoạt động nào gần đây.</p>
                    @endforelse
                </div>
                 <button class="w-full mt-4 py-2.5 bg-gray-50 text-gray-600 font-bold text-sm rounded-xl hover:bg-gray-100 transition-colors">
                    Xem lịch sử hoạt động
                </button>
            </div>
        </div>
    </div>
@endsection
