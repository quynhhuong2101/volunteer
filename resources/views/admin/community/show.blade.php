@extends('layouts.admin')

@section('header', 'Chi tiết Bài đăng Cộng đồng')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header/Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.community.index') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i> Trở về danh sách
        </a>
        <form action="{{ route('admin.community.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này không?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white transition-colors border border-red-200 hover:border-red-600 shadow-sm">
                <i class="fa-solid fa-trash-can mr-2"></i> Xóa bài vi phạm
            </button>
        </form>
    </div>

    <!-- Post Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="p-8">
            <!-- Author Header -->
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    @if($post->user->avatar)
                        <img src="{{ $post->user->avatar }}" class="w-14 h-14 rounded-full object-cover ring-4 ring-slate-50">
                    @else
                        <div class="w-14 h-14 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-700 font-bold text-xl ring-4 ring-slate-50">
                            {{ substr($post->user->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-lg text-slate-900">{{ $post->user->name }}</h3>
                            @if($post->user->role === 'student')<span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Sinh viên</span>
                            @elseif($post->user->role === 'organizer')<span class="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Tổ chức</span>
                            @elseif($post->user->role === 'admin')<span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Quản trị</span>@endif
                        </div>
                        <p class="text-sm font-medium text-slate-500">{{ $post->user->email }} • Nhóm: {{ $post->user->role }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-slate-500 mb-2">{{ $post->created_at->format('H:i - d/m/Y') }}</p>
                     @if($post->type === 'idea')
                        <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-bold border border-yellow-200">Ý tưởng dự án</span>
                    @elseif($post->type === 'recruitment')
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-lg text-sm font-bold border border-green-200">Tuyển TNV</span>
                    @elseif($post->type === 'announcement')
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-sm font-bold border border-blue-200">Thông báo chung</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-800 rounded-lg text-sm font-bold border border-slate-200">Khác</span>
                    @endif
                </div>
            </div>

            <!-- Title & Body -->
            <h1 class="text-2xl font-black text-slate-900 mb-6 leading-tight">{{ $post->title }}</h1>
            <div class="prose max-w-none text-slate-700 leading-relaxed text-[1.05rem] mb-6">
                {!! nl2br(e($post->content)) !!}
            </div>

            @if($post->image_url)
            <div class="w-full rounded-2xl overflow-hidden mb-6 border border-slate-100 shadow-sm">
                <img src="{{ asset('storage/' . $post->image_url) }}" alt="Post image" class="w-full object-cover max-h-[500px]">
            </div>
            @endif
        </div>

        <!-- Meta Stats -->
        <div class="bg-slate-50 px-8 py-5 border-t border-slate-100 flex items-center gap-8">
            <div class="flex items-center gap-2 text-slate-600 font-bold">
                <i class="fa-solid fa-thumbs-up text-emerald-500 text-lg"></i>
                <span class="text-lg">{{ $post->reactions->where('type', 'like')->count() }}</span> lượt thích
            </div>
            <div class="flex items-center gap-2 text-slate-600 font-bold">
                <i class="fa-solid fa-thumbs-down text-red-500 text-lg"></i>
                <span class="text-lg">{{ $post->reactions->where('type', 'dislike')->count() }}</span> không thích
            </div>
            <div class="flex items-center gap-2 text-slate-600 font-bold">
                <i class="fa-solid fa-comment text-indigo-500 text-lg"></i>
                <span class="text-lg">{{ $post->comments->count() }}</span> bình luận
            </div>
        </div>
    </div>

    <!-- Comments Moderation -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h3 class="text-xl font-extrabold text-slate-800 mb-6 flex items-center gap-3">
            <i class="fa-solid fa-comments text-indigo-500"></i>
            Chi tiết Bình luận
        </h3>
        
        <div class="space-y-6">
            @forelse($post->comments->whereNull('parent_id')->sortByDesc('created_at') as $comment)
                <div class="flex gap-4 items-start p-4 bg-slate-50 transition-colors rounded-xl border border-slate-100">
                    <div class="flex-shrink-0">
                        @if($comment->user->avatar)
                            <img src="{{ $comment->user->avatar }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                        @else
                            <div class="w-10 h-10 rounded-full bg-white text-slate-600 flex items-center justify-center font-bold text-sm border border-slate-200">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-slate-900 text-sm">{{ $comment->user->name }}</h4>
                                @if($comment->user->role === 'student')<span class="bg-blue-100 text-blue-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Sinh viên</span>
                                @elseif($comment->user->role === 'organizer')<span class="bg-indigo-100 text-indigo-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Tổ chức</span>
                                @elseif($comment->user->role === 'admin')<span class="bg-red-100 text-red-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Quản trị</span>@endif
                            </div>
                            <span class="text-xs font-bold text-slate-400">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="text-slate-700 text-sm leading-relaxed mb-2">{{ $comment->content }}</p>

                        <!-- Replies -->
                        @if($comment->replies->count() > 0)
                        <div class="mt-4 space-y-3 pl-4 border-l-2 border-slate-200">
                            @foreach($comment->replies as $reply)
                            <div class="flex gap-3 items-start bg-white p-3 rounded-lg border border-slate-100">
                                <div class="flex-shrink-0">
                                    @if($reply->user->avatar)
                                        <img src="{{ $reply->user->avatar }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-slate-50 text-slate-500 flex items-center justify-center font-bold text-xs border border-slate-200">
                                            {{ substr($reply->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-baseline justify-between mb-1">
                                        <h4 class="font-bold text-slate-800 text-[13px]">{{ $reply->user->name }}</h4>
                                        <span class="text-[11px] font-bold text-slate-400">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-slate-600 text-sm leading-relaxed">{{ $reply->content }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-10 rounded-xl border border-dashed border-slate-200">
                    <p class="text-slate-500 font-medium">Bài đăng này chưa có bình luận nào.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
