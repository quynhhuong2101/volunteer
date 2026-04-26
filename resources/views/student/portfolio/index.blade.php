@extends('layouts.student')

@section('header', 'Hồ sơ năng lực')

@section('content')
<div class="max-w-6xl mx-auto space-y-10 pb-12">

    <!-- Header Banner & Profile -->
    <div class="relative bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <!-- Cover Photo -->
        <div class="h-48 md:h-64 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 relative overflow-hidden">
            <!-- Decorative shapes -->
            <div class="absolute inset-0 opacity-30 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        </div>

        <div class="px-8 pb-8 relative z-10 flex flex-col items-center text-center">
            <!-- Avatar -->
            <div class="relative -mt-20 md:-mt-24 mb-4">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-md"></div>
                    <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="relative w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-xl object-cover bg-white z-20">
                </div>
            </div>
            
            <!-- Info -->
            <div class="flex flex-col items-center justify-center">
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">{{ $student['name'] }}</h2>
            </div>

            <!-- Bio -->
            <div class="mt-8 max-w-3xl">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Về bản thân</h3>
                <p class="text-slate-600 leading-relaxed bg-slate-50 p-4 md:p-5 rounded-2xl border border-slate-100 text-sm md:text-base">{{ $student['bio'] }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- Left Sidebar -->
        <div class="xl:col-span-1 space-y-8">
            
            <!-- Thống kê hoạt động thay thế Huy hiệu -->
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-xl shadow-slate-200/40 border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl shadow-lg shadow-orange-500/30 text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Thống kê hoạt động</h3>
                </div>
                
                <div class="grid grid-cols-2 lg:grid-cols-2 gap-4">
                    @foreach($statsList as $stat)
                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex flex-col items-center justify-center text-center shadow-sm hover:shadow-md transition-shadow">
                        <span class="text-3xl mb-2">{{ $stat['icon'] }}</span>
                        <span class="text-2xl font-black text-slate-800">{{ $stat['value'] }}</span>
                        <span class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wide">{{ $stat['name'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Right Content: Timeline & Certificates -->
        <div class="xl:col-span-2 space-y-8">
            
            <!-- Timeline -->
            <div class="bg-white rounded-3xl p-6 md:p-10 shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden relative">
                <!-- BG Decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-50 z-0"></div>

                <div class="flex items-center gap-3 mb-8 relative z-10">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30 text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-extrabold text-slate-800">Hành trình phát triển</h3>
                </div>

                <div class="relative z-10 ml-4 md:ml-6 border-l-2 border-indigo-100 space-y-12 pb-4">
                    @foreach($timeline as $item)
                    <div class="relative pl-8 md:pl-10 group">
                        <div class="absolute -left-[11px] top-1.5 w-5 h-5 bg-white border-4 border-indigo-500 rounded-full shadow-md group-hover:scale-125 group-hover:border-indigo-600 transition-transform"></div>
                        
                        <div class="bg-slate-50 md:bg-transparent rounded-2xl p-4 md:p-0 md:group-hover:-translate-y-1 transition-all">
                            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mb-2">
                                <h4 class="text-lg md:text-xl font-bold text-slate-800">{{ $item['title'] }}</h4>
                                <span class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full mb-2 md:mb-0 w-max">{{ $item['date'] }}</span>
                            </div>
                            <p class="text-slate-600 leading-relaxed text-sm md:text-base bg-white md:bg-transparent p-4 md:p-0 rounded-xl md:rounded-none shadow-sm md:shadow-none border border-slate-100 md:border-none">{{ $item['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Certificates -->
            <div class="bg-white rounded-3xl p-6 md:p-10 shadow-xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden">
                <div class="flex items-center justify-between mb-8 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl shadow-lg shadow-teal-500/30 text-white">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                        </div>
                        <h3 class="text-xl md:text-2xl font-extrabold text-slate-800">Chứng nhận & Giải thưởng</h3>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 relative z-10">
                    @foreach($certificates as $cert)
                    <div class="group relative bg-white p-5 rounded-2xl border border-slate-200 hover:border-teal-300 hover:shadow-2xl hover:shadow-teal-500/10 transition-all duration-300 overflow-hidden cursor-pointer flex flex-col justify-between min-h-[140px]">
                        <!-- Abstract bg inside card -->
                        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-teal-50 rounded-full blur-xl group-hover:bg-teal-100 transition-colors"></div>
                        
                        <div class="relative z-10 flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 flex items-center justify-center text-teal-600 shrink-0 shadow-inner group-hover:text-teal-500 group-hover:border-teal-200 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2A10 10 0 1022 12A10 10 0 0012 2Zm0 18a8 8 0 118-8A8 8 0 0112 20Zm-1-13h2v6h-2Zm0 8h2v2h-2Z"/></svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-[15px] leading-snug group-hover:text-teal-700 transition-colors">{{ $cert['name'] }}</h4>
                        </div>
                        <div class="relative z-10 flex items-center gap-2 mt-4 text-xs font-bold text-slate-400">
                             <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                             Đạt được vào: {{ $cert['date'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
</style>
@endsection
