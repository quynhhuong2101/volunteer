@extends('layouts.admin')

@section('header', 'Quản trị Cộng đồng')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-500">Tổng Bài Đăng</p>
                <p class="text-2xl font-extrabold text-slate-800">{{ $posts->total() }}</p>
            </div>
        </div>
        <!-- Add more stats if needed -->
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Danh sách Bài đăng Cộng đồng</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tác giả</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-1/3">Tiêu đề (Loại)</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Tương tác</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Ngày đăng</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($posts as $post)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($post->user->avatar)
                                    <img src="{{ $post->user->avatar }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold font-mono text-sm border border-indigo-100">
                                        {{ substr($post->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $post->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $post->user->role == 'student' ? 'Sinh viên' : 'Tổ chức' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors line-clamp-1 mb-1">
                                <a href="{{ route('admin.community.show', $post->id) }}">{{ $post->title }}</a>
                            </div>
                            <div>
                                @if($post->type === 'idea')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">💡 Ý tưởng</span>
                                @elseif($post->type === 'recruitment')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-green-100 text-green-800 border border-green-200">🤝 Tuyển dụng</span>
                                @elseif($post->type === 'announcement')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-100 text-blue-800 border border-blue-200">📢 Thông báo</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-200">Khác</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-4 text-xs font-medium text-slate-500">
                                <span class="flex items-center gap-1.5" title="Hữu ích"><i class="fa-solid fa-thumbs-up text-emerald-500"></i> {{ $post->reactions->where('type', 'like')->count() }}</span>
                                <span class="flex items-center gap-1.5" title="Bình luận"><i class="fa-solid fa-comment text-indigo-500"></i> {{ $post->comments->count() }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-slate-500 font-medium">
                            {{ $post->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.community.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài đăng này không? Hành động này không thể hoàn tác.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Xóa bài đăng vi phạm">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-regular fa-folder-open text-2xl text-slate-400"></i>
                            </div>
                            <p class="text-sm font-medium">Chưa có bài đăng nào trong cộng đồng.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
        <div class="p-6 border-t border-slate-100 bg-slate-50/50">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
