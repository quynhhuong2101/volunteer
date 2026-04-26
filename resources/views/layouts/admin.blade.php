<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VWA-Admin - Volunteer Connect</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4338ca', // Indigo 700
                        'primary-dark': '#3730a3', // Indigo 800
                        secondary: '#64748b',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased selection:bg-indigo-100 selection:text-indigo-700">
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col transition-all duration-300">
            <div class="px-6 py-8 flex items-center gap-3">
                <img src="/images/logo-hv.png" alt="Logo" class="w-8 h-8 object-contain bg-white rounded-lg p-0.5">
                <span class="font-bold text-xl tracking-tight">VWA - Admin</span>
            </div>
            
            <nav class="flex-1 px-4 space-y-2 py-4">
                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tổng quan</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>
                 
                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Quản trị</p>

                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Quản lý Người dùng
                </a>

                <a href="{{ route('admin.community.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.community.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Cộng đồng
                </a>

                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Nghiệp vụ</p>
                
                <a href="{{ route('admin.events.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.events.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Phê duyệt Sự kiện
                </a>
                
                <a href="{{ route('admin.budgets.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.budgets.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Kiểm soát Tài chính
                </a>

                <a href="{{ route('admin.disputes.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.disputes.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                    Giải quyết Tranh chấp
                </a>

                <a href="{{ route('admin.certificates.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.certificates.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Quản lý Chứng nhận
                </a>

                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Hệ thống</p>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    Cài đặt chung
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center gap-3 px-2">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=fff" class="w-9 h-9 rounded-full ring-2 ring-indigo-500/50">
                    <div>
                        <p class="text-sm font-bold text-white">Ban Chấp Hành</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-slate-400 hover:text-white hover:underline">Đăng xuất</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 shadow-sm z-10">
                <h1 class="text-xl font-bold text-slate-800">@yield('header', 'Dashboard')</h1>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                        <svg class="w-6 h-6 text-slate-400 hover:text-slate-600 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-auto p-6">
                <!-- Global Alerts -->
                @if(session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center shadow-sm relative" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="block sm:inline font-bold">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-emerald-500 hover:text-emerald-800">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center shadow-sm relative" role="alert">
                     <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="block sm:inline font-bold">{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-500 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    <!-- Support Chat Widget -->
    <div x-data="{ chatOpen: false }" class="fixed bottom-6 right-6 z-50">
        <!-- Chat Window -->
        <div x-show="chatOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="absolute bottom-20 right-0 w-80 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden origin-bottom-right">
            
            <!-- Header -->
            <div class="bg-indigo-600 p-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <span class="w-2 h-2 bg-green-400 rounded-full absolute bottom-0 right-0 border border-indigo-600"></span>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">KT</div>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Hỗ trợ Kỹ thuật</h4>
                        <p class="text-xs text-indigo-200">System Admin</p>
                    </div>
                </div>
                <button @click="chatOpen = false" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-4 h-64 overflow-y-auto bg-slate-50 space-y-3">
                <div class="flex gap-2">
                    <div class="w-6 h-6 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center text-xs font-bold text-indigo-600">KT</div>
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-slate-600 border border-slate-200">
                        Hệ thống đang hoạt động ổn định. Admin cần hỗ trợ gì không?
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="p-3 bg-white border-t border-slate-100 flex gap-2">
                <input type="text" placeholder="Nhập yêu cầu..." class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-indigo-600">
                <button class="p-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </div>
        </div>

        <!-- Float Button -->
        <button @click="chatOpen = !chatOpen" 
                class="group relative flex items-center justify-center w-14 h-14 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full text-white shadow-lg hover:shadow-2xl hover:scale-110 transition-all duration-300">
            <span class="absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75 animate-ping group-hover:hidden"></span>
            <svg x-show="!chatOpen" class="w-6 h-6 transform transition-transform duration-300 rotate-0 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            <svg x-show="chatOpen" class="w-6 h-6 transform transition-transform duration-300 rotate-90" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    @stack('scripts')
</body>
</html>
