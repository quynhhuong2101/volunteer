@extends('layouts.student')

@section('header')
    <div class="flex items-center space-x-2">
        <a href="javascript:history.back()" class="text-gray-500 hover:text-primary transition-colors flex items-center gap-1 group">
             <div class="p-1.5 rounded-full group-hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
             </div>
             <span class="text-sm font-medium">Quay lại</span>
        </a>
        <span class="text-slate-300">|</span>
        <span class="font-bold text-slate-700">Chi tiết sự kiện</span>
    </div>
@endsection

@section('content')
    <div x-data="{ isRegistrationModalOpen: false }" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Hero Image -->
            <div class="relative h-64 md:h-80 rounded-2xl overflow-hidden shadow-sm">
                <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 md:p-8">
                    <span class="inline-block bg-accent text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
                        {{ $event['category'] }}
                    </span>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2 leading-tight">
                        {{ $event['title'] }}
                    </h1>
                     <div class="flex items-center text-white/90 text-sm space-x-4">
                         @if($event['scope'] == 'Trong trường')
                        <span class="flex items-center text-blue-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Trong trường
                        </span>
                        @else
                        <span class="flex items-center text-teal-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Ngoài trường
                        </span>
                        @endif
                     </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-start space-x-3">
                    <div class="p-2 bg-blue-50 text-primary rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Thời gian</p>
                        <p class="text-xs font-bold text-gray-800 mt-0.5">
                            {{ \Carbon\Carbon::parse($event['start_time'])->format('H:i d/m/Y') }}
                        </p>
                        <p class="text-xs font-bold text-gray-800">
                            - {{ \Carbon\Carbon::parse($event['end_time'])->format('H:i d/m/Y') }}
                        </p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-start space-x-3">
                    <div class="p-2 bg-orange-50 text-accent rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Địa điểm</p>
                        <p class="text-sm font-bold text-gray-800 line-clamp-2" title="{{ $event['location'] }}">{{ $event['location'] }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-start space-x-3">
                    <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Đã đăng ký</p>
                        <p class="text-sm font-bold text-gray-800">{{ $event['registered'] }} / {{ $event['slots'] }}</p>
                        @php $percent = $event['slots'] > 0 ? ($event['registered'] / $event['slots']) * 100 : 0; @endphp
                         <div class="w-full bg-gray-200 h-1.5 rounded-full mt-1">
                            <div class="h-1.5 rounded-full {{ $percent > 90 ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description & Content -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-100">Chi tiết sự kiện</h2>
                <div class="prose max-w-none text-gray-600">
                    <p class="mb-6">{{ $event['description'] }}</p>

                    @if($event->schedules->isNotEmpty())
                    <div class="mb-12">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-slate-800">Lịch trình sự kiện</h3>
                                    <p class="text-xs text-slate-500 font-medium">Chi tiết các hoạt động diễn ra</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-10">
                            @foreach($event->schedules->groupBy('date') as $date => $daySchedules)
                                <div>
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="px-4 py-1.5 bg-slate-800 text-white rounded-full text-xs font-black tracking-widest shadow-sm">
                                            {{ \Carbon\Carbon::parse($date)->format('d . m . Y') }}
                                        </div>
                                        <div class="h-px flex-1 bg-gradient-to-r from-slate-200 to-transparent"></div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($daySchedules as $item)
                                            <div class="group bg-white p-5 rounded-3xl border border-slate-100 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-500 relative overflow-hidden">
                                                <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50/30 rounded-bl-full -mr-12 -mt-12 group-hover:bg-indigo-100/50 transition-colors"></div>
                                                
                                                <div class="relative z-10 flex gap-4">
                                                    <div class="shrink-0">
                                                        <div class="flex flex-col items-center justify-center w-14 h-14 bg-indigo-50 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                                                            <span class="text-sm font-black leading-none">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0 pt-1">
                                                        <h4 class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors truncate">{{ $item->title }}</h4>
                                                        @if($item->description)
                                                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Requirements -->
                        <div class="bg-red-50 p-5 rounded-xl border border-red-100">
                             <h3 class="flex items-center text-lg font-bold text-red-800 mb-3">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Yêu cầu tham gia
                            </h3>
                            <ul class="space-y-2">
                                @if(isset($event['requirements']))
                                    @foreach($event['requirements'] as $req)
                                    <li class="flex items-start text-sm text-gray-700">
                                        <span class="mr-2 mt-1 text-red-500">•</span>
                                        {{ $req }}
                                    </li>
                                    @endforeach
                                @else
                                    <li class="text-sm text-gray-500 italic">Không có yêu cầu cụ thể.</li>
                                @endif
                            </ul>
                        </div>

                        <!-- Benefits -->
                        <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                             <h3 class="flex items-center text-lg font-bold text-blue-800 mb-3">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                Quyền lợi
                            </h3>
                            <ul class="space-y-2">
                                 @if(isset($event['benefits']))
                                    @foreach($event['benefits'] as $ben)
                                    <li class="flex items-start text-sm text-gray-700">
                                        <span class="mr-2 mt-1 text-blue-500">•</span>
                                        {{ $ben }}
                                    </li>
                                    @endforeach
                                @else
                                     <li class="text-sm text-gray-500 italic">Đang cập nhật.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Thông tin liên hệ</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        <li><strong>Đơn vị tổ chức:</strong> {{ $event->organizer->name ?? $event['organizer'] }}</li>
                        <li><strong>Người phụ trách:</strong> {{ $event['contact_name'] ?? 'Đang cập nhật' }}</li>
                        <li><strong>Hotline:</strong> {{ $event['contact_phone'] ?? 'Đang cập nhật' }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar (CTA) -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                <!-- Registration Card -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Đăng ký tham gia</h3>
                    
                    @if(isset($registration) && $registration)
                        {{-- 1. Already Registered --}}
                        <div class="bg-green-50 text-green-600 p-4 rounded-lg flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Bạn đã đăng ký tham gia sự kiện này.</span>
                        </div>

                        @if(\Carbon\Carbon::parse($registration->created_at)->addHours(3)->isFuture() && \Carbon\Carbon::now()->lt($event['start_time']))
                            <form action="{{ route('student.events.cancel', $event['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đăng ký?');">
                                @csrf
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-bold py-3 rounded-xl transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    Hủy đăng ký
                                </button>
                                <p class="text-xs text-center text-red-400 mt-2">
                                    Có thể hủy trong {{ \Carbon\Carbon::parse($registration->created_at)->addHours(3)->diffForHumans(now(), true) }} nữa
                                </p>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-100 text-gray-500 font-bold py-3 rounded-xl cursor-not-allowed">
                                Đã đăng ký
                            </button>
                        @endif

                    @elseif($event['status'] == 'cancelled')
                        {{-- 2. Cancelled --}}
                        <div class="bg-red-50 text-red-600 p-4 rounded-lg flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Sự kiện đã bị hủy</span>
                        </div>
                        <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">
                            Không thể đăng ký
                        </button>

                    @elseif($event['is_registration_paused'])
                        {{-- 3. Paused --}}
                        <div class="bg-orange-50 text-orange-600 p-4 rounded-lg flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Đang tạm dừng đăng ký</span>
                        </div>
                        <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">
                            Tạm dừng đăng ký
                        </button>

                    @elseif(\Carbon\Carbon::now()->gt($event['end_time']))
                        {{-- 4. Already Ended --}}
                        <div class="bg-orange-50 text-orange-600 p-4 rounded-lg flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Sự kiện đã kết thúc</span>
                        </div>
                        <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">
                            Đã đóng đăng ký
                        </button>
                    @elseif($event['registered'] >= $event['slots'])
                        {{-- 5. Full --}}
                        <div class="bg-red-50 text-red-600 p-4 rounded-lg flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Sự kiện đã hết chỗ!</span>
                        </div>
                        <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed">
                            Hết chỗ đăng ký
                        </button>

                    @else
                        {{-- 6. Open for registration --}}
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-500">Trạng thái:</span>
                                <span class="font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded">Đang mở đăng ký</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Còn lại:</span>
                                <span class="font-bold text-accent">{{ $event['slots'] - $event['registered'] }} suất</span>
                            </div>
                        </div>

                        @if(isset($form))
                            {{-- Modal button --}}
                            <button @click="isRegistrationModalOpen = true" type="button" class="w-full bg-accent hover:bg-orange-600 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl transform active:scale-95 transition-all flex items-center justify-center">
                                <span>Đăng ký tham gia</span>
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                        @else
                            {{-- Direct submit button --}}
                            <form action="{{ route('student.events.register.store', $event['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-accent hover:bg-orange-600 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl transform active:scale-95 transition-all flex items-center justify-center">
                                    <span>Đăng ký ngay</span>
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </form>
                        @endif

                        <p class="text-xs text-center text-gray-400 mt-3">
                            * Xác nhận tham gia đồng nghĩa với việc bạn cam kết tuân thủ quy định của BTC.
                        </p>
                    @endif
                </div>

                <!-- Participants List -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-6 bg-accent rounded-full"></div>
                            <h3 class="text-sm font-black text-gray-800 uppercase tracking-tight">Thành viên</h3>
                        </div>
                        <span class="text-[10px] font-black px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg">{{ $event['registered'] }} / {{ $event['slots'] }}</span>
                    </div>

                    @if($participants->isNotEmpty())
                        <div class="space-y-5">
                            @foreach($participants->take(10) as $p)
                                <div class="flex items-center gap-3 group">
                                    <div class="w-8 h-8 rounded-full overflow-hidden shrink-0 border border-indigo-50 shadow-sm relative">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p->user->name) }}&background=6366f1&color=fff&bold=true" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-bold text-slate-700 truncate group-hover:text-accent transition-colors leading-tight">{{ $p->user->name }}</p>
                                        <p class="text-[9px] text-slate-400 font-medium">{{ \Carbon\Carbon::parse($p->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($event['registered'] > 10)
                            <div class="mt-4 pt-4 border-t border-slate-50">
                                <p class="text-[10px] text-center text-slate-400 font-bold italic">... và {{ $event['registered'] - 10 }} thành viên khác</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-3 transform -rotate-6">
                                <svg class="w-7 h-7 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <p class="text-xs text-slate-400 font-bold tracking-tight">Chưa có thành viên nào</p>
                        </div>
                    @endif
                </div>

                <!-- Sharing -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Chia sẻ</h3>
                    <div class="flex space-x-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg flex items-center justify-center transition-colors">
                            <span class="text-sm font-bold">Facebook</span>
                        </a>
                        <button onclick="copyToClipboard(window.location.href)" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 py-2 rounded-lg flex items-center justify-center transition-colors">
                            <span class="text-sm font-bold">Copy Link</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Registration Form Modal -->
        @if(isset($form))
        <div x-show="isRegistrationModalOpen" style="display: none" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isRegistrationModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" @click="isRegistrationModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="isRegistrationModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-xl w-full sm:p-6">
                    <div class="absolute top-0 right-0 pt-4 pr-4">
                        <button type="button" @click="isRegistrationModalOpen = false" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">Đóng</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-bold leading-6 text-gray-900 mb-4" id="modal-title">
                                Đơn đăng ký tham gia
                            </h3>
                            <div class="mt-2 text-sm text-gray-500 mb-6">Bạn vui lòng điền đầy đủ các thông tin theo yêu cầu của BTC.</div>
                            
                            <form action="{{ route('student.events.register.store', $event['id']) }}" method="POST" class="space-y-5">
                                @csrf
                                
                                @if(isset($positions) && count($positions) > 0)
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Vị trí đăng ký <span class="text-red-500">*</span></label>
                                    <div class="space-y-2">
                                        @foreach($positions as $pos)
                                        <label class="flex items-center p-3 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition-colors">
                                            <input type="radio" name="position_id" value="{{ $pos->id }}" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                                            <div class="ml-3 flex-1">
                                                <span class="block text-sm font-bold text-gray-900">{{ $pos->name }}</span>
                                                <span class="block text-xs text-gray-500">{{ $pos->description }}</span>
                                            </div>
                                            <div class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">SL: {{ $pos->quantity }}</div>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(isset($fields) && count($fields) > 0)
                                    @foreach($fields as $field)
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">
                                            {{ $field->question }}
                                            @if($field->is_required) <span class="text-red-500">*</span> @endif
                                        </label>
                                        
                                        @if($field->type == 'select')
                                            @php $options = json_decode($field->options, true) ?? []; @endphp
                                            <select name="custom_answers[{{ $field->id }}]" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-gray-700" {{ $field->is_required ? 'required' : '' }}>
                                                <option value="">-- Chọn một tùy chọn --</option>
                                                @foreach($options as $opt)
                                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                        @elseif($field->type == 'checkbox')
                                            @php $options = json_decode($field->options, true) ?? []; @endphp
                                            <div class="grid grid-cols-2 gap-2 mt-2">
                                                @foreach($options as $opt)
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="checkbox" name="custom_answers[{{ $field->id }}][]" value="{{ $opt }}" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                                                    <span class="ml-2 text-sm text-gray-700">{{ $opt }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <input type="text" name="custom_answers[{{ $field->id }}]" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-gray-700" {{ $field->is_required ? 'required' : '' }} placeholder="Câu trả lời của bạn">
                                        @endif
                                    </div>
                                    @endforeach
                                @endif

                                <div class="mt-6 flex gap-3">
                                     <button type="button" @click="isRegistrationModalOpen = false" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-gray-700 font-bold hover:bg-gray-50 transition-colors">
                                        Hủy bỏ
                                    </button>
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-500/30 transition-all">
                                        Xác nhận Đăng ký
                                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function copyToClipboard(text) {
        if (!navigator.clipboard) {
            fallbackCopyTextToClipboard(text);
            return;
        }
        navigator.clipboard.writeText(text).then(function() {
            alert('Đã copy liên kết vào bộ nhớ tạm!');
        }, function(err) {
            fallbackCopyTextToClipboard(text);
        });
    }

    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        
        // Avoid scrolling to bottom
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            if (successful) {
                alert('Đã copy liên kết vào bộ nhớ tạm!');
            } else {
                alert('Không thể copy liên kết.');
            }
        } catch (err) {
            alert('Không thể copy liên kết.');
        }

        document.body.removeChild(textArea);
    }
</script>
@endpush
