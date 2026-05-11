<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Volunteer Connect') }} - Student</title>

    <!-- Google Fonts: Be Vietnam Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @if(app()->isLocal() || config('app.debug'))
    <!-- Fallback style for preview without Vite build -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#0F4C81', // Ocean Blue
                            light: '#357abd',
                            dark: '#0a365c',
                        },
                        accent: {
                            DEFAULT: '#FF6D00', // Energetic Orange
                            light: '#ff9e40',
                        },
                        neutral: {
                            bg: '#F4F7FE',
                            surface: '#FFFFFF',
                        }
                    },
                    fontFamily: {
                        sans: ['"Be Vietnam Pro"', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    @endif
    
    <!-- AlpineJS for interactivity -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Be Vietnam Pro', sans-serif; }
    </style>
</head>
<body class="bg-neutral-bg text-gray-800 antialiased">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false, safetyModalOpen: false }">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 shadow-2xl flex flex-col">
            
            <!-- Logo -->
            <div class="h-16 flex items-center justify-center border-b border-primary-dark">
                <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo-hv.png') }}" alt="VWA Logo" class="h-8 w-auto">
                    <span class="text-xl font-bold tracking-wide">VWA- Connect</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('student.dashboard') ? 'bg-primary-dark text-white' : 'text-blue-100 hover:bg-primary-light hover:text-white' }} rounded-lg group transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Tổng quan</span>
                </a>

                <a href="{{ route('student.events.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('student.events.index', 'student.events.show', 'student.events.register') ? 'bg-primary-dark text-white' : 'text-blue-100 hover:bg-primary-light hover:text-white' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-medium">Sự kiện</span>
                </a>

                <div x-data="{ open: {{ request()->routeIs('student.activities.*', 'student.events.registered', 'student.certificates.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-blue-100 hover:bg-primary-light hover:text-white rounded-lg transition-colors focus:outline-none">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span class="font-medium">Hoạt động</span>
                        </div>
                        <svg class="w-4 h-4 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-12 pr-4 space-y-1 mt-1">
                        <a href="{{ route('student.activities.schedule') }}" class="block py-2 text-sm {{ request()->routeIs('student.activities.schedule') ? 'text-white font-semibold' : 'text-blue-200 hover:text-white' }} transition-colors">
                            Lịch trình
                        </a>
                        <a href="{{ route('student.events.registered') }}" class="block py-2 text-sm {{ request()->routeIs('student.events.registered') ? 'text-white font-semibold' : 'text-blue-200 hover:text-white' }} transition-colors">
                            Sự kiện của tôi
                        </a>
                        <a href="{{ route('student.activities.history') }}" class="block py-2 text-sm {{ request()->routeIs('student.activities.history') || request()->routeIs('student.certificates.*') ? 'text-white font-semibold' : 'text-blue-200 hover:text-white' }} transition-colors">
                            Lịch sử
                        </a>
                    </div>
                </div>

                <a href="{{ route('student.checkin.view') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('student.checkin.*') ? 'bg-primary-dark text-white' : 'text-blue-100 hover:bg-primary-light hover:text-white' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span class="font-medium">Điểm danh & Tasks</span>
                </a>

                <a href="{{ route('student.reviews.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('student.reviews.*') ? 'px-4 py-3 bg-primary-dark rounded-lg text-white' : 'text-blue-100 hover:bg-primary-light hover:text-white rounded-lg' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    <span class="font-medium">Đánh giá</span>
                </a>

                <a href="{{ route('student.reports.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('student.reports.*') ? 'bg-primary-dark text-white' : 'text-blue-100 hover:bg-primary-light hover:text-white' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span class="font-medium">Khiếu nại / Báo cáo</span>
                </a>

                <a href="{{ route('student.community.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('student.community.*') ? 'bg-primary-dark text-white' : 'text-blue-100 hover:bg-primary-light hover:text-white' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span class="font-medium">Cộng đồng</span>
                </a>

                <a href="{{ route('student.portfolio.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('student.portfolio.*') ? 'bg-primary-dark text-white' : 'text-blue-100 hover:bg-primary-light hover:text-white' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">Hồ sơ năng lực</span>
                </a>
                <div x-data="{ open: {{ request()->routeIs('student.settings.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" type="button" class="flex items-center justify-between w-full px-4 py-3 {{ request()->routeIs('student.settings.*') ? 'text-white bg-primary-dark rounded-lg' : 'text-blue-100 hover:bg-primary-light hover:text-white rounded-lg' }} transition-colors focus:outline-none">
                        <div class="flex items-center">
                            <span class="w-6 h-6 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </span>
                            <span class="font-medium">Cài đặt</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="opacity-0 transform -translate-y-2" 
                         x-transition:enter-end="opacity-100 transform translate-y-0" 
                         class="pl-11 pr-2 space-y-1">
                        <a href="{{ route('student.settings.account') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('student.settings.account') ? 'text-white bg-white/20' : 'text-blue-200 hover:text-white hover:bg-white/10' }} transition-colors">
                            Tài khoản
                        </a>
                        <a href="{{ route('student.settings.password') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('student.settings.password') ? 'text-white bg-white/20' : 'text-blue-200 hover:text-white hover:bg-white/10' }} transition-colors">
                            Đổi mật khẩu
                        </a>
                    </div>
                </div>

                <div class="pt-4 mt-6 border-t border-blue-400/30">
                     <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-3 text-blue-100 hover:bg-red-500/20 hover:text-red-200 rounded-lg transition-colors group">
                             <svg class="w-5 h-5 mr-3 group-hover:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                             <span class="font-medium">Đăng xuất</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- User Footer Removed -->
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <header class="h-20 bg-white shadow-sm flex items-center justify-between px-6 z-10 gap-4">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>

                    <!-- Breadcrumb / Title -->
                    <h1 class="text-xl font-bold text-gray-800 whitespace-nowrap hidden md:block">@yield('header', 'Dashboard')</h1>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl mx-4">
                    <form method="GET" action="{{ route('student.events.index') }}" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="query" value="{{ request('query') }}" class="block w-full pl-10 pr-3 py-2.5 border-none rounded-xl bg-slate-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all shadow-inner font-medium sm:text-sm" placeholder="Tìm kiếm hoạt động, sự kiện...">
                    </form>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-2 md:gap-4">
                    
                    <!-- Safety/SOS Button -->
                    <button @click="safetyModalOpen = true" class="hidden md:flex items-center gap-2 bg-red-100 text-red-600 px-4 py-2 rounded-xl font-bold hover:bg-red-600 hover:text-white transition-all animate-pulse">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <span>SOS</span>
                    </button>

                    <!-- Notification Bell -->
                    <button class="relative p-2.5 text-gray-400 hover:text-accent hover:bg-orange-50 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-2 right-2.5 h-2 w-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    
                    <!-- Divider -->
                    <div class="h-8 w-px bg-gray-200 mx-1 hidden md:block"></div>

                    <!-- User Profile -->
                    <div class="flex items-center gap-3 pl-1">
                        <div class="text-right hidden md:block">
                            <div class="text-sm font-bold text-gray-800">{{ Auth::user()->name ?? 'Sinh viên' }}</div>
                            <div class="text-xs text-gray-500 font-medium">Sinh viên tình nguyện</div>
                        </div>
                        <div class="relative group cursor-pointer">
                            <div class="absolute -inset-0.5 bg-gradient-to-br from-primary to-accent rounded-full opacity-0 group-hover:opacity-100 transition-opacity blur"></div>
                            @if(Auth::user()->avatar && (str_starts_with(Auth::user()->avatar, 'http') || file_exists(public_path(Auth::user()->avatar))))
                                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="relative w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm">
                            @else
                                <div class="relative w-10 h-10 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-slate-600 font-bold shadow-sm group-hover:bg-white group-hover:text-primary transition-colors">
                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-neutral-bg p-6">
                @yield('content')
            </main>
        </div>

        <!-- Overlay for Mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black opacity-50 md:hidden"></div>

        <!-- Mobile Floating SOS Button -->
        <button @click="safetyModalOpen = true" class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-red-600 text-white rounded-full shadow-2xl flex items-center justify-center z-50 hover:scale-110 active:scale-95 transition-all animate-bounce">
             <span class="font-extrabold text-xs">SOS</span>
        </button>

        <!-- Safety Modal -->
        <div x-show="safetyModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div x-show="safetyModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" @click="safetyModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="safetyModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-[2rem] text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div x-data="{ activeTab: 'sos' }">
                            
                            <!-- Tabs -->
                            <div class="flex space-x-2 bg-slate-100 p-1 rounded-xl mb-6">
                                <button @click="activeTab = 'sos'" :class="activeTab === 'sos' ? 'bg-red-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-2 px-4 rounded-lg font-bold text-sm transition-all text-center">
                                    KHẨN CẤP (SOS)
                                </button>
                                <button @click="activeTab = 'report'" :class="activeTab === 'report' ? 'bg-white text-primary shadow-md' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-2 px-4 rounded-lg font-bold text-sm transition-all text-center">
                                    Báo cáo sự cố
                                </button>
                            </div>

                            <!-- SOS Content -->
                            <div x-show="activeTab === 'sos'" class="text-center py-6">
                                <div class="mb-6 relative flex justify-center">
                                    <div class="absolute inset-0 bg-red-100 rounded-full animate-ping opacity-75 w-32 h-32 mx-auto"></div>
                                    <button @click="sendSOS()" class="relative w-32 h-32 bg-red-600 rounded-full flex items-center justify-center text-white shadow-xl hover:bg-red-700 active:scale-95 transition-all">
                                        <div class="text-center">
                                            <svg class="w-10 h-10 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                            <span class="font-black text-2xl tracking-widest">SOS</span>
                                        </div>
                                    </button>
                                </div>
                                <h3 class="text-xl font-extrabold text-slate-800 mb-2">Bạn đang gặp nguy hiểm?</h3>
                                <p class="text-slate-500 text-sm px-8">Nhấn nút đỏ để gửi vị trí GPS của bạn ngay lập tức cho Ban tổ chức và Đội trưởng.</p>
                                <p id="sos-status" class="mt-4 text-sm font-bold h-6"></p>
                            </div>

                            <!-- Report Content -->
                            <div x-show="activeTab === 'report'">
                                <form action="{{ route('student.safety.report') }}" method="POST">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-bold text-slate-700 mb-1">Loại sự cố</label>
                                            <select name="type" class="w-full bg-slate-50 border-none rounded-xl px-4 py-2.5 font-medium text-slate-700 focus:ring-2 focus:ring-primary/20">
                                                <option value="health">Vấn đề sức khỏe / Tai nạn</option>
                                                <option value="harassment">Bị quấy rối / Đe dọa</option>
                                                <option value="lost">Đi lạc / Mất phương hướng</option>
                                                <option value="logistics">Vấn đề hậu cần / Di chuyển</option>
                                                <option value="other">Khác</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-slate-700 mb-1">Mô tả chi tiết</label>
                                            <textarea name="description" rows="3" placeholder="Mô tả tình huống hiện tại..." class="w-full bg-slate-50 border-none rounded-xl px-4 py-2.5 font-medium text-slate-700 focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-slate-500 bg-slate-50 p-3 rounded-lg">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            <span class="font-medium">Vị trí sẽ được gửi kèm tự động.</span>
                                        </div>
                                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary-dark shadow-lg shadow-blue-500/20 transition-all">Gửi báo cáo</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="safetyModalOpen = false">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function sendSOS() {
                const statusEl = document.getElementById('sos-status');
                statusEl.textContent = "Đang lấy vị trí...";
                statusEl.className = "mt-4 text-sm font-bold text-blue-600 animate-pulse";

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        statusEl.textContent = "Đang gửi tín hiệu...";

                        fetch('{{ route("student.safety.sos") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ latitude: lat, longitude: lng })
                        })
                        .then(response => response.json())
                        .then(data => {
                            statusEl.textContent = data.message;
                            statusEl.className = "mt-4 text-sm font-bold text-green-600";
                            setTimeout(() => {
                                // alert("Đã gửi SOS thành công!");
                                // Alpine data binding handles modal close if needed, or keep open for assurance
                            }, 500);
                        })
                        .catch(error => {
                            statusEl.textContent = "Lỗi kết nối. Vui lòng gọi điện trực tiếp!";
                            statusEl.className = "mt-4 text-sm font-bold text-red-600";
                        });

                    }, (error) => {
                        statusEl.textContent = "Không thể lấy vị trí. Hãy gọi 113!";
                        statusEl.className = "mt-4 text-sm font-bold text-red-600";
                    });
                } else {
                    statusEl.textContent = "Trình duyệt không hỗ trợ Geolocation.";
                    statusEl.className = "mt-4 text-sm font-bold text-red-600";
                }
            }
        </script>
    </div>
    <!-- Support Chat Widget -->
    <div x-data="{ chatOpen: false }" class="fixed bottom-24 md:bottom-6 right-6 z-40">
        <!-- Chat Window -->
        <div x-show="chatOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="absolute bottom-20 right-0 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden origin-bottom-right">
            
            <!-- Header -->
            <div class="bg-primary p-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <span class="w-2 h-2 bg-green-400 rounded-full absolute bottom-0 right-0 border border-white"></span>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">SV</div>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Hỗ trợ Sinh viên</h4>
                        <p class="text-xs text-blue-100">Luôn sẵn sàng 24/7</p>
                    </div>
                </div>
                <button @click="chatOpen = false" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-4 h-64 overflow-y-auto bg-slate-50 space-y-3">
                <div class="flex gap-2">
                    <div class="w-6 h-6 rounded-full bg-primary/20 flex-shrink-0 flex items-center justify-center text-xs font-bold text-primary">SV</div>
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-slate-600 border border-slate-100">
                        Chào bạn! Ban Hỗ trợ Sinh viên có thể giúp gì cho bạn?
                    </div>
                </div>
                <div class="flex gap-2 flex-row-reverse">
                    <div class="bg-primary text-white p-3 rounded-2xl rounded-tr-none shadow-sm text-sm">
                        Mình muốn hỏi về quy trình đổi điểm rèn luyện ạ.
                    </div>
                </div>
                 <div class="flex gap-2">
                    <div class="w-6 h-6 rounded-full bg-primary/20 flex-shrink-0 flex items-center justify-center text-xs font-bold text-primary">SV</div>
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-slate-600 border border-slate-100">
                        Bạn có thể xem chi tiết trong mục "Hồ sơ năng lực" hoặc gửi câu hỏi cụ thể tại đây nhé!
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="p-3 bg-white border-t border-slate-100 flex gap-2">
                <input type="text" placeholder="Nhập tin nhắn..." class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-primary">
                <button class="p-2 bg-primary text-white rounded-xl hover:bg-primary-dark transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </div>
        </div>

        <!-- Float Button -->
        <button @click="chatOpen = !chatOpen" 
                class="group relative flex items-center justify-center w-14 h-14 bg-gradient-to-r from-primary to-cyan-500 rounded-full text-white shadow-lg hover:shadow-2xl hover:scale-110 transition-all duration-300">
            <span class="absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75 animate-ping group-hover:hidden"></span>
            <svg x-show="!chatOpen" class="w-6 h-6 transform transition-transform duration-300 rotate-0 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
            <svg x-show="chatOpen" class="w-6 h-6 transform transition-transform duration-300 rotate-90" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
    </div>
    @stack('scripts')
    
    <!-- SweetAlert2 Initialization for Global Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });
            @endif
            
            @if(session('info'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: "{{ session('info') }}",
                    showConfirmButton: false,
                    timer: 5000,
                });
            @endif
        });
    </script>
</body>
</html>
