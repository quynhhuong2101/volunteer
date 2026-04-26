@extends('layouts.webapp')

@section('content')
<div class="space-y-8" x-data="{ currentTab: 'all' }">

    <!-- Dashboard Header Greeting -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight mb-2">
                Tổng quan cá nhân 👋
            </h1>
            <p class="text-slate-500 font-medium">Bảng điều khiển hoạt động tình nguyện của bạn hôm nay.</p>
        </div>
        <button class="px-5 py-2.5 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:-translate-y-0.5 hover:bg-primary-dark transition-all duration-300 flex items-center gap-2 w-fit">
            <i class="fa-solid fa-magnifying-glass"></i> Tìm sự kiện
        </button>
    </div>

    <!-- Quick Stats Widgets (Dashboard Style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Widget 1: Hours -->
        <div class="bg-white rounded-[20px] p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow group relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-accent/5 rounded-full blur-xl group-hover:bg-accent/10 transition-colors"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-accent/10 text-accent flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded-lg">+12h tháng này</span>
            </div>
            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold text-slate-800 mb-1">48<span class="text-base font-semibold text-slate-400 ml-1">Giờ</span></h2>
                <p class="text-sm font-medium text-slate-500">Tổng giờ tình nguyện</p>
            </div>
        </div>

        <!-- Widget 2: Events -->
        <div class="bg-white rounded-[20px] p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow group relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold text-slate-800 mb-1">12<span class="text-base font-semibold text-slate-400 ml-1">Sự kiện</span></h2>
                <p class="text-sm font-medium text-slate-500">Đã tham gia hoàn tất</p>
            </div>
        </div>

        <!-- Widget 3: Certificates -->
        <div class="bg-white rounded-[20px] p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow group relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-500/5 rounded-full blur-xl group-hover:bg-green-500/10 transition-colors"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-award"></i>
                </div>
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-lg">Có thể tải về</span>
            </div>
            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold text-slate-800 mb-1">5<span class="text-base font-semibold text-slate-400 ml-1">Chứng chỉ</span></h2>
                <p class="text-sm font-medium text-slate-500">Chứng nhận hoạt động</p>
            </div>
        </div>

        <!-- Widget 4: Next Event (Highlighted) -->
        <div class="bg-gradient-to-br from-primary to-blue-700 rounded-[20px] p-6 shadow-lg shadow-primary/20 text-white relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-pointer">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700 delay-100"></div>
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-xs font-bold text-blue-100 uppercase tracking-wider">Sắp diễn ra</span>
                    </div>
                    <h3 class="text-lg font-bold leading-snug mb-2 line-clamp-2">Lễ Ra Quân Ngày Chủ Nhật Xanh 2026</h3>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <div class="text-sm font-medium text-blue-100">
                        <i class="fa-regular fa-clock mr-1"></i> 08:00 Ngày mai
                    </div>
                    <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-colors border border-white/20">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Main Grid Layout (2 cols: Events & Activity) -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- Left: Recommended Events Filter & List -->
        <div class="xl:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-extrabold text-slate-800">Đề xuất cho bạn</h2>
                <a href="#" class="text-sm font-bold text-primary hover:text-primary-dark transition-colors">Xem toàn bộ</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Event Card 1 -->
                <div class="group bg-white rounded-[20px] border border-slate-100 overflow-hidden hover:shadow-[0_10px_40px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col cursor-pointer">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1593113589914-07544028f52f?auto=format&fit=crop&w=600&q=80" alt="Event" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="px-2.5 py-1 bg-white/95 backdrop-blur-md text-slate-800 rounded-lg text-[10px] uppercase tracking-wider font-extrabold shadow-sm">
                                <i class="fa-solid fa-tree text-green-500 mr-1"></i> Môi trường
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-primary transition-colors">Chiến Dịch Phủ Xanh Đồi Trọc 2026</h3>
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2">Cùng chung tay mang lại không gian xanh sạch đẹp cho thành phố.</p>
                        
                        <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4">
                            <div class="flex items-center text-xs text-slate-500 font-medium">
                                <i class="fa-regular fa-calendar-days text-primary mr-1.5"></i> 10/04/2026
                            </div>
                            <button class="text-sm font-bold text-primary bg-primary/10 px-4 py-2 rounded-xl group-hover:bg-primary group-hover:text-white transition-all shadow-sm group-hover:shadow-primary/30">
                                Đăng ký
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Event Card 2 -->
                <div class="group bg-white rounded-[20px] border border-slate-100 overflow-hidden hover:shadow-[0_10px_40px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 flex flex-col cursor-pointer">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80" alt="Event" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        <div class="absolute top-3 left-3 flex gap-2">
                            <span class="px-2.5 py-1 bg-white/95 backdrop-blur-md text-slate-800 rounded-lg text-[10px] uppercase tracking-wider font-extrabold shadow-sm">
                                <i class="fa-solid fa-book-open text-accent mr-1"></i> Giáo dục
                            </span>
                            <span class="px-2.5 py-1 bg-rose-500 text-white rounded-lg text-[10px] uppercase tracking-wider font-extrabold shadow-sm animate-pulse">
                                HOT
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-primary transition-colors">Lớp Học Tình Thương Vùng Cao</h3>
                        <p class="text-slate-500 text-sm mb-4 line-clamp-2">Hỗ trợ giảng dạy và quyên góp sách vở cho các em học sinh tiểu học.</p>
                        
                        <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4">
                            <div class="flex items-center text-xs text-slate-500 font-medium">
                                <i class="fa-regular fa-calendar-days text-accent mr-1.5"></i> 15/05/2026
                            </div>
                            <button class="text-sm font-bold text-accent bg-accent/10 px-4 py-2 rounded-xl group-hover:bg-accent group-hover:text-white transition-all shadow-sm group-hover:shadow-accent/30">
                                Đăng ký
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Tasks / Recents Sidebar -->
        <div class="space-y-6">
            <h2 class="text-xl font-extrabold text-slate-800">Hoạt động bám sát</h2>
            
            <div class="bg-white rounded-[20px] p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-slate-800">Lịch trình sắp tới</h3>
                    <div class="p-1.5 bg-slate-50 rounded-lg text-slate-400">
                        <i class="fa-solid fa-list-check text-sm"></i>
                    </div>
                </div>
                
                <div class="space-y-6 relative border-l-2 border-slate-100 ml-3">
                    
                    <!-- Timeline Item -->
                    <div class="relative pl-6">
                        <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-white border-4 border-primary shadow-sm"></span>
                        <p class="text-[10px] font-bold text-primary mb-1 uppercase tracking-wider">08:00 AM • Ngày mai</p>
                        <h4 class="text-sm font-bold text-slate-800">Tập trung Lễ Ra Quân</h4>
                        <p class="text-xs font-medium text-slate-500 mt-1">Sân vận động Trung tâm</p>
                    </div>
                    
                    <!-- Timeline Item -->
                    <div class="relative pl-6">
                        <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-white border-4 border-slate-300"></span>
                        <p class="text-[10px] font-bold text-slate-400 mb-1 uppercase tracking-wider">14:00 PM • 18/04</p>
                        <h4 class="text-sm font-bold text-slate-700">Buổi Training Kỹ năng Y tế</h4>
                        <p class="text-xs font-medium text-slate-500 mt-1">Phòng Sinh hoạt T5</p>
                    </div>

                    <!-- Timeline Item -->
                    <div class="relative pl-6">
                        <span class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-white border-4 border-slate-300"></span>
                        <p class="text-[10px] font-bold text-slate-400 mb-1 uppercase tracking-wider">All day • 20/04</p>
                        <h4 class="text-sm font-bold text-slate-700">Hiến Máu Nhân Đạo</h4>
                        <p class="text-xs font-medium text-slate-500 mt-1">Bệnh viện Huyết Học</p>
                    </div>
                </div>
                
                <button class="w-full mt-6 py-3 border-2 border-dashed border-slate-200 rounded-xl text-sm font-bold text-slate-400 hover:border-primary hover:text-primary transition-colors">
                    Xem toàn bộ lịch trình
                </button>
            </div>
            
            <!-- Quick Ad / Help -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-[20px] p-6 border border-indigo-100 flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 shrink-0">
                    <i class="fa-solid fa-circle-question text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 mb-1 text-sm">Cần trợ giúp?</h3>
                    <p class="text-xs font-medium text-slate-500 mb-3">Đội ngũ hỗ trợ VolunteerHub luôn sẵn sàng giải đáp thắc mắc của bạn.</p>
                    <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">Liên hệ ngay &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
