@extends('layouts.organization')

@section('header', 'Tạo Sự kiện Mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-slate-800">Tạo Chiến Dịch Mới</h1>
        <p class="text-slate-500 mt-2">Hãy điền thông tin chi tiết để bắt đầu tuyển tình nguyện viên</p>
    </div>

    <form action="{{ route('organization.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        @csrf
        
        <div class="p-8 space-y-8">
            <!-- Error Handling -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Có lỗi xảy ra</h3>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Section 1: General Info -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 text-sm">1</span>
                    Thông tin chung
                </h3>
                <div class="grid grid-cols-1 gap-6 ml-10">
                    <div class="group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tên sự kiện <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <input type="text" name="title" value="{{ old('title') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium placeholder-slate-400" 
                                placeholder="VD: Chiến dịch Mùa Hè Xanh 2024" required>
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Mô tả chi tiết</label>
                        <div class="relative">
                             <textarea name="description" rows="4" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium placeholder-slate-400" 
                                placeholder="Mô tả mục đích, ý nghĩa và nội dung chính của sự kiện...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Phạm vi tổ chức <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative border border-slate-200 rounded-xl p-4 cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="scope" value="trong_truong" class="absolute opacity-0" {{ old('scope') == 'trong_truong' || !old('scope') ? 'checked' : '' }}>
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full border border-slate-300 flex items-center justify-center text-indigo-600 peer-checked:border-indigo-600">
                                        <div class="w-2.5 h-2.5 rounded-full bg-current opacity-0 transition-opacity peer-checked:opacity-100"></div>
                                    </div>
                                    <span class="font-bold text-slate-700">Trong trường</span>
                                </div>
                            </label>
                            <label class="relative border border-slate-200 rounded-xl p-4 cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="scope" value="ngoai_truong" class="absolute opacity-0" {{ old('scope') == 'ngoai_truong' ? 'checked' : '' }}>
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full border border-slate-300 flex items-center justify-center text-indigo-600 peer-checked:border-indigo-600">
                                        <div class="w-2.5 h-2.5 rounded-full bg-current opacity-0 transition-opacity peer-checked:opacity-100"></div>
                                    </div>
                                    <span class="font-bold text-slate-700">Ngoài trường</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Time & Location -->
            <div>
                 <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 text-sm">2</span>
                    Thời gian & Địa điểm
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ml-10">
                    <div class="group">
                         <label class="block text-sm font-semibold text-slate-700 mb-2">Bắt đầu <span class="text-red-500">*</span></label>
                         <div class="relative">
                            <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium" required>
                         </div>
                    </div>
                    <div class="group">
                         <label class="block text-sm font-semibold text-slate-700 mb-2">Kết thúc <span class="text-red-500">*</span></label>
                         <div class="relative">
                            <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium" required>
                         </div>
                    </div>
                    <div class="group md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Địa điểm tổ chức <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <input type="text" name="location" value="{{ old('location') }}" 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium placeholder-slate-400" 
                                placeholder="VD: Hội trường A, ĐH Sư Phạm Kỹ Thuật" required>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Section 3: Capacity & Media -->
             <div>
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-4">
                   <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 text-sm">3</span>
                   Quy mô & Hình ảnh
               </h3>
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ml-10">
                   <div class="group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Số lượng tối đa</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                           <input type="number" name="max_participants" value="{{ old('max_participants') }}" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium" 
                               placeholder="VD: 50">
                        </div>
                   </div>

                   <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ảnh bìa sự kiện</label>
                        <div class="relative border-2 border-dashed border-slate-300 rounded-xl p-8 hover:bg-slate-50 transition-colors text-center cursor-pointer group" onclick="document.getElementById('imageInput').click()">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(this)">
                            <div id="uploadPlaceholder">
                                <div class="w-16 h-16 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-slate-600 font-medium">Click để tải ảnh lên hoặc kéo thả vào đây</p>
                                <p class="text-xs text-slate-400 mt-1">PNG, JPG, JPEG (Tối đa 2MB)</p>
                            </div>
                           <img id="imagePreview" class="hidden max-h-64 mx-auto rounded-lg shadow-md" />
                        </div>
                   </div>
               </div>
           </div>

           <!-- Section 4: Details & Contact -->
           <div>
               <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-4">
                   <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 text-sm">4</span>
                   Thông tin chi tiết & Liên hệ
               </h3>
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ml-10">
                   <div class="group">
                       <label class="block text-sm font-semibold text-slate-700 mb-2">Yêu cầu tham gia</label>
                       <textarea name="requirements" rows="4" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium placeholder-slate-400" 
                           placeholder="Mỗi dòng 1 yêu cầu. VD:&#10;Có trách nhiệm cao&#10;Đúng giờ">{{ old('requirements') }}</textarea>
                   </div>
                   <div class="group">
                       <label class="block text-sm font-semibold text-slate-700 mb-2">Quyền lợi tình nguyện viên</label>
                       <textarea name="benefits" rows="4" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium placeholder-slate-400" 
                           placeholder="Mỗi dòng 1 quyền lợi. VD:&#10;Cấp giấy chứng nhận&#10;Hỗ trợ ăn trưa">{{ old('benefits') }}</textarea>
                   </div>
                   <div class="group">
                       <label class="block text-sm font-semibold text-slate-700 mb-2">Người phụ trách</label>
                       <input type="text" name="contact_name" value="{{ old('contact_name') }}" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium placeholder-slate-400" 
                           placeholder="VD: Nguyễn Văn A">
                   </div>
                   <div class="group">
                       <label class="block text-sm font-semibold text-slate-700 mb-2">Hotline liên hệ</label>
                       <input type="text" name="contact_phone" value="{{ old('contact_phone') }}" 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium placeholder-slate-400" 
                           placeholder="VD: 0123456789">
                   </div>
               </div>
           </div>
        </div>

        <!-- Footer Actions -->
        <div class="bg-slate-50 px-8 py-6 border-t border-slate-100 flex justify-between items-center">
            <a href="{{ route('organization.events.index') }}" class="px-6 py-2.5 rounded-xl font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-200 transition-colors">
                Hủy bỏ
            </a>
            <button type="submit" class="px-8 py-3 rounded-xl font-bold text-white bg-gradient-to-r from-indigo-600 to-violet-600 shadow-lg shadow-indigo-500/30 hover:scale-[1.02] hover:shadow-indigo-500/40 active:scale-95 transition-all">
                Tạo Sự Kiện
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection


