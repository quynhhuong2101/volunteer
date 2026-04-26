@extends('layouts.student')

@section('header', 'Cộng đồng Volunteer Connect')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Professional Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col sm:flex-row items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                Cộng đồng Tình nguyện
            </h2>
            <p class="text-slate-500 mt-1 text-sm">Nơi kết nối, chia sẻ ý tưởng và truyền cảm hứng thiện nguyện.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('student.community.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white font-medium text-sm rounded-lg hover:bg-primary-dark transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tạo bài viết
            </a>
        </div>
    </div>

    <!-- Feed -->
    <div class="space-y-4 pb-12">
        @forelse($posts as $post)
            <a href="{{ route('student.community.show', $post->id) }}" class="block bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-slate-300 transition-all group overflow-hidden">
                <div class="p-5 sm:p-6 pb-4">
                    <!-- Post Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            @if($post->user->avatar)
                                <img src="{{ $post->user->avatar }}" class="w-11 h-11 rounded-full object-cover border border-slate-100">
                            @else
                                <div class="w-11 h-11 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 font-bold text-lg border border-slate-100">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2 leading-none">
                                    <h4 class="font-bold text-slate-800 text-[15px] group-hover:text-primary transition-colors">{{ $post->user->name }}</h4>
                                    @if($post->user->hasRole('student'))<span class="text-slate-500 bg-slate-100 border border-slate-200 text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wide">Sinh viên</span>
                                    @elseif($post->user->hasRole('organizer'))<span class="text-indigo-600 bg-indigo-50 border border-indigo-100 text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wide">Tổ chức</span>
                                    @elseif($post->user->hasRole('admin'))<span class="text-red-600 bg-red-50 border border-red-200 text-[9px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wide">Quản trị</span>@endif
                                </div>
                                <p class="text-[12px] text-slate-400 mt-1.5 flex items-center gap-1 font-medium italic">
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Type Badge -->
                        <div>
                            @if($post->type === 'idea')
                                <span class="inline-flex items-center px-2 py-1 rounded bg-amber-50 border border-amber-100 text-[11px] font-bold text-amber-700">💡 Ý tưởng</span>
                            @elseif($post->type === 'recruitment')
                                <span class="inline-flex items-center px-2 py-1 rounded bg-emerald-50 border border-emerald-100 text-[11px] font-bold text-emerald-700">🤝 Tuyển dụng</span>
                            @elseif($post->type === 'announcement')
                                <span class="inline-flex items-center px-2 py-1 rounded bg-blue-50 border border-blue-100 text-[11px] font-bold text-blue-700">📢 Thông báo</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded bg-slate-50 border border-slate-200 text-[11px] font-bold text-slate-600">Khác</span>
                            @endif
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="space-y-2">
                        <h3 class="text-[17px] font-bold text-slate-900 leading-snug">{{ $post->title }}</h3>
                        <p class="text-slate-600 line-clamp-3 text-[14.5px] leading-relaxed">{{ Str::limit($post->content, 220) }}</p>
                    </div>
                </div>

                <!-- Post Image (If exists) -->
                @if($post->image_url)
                    <div class="w-full h-64 sm:h-72 border-y border-slate-100 bg-slate-50 overflow-hidden">
                        <img src="{{ asset('storage/' . $post->image_url) }}" alt="Post cover" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-500">
                    </div>
                @endif

                <!-- Post Footer (Interactions - Clean Style) -->
                <div class="px-5 py-3 bg-slate-50/50 flex items-center justify-between border-t border-slate-100">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1.5 text-slate-500 hover:text-emerald-600 transition-colors font-semibold text-[13px]">
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                            <span>{{ $post->reactions->where('type', 'like')->count() }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-slate-400 hover:text-red-500 transition-colors font-semibold text-[13px]">
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" /></svg>
                            <span>{{ $post->reactions->where('type', 'dislike')->count() }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-slate-500 hover:text-primary transition-colors font-semibold text-[13px]">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        <span>{{ $post->comments->count() }} Bình luận</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-xl border border-slate-200 p-12 text-center text-slate-500 shadow-sm flex flex-col items-center justify-center">
                <div class="w-16 h-16 mb-4 bg-slate-50 rounded-full flex items-center justify-center border border-slate-100">
                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
                </div>
                <p class="font-bold text-slate-800">Chưa có bài viết nào</p>
                <p class="text-xs mt-1">Hãy là người đầu tiên chia sẻ ý tưởng!</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="pt-4 pb-8">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

