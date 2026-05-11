@extends('layouts.student')

@section('header', 'Khám phá Sự kiện')

@section('content')
<div class="space-y-8">
    <!-- 1. Hero / Featured Section -->
    <div class="relative bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 rounded-[2.5rem] p-8 md:p-12 overflow-hidden shadow-2xl text-white">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-indigo-500/20 rounded-full blur-[100px] -mr-40 -mt-40 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-pink-500/20 rounded-full blur-[100px] -ml-20 -mb-20 animate-pulse" style="animation-duration: 4s;"></div>
        
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-emerald-300 text-xs font-bold uppercase tracking-widest backdrop-blur-md mb-6">
                    ✨ Featured Event
                </span>
                <h1 class="text-4xl md:text-5xl font-black leading-tight mb-6">
                    Mùa Hè Xanh <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-cyan-300">2024</span>
                </h1>
                <p class="text-lg text-indigo-100 mb-8 max-w-lg leading-relaxed">
                    Tham gia chiến dịch tình nguyện lớn nhất năm. Cùng chung tay xây dựng cộng đồng và tích lũy những trải nghiệm quý giá.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#" class="px-8 py-4 bg-white text-indigo-900 font-bold rounded-2xl shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:shadow-[0_0_30px_rgba(255,255,255,0.5)] hover:scale-105 transition-all duration-300 flex items-center">
                        Đăng ký ngay
                        <svg class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                    <button class="px-8 py-4 bg-indigo-800/50 hover:bg-indigo-700/50 text-white font-bold rounded-2xl border border-white/10 backdrop-blur-sm transition-all flex items-center">
                        Xem chi tiết
                    </button>
                </div>
            </div>
            <!-- Hero Image/Illustration -->
            <div class="relative hidden lg:block">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-pink-500 rounded-[2rem] rotate-3 opacity-20 blur-xl"></div>
                <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Volunteer" class="relative rounded-[2rem] shadow-2xl transform rotate-2 hover:rotate-0 transition-all duration-500 object-cover h-80 w-full border-4 border-white/10">
                
                <!-- Floating Stats -->
                <div class="absolute -bottom-6 -left-6 bg-white/10 backdrop-blur-xl border border-white/20 p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce" style="animation-duration: 3s;">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold">50</div>
                    <div>
                        <p class="text-xs text-indigo-200">Tình nguyện viên</p>
                        <p class="text-sm font-bold text-white">Đã tham gia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Advanced Filter Section -->
    <div class="z-30">
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white p-2">
            <form method="GET" action="{{ route('student.events.index') }}" class="flex flex-col md:flex-row gap-2">
                <!-- Search -->
                <div class="flex-1 relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="query" value="{{ request('query') }}" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all font-medium" placeholder="Tìm kiếm sự kiện...">
                </div>

                <!-- Scope Filter -->
                <div class="flex bg-slate-100 p-1 rounded-xl">
                    @foreach(['Tất cả', 'Trong trường', 'Ngoài trường'] as $scopeItem)
                        <button type="submit" name="scope" value="{{ $scopeItem }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ (request('scope') == $scopeItem) || (!request('scope') && $scopeItem == 'Tất cả') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                            {{ $scopeItem }}
                        </button>
                    @endforeach
                </div>

                <!-- Category Dropdown -->
                <div class="relative w-full md:w-48">
                    <select name="category" onchange="this.form.submit()" class="appearance-none block w-full pl-4 pr-10 py-3 bg-slate-50 border-none rounded-xl text-slate-700 font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white cursor-pointer group-hover:bg-white transition-all">
                        <option value="Tất cả">Tất cả thể loại</option>
                        @foreach(['Cộng đồng', 'Y tế', 'Giáo dục', 'Môi trường', 'Đào tạo', 'Thiện nguyện', 'Kỹ năng'] as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                     <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. Events Grid -->
    @if($events->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($events as $event)
        <a href="{{ route('student.events.show', $event['id']) }}" class="group bg-white rounded-[2rem] border border-slate-100 shadow-[0_2px_20px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.1)] transition-all duration-500 hover:-translate-y-2 overflow-hidden flex flex-col h-full relative">
            
            <!-- Image Container -->
            <div class="relative h-60 overflow-hidden">
                <img src="{{ Str::startsWith($event->image, 'http') ? $event->image : ($event->image ? asset($event->image) : 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80') }}" alt="{{ $event->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60"></div>
                
                <!-- Category Badge -->
                 @php
                    $colors = [
                        'Môi trường' => 'bg-emerald-500',
                        'Y tế' => 'bg-rose-500',
                        'Giáo dục' => 'bg-blue-500',
                        'Thiện nguyện' => 'bg-purple-500',
                        'Kỹ năng' => 'bg-amber-500'
                    ];
                    $bgClass = $colors[$event['category']] ?? 'bg-slate-500';
                @endphp
                <span class="absolute top-4 left-4 {{ $bgClass }} text-white text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm bg-opacity-90">
                    {{ $event['category'] }}
                </span>

                <!-- Status Badges -->
                @if($event['status'] == 'cancelled')
                <span class="absolute top-4 right-4 bg-red-600 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg">
                    ĐÃ HỦY
                </span>
                @elseif(\Carbon\Carbon::now()->gt($event['end_time']))
                <span class="absolute top-4 right-4 bg-slate-600 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg">
                    ĐÃ KẾT THÚC
                </span>
                @elseif(\Carbon\Carbon::now()->between($event['start_time'], $event['end_time']))
                <span class="absolute top-4 right-4 bg-emerald-500 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg animate-pulse">
                    ĐANG DIỄN RA
                </span>
                @elseif($event['is_hot'])
                <span class="absolute top-4 right-4 bg-red-500 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg animate-pulse">
                    HOT
                </span>
                @endif
                
                <!-- Date Badge (Bottom Left) -->
                <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-xl shadow-lg flex items-center gap-2">
                     <span class="text-xl font-black text-slate-800">{{ \Carbon\Carbon::parse($event->start_time)->format('d') }}</span>
                     <div class="flex flex-col leading-none">
                         <span class="text-[9px] font-bold text-slate-500 uppercase">{{ \Carbon\Carbon::parse($event->start_time)->format('M') }}</span>
                         <span class="text-[9px] font-bold text-slate-400">{{ \Carbon\Carbon::parse($event->start_time)->format('Y') }}</span>
                     </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 flex-1 flex flex-col">
                <div class="flex items-center gap-2 mb-3">
                     <span class="px-2 py-0.5 rounded-md bg-slate-50 text-slate-500 text-[10px] font-bold uppercase tracking-wide border border-slate-100 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                        {{ Str::limit($event['location'], 20) }}
                     </span>
                </div>

                <h3 class="text-xl font-black text-slate-800 mb-3 leading-snug group-hover:text-indigo-600 transition-colors line-clamp-2">
                    {{ $event['title'] }}
                </h3>
                
                <p class="text-slate-500 text-sm line-clamp-2 mb-6 font-medium">
                    {{ $event['description'] }}
                </p>

                <!-- Footer Info -->
                <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        @php
                            $checkinCount = $event->checkins()->count();
                        @endphp
                        <span class="text-xs font-bold text-slate-500"><span class="text-slate-800">{{ $checkinCount }}</span> tham gia</span>
                    </div>

                    <button class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-indigo-500/30">
                        <svg class="w-5 h-5 transform -rotate-45 group-hover:rotate-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mt-8">
        {{ $events->links() }}
    </div>
    @else
    <div class="bg-white rounded-[2.5rem] p-16 text-center shadow-sm border border-slate-100">
        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
        </div>
        <h3 class="text-2xl font-black text-slate-800 mb-2">Không tìm thấy sự kiện</h3>
        <p class="text-slate-500 max-w-md mx-auto mb-8 font-medium">Rất tiếc, không có sự kiện nào phù hợp với từ khóa của bạn. Hãy thử tìm kiếm với các từ khóa khác.</p>
        <a href="{{ route('student.events.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-xl hover:border-indigo-600 hover:text-indigo-600 transition-all">
            Xóa bộ lọc tìm kiếm
        </a>
    </div>
    @endif
</div>
@endsection
