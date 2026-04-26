@extends('layouts.student')

@section('header', 'Đánh giá hoạt động')

@section('content')
<div class="max-w-5xl mx-auto space-y-8" x-data="{ currentTab: 'pending' }">
    
    <!-- Hero Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Engagement -->
        <div class="bg-gradient-to-br from-[#0F4C81] to-[#1e4b85] rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-200 text-sm font-medium mb-1">Tổng sự kiện đã tham gia</p>
                <h3 class="text-4xl font-bold">{{ $reviewedEvents->count() + $pendingReviews->count() }}</h3>
                <div class="mt-4 flex items-center gap-2 text-xs bg-white/10 w-fit px-3 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    <span>{{ $pendingReviews->count() }} chờ đánh giá</span>
                </div>
            </div>
            <!-- Decor -->
            <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 rounded-full blur-2xl -mr-10 -mt-10"></div>
        </div>

        <!-- Card 2: Average Rating -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between relative overflow-hidden">
            <div>
                <p class="text-slate-500 text-sm font-medium mb-1">Đánh giá trung bình của bạn</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-bold text-slate-800">{{ number_format($reviewedEvents->avg('rating') ?? 0, 1) }}</h3>
                    <span class="text-yellow-500 text-xl">★</span>
                </div>
            </div>
            <div class="mt-4">
                 <p class="text-xs text-slate-400">Dựa trên {{ $reviewedEvents->count() }} đánh giá gần nhất</p>
            </div>
             <!-- Decor -->
            <div class="absolute right-4 bottom-4 opacity-5">
                 <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </div>
        </div>

        <!-- Card 3: Motivation -->
        <div class="bg-orange-50 rounded-3xl p-6 border border-orange-100 flex flex-col justify-center items-center text-center">
             <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-3 text-orange-500">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
             </div>
             <p class="text-slate-700 font-bold mb-1">Cảm ơn đóng góp của bạn!</p>
             <p class="text-slate-500 text-xs text-balance">Mỗi đánh giá giúp BTC tổ chức hoạt động tốt hơn.</p>
        </div>
    </div>
    
    <!-- Content Section -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden min-h-[500px]">
        
        <!-- Tabs Header -->
        <div class="flex items-center gap-2 p-4 border-b border-slate-100 bg-slate-50/50">
            <button @click="currentTab = 'pending'" 
                :class="currentTab === 'pending' ? 'bg-[#0F4C81] text-white shadow-md' : 'text-slate-500 hover:bg-white hover:text-slate-700'" 
                class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                Chờ đánh giá
                @if($pendingReviews->count() > 0)
                    <span :class="currentTab === 'pending' ? 'bg-white text-[#0F4C81]' : 'bg-red-500 text-white'" class="ml-1 w-5 h-5 flex items-center justify-center text-[10px] rounded-full transition-colors">{{ $pendingReviews->count() }}</span>
                @endif
            </button>
            <button @click="currentTab = 'history'" 
                :class="currentTab === 'history' ? 'bg-[#0F4C81] text-white shadow-md' : 'text-slate-500 hover:bg-white hover:text-slate-700'" 
                class="px-6 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2">
                Lịch sử
            </button>
        </div>

        <!-- PENDING REVIEWS TAB -->
        <div x-show="currentTab === 'pending'" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="p-6 md:p-8 space-y-6">
            @forelse($pendingReviews as $event)
            <div class="group bg-white rounded-2xl border border-slate-200 hover:border-blue-300 hover:shadow-lg transition-all duration-300 overflow-hidden" x-data="{ rating: 0, hoverRating: 0, showForm: false }">
                <div class="md:flex">
                    <!-- Event Image -->
                    <div class="md:w-1/3 min-h-[200px] relative overflow-hidden">
                        <img src="{{ $event->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($event->title) . '&background=random' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-4">
                             <div class="text-white">
                                <span class="text-xs font-bold bg-orange-500 px-2 py-1 rounded-md mb-2 inline-block">Cần Đánh Giá</span>
                                <h3 class="font-bold text-lg leading-tight">{{ $event->title }}</h3>
                             </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 p-6 flex flex-col justify-between">
                       <div>
                            <div class="flex flex-wrap gap-4 text-xs font-medium text-slate-500 mb-4">
                                <span class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded-md">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg> 
                                    Kết thúc: {{ \Carbon\Carbon::parse($event->end_time)->format('H:i d/m/Y') }}
                                </span>
                                <span class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded-md">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg> 
                                    {{ Str::limit($event->location, 30) }}
                                </span>
                            </div>
                            <p class="text-slate-600 text-sm line-clamp-2 mb-4">{{ $event->description }}</p>
                       </div>

                       <!-- Call to Action -->
                       <div x-show="!showForm">
                            <button @click="showForm = true" class="w-full bg-[#0F4C81] text-white py-3 rounded-xl font-bold hover:bg-[#0a365c] transition-colors shadow-lg shadow-blue-900/10 flex items-center justify-center gap-2">
                                <span class="text-xl pb-1">★</span> Viết đánh giá ngay
                            </button>
                       </div>

                        <!-- Rating Form (Expandable) -->
                        <div x-show="showForm" x-transition class="space-y-4 pt-4 border-t border-slate-100">
                             <form action="{{ route('student.reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="rating" :value="rating">
                                
                                <div class="flex justify-center mb-4 gap-2">
                                    <template x-for="star in 5">
                                        <button type="button" 
                                            @click="rating = star" 
                                            @mouseenter="hoverRating = star" 
                                            @mouseleave="hoverRating = 0"
                                            class="p-1 focus:outline-none transition-transform hover:scale-125 duration-200">
                                            <svg class="w-8 h-8 drop-shadow-sm" :class="(hoverRating || rating) >= star ? 'text-yellow-400 fill-current' : 'text-slate-200'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363 1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                                <div class="relative">
                                     <textarea name="comment" rows="3" placeholder="Chia sẻ trải nghiệm của bạn..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-[#0F4C81]/20 focus:border-[#0F4C81] resize-none"></textarea>
                                </div>
                                <div class="flex items-center justify-end gap-3 mt-3">
                                    <button type="button" @click="showForm = false" class="text-slate-500 font-medium hover:text-slate-700 text-sm px-3">Hủy</button>
                                    <button type="submit" :disabled="rating === 0" class="px-6 py-2 bg-[#0F4C81] text-white font-bold rounded-lg text-sm shadow-sm hover:bg-[#0a365c] disabled:opacity-50 disabled:cursor-not-allowed transition-all">Gửi đánh giá</button>
                                </div>
                             </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-32 h-32 bg-indigo-50 rounded-full flex items-center justify-center mb-6 animate-pulse">
                    <svg class="w-16 h-16 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Tuyệt vời! Bạn đã hoàn thành nhiệm vụ.</h3>
                <p class="text-slate-500 max-w-sm mx-auto">Tất cả các sự kiện bạn tham gia đã được đánh giá. Cảm ơn bạn đã đóng góp ý kiến!</p>
            </div>
            @endforelse
        </div>

        <!-- HISTORY TAB (Timeline Style) -->
        <div x-show="currentTab === 'history'" class="p-6 md:p-8" style="display: none;" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            @if($reviewedEvents->count() > 0)
                <div class="relative border-l-2 border-slate-100 ml-3 space-y-8 pl-8 pb-4">
                    @foreach($reviewedEvents as $review)
                    <div class="relative group">
                        <!-- Timeline Dot -->
                        <div class="absolute -left-[41px] top-4 w-6 h-6 rounded-full bg-white border-4 border-[#0F4C81] transition-transform group-hover:scale-110 shadow-sm z-10"></div>
                        
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="md:flex justify-between items-start mb-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100">
                                         <img src="{{ $review->event->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->event->title) . '&background=random' }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 text-lg">{{ $review->event->title }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex text-yellow-400 text-sm">
                                                @for($i=1; $i<=5; $i++)
                                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-slate-400">• {{ $review->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-slate-50 p-4 rounded-xl relative">
                                <svg class="w-8 h-8 text-slate-200 absolute -top-3 -left-2" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 13.1216 16 12.017 16H9C9.02126 13.6167 10.2792 11.4384 12.3 10.2628L12.6156 10.0833C13.5636 9.42197 13.7845 8.16788 13.0906 7.23467L12.7235 6.74101C12.0296 5.8078 10.7431 5.58913 9.79515 6.25046L9.67385 6.33509C7.15187 8.16489 5.48514 10.9202 5.09765 14H5.01695C3.91238 14 3.01695 14.8954 3.01695 16L3.01695 19C3.01695 20.1046 3.91238 21 5.01695 21H14.017ZM22.017 21L22.017 18C22.017 16.8954 21.1216 16 20.017 16H17C17.0213 13.6167 18.2792 11.4384 20.3 10.2628L20.6156 10.0833C21.5636 9.42197 21.7845 8.16788 21.0906 7.23467L20.7235 6.74101C20.0296 5.8078 18.7431 5.58913 17.7952 6.25046L17.6739 6.33509C15.1519 8.16489 13.4851 10.9202 13.0977 14H13.017C11.9124 14 11.017 14.8954 11.017 16L11.017 19C11.017 20.1046 11.9124 21 13.017 21H22.017Z" /></svg>
                                <p class="text-slate-600 pl-4 relative">{{ $review->comment }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <p class="text-slate-400">Bạn chưa có đánh giá nào trong lịch sử.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
