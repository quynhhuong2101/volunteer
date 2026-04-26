@extends('layouts.organization')

@section('header', 'Cộng đồng Truyền cảm hứng')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Cộng đồng</h2>
            <p class="text-slate-500 mt-1">Kết nối, tuyển mộ tình nguyện viên và chia sẻ những câu chuyện ý nghĩa.</p>
        </div>
        <a href="{{ route('organization.community.create') }}" class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/30 transform hover:-translate-y-0.5 whitespace-nowrap">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tạo bài đăng mới
        </a>
    </div>

    <!-- Feed -->
    <div class="space-y-4">
        @forelse($posts as $post)
            <a href="{{ route('organization.community.show', $post->id) }}" class="block p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                <!-- Post Header -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        @if($post->user->avatar)
                            <img src="{{ $post->user->avatar }}" class="w-12 h-12 rounded-full object-cover shadow-sm">
                        @else
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-lg shadow-sm">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $post->user->name }}</h4>
                            <p class="text-xs text-slate-500 font-medium">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div>
                        @if($post->type === 'idea')
                            <span class="inline-block px-3 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs font-bold border border-yellow-200">💡 Ý tưởng dự án</span>
                        @elseif($post->type === 'recruitment')
                            <span class="inline-block px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-200">🤝 Tuyển TNV</span>
                        @elseif($post->type === 'announcement')
                            <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold border border-blue-200">📢 Thông báo</span>
                        @else
                            <span class="inline-block px-3 py-1 bg-slate-50 text-slate-700 rounded-full text-xs font-bold border border-slate-200">Khác</span>
                        @endif
                    </div>
                </div>

                <!-- Post Content -->
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-primary transition-colors">{{ $post->title }}</h3>
                    <p class="text-slate-600 line-clamp-2 leading-relaxed mb-3">{{ Str::limit($post->content, 200) }}</p>
                    <!-- Image Thumbnail (If any) -->
                    @if($post->image_url)
                        <div class="mt-4 rounded-xl overflow-hidden border border-slate-100 max-h-64 mb-4">
                            <img src="{{ asset('storage/' . $post->image_url) }}" alt="Thumbnail" class="w-full h-full object-cover">
                        </div>
                    @endif
                </div>

                <!-- Post Footer (Interactions) -->
                <div class="flex items-center gap-6 pt-4 border-t border-slate-100">
                    <div class="flex items-center text-slate-500 gap-2 font-medium">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        <span>{{ $post->reactions->where('type', 'like')->count() }}</span>
                    </div>
                    <div class="flex items-center text-slate-500 gap-2 font-medium">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                        </svg>
                        <span>{{ $post->reactions->where('type', 'dislike')->count() }}</span>
                    </div>
                    <div class="flex items-center text-slate-500 gap-2 ml-auto font-medium bg-slate-50 px-3 py-1 rounded-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>{{ $post->comments->count() }} Bình luận</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="bg-white rounded-2xl border border-slate-100 p-12 text-center text-slate-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                </svg>
                <p class="text-lg font-bold">Chưa có bài viết nào trong cộng đồng.</p>
                <p class="text-sm mt-1">Gửi thông báo đầu tiên của Tổ chức ngay nào!</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="pt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
