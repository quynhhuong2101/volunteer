@extends('layouts.organization')

@section('header', 'Quản lý Nhân sự & Tuyển dụng')

@section('content')
<div class="h-[calc(100vh-8rem)] flex flex-col" x-data='{ 
    rejectModalOpen: false, 
    detailModalOpen: false,
    selectedVolunteer: null,
    filterSpam: false,
    filterFaculty: "all",
    
    volunteers: @json($volunteers).map(v => ({...v, show: true})),

    applyFilters() {
        this.volunteers.forEach(v => {
            let match = true;
            if (this.filterSpam && !v.is_spam) match = false;
            if (this.filterFaculty !== "all" && v.faculty !== this.filterFaculty) match = false;
            v.show = match;
        });
    },

    openDetail(volunteer) {
        this.selectedVolunteer = volunteer;
        this.detailModalOpen = true;
    }
}'>
    
    <!-- Stats & Filters -->
    <!-- Stats & Filters -->
    <div class="flex flex-col gap-4 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Danh sách Tình nguyện viên</h1>
                <p class="text-sm text-slate-500">Quản lý tất cả tình nguyện viên đã tham gia các chiến dịch.</p>
            </div>
            
            <div class="flex items-center gap-4">
                 <div class="flex items-center gap-2 bg-green-50 px-3 py-1.5 rounded-lg border border-green-100">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span class="text-xs font-bold text-green-700">Tổng số: {{ count($volunteers) }}</span>
                </div>
            </div>
        </div>

        <!-- Smart Filter Toolbar -->
        <div class="flex items-center gap-3 bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-sm font-bold text-slate-500 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                Bộ lọc:
            </span>
            
            <select x-model="filterFaculty" @change="applyFilters()" class="bg-slate-50 border-none text-xs font-bold text-slate-700 rounded-lg py-1.5 pl-3 pr-8 focus:ring-2 focus:ring-primary/20">
                <option value="all">Tất cả Khoa</option>
                <option value="Khoa học Máy tính">Khoa học Máy tính</option>
                <option value="Hệ thống Thông tin">Hệ thống Thông tin</option>
                <option value="Công nghệ Phần mềm">Công nghệ Phần mềm</option>
            </select>

            <div class="h-6 w-px bg-slate-200"></div>

             <label class="flex items-center cursor-pointer gap-2 px-3 py-1.5 rounded-lg hover:bg-slate-50 transition-colors select-none" :class="{'bg-red-50 text-red-600': filterSpam}">
                <input type="checkbox" x-model="filterSpam" @change="applyFilters()" class="hidden">
                <svg class="w-4 h-4" :class="filterSpam ? 'text-red-500' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <span class="text-xs font-bold">Lọc hồ sơ rác (Spam)</span>
            </label>
        </div>
    </div>

    <!-- Volunteer List (Grid) -->
    <div class="flex-1 overflow-y-auto pr-2 pb-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
             @foreach($volunteers as $volunteer)
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                        <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $volunteer['avatar'] }}" class="w-10 h-10 rounded-full border border-slate-100">
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">{{ $volunteer['name'] }}</h4>
                                <p class="text-xs text-slate-500 font-mono">{{ $volunteer['student_id'] }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-full border border-green-100">
                            Đã tham gia
                        </span>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                {{ $volunteer['faculty'] }}
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                {{ $volunteer['role'] }}
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ $volunteer['event'] }}
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-50 flex items-center justify-between">
                            <span class="text-[10px] text-slate-400 font-medium">Đăng ký: {{ $volunteer['applied_at'] }}</span>
                            <button @click="openDetail(volunteer)" class="text-xs font-bold text-primary hover:text-primary-dark hover:underline">Xem chi tiết</button>
                        </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection


