<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Volunteer Connect') }} - Organization</title>

    <!-- Google Fonts: Be Vietnam Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @if(app()->isLocal() || config('app.debug'))
    <!-- Fallback style -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#0F4C81',
                            light: '#357abd',
                            dark: '#0a365c',
                        },
                        accent: {
                            DEFAULT: '#FF6D00',
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
    
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>body { font-family: 'Be Vietnam Pro', sans-serif; }</style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-neutral-bg text-gray-800 antialiased">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 shadow-2xl flex flex-col">
            
            <!-- Logo -->
            <div class="h-16 flex items-center justify-center border-b border-slate-800 bg-slate-900">
                <a href="#" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo-hv.png') }}" alt="VWA Logo" class="w-8 h-8 object-contain bg-white rounded-md p-0.5">
                    <span class="text-xl font-bold tracking-wide text-white">VWA-Portal</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                
        
                <a href="{{ route('organization.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('organization.dashboard') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all group">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-medium">Tổng quan</span>
                </a>

              
                
                <!-- Event Management -->
                <a href="{{ route('organization.events.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('organization.events.*') && !request()->routeIs('organization.events.builder') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all group">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-medium">Quản lý Sự kiện</span>
                </a>

                <!-- HR (Dropdown) -->
                <div x-data="{ open: {{ request()->routeIs('organization.hr.*') || request()->routeIs('organization.volunteers.*') || request()->routeIs('organization.events.builder') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all group {{ request()->routeIs('organization.hr.*') || request()->routeIs('organization.volunteers.*') || request()->routeIs('organization.events.builder') ? 'bg-slate-800 text-white' : '' }}">
                        <div class="flex items-center">
                             <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="font-medium">Nhân sự</span>
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <!-- Sub-menu -->
                    <div x-show="open" class="mt-1 space-y-1 pl-11 pr-2" style="display: none;">
                        <a href="{{ route('organization.hr.forms') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization.hr.forms') || request()->routeIs('organization.events.builder') ? 'text-white bg-primary' : 'text-slate-400 hover:text-white hover:bg-slate-700' }}">
                            Đơn đăng ký
                        </a>
                        <a href="{{ route('organization.hr.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization.hr.*') && !request()->routeIs('organization.hr.forms') ? 'text-white bg-primary' : 'text-slate-400 hover:text-white hover:bg-slate-700' }}">
                            Quản lý Nhân sự
                        </a>
                    </div>
                </div>

                <!-- Financial (Dropdown) -->
                <div x-data="{ open: {{ request()->routeIs('organization.finance.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all group {{ request()->routeIs('organization.finance.*') ? 'bg-slate-800 text-white' : '' }}">
                        <div class="flex items-center">
                             <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Tài chính</span>
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <!-- Sub-menu -->
                    <div x-show="open" class="mt-1 space-y-1 pl-11 pr-2" style="display: none;">
                        <a href="{{ route('organization.finance.plan') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization.finance.plan') ? 'text-white bg-primary' : 'text-slate-400 hover:text-white hover:bg-slate-700' }}">
                            Lập Dự Trù
                        </a>
                        <a href="{{ route('organization.finance.tracker') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization.finance.tracker') ? 'text-white bg-primary' : 'text-slate-400 hover:text-white hover:bg-slate-700' }}">
                            Theo dõi Chi tiêu
                        </a>
                        <a href="{{ route('organization.finance.settlement') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('organization.finance.settlement') ? 'text-white bg-primary' : 'text-slate-400 hover:text-white hover:bg-slate-700' }}">
                            Quyết toán
                        </a>
                    </div>
                </div>

                <!-- Smart Attendance -->
                <a href="{{ route('organization.attendance.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('organization.attendance.*') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all group">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-medium">Điểm danh</span>
                </a>

                <!-- Reviews -->
                <a href="{{ route('organization.reviews.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('organization.reviews.*') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all group">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                    <span class="font-medium">Đánh giá</span>
                </a>

                <!-- Community -->
                <a href="{{ route('organization.community.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('organization.community.*') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all group">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span class="font-medium">Cộng đồng</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('organization.profile') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('organization.profile') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl transition-all group">
                    <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span class="font-medium">Thông tin tài khoản</span>
                </a>
                
            </nav>

            <!-- User Footer -->
            <div class="p-4 border-t border-slate-800 bg-slate-900">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-white font-bold border border-slate-600">
                        {{ substr(Auth::user()->name ?? 'O', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white truncate w-32">{{ Auth::user()->name ?? 'Organizer' }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-slate-400 hover:text-white hover:underline">Đăng xuất</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">
            
            <!-- Header -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
                <div class="flex items-center gap-4">
                     <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                    <h2 class="text-xl font-bold text-slate-800">@yield('header', 'Overview')</h2>
                </div>

                <div class="flex items-center space-x-4">
                     <!-- Notification -->
                    @php
                        $unreadNotifications = \App\Models\Notification::where('user_id', Auth::id())
                            ->where('is_read', false)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();
                        $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                    @endphp
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="relative p-2 text-gray-400 hover:text-primary transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if($unreadCount > 0)
                                <span class="absolute top-1 right-1 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                                </span>
                            @endif
                        </button>

                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg py-2 z-50 border border-gray-100" style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-50 flex justify-between items-center">
                                <h3 class="text-sm font-bold text-gray-800">Thông báo</h3>
                                @if($unreadCount > 0)
                                    <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold">{{ $unreadCount }} mới</span>
                                @endif
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                @forelse($unreadNotifications as $notification)
                                    <a href="{{ $notification->link ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 transition-colors {{ $notification->type == 'danger' ? 'bg-red-50/50' : '' }}">
                                        <p class="text-sm font-bold {{ $notification->type == 'danger' ? 'text-red-600' : 'text-gray-800' }}">{{ $notification->title }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $notification->message }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-gray-500 text-sm">
                                        Không có thông báo mới
                                    </div>
                                @endforelse
                            </div>
                            <div class="px-4 py-2 text-center border-t border-gray-50">
                                <a href="#" class="text-xs text-primary font-bold hover:underline">Xem tất cả</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
    <!-- Support Chat Widget -->
    <div x-data="{ 
            chatOpen: false, 
            newMessage: '', 
            isTyping: false,
            messages: [
                { sender: 'bot', text: 'Chào Ban tổ chức! Trợ lý VWA có thể giúp gì cho bạn?' }
            ],
            sendMessage() {
                if(this.newMessage.trim() === '') return;
                
                this.messages.push({ sender: 'user', text: this.newMessage });
                const msgToSend = this.newMessage;
                this.newMessage = '';
                this.isTyping = true;
                
                this.$nextTick(() => { this.$refs.chatBody.scrollTop = this.$refs.chatBody.scrollHeight; });

                fetch('{{ route('chatbot.respond') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ message: msgToSend })
                })
                .then(res => res.json())
                .then(data => {
                    this.isTyping = false;
                    this.messages.push({ sender: 'bot', text: data.reply });
                    this.$nextTick(() => { this.$refs.chatBody.scrollTop = this.$refs.chatBody.scrollHeight; });
                })
                .catch(err => {
                    this.isTyping = false;
                    this.messages.push({ sender: 'bot', text: 'Xin lỗi, hệ thống đang bận.' });
                });
            }
        }" class="fixed bottom-6 right-6 z-50">
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
                        <span class="w-2 h-2 bg-green-400 rounded-full absolute bottom-0 right-0 border border-primary"></span>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">A</div>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm">Hỗ trợ trực tuyến</h4>
                        <p class="text-xs text-blue-100">Luôn sẵn sàng 24/7</p>
                    </div>
                </div>
                <button @click="chatOpen = false" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- Body -->
            <div x-ref="chatBody" class="p-4 h-64 overflow-y-auto bg-slate-50 space-y-3 custom-scrollbar">
                <template x-for="(msg, index) in messages" :key="index">
                    <div :class="msg.sender === 'user' ? 'flex gap-2 flex-row-reverse' : 'flex gap-2'">
                        <div x-show="msg.sender === 'bot'" class="w-6 h-6 rounded-full bg-primary/20 flex-shrink-0 flex items-center justify-center text-xs font-bold text-primary">BOT</div>
                        <div :class="msg.sender === 'user' ? 'bg-primary text-white p-3 rounded-2xl rounded-tr-none shadow-sm text-sm' : 'bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-slate-600 border border-slate-100'" x-text="msg.text"></div>
                    </div>
                </template>
                
                <div x-show="isTyping" class="flex gap-2" x-cloak>
                    <div class="w-6 h-6 rounded-full bg-primary/20 flex-shrink-0 flex items-center justify-center text-xs font-bold text-primary">BOT</div>
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 flex gap-1 items-center">
                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></span>
                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="p-3 bg-white border-t border-slate-100 flex gap-2">
                <input @keydown.enter="sendMessage()" x-model="newMessage" type="text" placeholder="Nhập tin nhắn..." class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-primary">
                <button @click="sendMessage()" class="p-2 bg-primary text-white rounded-xl hover:bg-primary-dark transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                </button>
            </div>
        </div>

        <!-- Float Button -->
        <button @click="chatOpen = !chatOpen" 
                class="group relative flex items-center justify-center w-14 h-14 bg-gradient-to-r from-primary to-blue-600 rounded-full text-white shadow-lg hover:shadow-2xl hover:scale-110 transition-all duration-300 z-50">
            <!-- Ping Effect -->
            <span class="absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75 animate-ping group-hover:hidden"></span>
            
            <!-- Icons -->
            <svg x-show="!chatOpen" class="w-6 h-6 transform transition-transform duration-300 rotate-0 group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
            <svg x-show="chatOpen" class="w-6 h-6 transform transition-transform duration-300 rotate-90" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <!-- SweetAlert Session Handlers -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{!! session('success') !!}",
            confirmButtonColor: '#0F4C81'
        });
    </script>
    @endif
    
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: "{!! session('error') !!}",
            confirmButtonColor: '#0F4C81'
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
