@extends('layouts.student')

@section('header', 'Chi tiết bài viết')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center text-sm font-medium text-slate-500">
        <a href="{{ route('student.community.index') }}" class="hover:text-primary transition-colors">Cộng đồng</a>
        <svg class="w-4 h-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-800">Chi tiết</span>
    </div>

    <!-- Post Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="p-8">
            <!-- Author Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    @if($post->user->avatar)
                        <img src="{{ $post->user->avatar }}" class="w-14 h-14 rounded-full object-cover shadow-sm">
                    @else
                        <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xl shadow-sm">
                            {{ substr($post->user->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-lg text-slate-800">{{ $post->user->name }}</h3>
                            @if($post->user->hasRole('student'))<span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Sinh viên</span>
                            @elseif($post->user->hasRole('organizer'))<span class="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Tổ chức</span>
                            @elseif($post->user->hasRole('admin'))<span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Quản trị</span>@endif
                        </div>
                        <div class="flex items-center text-sm text-slate-500 gap-2 mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div>
                     @if($post->type === 'idea')
                        <span class="inline-flex items-center px-4 py-1.5 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-bold border border-yellow-200">
                            <span class="mr-2">💡</span> Ý tưởng dự án
                        </span>
                    @elseif($post->type === 'recruitment')
                        <span class="inline-flex items-center px-4 py-1.5 bg-green-100 text-green-800 rounded-lg text-sm font-bold border border-green-200">
                            <span class="mr-2">🤝</span> Tuyển TNV
                        </span>
                    @elseif($post->type === 'announcement')
                        <span class="inline-flex items-center px-4 py-1.5 bg-blue-100 text-blue-800 rounded-lg text-sm font-bold border border-blue-200">
                            <span class="mr-2">📢</span> Thông báo
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-1.5 bg-slate-100 text-slate-800 rounded-lg text-sm font-bold border border-slate-200">Khác</span>
                    @endif
                </div>
            </div>

            <!-- Title & Body -->
            <h1 class="text-3xl font-extrabold text-slate-900 mb-6 leading-tight">{{ $post->title }}</h1>
            <div class="prose max-w-none text-slate-700 leading-loose text-[1.1rem] mb-6">
                {!! nl2br(e($post->content)) !!}
            </div>
            
            @if($post->image_url)
            <div class="w-full rounded-2xl overflow-hidden mb-6 border border-slate-100 shadow-sm">
                <img src="{{ asset('storage/' . $post->image_url) }}" alt="Post image" class="w-full object-cover max-h-[500px]">
            </div>
            @endif
            
            @if($post->type === 'recruitment')
            <div class="mt-8 p-4 bg-indigo-50 border border-indigo-100 rounded-xl flex items-start gap-4">
                <div class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <h4 class="font-bold text-indigo-900 mb-1">Mẹo kết nối</h4>
                    <p class="text-sm text-indigo-800">Hãy để lại bình luận bên dưới với thông tin liên hệ của bạn nếu muốn tham gia vào dự án này!</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Interactions Action Bar -->
        <div id="action-bar-container" class="bg-slate-50 px-8 py-4 border-t border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Like Button -->
                @php
                    $isLiked = $post->reactions->where('user_id', auth()->id())->where('type', 'like')->count() > 0;
                    $isDisliked = $post->reactions->where('user_id', auth()->id())->where('type', 'dislike')->count() > 0;
                @endphp
                <button type="button" onclick="reactToPost({{ $post->id }}, 'like')" id="btn-like-{{ $post->id }}" 
                        class="flex items-center gap-2 px-4 py-2 rounded-xl font-bold transition-all {{ $isLiked ? 'bg-emerald-100 text-emerald-700' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                     <svg class="w-5 h-5 {{ $isLiked ? 'text-emerald-500' : '' }}" fill="{{ $isLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                    </svg>
                    <span id="count-like-{{ $post->id }}">{{ $post->reactions->where('type', 'like')->count() }}</span> Hữu ích
                </button>

                <!-- Dislike Button -->
                <button type="button" onclick="reactToPost({{ $post->id }}, 'dislike')" id="btn-dislike-{{ $post->id }}" 
                        class="flex items-center gap-2 px-4 py-2 rounded-xl font-bold transition-all {{ $isDisliked ? 'bg-red-100 text-red-700' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100' }}">
                    <svg class="w-5 h-5 {{ $isDisliked ? 'text-red-500' : '' }}" fill="{{ $isDisliked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                    </svg>
                    <span id="count-dislike-{{ $post->id }}">{{ $post->reactions->where('type', 'dislike')->count() }}</span>
                </button>
            </div>
            
            <div class="text-slate-500 font-medium">
                {{ $post->comments->count() }} Bình luận
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div id="comments-wrapper" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <h3 class="text-xl font-bold text-slate-800 mb-6">Bình luận</h3>
        
        <!-- Comment Form -->
        <form action="{{ route('student.community.comment', $post->id) }}" method="POST" class="ajax-comment-form mb-8 flex gap-4">
            @csrf
            <div class="flex-shrink-0 mt-1">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <textarea name="content" required rows="3" placeholder="Chia sẻ suy nghĩ của bạn về bài đăng này..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors resize-y"></textarea>
                <div class="mt-2 text-right">
                    <button type="submit" class="px-6 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-all shadow-md">Gửi bình luận</button>
                </div>
            </div>
        </form>

        <!-- Comments List -->
        <div class="space-y-8">
            @forelse($post->comments->whereNull('parent_id')->sortByDesc('created_at') as $comment)
                <div class="group">
                    <!-- Parent Comment -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            @if($comment->user->avatar)
                                <img src="{{ $comment->user->avatar }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                             <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl rounded-tl-none relative">
                                 <div class="flex items-center justify-between mb-1">
                                     <div class="flex items-center gap-2">
                                         <h4 class="font-bold text-slate-800 text-sm">{{ $comment->user->name }}</h4>
                                         @if($comment->user->hasRole('student'))<span class="bg-blue-100 text-blue-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Sinh viên</span>
                                         @elseif($comment->user->hasRole('organizer'))<span class="bg-indigo-100 text-indigo-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Tổ chức</span>
                                         @elseif($comment->user->hasRole('admin'))<span class="bg-red-100 text-red-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Quản trị</span>@endif
                                     </div>
                                     <span class="text-xs font-medium text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                 </div>
                                 <p class="text-slate-700 text-[0.95rem] leading-relaxed">{{ $comment->content }}</p>
                             </div>
                             
                             <!-- Comment Actions -->
                             <div class="flex items-center gap-4 mt-2 ml-2 text-sm">
                                 @php
                                     $cLiked = $comment->reactions->where('user_id', auth()->id())->where('type', 'like')->count() > 0;
                                     $cDisliked = $comment->reactions->where('user_id', auth()->id())->where('type', 'dislike')->count() > 0;
                                 @endphp
                                 <button type="button" onclick="reactToComment({{ $comment->id }}, 'like')" class="flex items-center gap-1 font-medium transition-colors {{ $cLiked ? 'text-emerald-600' : 'text-slate-500 hover:text-emerald-600' }}">
                                     <svg class="w-4 h-4" fill="{{ $cLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                     {{ $comment->reactions->where('type', 'like')->count() }}
                                 </button>
                                 <button type="button" onclick="reactToComment({{ $comment->id }}, 'dislike')" class="flex items-center gap-1 font-medium transition-colors {{ $cDisliked ? 'text-red-600' : 'text-slate-500 hover:text-red-600' }}">
                                     <svg class="w-4 h-4" fill="{{ $cDisliked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" /></svg>
                                 </button>
                                 <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="font-bold text-slate-500 hover:text-primary transition-colors">Trả lời</button>
                             </div>

                             <!-- Reply Form (Hidden by default) -->
                             <form id="reply-form-{{ $comment->id }}" action="{{ route('student.community.comment', $post->id) }}" method="POST" class="ajax-comment-form hidden mt-4 flex gap-3">
                                 @csrf
                                 <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                 <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                 </div>
                                 <div class="flex-1">
                                     <textarea name="content" required rows="2" placeholder="Viết câu trả lời..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors resize-y"></textarea>
                                     <div class="mt-2 text-right">
                                         <button type="submit" class="px-4 py-1.5 bg-primary text-white font-bold rounded-lg text-sm hover:bg-primary-dark transition-all shadow-sm">Gửi</button>
                                     </div>
                                 </div>
                             </form>

                             <!-- Replies List -->
                             @if($comment->replies->count() > 0)
                             <div class="mt-4 space-y-4 pl-4 border-l-2 border-slate-100">
                                 @foreach($comment->replies as $reply)
                                 <div class="flex gap-3">
                                     <div class="flex-shrink-0">
                                         @if($reply->user->avatar)
                                             <img src="{{ $reply->user->avatar }}" class="w-8 h-8 rounded-full object-cover">
                                         @else
                                             <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs">
                                                 {{ substr($reply->user->name, 0, 1) }}
                                             </div>
                                         @endif
                                     </div>
                                     <div class="flex-1">
                                         <div class="bg-white border border-slate-100 p-3 rounded-2xl rounded-tl-none">
                                             <div class="flex items-center justify-between mb-1">
                                                 <div class="flex items-center gap-2">
                                                     <h4 class="font-bold text-slate-800 text-[13px]">{{ $reply->user->name }}</h4>
                                                     @if($reply->user->hasRole('student'))<span class="bg-blue-100 text-blue-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Sinh viên</span>
                                                     @elseif($reply->user->hasRole('organizer'))<span class="bg-indigo-100 text-indigo-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Tổ chức</span>
                                                     @elseif($reply->user->hasRole('admin'))<span class="bg-red-100 text-red-700 text-[9px] px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Quản trị</span>@endif
                                                 </div>
                                                 <span class="text-[11px] font-medium text-slate-400">{{ $reply->created_at->diffForHumans() }}</span>
                                             </div>
                                             <p class="text-slate-700 text-sm leading-relaxed">{{ $reply->content }}</p>
                                         </div>
                                         
                                         <!-- Reply Actions -->
                                         <div class="flex items-center gap-4 mt-1.5 ml-2 text-xs">
                                             @php
                                                 $rLiked = $reply->reactions->where('user_id', auth()->id())->where('type', 'like')->count() > 0;
                                                 $rDisliked = $reply->reactions->where('user_id', auth()->id())->where('type', 'dislike')->count() > 0;
                                             @endphp
                                             <button type="button" onclick="reactToComment({{ $reply->id }}, 'like')" class="flex items-center gap-1 font-medium transition-colors {{ $rLiked ? 'text-emerald-600' : 'text-slate-500 hover:text-emerald-600' }}">
                                                 <svg class="w-3.5 h-3.5" fill="{{ $rLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                                 {{ $reply->reactions->where('type', 'like')->count() }}
                                             </button>
                                             <button type="button" onclick="reactToComment({{ $reply->id }}, 'dislike')" class="flex items-center gap-1 font-medium transition-colors {{ $rDisliked ? 'text-red-600' : 'text-slate-500 hover:text-red-600' }}">
                                                 <svg class="w-3.5 h-3.5" fill="{{ $rDisliked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" /></svg>
                                             </button>
                                         </div>
                                     </div>
                                 </div>
                                 @endforeach
                             </div>
                             @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-slate-500 font-medium">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Logic tắt/mở form trả lời bình luận
    function toggleReplyForm(commentId) {
        const form = document.getElementById(`reply-form-${commentId}`);
        if(form.classList.contains('hidden')) {
            form.classList.remove('hidden');
        } else {
            form.classList.add('hidden');
        }
    }

    // Hàm dùng chung để tải lại DOM phần Hành động và Bình luận (Không reload trang gốc)
    async function reloadPostSection() {
        try {
            const response = await fetch(window.location.href);
            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            const currentActionBar = document.getElementById('action-bar-container');
            const newActionBar = doc.getElementById('action-bar-container');
            if (currentActionBar && newActionBar) {
                currentActionBar.innerHTML = newActionBar.innerHTML;
            }

            const currentComments = document.getElementById('comments-wrapper');
            const newComments = doc.getElementById('comments-wrapper');
            if (currentComments && newComments) {
                currentComments.innerHTML = newComments.innerHTML;
            }
        } catch (error) {
            console.error('Lỗi cập nhật giao diện:', error);
        }
    }

    // Xử lý gửi Like/Dislike bài đăng qua AJAX
    function reactToPost(postId, type) {
        fetch(`/student/community/${postId}/react`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ type: type })
        })
        .then(response => response.json())
        .then(data => {
            reloadPostSection();
        })
        .catch(error => console.error('Error:', error));
    }

    // Xử lý gửi Like/Dislike bình luận qua AJAX
    function reactToComment(commentId, type) {
        fetch(`/student/community/${commentId}/comment/react`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ type: type })
        })
        .then(response => response.json())
        .then(data => {
            reloadPostSection();
        })
        .catch(error => console.error('Error:', error));
    }

    // Xử lý sự kiện đăng bình luận (Bình luận gốc / Trả lời)
    document.addEventListener('submit', async function(e) {
        if (e.target.matches('form.ajax-comment-form')) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="animate-pulse">Đang gửi...</span>';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (response.ok) {
                    Swal.fire({ 
                        toast: true, position: 'top-end', icon: 'success', 
                        title: 'Đã gửi bình luận!', showConfirmButton: false, timer: 2000 
                    });
                    
                    const html = await response.text();
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    
                    document.getElementById('action-bar-container').innerHTML = doc.getElementById('action-bar-container').innerHTML;
                    document.getElementById('comments-wrapper').innerHTML = doc.getElementById('comments-wrapper').innerHTML;
                } else {
                    Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Có lỗi xảy ra khi gửi bình luận.', showConfirmButton: false, timer: 3000 });
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            } catch (error) {
                console.error('Error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }
    });
</script>
@endpush
@endsection
