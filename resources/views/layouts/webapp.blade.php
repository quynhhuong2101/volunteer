<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VolunteerHub') }} - Student Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/webapp.css', 'resources/js/webapp.js'])

    <style>
        [x-cloak] { display: none !important; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-[#F4F7FE] selection:bg-primary/20 selection:text-primary overflow-hidden" x-data="{ sidebarOpen: false }">
    
    <div class="flex h-screen w-full">
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-white flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] border-r border-slate-100">
            <!-- Logo Section -->
            <div class="h-20 flex items-center px-8 border-b border-slate-100/50">
                <a href="{{ route('webapp.index') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-[12px] bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-md group-hover:scale-105 transition-transform duration-300">
                        V
                    </div>
                    <span class="text-2xl font-extrabold text-slate-800 tracking-tight group-hover:text-primary transition-colors">Volun<span class="text-primary">Hub</span></span>
                </a>
                <button @click="sidebarOpen = false" class="ml-auto lg:hidden text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-4">Menu Chính</p>
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-primary/10 text-primary rounded-xl font-bold transition-all relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-primary rounded-r-full"></div>
                    <i class="fa-solid fa-table-cells-large w-5 text-center text-lg"></i>
                    <span>Tổng quan</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-primary rounded-xl font-semibold transition-all group">
                    <i class="fa-regular fa-compass w-5 text-center text-lg group-hover:scale-110 transition-transform"></i>
                    <span>Khám phá sự kiện</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-primary rounded-xl font-semibold transition-all group">
                    <i class="fa-regular fa-calendar-check w-5 text-center text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="flex-1">Lịch của tôi</span>
                    <span class="bg-rose-100 text-rose-600 py-0.5 px-2 rounded-md text-[10px] font-bold">2 MỚI</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-primary rounded-xl font-semibold transition-all group">
                    <i class="fa-solid fa-medal w-5 text-center text-lg group-hover:scale-110 transition-transform"></i>
                    <span>Chứng nhận</span>
                </a>

                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-8">Cá Nhân</p>
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-primary rounded-xl font-semibold transition-all group">
                    <i class="fa-regular fa-user w-5 text-center text-lg group-hover:scale-110 transition-transform"></i>
                    <span>Hồ sơ</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 hover:text-primary rounded-xl font-semibold transition-all group">
                    <i class="fa-solid fa-gear w-5 text-center text-lg group-hover:scale-110 transition-transform"></i>
                    <span>Cài đặt</span>
                </a>
            </div>

            <!-- Bottom Ad / Info -->
            <div class="p-4 mx-4 mb-4 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/10 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-primary shadow-sm mb-3">
                        <i class="fa-solid fa-bolt text-lg"></i>
                    </div>
                    <h4 class="font-bold text-slate-800 text-sm mb-1">Cấp độ Năng nổ</h4>
                    <p class="text-xs text-slate-500 font-medium mb-3">Bạn cần 5 giờ nữa để thăng cấp.</p>
                    <div class="w-full bg-white rounded-full h-1.5 mb-2 overflow-hidden">
                        <div class="bg-primary h-1.5 rounded-full w-[70%]"></div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <!-- Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100/50 flex items-center justify-between px-6 lg:px-10 z-30 flex-shrink-0">
                
                <!-- Left: Mobile Toggle & Search -->
                <div class="flex items-center gap-4 flex-1">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-primary transition-colors">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>

                    <div class="hidden sm:flex relative group w-full max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-primary transition-colors"></i>
                        </div>
                        <input type="text" class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-full text-sm placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary/30 transition-all shadow-sm" placeholder="Tìm kiếm nhanh sự kiện...">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-[10px] font-bold text-slate-400 border border-slate-200 rounded px-1.5 py-0.5 bg-white">Ctrl K</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Profile & Actions -->
                <div class="flex items-center gap-3 sm:gap-5">
                    
                    <button class="relative p-2.5 rounded-full bg-slate-50 text-slate-500 hover:bg-slate-100 hover:text-primary transition-all duration-200 border border-slate-200/50">
                        <i class="fa-regular fa-bell"></i>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-slate-50"></span>
                    </button>
                    
                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center gap-3 p-1 rounded-full hover:bg-slate-50 transition-all border border-transparent hover:border-slate-200 pr-3">
                            <img class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Student') }}&background=0F4C81&color=fff&bold=true" alt="Avatar">
                            <div class="hidden md:flex flex-col items-start leading-tight">
                                <span class="text-sm font-bold text-slate-700">{{ auth()->user()->name ?? 'Sinh viên' }}</span>
                                <span class="text-[10px] font-bold text-primary">Tình nguyện viên</span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1 transition-transform duration-200" :class="openProfile ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="openProfile" x-transition.opacity.duration.200ms class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] py-2 border border-slate-100 z-50 ring-1 ring-slate-900/5 origin-top-right scale-100" x-cloak>
                            <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-primary transition-colors">
                                <i class="fa-solid fa-desktop w-5 text-center mr-2"></i> Trở về Trang Admin
                            </a>
                            <div class="h-px bg-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 transition-colors">
                                    <i class="fa-solid fa-power-off w-5 text-center mr-2"></i> Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto p-6 lg:p-10 relative">
                <!-- Background decorative blob inside content -->
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[100px] pointer-events-none mix-blend-multiply"></div>
                
                <div class="relative z-10 max-w-7xl mx-auto">
                    @yield('content')
                </div>
                
                <footer class="mt-20 pt-8 pb-4 text-center text-sm font-medium text-slate-400 border-t border-slate-200/60 w-full relative z-10">
                    &copy; {{ date('Y') }} VolunteerHub Dashboard. All rights reserved.
                </footer>
            </div>
            
        </main>
    </div>
</body>
</html>
