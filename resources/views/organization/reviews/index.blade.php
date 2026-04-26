@extends('layouts.organization')

@section('header', 'Đánh giá & Phản hồi')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- Hero Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Avg Rating -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-5 transform translate-x-4 -translate-y-4 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-slate-500 font-medium mb-1">Đánh giá chung</p>
                <div class="flex items-end gap-3">
                    <h2 class="text-5xl font-black text-slate-800">{{ number_format($avgRating, 1) }}</h2>
                    <div class="mb-2 flex items-center gap-1 text-yellow-500">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
                <p class="text-sm text-emerald-600 mt-2 font-bold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    Xu hướng tích cực trong 30 ngày qua
                </p>
            </div>
        </div>

        <!-- Total Reviews -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-center gap-4">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl">
                     <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                </div>
                <div>
                     <p class="text-slate-500 font-medium">Tổng lượt đánh giá</p>
                     <h2 class="text-4xl font-black text-slate-800">{{ $totalReviews }}</h2>
                </div>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                <div class="bg-indigo-500 h-full rounded-full" style="width: 70%"></div>
            </div>
             <p class="text-xs text-slate-400 text-right">70% phản hồi có nội dung</p>
        </div>

        <!-- Action Card -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-8 rounded-3xl shadow-lg text-white flex flex-col justify-between relative overflow-hidden">
             <div class="absolute top-0 right-0 p-8 opacity-20 transform translate-x-8 -translate-y-8">
                 <svg class="w-40 h-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="relative z-10">
                <h3 class="text-xl font-bold mb-2">Lời khuyên</h3>
                <p class="text-indigo-100 text-sm mb-4">Các sự kiện có hình ảnh thực tế thường nhận được đánh giá cao hơn từ tình nguyện viên.</p>
                <a href="{{ route('organization.events.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl text-sm font-bold transition-all w-fit">
                    Quản lý hình ảnh sự kiện &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4 justify-between items-center">
        <form action="{{ route('organization.reviews.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <select name="event_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm font-medium text-slate-600 focus:ring-2 focus:ring-indigo-500/20">
                <option value="all">Tất cả chiến dịch</option>
                @foreach($orgEvents as $event)
                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>{{ Str::limit($event->title, 40) }}</option>
                @endforeach
            </select>
            
            <div class="flex bg-slate-50 rounded-xl p-1 overflow-x-auto">
                <button type="submit" name="rating" value="all" class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap {{ request('rating', 'all') == 'all' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">Tất cả</button>
                <button type="submit" name="rating" value="5" class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap {{ request('rating') == '5' ? 'bg-white shadow-sm text-yellow-600' : 'text-slate-500 hover:text-slate-700' }}">5 ⭐</button>
                <button type="submit" name="rating" value="4" class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap {{ request('rating') == '4' ? 'bg-white shadow-sm text-yellow-600' : 'text-slate-500 hover:text-slate-700' }}">4 ⭐</button>
                <button type="submit" name="rating" value="3" class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap {{ request('rating') == '3' ? 'bg-white shadow-sm text-yellow-600' : 'text-slate-500 hover:text-slate-700' }}">3 ⭐</button>
                <button type="submit" name="rating" value="2" class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap {{ request('rating') == '2' ? 'bg-white shadow-sm text-yellow-600' : 'text-slate-500 hover:text-slate-700' }}">2 ⭐</button>
                <button type="submit" name="rating" value="1" class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all whitespace-nowrap {{ request('rating') == '1' ? 'bg-white shadow-sm text-yellow-600' : 'text-slate-500 hover:text-slate-700' }}">1 ⭐</button>
            </div>
        </form>

        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-slate-500">Sắp xếp:</span>
            <select class="px-3 py-1.5 bg-transparent border-none text-sm font-bold text-slate-700 focus:ring-0 cursor-pointer">
                <option>Mới nhất</option>
                <option>Cũ nhất</option>
            </select>
        </div>
    </div>

    <!-- Reviews Grid -->
    <div class="grid grid-cols-1 gap-4">
        @forelse($reviews as $review)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all flex flex-col md:flex-row gap-6">
            <!-- User Info -->
            <div class="flex-shrink-0 flex md:flex-col items-center gap-3 md:w-32 text-center border-b md:border-b-0 md:border-r border-slate-50 pb-4 md:pb-0 md:pr-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random" class="w-12 h-12 rounded-full border-2 border-white shadow-sm">
                <div class="text-left md:text-center">
                    <h4 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $review->user->name }}</h4>
                    <p class="text-xs text-slate-400">{{ $review->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Content -->
            <div class="flex-1 space-y-3">
                 <div class="flex justify-between items-start">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-600 max-w-[200px] truncate" title="{{ $review->event->title }}">
                            {{ $review->event->title }}
                        </span>
                    </div>
                    @if($review->rating >= 5)
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-500 uppercase tracking-wide border border-rose-100">Tuyệt vời</span>
                    @endif
                </div>

                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400 fill-current drop-shadow-sm' : 'text-slate-200' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363 1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    @endfor
                </div>
                
                <div class="relative bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <svg class="absolute top-2 left-2 w-6 h-6 text-slate-200 transform -translate-x-1 -translate-y-1" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.054 15.619 14.545 17.653 14.545L18.428 14.545C19.349 14.545 20.096 13.798 20.096 12.877L20.096 9.346C20.096 8.425 19.349 7.678 18.428 7.678L16.428 7.678C15.507 7.678 14.76 8.425 14.76 9.346L14.76 11.235C14.76 11.666 14.717 12.067 14.636 12.433C14.249 14.175 12.457 15.361 10.665 15.361L10.665 15.361C8.783 15.361 7.258 13.836 7.258 11.954C7.258 10.072 8.783 8.547 10.665 8.547L10.941 8.547C11.396 8.547 11.764 8.179 11.764 7.724L11.764 5.346C11.764 4.891 11.396 4.523 10.941 4.523L10.665 4.523C6.559 4.523 3.232 7.85 3.232 11.954C3.232 16.059 6.559 19.387 10.665 19.387L11.259 19.387C13.067 19.387 14.589 20.846 14.647 22.651C14.653 22.846 14.814 23 15.009 23L17.514 23C17.79 23 18.014 22.776 18.014 22.499L18.014 21L14.017 21Z"/></svg>
                    <p class="text-slate-600 text-sm italic relative z-10 pl-4">{{ $review->comment ?? 'Không có nhận xét chi tiết.' }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-24 bg-white rounded-3xl border-2 border-dashed border-slate-100">
            <div class="bg-slate-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Chưa có đánh giá nào</h3>
            <p class="text-slate-500 max-w-sm mx-auto">Các đánh giá từ tình nguyện viên sẽ xuất hiện tại đây sau khi họ hoàn thành nhiệm vụ.</p>
        </div>
        @endforelse
    </div>
    
    <div class="pb-12">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
</div>
@endsection


