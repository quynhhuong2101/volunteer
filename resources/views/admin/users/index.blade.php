@extends('layouts.admin')

@section('header', 'Quản lý Người dùng')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ currentTab: 'all', search: '' }">
    
    <!-- Stats Banner -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-indigo-600 rounded-xl p-4 text-white shadow-lg shadow-indigo-600/20">
            <p class="text-indigo-200 text-xs font-bold uppercase">Tổng người dùng</p>
            <h3 class="text-2xl font-black mt-1">{{ $stats['total'] }}</h3>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
            <p class="text-slate-400 text-xs font-bold uppercase">Sinh viên</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['students'] }}</h3>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
            <p class="text-slate-400 text-xs font-bold uppercase">Tổ chức</p>
            <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $stats['organizations'] }}</h3>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-4 opacity-10">
                 <svg class="w-16 h-16 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
            </div>
            <p class="text-yellow-500 text-xs font-bold uppercase">Chờ duyệt</p>
            <h3 class="text-2xl font-black text-yellow-600 mt-1">{{ $stats['pending'] }}</h3>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="bg-slate-100 p-1 rounded-xl inline-flex overflow-x-auto max-w-full">
            <button @click="currentTab = 'all'" :class="currentTab === 'all' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold rounded-lg transition-all whitespace-nowrap">Tất cả</button>
            <button @click="currentTab = 'Pending'" :class="currentTab === 'Pending' ? 'bg-white text-yellow-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold rounded-lg transition-all whitespace-nowrap flex items-center gap-2">
                Chờ duyệt
                <span class="bg-yellow-100 text-yellow-700 text-[10px] px-1.5 py-0.5 rounded-full">{{ $stats['pending'] }}</span>
            </button>
            <button @click="currentTab = 'Sinh viên'" :class="currentTab === 'Sinh viên' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold rounded-lg transition-all whitespace-nowrap">Sinh viên</button>
            <button @click="currentTab = 'Tổ chức'" :class="currentTab === 'Tổ chức' ? 'bg-white text-indigo-700 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold rounded-lg transition-all whitespace-nowrap">Tổ chức</button>
            <button @click="currentTab = 'locked'" :class="currentTab === 'locked' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-4 py-2 text-sm font-bold rounded-lg transition-all whitespace-nowrap">Đã khóa</button>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                <span class="hidden sm:inline">Cấp tài khoản mới</span>
            </a>

            <div class="relative w-full md:w-72">
                <input x-model="search" type="text" placeholder="Tìm kiếm theo tên, email..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 rounded-xl text-sm outline-none transition-all">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Người dùng</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Vai trò</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Số điện thoại</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 text-right"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $user)
                <tr 
                    x-show="(currentTab === 'all' || currentTab === '{{ $user['status'] === 'Pending' ? 'Pending' : $user['role'] }}' || (currentTab === 'locked' && '{{ $user['status'] }}' === 'locked')) && ('{{ strtolower($user['name']) }}'.includes(search.toLowerCase()) || '{{ strtolower($user['email']) }}'.includes(search.toLowerCase()))"
                    class="hover:bg-slate-50 transition-colors group cursor-pointer"
                    onclick="window.location='{{ route('admin.users.show', $user['id']) }}'"
                >
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user['avatar'] }}" class="w-10 h-10 rounded-full border border-slate-100">
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $user['name'] }}</h4>
                                <p class="text-xs text-slate-500">{{ $user['email'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-{{ $user['role_color'] }}-100 text-{{ $user['role_color'] }}-700">
                            {{ $user['role'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-600">
                        {{ $user['phone'] }}
                    </td>
                    <td class="px-6 py-4">
                        @if($user['status'] == 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                            </span>
                        @elseif($user['status'] == 'Pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-600 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Chờ duyệt
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600 border border-red-200">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                Đã khóa
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
