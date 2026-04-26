@extends('layouts.student')

@section('header', 'Lịch trình hoạt động')

@section('content')
<div class="flex flex-col min-h-screen" x-data="calendarApp()">
    
    <!-- Top Toolbar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 shrink-0">
        <div>
            <h2 class="text-2xl font-black text-slate-800">Tổng quan lịch trình</h2>
            <p class="text-slate-500 text-sm">Quản lý các sự kiện học thuật và ca tình nguyện cộng đồng.</p>
        </div>
        
        <div class="flex items-center gap-3">
             <a href="{{ route('student.events.index') }}" class="bg-primary hover:bg-primary-dark text-white font-bold py-2.5 px-4 rounded-xl shadow-lg shadow-primary/20 flex items-center transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tìm sự kiện
            </a>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
        
        <!-- Main Calendar Area -->
        <div class="flex-1 bg-white rounded-3xl shadow-sm border border-slate-200 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Controls -->
            <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Filters -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <button class="flex items-center px-3 py-2 bg-white border border-slate-200 rounded-lg text-sm font-bold text-slate-700 hover:bg-slate-50 shadow-sm transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        Bộ lọc
                    </button>
                    <button @click="filterCategory = 'all'" :class="filterCategory === 'all' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="px-3 py-2 border rounded-lg text-sm font-bold whitespace-nowrap transition-colors">
                        ● Tất cả
                    </button>
                    <button @click="filterCategory = 'Giáo dục'" :class="filterCategory === 'Giáo dục' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="px-3 py-2 border rounded-lg text-sm font-medium whitespace-nowrap transition-colors">
                        ● Giáo dục
                    </button>
                    <button @click="filterCategory = 'Môi trường'" :class="filterCategory === 'Môi trường' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="px-3 py-2 border rounded-lg text-sm font-medium whitespace-nowrap transition-colors">
                        ● Môi trường
                    </button>
                     <button @click="filterCategory = 'Y tế'" :class="filterCategory === 'Y tế' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'" class="px-3 py-2 border rounded-lg text-sm font-medium whitespace-nowrap transition-colors">
                        ● Y tế
                    </button>
                </div>

                <!-- View Switcher & Month Nav -->
                <div class="flex items-center gap-4">
                    <!-- Nav -->
                    <div class="flex items-center gap-2">
                        <button @click="prev()" class="p-1 hover:bg-slate-100 rounded-full transition-colors">
                            <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        <span class="text-lg font-black text-slate-800 w-32 text-center" x-text="currentDateLabel"></span>
                        <button @click="next()" class="p-1 hover:bg-slate-100 rounded-full transition-colors">
                            <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>

                    <!-- Toggle -->
                    <div class="flex bg-slate-100 p-1 rounded-lg">
                        <button @click="viewMode = 'month'" :class="viewMode === 'month' ? 'bg-white shadow-sm text-slate-800' : 'text-slate-500 hover:text-slate-700'" class="px-3 py-1.5 rounded-md text-sm font-bold transition-all">Tháng</button>
                        <button @click="viewMode = 'week'" :class="viewMode === 'week' ? 'bg-white shadow-sm text-slate-800' : 'text-slate-500 hover:text-slate-700'" class="px-3 py-1.5 rounded-md text-sm font-bold transition-all">Tuần</button>
                        <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-white shadow-sm text-slate-800' : 'text-slate-500 hover:text-slate-700'" class="px-3 py-1.5 rounded-md text-sm font-bold transition-all">List</button>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div>
                
                <!-- MONTH VIEW -->
                <div x-show="viewMode === 'month'" class="flex flex-col">
                    <div class="grid grid-cols-7 border-b border-slate-100 shrink-0">
                        <template x-for="day in ['CN', 'Hai', 'Ba', 'Tư', 'Năm', 'Sáu', 'Bảy']">
                            <div class="py-3 text-center text-xs font-bold text-slate-400 uppercase tracking-wider" x-text="day"></div>
                        </template>
                    </div>
                    
                    <div class="grid grid-cols-7 bg-slate-50 gap-px border-b border-l border-slate-200">
                        <template x-for="date in monthDays" :key="date.dateString">
                            <div class="bg-white min-h-[80px] p-2 relative group hover:bg-slate-50/50 transition-colors cursor-pointer overflow-hidden border border-slate-100"
                                 :class="{'bg-slate-50/30 text-slate-400': !date.isCurrentMonth}">
                                
                                <div class="text-right mb-1">
                                    <span class="text-sm font-bold inline-block w-7 h-7 leading-7 text-center rounded-full"
                                          :class="date.isToday ? 'bg-primary text-white shadow-md' : 'text-slate-700'"
                                          x-text="date.day"></span>
                                </div>

                                <div class="space-y-1">
                                    <template x-for="evt in getEventsForDate(date.dateString).slice(0, 3)">
                                        <div class="px-2 py-1.5 rounded-md text-[10px] font-bold truncate border-l-2 shadow-sm transition-transform hover:scale-105 cursor-pointer"
                                             :class="getEventColor(evt.category)"
                                             @click.stop="openEventModal(evt)">
                                            <span x-text="evt.time"></span> <span x-text="evt.title"></span>
                                        </div>
                                    </template>
                                    <div x-show="getEventsForDate(date.dateString).length > 3" class="text-[10px] font-bold text-slate-400 pl-1">
                                        +<span x-text="getEventsForDate(date.dateString).length - 3"></span> khác
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- WEEK VIEW -->
                <div x-show="viewMode === 'week'" class="flex flex-col">
                    <div class="grid grid-cols-8 border-b border-slate-100 shrink-0">
                        <div class="py-3 text-center text-xs font-bold text-slate-400 uppercase tracking-wider border-r border-slate-100">Giờ</div>
                        <template x-for="date in weekDays">
                            <div class="py-3 text-center border-r border-slate-100 last:border-r-0 border-b border-slate-100" :class="{'bg-blue-50': date.isToday}">
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider" x-text="date.dayName"></div>
                                <div class="text-lg font-black text-slate-800" x-text="date.day"></div>
                            </div>
                        </template>
                    </div>
                    <div>
                        <div class="grid grid-cols-8 relative">
                            <!-- Time Slots -->
                            <div class="border-r border-slate-100 bg-slate-50">
                                <template x-for="hour in hours">
                                    <div class="h-24 border-b border-slate-200 text-xs font-bold text-slate-400 flex items-center justify-center border-r border-slate-200" x-text="hour + ':00'"></div>
                                </template>
                            </div>
                            
                            <!-- Columns -->
                            <template x-for="date in weekDays">
                                <div class="border-r border-slate-100 relative last:border-r-0 hover:bg-slate-50/30 transition-colors border-b border-slate-100">
                                    <template x-for="hour in hours">
                                        <div class="h-24 border-b border-slate-100 box-border"></div>
                                    </template>
                                    
                                    <!-- Events Overlay -->
                                    <template x-for="evt in getEventsForDate(date.dateString)">
                                        <div class="absolute w-[90%] left-[5%] rounded-lg p-2 text-xs font-bold shadow-sm border-l-4 cursor-pointer hover:shadow-md transition-all z-10"
                                             :class="getEventColor(evt.category)"
                                             :style="getEventStyle(evt)"
                                             @click.stop="openEventModal(evt)">
                                            <div x-text="evt.time + ' - ' + evt.endTime"></div>
                                            <div class="truncate" x-text="evt.title"></div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- LIST VIEW -->
                <div x-show="viewMode === 'list'" class="p-6 space-y-8">
                    <template x-for="group in sortedEventsByMonth">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 mb-4 py-2 border-b border-slate-100" x-text="group.month"></h3>
                            <div class="space-y-3">
                                <template x-for="evt in group.events">
                                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center gap-4 hover:shadow-md transition-shadow cursor-pointer"
                                         @click="openEventModal(evt)">
                                        <div class="w-16 h-16 rounded-xl bg-slate-50 flex flex-col items-center justify-center font-bold text-slate-700 border border-slate-100 shrink-0">
                                            <span class="text-xl" x-text="new Date(evt.dateString).getDate()"></span>
                                            <span class="text-xs uppercase text-slate-400" x-text="new Date(evt.dateString).toLocaleString('vi-VN', {month: 'short'})"></span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border"
                                                      :class="getEventColor(evt.category)">
                                                    <span x-text="evt.category"></span>
                                                </span>
                                                <span class="text-xs text-slate-400 font-medium" x-text="evt.time + ' - ' + evt.endTime"></span>
                                            </div>
                                            <h4 class="font-bold text-slate-800 text-lg" x-text="evt.title"></h4>
                                            <p class="text-sm text-slate-500 flex items-center gap-1 mt-1">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                                <span x-text="evt.location"></span>
                                            </p>
                                        </div>
                                        <div class="p-2 rounded-full border border-slate-100 text-slate-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                    <div x-show="sortedEventsByMonth.length === 0" class="text-center py-12 text-slate-500">
                        Không có sự kiện nào phù hợp.
                    </div>
                </div>

            </div>
        </div>

        <!-- Sidebar (Today's Agenda) -->
        <div class="w-full lg:w-80 xl:w-96 flex flex-col gap-6 shrink-0">
             <!-- Quick Stats -->
            <div class="grid grid-cols-1 gap-4 shrink-0">

                <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
                    <p class="text-slate-400 text-xs font-bold uppercase">Sắp tới</p>
                    <p class="text-3xl font-black text-amber-500 mt-1"><span x-text="upcomingCount"></span> <span class="text-sm text-slate-400 font-medium">ca</span></p>
                </div>
            </div>

            <!-- Agenda Timeline -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 flex flex-col">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Sắp tới</h3>
                    <span class="px-2 py-1 bg-blue-50 text-primary text-xs font-bold rounded-lg" x-text="new Date().toLocaleDateString('vi-VN')"></span>
                </div>
                <div class="p-5 space-y-6">
                    <template x-for="evt in upcomingEvents">
                        <div class="relative pl-6 border-l-2 border-primary cursor-pointer hover:opacity-80" @click="openEventModal(evt)">
                            <span class="absolute -left-[5px] top-0 w-2.5 h-2.5 rounded-full bg-primary ring-4 ring-blue-100"></span>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-primary" x-text="evt.dateFormatted + ' • ' + evt.time"></span>
                            </div>
                            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-3">
                                <h4 class="font-bold text-slate-800 text-sm" x-text="evt.title"></h4>
                                <p class="text-xs text-slate-500 flex items-center mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                    <span x-text="evt.location"></span>
                                </p>
                            </div>
                        </div>
                    </template>
                    <div x-show="upcomingEvents.length === 0" class="text-center text-sm text-slate-500 italic">
                        Không có sự kiện sắp tới.
                    </div>
                </div>
            </div>
            
             <!-- Promo/Action -->
            <div class="bg-blue-50 rounded-2xl p-4 flex items-center gap-4 border border-blue-100 shrink-0">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-primary">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-bold text-slate-500">Muốn tham gia thêm?</p>
                    <a href="{{ route('student.events.index') }}" class="text-sm font-black text-slate-800 hover:text-primary transition-colors">Check lịch trống ngay -></a>
                </div>
            </div>

        </div>
    </div>

    <!-- Event Summary Modal -->
    <div x-show="showEventModal" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden relative"
             @click.away="showEventModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-4">
            
            <!-- Modal Close -->
            <button @click="showEventModal = false" class="absolute top-4 right-4 text-white bg-black/20 hover:bg-black/40 rounded-full p-2 transition-colors z-10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            <!-- Modal Header -->
            <div class="h-32 bg-indigo-600 relative overflow-hidden flex items-end p-6">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-700"></div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                
                <div class="relative z-10 w-full">
                    <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/20 text-white backdrop-blur-md border border-white/20 mb-2" x-text="selectedEvent?.category">
                    </span>
                    <h3 class="text-xl font-black text-white leading-tight" x-text="selectedEvent?.title"></h3>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Thời gian</p>
                        <p class="text-slate-800 font-bold" x-text="selectedEvent?.dateFormatted"></p>
                        <p class="text-slate-600 text-sm" x-text="selectedEvent?.time + ' - ' + selectedEvent?.endTime"></p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Địa điểm</p>
                        <p class="text-slate-800 font-bold" x-text="selectedEvent?.location"></p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 pt-0">
                <button @click="window.location.href = '/student/events/' + selectedEvent?.id" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition-all flex items-center justify-center gap-2">
                    Xem chi tiết
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    function calendarApp() {
        return {
            viewMode: 'month', // month, week, list
            filterCategory: 'all',
            date: new Date(),
            monthDays: [],
            weekDays: [],
            showEventModal: false,
            selectedEvent: null,
            hours: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21], // Working hours
            rawEvents: {!! json_encode($calendarItems) !!},

            get events() {
                if (this.filterCategory === 'all') return this.rawEvents;
                return this.rawEvents.filter(e => e.category === this.filterCategory);
            },

            init() {
                this.generateMonth();
                this.generateWeek();
            },
            
            openEventModal(evt) {
                this.selectedEvent = evt;
                this.showEventModal = true;
            },

            get currentDateLabel() {
                if (this.viewMode === 'month') {
                    return 'Tháng ' + (this.date.getMonth() + 1) + ' ' + this.date.getFullYear();
                } else if (this.viewMode === 'week') {
                    // Start of week
                    let curr = new Date(this.date);
                    let first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
                    let firstDay = new Date(curr.setDate(first));
                    let lastDay = new Date(curr.setDate(curr.getDate() + 6));
                    return firstDay.getDate() + '/' + (firstDay.getMonth()+1) + ' - ' + lastDay.getDate() + '/' + (lastDay.getMonth()+1);
                } else {
                    return 'Danh sách';
                }
            },

            get upcomingEvents() {
                // Return top 5 future events
                return this.events.filter(e => e.isFuture).sort((a,b) => new Date(a.dateString) - new Date(b.dateString)).slice(0,5);
            },

            get upcomingCount() {
                return this.upcomingEvents.length;
            },

            // Group events by month for List View
            get sortedEventsByMonth() {
                let groups = {};
                let sorted = this.events.sort((a,b) => new Date(a.dateString) - new Date(b.dateString));
                
                sorted.forEach(evt => {
                    let d = new Date(evt.dateString);
                    let key = 'Tháng ' + (d.getMonth() + 1) + ' ' + d.getFullYear();
                    if (!groups[key]) groups[key] = [];
                    groups[key].push(evt);
                });

                return Object.keys(groups).map(k => ({ month: k, events: groups[k] }));
            },

            prev() {
                if (this.viewMode === 'month') {
                    let d = new Date(this.date);
                    d.setMonth(d.getMonth() - 1);
                    this.date = d;
                    this.generateMonth();
                } else if (this.viewMode === 'week') {
                    let d = new Date(this.date);
                    d.setDate(d.getDate() - 7);
                    this.date = d;
                    this.generateWeek();
                }
            },

            next() {
                if (this.viewMode === 'month') {
                    let d = new Date(this.date);
                    d.setMonth(d.getMonth() + 1);
                    this.date = d;
                    this.generateMonth();
                } else if (this.viewMode === 'week') {
                    let d = new Date(this.date);
                    d.setDate(d.getDate() + 7);
                    this.date = d;
                    this.generateWeek();
                }
            },

            getEventsForDate(dateStr) {
                return this.events.filter(e => e.dateString === dateStr);
            },

            generateMonth() {
                const year = this.date.getFullYear();
                const month = this.date.getMonth();
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const startingDay = firstDay.getDay(); // 0 (Sun)
                const totalDays = lastDay.getDate();

                let daysArray = [];

                // Previous Month Pad
                for (let i = 0; i < startingDay; i++) {
                    let prevDate = new Date(year, month, 0 - i);
                    daysArray.unshift({ // UNSHIFT to add to beginning in correct order
                        day: prevDate.getDate(),
                        dateString: this.formatDate(prevDate),
                        isCurrentMonth: false,
                        isToday: false
                    });
                }

                // Current Month
                for (let i = 1; i <= totalDays; i++) {
                    let currDate = new Date(year, month, i);
                    daysArray.push({
                        day: i,
                        dateString: this.formatDate(currDate),
                        isCurrentMonth: true,
                        isToday: this.isToday(currDate)
                    });
                }

                // Next Month Pad
                const remaining = 42 - daysArray.length; // Ensure 6 rows for consistency
                if (remaining > 0) { // Only add if there are remaining slots
                    for (let i = 1; i <= remaining; i++) {
                         let nextDate = new Date(year, month + 1, i);
                        daysArray.push({
                            day: i,
                            dateString: this.formatDate(nextDate),
                            isCurrentMonth: false,
                            isToday: false
                        });
                    }
                }

                this.monthDays = daysArray;
            },

            generateWeek() {
                let curr = new Date(this.date);
                let first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
                // If we want Monday start: let first = curr.getDate() - curr.getDay() + 1; (and handle Sun)
                
                let week = [];
                for (let i = 0; i < 7; i++) {
                    let day = new Date(curr.setDate(first + i));
                    week.push({
                        day: day.getDate(),
                        dayName: ['CN', 'Hai', 'Ba', 'Tư', 'Năm', 'Sáu', 'Bảy'][day.getDay()],
                        dateString: this.formatDate(day),
                        isToday: this.isToday(day)
                    });
                    // Reset curr for next iteration calculation seems slightly off with setDate mutation in loop?
                    // Better verify:
                    curr = new Date(this.date); // Reset base
                }
                this.weekDays = week;
            },

            formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            },

            isToday(date) {
                const today = new Date();
                return date.getDate() === today.getDate() &&
                       date.getMonth() === today.getMonth() &&
                       date.getFullYear() === today.getFullYear();
            },

            getEventColor(category) {
                // Tailwind classes
                if (category === 'Giáo dục') return 'bg-blue-50 text-blue-700 border-blue-200';
                if (category === 'Y tế') return 'bg-red-50 text-red-700 border-red-200';
                if (category === 'Môi trường') return 'bg-green-50 text-green-700 border-green-200';
                return 'bg-slate-50 text-slate-700 border-slate-200';
            },

            getEventStyle(evt) {
                const startHour = evt.startHour;
                const endHour = evt.endHour;
                const duration = endHour - startHour;
                
                // Assuming grid starts at 7:00 (index 0)
                const offset = startHour - 7;
                
                return `top: ${offset * 24 * 4 / 3}px; height: ${duration * 24 * 4 / 3}px;`; // Adjusted height calc (approx 96px per hour given h-24 = 6rem = 96px)
                // h-24 class is 6rem. 1rem = 16px. 6 * 16 = 96px.
                // So 96px per hour.
                // Formula: 96 * offset
            }
        }
    }
</script>
@endsection
