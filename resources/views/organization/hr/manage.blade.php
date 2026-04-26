@extends('layouts.organization')

@section('header', 'Quản lý Nhân sự: ' . $event->title)

@section('content')
<div class="h-[calc(100vh-8rem)] flex flex-col gap-4" x-data="personnelManagement()">

    <!-- 1. HEADER & GLOBAL ACTIONS -->
    <div class="flex items-center justify-between bg-white p-4 rounded-3xl border border-slate-100 shadow-sm shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('organization.hr.index') }}" class="p-2.5 rounded-2xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all group" title="Quay lại">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div class="h-10 w-px bg-slate-100"></div>
            <div>
                <h1 class="text-xl font-black text-slate-800 leading-tight">{{ $event->title }}</h1>
                <div class="flex items-center gap-3 mt-1">
                    <span class="px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest border border-indigo-100">Quản lý Nhân sự</span>
                    <span class="text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden md:flex flex-col items-end mr-2">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Tổng nhân sự</span>
                <span class="text-xl font-black text-slate-800 leading-none mt-1" x-text="volunteers.length"></span>
            </div>
            <button class="bg-indigo-600 text-white px-5 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-xl transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                Thêm nhân sự
            </button>
        </div>
    </div>
    
    <div class="flex h-full gap-6 min-h-0">
        
        <!-- 2. LEFT SIDEBAR: FILTERS & TEAMS -->
        <div class="w-1/4 min-w-[300px] flex flex-col gap-4 h-full">
             <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col overflow-hidden h-full">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-black text-slate-800 text-lg uppercase tracking-tight">Bộ lọc & Đội nhóm</h3>
                </div>
                
                <div class="flex-1 overflow-y-auto p-3 space-y-2 custom-scrollbar">
                    <!-- Standard Filters -->
                    <div class="space-y-1 mb-6">
                        <h4 class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Trạng thái</h4>
                        <template x-for="filter in mainFilters" :key="filter.id">
                            <button @click="selectedFilter = filter.id" 
                                    class="w-full flex items-center justify-between p-3.5 rounded-2xl transition-all text-left group"
                                    :class="selectedFilter === filter.id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 ring-4 ring-indigo-50' : 'text-slate-600 hover:bg-slate-50'">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                                         :class="selectedFilter === filter.id ? 'bg-white/20' : 'bg-slate-100 text-slate-400 group-hover:text-indigo-600 shadow-sm'">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="filter.icon" /></svg>
                                    </div>
                                    <span class="font-bold text-sm" x-text="filter.name"></span>
                                </div>
                                <span class="text-[10px] font-black px-2 py-0.5 rounded-lg" 
                                      :class="selectedFilter === filter.id ? 'bg-white/20' : 'bg-slate-100 text-slate-400'"
                                      x-text="getCount(filter.id)"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Positions/Teams -->
                    <div class="space-y-1">
                        <h4 class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Đội nhóm (Vị trí)</h4>
                        <template x-for="team in teams" :key="team.id">
                            <button @click="selectedFilter = team.id" 
                                    class="w-full flex items-center justify-between p-3.5 rounded-2xl transition-all text-left group"
                                    :class="selectedFilter === team.id ? 'bg-amber-500 text-white shadow-lg shadow-amber-100 ring-4 ring-amber-50' : 'text-slate-600 hover:bg-slate-50'">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                                         :class="selectedFilter === team.id ? 'bg-white/20' : team.bg + ' ' + team.color + ' opacity-70 group-hover:opacity-100 shadow-sm'">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="team.icon" /></svg>
                                    </div>
                                    <span class="font-bold text-sm" x-text="team.name"></span>
                                </div>
                                <span class="text-[10px] font-black px-2 py-0.5 rounded-lg" 
                                      :class="selectedFilter === team.id ? 'bg-white/20' : 'bg-slate-100 text-slate-400'"
                                      x-text="getCount(team.id)"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                    <button @click="openCreateGroup()" class="w-full py-3.5 border-2 border-dashed border-slate-300 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50/50 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Thêm Đội nhóm
                    </button>
                </div>
             </div>
        </div>

        <!-- 3. MAIN CONTENT: PERSONNEL LIST -->
        <div class="flex-1 flex flex-col gap-4 min-w-0 h-full">
            
            <!-- List Actions & Search -->
            <div class="bg-white p-3 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between shrink-0">
                <div class="flex items-center gap-4 flex-1 pl-3">
                    <div class="relative group flex-1 max-w-md">
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        <input type="text" x-model="search" placeholder="Họ tên, MSSV hoặc Khoa..." class="w-full bg-slate-50 border-none rounded-2xl py-3 pl-12 pr-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-50 transition-all placeholder:text-slate-400">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                     <button @click="exportData()" class="p-3 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl transition-all border border-transparent hover:border-indigo-100" title="Xuất dữ liệu">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                     </button>
                     <div class="h-8 w-px bg-slate-100"></div>
                     <button class="flex items-center gap-2 px-4 py-3 bg-slate-50 text-slate-600 border border-slate-100 rounded-2xl font-bold text-sm hover:bg-slate-100 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        Lọc nâng cao
                     </button>
                </div>
            </div>

            <!-- Scrollable Grid/Table -->
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 flex-1 overflow-hidden flex flex-col relative">
                <template x-if="loading">
                    <div class="absolute inset-0 bg-white/60 backdrop-blur-sm z-50 flex items-center justify-center">
                        <div class="w-12 h-12 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                </template>

                <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                        <template x-for="v in filteredVolunteers" :key="v.registration_id">
                            <div class="group relative bg-white rounded-3xl p-5 border border-slate-150 shadow-sm hover:shadow-xl transition-all duration-300 flex items-start gap-4">
                                <div class="absolute top-0 right-0 p-4">
                                     <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border"
                                           :class="{
                                               'bg-emerald-50 text-emerald-600 border-emerald-100': v.status === 'approved',
                                               'bg-amber-50 text-amber-600 border-amber-100': v.status === 'pending',
                                               'bg-rose-50 text-rose-600 border-rose-100': v.status === 'rejected',
                                               'bg-slate-50 text-slate-400 border-slate-200': v.status === 'cancelled'
                                           }" x-text="statusLabel(v.status)"></span>
                                </div>

                                <!-- Avatar -->
                                <div class="relative shrink-0">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden border-4 border-slate-50 group-hover:border-indigo-100 transition-colors shadow-sm">
                                        <img :src="v.avatar" class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white shadow-sm"
                                         :class="v.status === 'approved' ? 'bg-emerald-500' : 'bg-amber-400'"></div>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-black text-lg text-slate-800 leading-tight group-hover:text-indigo-600 transition-colors truncate" x-text="v.name"></h4>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 mb-2" x-text="v.student_id + ' • ' + v.faculty"></p>
                                    
                                    <div class="flex flex-wrap gap-2 items-center mt-3">
                                        <div class="flex items-center gap-1.5 px-2 py-1 rounded-lg bg-slate-50 text-slate-500 text-[10px] font-bold border border-slate-100 group-hover:bg-indigo-50 group-hover:text-indigo-600 group-hover:border-indigo-100 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                            <span x-text="v.position"></span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-bold" x-text="'Ứng tuyển ' + v.applied_at"></div>
                                    </div>

                                    <!-- Context Actions -->
                                    <div class="flex items-center gap-2 mt-4 pt-4 border-t border-slate-100/50">
                                        <button @click="openMoveModal(v)" class="flex-1 py-1.5 px-3 bg-slate-50 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-100 transition-all flex items-center justify-center gap-2">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m4-4H3" /></svg>
                                            Chuyển nhóm
                                        </button>
                                        <button @click="openDetail(v)" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors" title="Chi tiết">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <template x-if="filteredVolunteers.length === 0">
                        <div class="flex flex-col items-center justify-center py-32 text-slate-400">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4 opacity-50">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <h3 class="font-bold text-slate-800">Không tìm thấy nhân sự</h3>
                            <p class="text-sm">Thử điều chỉnh bộ lọc hoặc từ khóa tìm kiếm của bạn.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. MODALS -->
    
    <!-- Move Position Modal -->
    <div x-show="moveModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="moveModalOpen = false" class="bg-white rounded-[2rem] shadow-2xl w-full max-w-sm overflow-hidden flex flex-col border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-black text-slate-800 uppercase tracking-tight">Chuyển đội nhóm</h3>
                <button @click="moveModalOpen = false" class="p-2 hover:bg-slate-200 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <div class="p-6 space-y-3">
                <template x-for="team in teams" :key="team.id">
                    <button @click="savePositionUpdate(team.pos_real_id)" 
                            class="w-full flex items-center gap-3 p-4 rounded-2xl hover:bg-indigo-50 border border-slate-100 hover:border-indigo-200 transition-all text-left">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-sm" :class="team.bg + ' ' + team.color">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="team.icon" /></svg>
                        </div>
                        <span class="font-bold text-slate-700" x-text="team.name"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Detail Profile Modal -->
    <div x-show="detailModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="detailModalOpen = false" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden flex flex-col relative" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100">
             <template x-if="selectedVolunteer">
                <div class="flex flex-col">
                     <!-- Cover Decor -->
                     <div class="h-32 bg-gradient-to-br from-indigo-600 via-indigo-700 to-blue-800 relative">
                        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(white 2px, transparent 2px); background-size: 20px 20px;"></div>
                        <button @click="detailModalOpen = false" class="absolute top-6 right-6 p-2.5 bg-white/10 hover:bg-white/20 text-white rounded-2xl backdrop-blur-md transition-colors border border-white/20">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                     </div>

                     <!-- Content -->
                     <div class="px-8 pb-10">
                        <div class="relative -mt-10 mb-6 group">
                            <img :src="selectedVolunteer.avatar" class="w-24 h-24 rounded-[1.5rem] border-4 border-white shadow-xl object-cover relative z-10">
                            <div class="absolute inset-0 bg-indigo-500 blur-2xl opacity-20 scale-110 -z-0"></div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-3xl font-black text-slate-800 tracking-tight" x-text="selectedVolunteer.name"></h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs font-black text-indigo-600 uppercase tracking-widest px-2 py-0.5 rounded-lg bg-indigo-50" x-text="selectedVolunteer.student_id"></span>
                                <span class="w-1 h-1 rounded-full bg-slate-300 mx-1"></span>
                                <span class="text-sm font-bold text-slate-400" x-text="selectedVolunteer.faculty"></span>
                            </div>
                        </div>

                        <!-- Applicant Answers -->
                        <div class="space-y-6">
                            <div class="bg-slate-50 p-6 rounded-[2rem] border border-white shadow-inner">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Câu trả lời tuyển dụng</h4>
                                <div class="space-y-4">
                                    <template x-for="(answer, qIndex) in selectedVolunteer.answers" :key="qIndex">
                                        <div>
                                            <p class="text-[10px] font-bold text-indigo-400 mb-1" x-text="'Câu hỏi ' + (qIndex + 1)"></p>
                                            <p class="text-sm font-bold text-slate-700 italic border-l-2 border-slate-200 pl-3 leading-relaxed" x-text="answer"></p>
                                        </div>
                                    </template>
                                    <template x-if="!selectedVolunteer.answers || Object.keys(selectedVolunteer.answers).length === 0">
                                        <p class="text-sm text-slate-400 font-bold italic">Không có dữ liệu câu trả lời.</p>
                                    </template>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button class="py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 text-xs uppercase tracking-widest flex items-center justify-center gap-2 group/msg">
                                    <svg class="w-4 h-4 group-hover/msg:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                    Nhắn tin
                                </button>
                                <button class="py-4 bg-white text-slate-800 border-2 border-slate-100 font-black rounded-2xl hover:bg-slate-50 transition-all text-xs uppercase tracking-widest flex items-center justify-center gap-2 group/profile">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Hồ sơ
                                </button>
                            </div>
                        </div>
                     </div>
                </div>
             </template>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    [x-cloak] { display: none !important; }
</style>

<script>
    function personnelManagement() {
        return {
            loading: false,
            search: '',
            selectedFilter: 'all',
            volunteers: @json($volunteers),
            
            // Modal States
            detailModalOpen: false,
            moveModalOpen: false,
            selectedVolunteer: null,

            mainFilters: [
                { id: 'all', name: 'Tất cả nhân sự', icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' },
                { id: 'approved', name: 'Đã xác nhận', icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }
            ],

            teams: [
                ...(@json($positions)).map((p, index) => {
                    const icons = [
                        'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 
                        'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 
                        'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 
                        'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 
                        'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z' 
                    ];
                    const colors = [
                        { text: 'text-blue-600', bg: 'bg-blue-50' },
                        { text: 'text-purple-600', bg: 'bg-purple-50' },
                        { text: 'text-rose-600', bg: 'bg-rose-50' },
                        { text: 'text-emerald-600', bg: 'bg-emerald-50' },
                        { text: 'text-amber-600', bg: 'bg-amber-50' }
                    ];
                    const colorSet = colors[index % colors.length];
                    return {
                        id: 'pos_' + p.id,
                        pos_real_id: p.id,
                        name: p.name,
                        icon: icons[index % icons.length],
                        color: colorSet.text,
                        bg: colorSet.bg
                    };
                })
            ],

            get filteredVolunteers() {
                return this.volunteers.filter(v => {
                    const matchesFilter = this.selectedFilter === 'all' || 
                                          (this.selectedFilter === 'pending' && v.status === 'pending') ||
                                          (this.selectedFilter === 'approved' && v.status === 'approved') ||
                                          (v.team_id === this.selectedFilter);
                    
                    const q = this.search.toLowerCase();
                    const matchesSearch = this.search === '' || 
                                          v.name.toLowerCase().includes(q) || 
                                          v.student_id.toLowerCase().includes(q) ||
                                          v.faculty.toLowerCase().includes(q);
                    
                    return matchesFilter && matchesSearch;
                });
            },

            getCount(filterId) {
                if (filterId === 'all') return this.volunteers.length;
                if (filterId === 'pending') return this.volunteers.filter(v => v.status === 'pending').length;
                if (filterId === 'approved') return this.volunteers.filter(v => v.status === 'approved').length;
                return this.volunteers.filter(v => v.team_id === filterId).length;
            },

            statusLabel(status) {
                const labels = {
                    'pending': 'Chờ duyệt',
                    'approved': 'Đã duyệt',
                    'rejected': 'Từ chối',
                    'cancelled': 'Đã hủy'
                };
                return labels[status] || status;
            },

            openDetail(volunteer) {
                this.selectedVolunteer = volunteer;
                this.detailModalOpen = true;
            },

            openMoveModal(volunteer) {
                this.selectedVolunteer = volunteer;
                this.moveModalOpen = true;
            },

            async updateStatus(regId, status) {
                if(!confirm('Xác nhận thay đổi trạng thái đăng ký này?')) return;
                
                this.loading = true;
                try {
                    const response = await fetch('{{ route("organization.hr.updateStatus") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ registration_id: regId, status: status })
                    });
                    
                    if(response.ok) {
                        const data = await response.json();
                        // Update local state
                        const vol = this.volunteers.find(v => v.registration_id === regId);
                        if(vol) vol.status = status;
                    }
                } catch (e) {
                    alert('Lỗi kết nối');
                } finally {
                    this.loading = false;
                }
            },

            async savePositionUpdate(posId) {
                this.loading = true;
                this.moveModalOpen = false;
                try {
                    const response = await fetch('{{ route("organization.hr.updatePosition") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ 
                            registration_id: this.selectedVolunteer.registration_id, 
                            position_id: posId 
                        })
                    });
                    
                    if(response.ok) {
                        const data = await response.json();
                        // Update local state
                        const vol = this.volunteers.find(v => v.registration_id === this.selectedVolunteer.registration_id);
                        if(vol) {
                            vol.position_id = posId;
                            vol.team_id = 'pos_' + posId;
                            const pos = @json($positions).find(p => p.id == posId);
                            vol.position = pos ? pos.name : 'Chưa xác định';
                        }
                    }
                } catch (e) {
                    alert('Lỗi kết nối');
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endsection
