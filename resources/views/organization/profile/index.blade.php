@extends('layouts.organization')

@section('header', 'Hồ sơ Tổ chức')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 relative" role="alert">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Profile Card -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-32 bg-slate-900"></div>
                
                <div class="relative z-10 mt-12 mb-4">
                    <div class="w-24 h-24 mx-auto rounded-full bg-slate-800 border-4 border-white flex items-center justify-center text-3xl font-bold text-white shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>

                <div class="relative z-10">
                    <h3 class="text-xl font-bold text-slate-800">{{ $user->name }}</h3>
                    <p class="text-slate-500 text-sm mt-1">Tổ chức / CLB</p>
                    <div class="mt-4 flex justify-center gap-2">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Đã xác minh</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right: Edit Form -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- General Info -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Thông tin chung
                    </h3>
                </div>

                <form action="{{ route('organization.profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="font-bold text-sm text-slate-600">Tên tổ chức</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all font-semibold text-slate-800">
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-sm text-slate-600">Email liên hệ</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all font-semibold text-slate-800">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-sm text-slate-600">Giới thiệu (Bio)</label>
                        <textarea name="bio" rows="4" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all text-slate-800" placeholder="Mô tả ngắn về tổ chức của bạn...">{{ old('bio', $user->bio ?? '') }}</textarea>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                            Cập nhật thông tin
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                     <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        Bảo mật
                    </h3>
                </div>

                 <form action="{{ route('organization.profile.password') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="space-y-1">
                        <label class="font-bold text-sm text-slate-600">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="font-bold text-sm text-slate-600">Mật khẩu mới</label>
                            <input type="password" name="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-sm text-slate-600">Nhập lại mật khẩu mới</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 transition-all">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-slate-700 transition-all shadow-lg shadow-slate-500/30">
                            Đổi mật khẩu
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
