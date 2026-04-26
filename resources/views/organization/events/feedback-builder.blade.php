@extends('layouts.organization')

@section('header', 'Thiết lập Phiếu Đánh giá')

@section('content')
<div class="h-[calc(100vh-8rem)] flex gap-6" x-data="feedbackBuilder()">
    
    <!-- LEFT: Instructions -->
    <div class="w-1/3 flex flex-col gap-4 h-full">
        <div class="bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-500/30 p-8 text-white flex flex-col justify-between h-full relative overflow-hidden">
             <!-- Background Pattern -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>

            <div>
                <a href="{{ route('organization.events.index') }}" class="inline-block mb-6 text-white/70 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
                 <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363 1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                </div>
                <h2 class="text-3xl font-bold mb-4">Phiếu Đánh Giáo</h2>
                <p class="text-indigo-100 leading-relaxed opacity-90">
                    Tạo các câu hỏi tùy chỉnh để thu thập phản hồi chi tiết từ tình nguyện viên sau khi sự kiện kết thúc.
                    <br><br>
                    Các câu hỏi này sẽ xuất hiện kèm theo đánh giá sao mặc định.
                </p>
            </div>

            <div class="space-y-4 relative z-10">
                <div class="flex items-start gap-3 bg-white/10 p-4 rounded-xl backdrop-blur-sm border border-white/10">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm font-medium">Hệ thống luôn thu thập đánh giá Star Rating và Bình luận chung.</p>
                </div>
                
                 <div class="flex items-start gap-3 bg-white/10 p-4 rounded-xl backdrop-blur-sm border border-white/10">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm font-medium">Bạn có thể thêm tối đa 10 câu hỏi tùy chỉnh.</p>
                </div>
            </div>

             <form action="{{ route('organization.events.saveFeedbackForm', ['id' => request()->id]) }}" method="POST" class="mt-8">
                @csrf
                <input type="hidden" name="config" :value="JSON.stringify({fields: fields})">
                <button type="submit" class="w-full bg-white text-indigo-600 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    Lưu Phiếu Đánh Giá
                </button>
            </form>
        </div>
    </div>

    <!-- RIGHT: Form Questions Builder -->
    <div class="flex-1 flex flex-col bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Câu hỏi tùy chỉnh</h3>
                <p class="text-sm text-slate-500">Thiết kế các câu hỏi bổ sung cho form đánh giá</p>
            </div>
            <div class="flex gap-2">
                 <button @click="addField('text')" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:border-indigo-500 hover:text-indigo-600 transition-all shadow-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    Văn bản
                </button>
                 <button @click="addField('select')" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:border-indigo-500 hover:text-indigo-600 transition-all shadow-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    Menu thả xuống
                </button>
                <button @click="addField('radio')" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:border-indigo-500 hover:text-indigo-600 transition-all shadow-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Trắc nghiệm
                </button>
            </div>
        </div>
        
        <div class="flex-1 overflow-y-auto p-8 space-y-6 bg-slate-50/30">
            <!-- Dynamic Fields -->
            <template x-for="(field, index) in fields" :key="index">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-indigo-300 hover:shadow-md transition-all relative group">
                    <!-- Remove Button -->
                    <button @click="removeField(index)" class="absolute top-4 right-4 text-slate-300 hover:text-rose-500 transition-colors bg-slate-50 hover:bg-rose-50 p-1.5 rounded-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                    
                    <div class="flex items-center gap-3 mb-4">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-slate-500 text-xs font-bold" x-text="index + 1"></span>
                        <h4 class="font-bold text-slate-700" x-text="getLabel(field.type)"></h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5 ml-1">Câu hỏi</label>
                            <input type="text" x-model="field.label" class="w-full bg-slate-50 border border-slate-200/50 rounded-xl px-4 py-2.5 font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder:font-normal placeholder:text-slate-400" placeholder="Nhập nội dung câu hỏi...">
                        </div>
                         <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5 ml-1">Loại câu hỏi</label>
                            <select x-model="field.type" class="w-full bg-slate-50 border border-slate-200/50 rounded-xl px-4 py-2.5 font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                <option value="text">Văn bản ngắn</option>
                                <option value="radio">Trắc nghiệm (1 đáp án)</option>
                                <option value="checkbox">Hộp kiểm (Nhiều đáp án)</option>
                                <option value="select">Menu thả xuống</option>
                            </select>
                        </div>
                    </div>

                    <div x-show="field.type !== 'text'" class="bg-indigo-50/50 p-4 rounded-xl mb-4 border border-indigo-50">
                        <label class="block text-xs font-bold text-indigo-400 uppercase mb-2 ml-1">Các lựa chọn (Ngăn cách bằng dấu phẩy)</label>
                        <textarea :value="field.options.join(', ')" @input="field.options = $event.target.value.split(',').map(s => s.trim())" class="w-full bg-white border border-indigo-100 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" rows="2" placeholder="Tùy chọn A, Tùy chọn B, Tùy chọn C..."></textarea>
                    </div>

                    <div class="flex items-center">
                         <label class="flex items-center space-x-2 cursor-pointer select-none group/toggle">
                            <div class="relative">
                                <input type="checkbox" x-model="field.required" class="sr-only peer">
                                <div class="w-10 h-6 bg-slate-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-indigo-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </div>
                            <span class="text-sm font-semibold text-slate-600 group-hover/toggle:text-indigo-600 transition-colors">Bắt buộc trả lời</span>
                        </label>
                    </div>
                </div>
            </template>
            
            <div x-show="fields.length === 0" class="flex flex-col items-center justify-center py-16 text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                <p>Chưa có câu hỏi nào.</p>
                <p class="mt-1">Nhấn các nút phía trên để bắt đầu thêm câu hỏi.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function feedbackBuilder() {
        return {
            // Initial data from server can be injected here
            fields: [
                { type: 'radio', label: 'Bạn đánh giá thế nào về công tác tổ chức?', required: true, options: ['Rất tốt', 'Tốt', 'Bình thường', 'Cần cải thiện'] },
                 { type: 'text', label: 'Điều gì làm bạn ấn tượng nhất?', required: false, options: [] }
            ],
            
            // Methods
            getLabel(type) {
                const map = {
                    'text': 'Câu hỏi Văn bản',
                    'radio': 'Câu hỏi Trắc nghiệm',
                    'checkbox': 'Câu hỏi Hộp kiểm',
                    'select': 'Menu thả xuống'
                };
                return map[type] || 'Câu hỏi';
            },
            addField(type) {
                this.fields.push({
                    type: type,
                    label: '',
                    required: false,
                    options: type === 'text' ? [] : ['Lựa chọn 1', 'Lựa chọn 2']
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            }
        }
    }
</script>
@endsection


