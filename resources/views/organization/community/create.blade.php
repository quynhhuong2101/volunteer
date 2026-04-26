@extends('layouts.organization')

@section('header', 'Tạo bài đăng')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center text-sm font-medium text-slate-500">
        <a href="{{ route('organization.community.index') }}" class="hover:text-primary transition-colors">Cộng đồng</a>
        <svg class="w-4 h-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-800">Tạo bài đăng</span>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        <div class="mb-8 border-b border-slate-100 pb-6">
            <h2 class="text-2xl font-bold text-slate-800">Thông báo đến Cộng đồng</h2>
            <p class="text-slate-500 mt-2">Dùng bài viết này để thu hút sự chú ý của các tình nguyện viên tiềm năng.</p>
        </div>

        <form action="{{ route('organization.community.store') }}" method="POST" enctype="multipart/form-data" class="ajax-post-form space-y-6">
            @csrf

            <!-- Type -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Loại bài đăng</label>
                <div class="relative">
                    <select name="type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors appearance-none cursor-pointer">
                        <option value="announcement">📢 Bảng tin chung / Thông báo</option>
                        <option value="recruitment">🤝 Bài tuyển dụng Tình nguyện viên</option>
                        <option value="idea">💡 Đề xuất ý tưởng hợp tác</option>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Tiêu đề</label>
                <input type="text" name="title" required placeholder="Nhập tiêu đề thu hút..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nội dung chi tiết</label>
                <textarea name="content" required rows="8" placeholder="Viết những gì Tổ chức của bạn cần chia sẻ..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors resize-y leading-relaxed"></textarea>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Đính kèm hình ảnh (Không bắt buộc)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600 justify-center">
                            <label for="image" class="relative cursor-pointer rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none">
                                <span>Tải ảnh lên</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/png, image/jpeg, image/gif">
                            </label>
                            <p class="pl-1">hoặc kéo thả</p>
                        </div>
                        <p class="text-xs text-slate-500">PNG, JPG, GIF lên đến 5MB</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('organization.community.index') }}" class="px-6 py-3 font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors">Trở về</a>
                <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/30 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    Xuất bản ngay
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('submit', async function(e) {
        if (e.target.matches('form.ajax-post-form')) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="animate-pulse">Đang xử lý...</span>';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (response.ok) {
                    Swal.fire({ 
                        toast: true, position: 'top-end', icon: 'success', 
                        title: 'Đăng bài thành công!', showConfirmButton: false, timer: 1500 
                    }).then(() => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            window.location.href = "{{ route('organization.community.index') }}";
                        }
                    });
                } else {
                    Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Có lỗi xảy ra, vui lòng kiểm tra lại.', showConfirmButton: false, timer: 3000 });
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

    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                const uploadContainer = this.closest('.space-y-1');
                if (uploadContainer) {
                    const uploadText = uploadContainer.querySelector('p:last-child');
                    if (uploadText) {
                        uploadText.innerHTML = `<span class="text-emerald-600 font-bold">Đã đính kèm ảnh: ${fileName}</span>`;
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection
