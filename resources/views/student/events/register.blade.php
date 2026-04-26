@extends('layouts.student')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4">
    
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('student.events.show', $event['id']) }}" class="text-sm font-bold text-slate-500 hover:text-indigo-600 flex items-center gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Quay lại chi tiết sự kiện
        </a>
        <h1 class="text-3xl font-black text-slate-800">Đăng ký tham gia</h1>
        <p class="text-slate-500 mt-2">Sự kiện: <span class="font-bold text-indigo-600">{{ $event['name'] }}</span></p>
    </div>

    <form action="{{ route('student.events.register.store', $event['id']) }}" method="POST" class="space-y-8">
        @csrf

        <!-- 1. Select Position -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">1</span>
                Chọn Vị trí / Đội hình
            </h3>
            
            <div class="space-y-3">
                @foreach($event['positions'] as $pos)
                <label class="block relative">
                    <input type="radio" name="position_id" value="{{ $pos['id'] }}" class="peer sr-only" {{ $pos['status'] == 'Full' ? 'disabled' : '' }}>
                    <div class="p-4 rounded-xl border-2 border-slate-100 cursor-pointer transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:bg-slate-50 {{ $pos['status'] == 'Full' ? 'opacity-60 cursor-not-allowed bg-slate-50' : '' }}">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-slate-700 peer-checked:text-indigo-700">{{ $pos['name'] }}</h4>
                                <p class="text-xs text-slate-500">{{ $pos['desc'] }}</p>
                            </div>
                            <div class="text-right">
                                @if($pos['status'] == 'Full')
                                    <span class="inline-block px-2 py-1 rounded-md bg-red-100 text-red-600 text-xs font-bold uppercase">Đã đủ</span>
                                @else
                                    <span class="inline-block px-2 py-1 rounded-md bg-emerald-100 text-emerald-600 text-xs font-bold uppercase">Còn {{ $pos['needed'] - $pos['registered'] }} chỗ</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4 hidden peer-checked:block text-indigo-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- 2. Personal Info (Auto-filled) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 opacity-80">
            <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-sm">2</span>
                Thông tin cá nhân
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Họ và tên</label>
                    <div class="font-bold text-slate-700">Nguyễn Văn A</div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">MSSV</label>
                    <div class="font-bold text-slate-700">2152xxxx</div>
                </div>
                 <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Email</label>
                    <div class="font-bold text-slate-700">van.a@gm.uit.edu.vn</div>
                </div>
                 <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Số điện thoại</label>
                    <div class="font-bold text-slate-700">0909xxxxxx</div>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-4 italic">* Thông tin được lấy tự động từ hồ sơ của bạn.</p>
        </div>

        <!-- 3. Additional Questions (Dynamic) -->
        @if(count($event['custom_fields']) > 0)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-800 text-lg mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">3</span>
                Câu hỏi bổ sung
            </h3>
            
            <div class="space-y-5">
                @foreach($event['custom_fields'] as $index => $field)
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        {{ $field['label'] }}
                        @if($field['required']) <span class="text-red-500">*</span> @endif
                    </label>

                    @if($field['type'] == 'text')
                        <input type="text" name="custom_fields[{{$index}}]" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500" placeholder="Nhập câu trả lời của bạn..." {{ $field['required'] ? 'required' : '' }}>
                    
                    @elseif($field['type'] == 'select')
                        <select name="custom_fields[{{$index}}]" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500" {{ $field['required'] ? 'required' : '' }}>
                            <option value="">-- Chọn --</option>
                            @foreach($field['options'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    
                    @elseif($field['type'] == 'checkbox')
                        <div class="space-y-2">
                            @foreach($field['options'] as $option)
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="custom_fields[{{$index}}][]" value="{{ $option }}" class="w-5 h-5 text-indigo-600 bg-slate-50 border-slate-300 rounded focus:ring-indigo-500">
                                <span class="text-slate-700">{{ $option }}</span>
                            </label>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Footer / Policy Check -->
        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 flex items-start gap-3">
             <input type="checkbox" required class="mt-1 w-5 h-5 text-indigo-600 rounded border-blue-300 focus:ring-indigo-500">
             <div class="text-sm text-blue-800">
                 Tôi cam kết tham gia đầy đủ và tuân thủ quy định của BTC. Tôi hiểu rằng tôi chỉ có thể hủy đăng ký trong vòng <strong class="text-blue-900">{{ $event['policy']['cancel_hours'] }} tiếng</strong> sau khi gửi đơn.
             </div>
        </div>

        <button type="submit" class="w-full py-4 bg-indigo-600 text-white font-black text-lg rounded-2xl shadow-xl shadow-indigo-500/30 hover:bg-indigo-700 transition-all transform hover:scale-[1.01]">
            XÁC NHẬN ĐĂNG KÝ
        </button>

    </form>
</div>
@endsection
