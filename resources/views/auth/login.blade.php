@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">
        
        <!-- Left Side: Banner / Image -->
        <div class="hidden md:flex md:w-1/2 bg-primary relative overflow-hidden flex-col justify-between p-10 text-white">
            <!-- Dynamic Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary-dark via-primary to-primary-light z-10"></div>
            
            <!-- Abstract Shapes (Animated) -->
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-accent opacity-20 blur-[80px] animate-pulse z-20"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-white opacity-10 blur-[80px] animate-pulse z-20" style="animation-delay: 2s;"></div>
            
            <!-- Branding Header (VWA - Connect) -->
            <div class="relative z-30 flex items-center gap-4">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-xl p-1.5 flex-shrink-0">
                    <!-- Academic Logo -->
                    <img src="{{ asset('images/logo-hv.png') }}" alt="VWA Logo" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col">
                    <span class="text-3xl font-black tracking-wider text-white drop-shadow-md">VWA <span class="text-accent-light">-</span> Connect</span>
                    <span class="text-xs text-blue-200 font-medium tracking-widest uppercase mt-0.5">Học viện Phụ nữ Việt Nam</span>
                </div>
            </div>

            <!-- Content -->
            <div class="relative z-30 mt-auto mb-8">
                <h2 class="text-4xl font-extrabold leading-tight mb-4 text-white drop-shadow-lg">
                    Kết nối, sẻ chia <br/> 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-light to-yellow-300">và trưởng thành.</span>
                </h2>
                <p class="text-blue-100 text-lg mb-8 max-w-sm font-medium leading-relaxed drop-shadow">
                    Cùng cộng đồng VWA thiết lập những giá trị tích cực và ý nghĩa cho xã hội hôm nay.
                </p>
                

            </div>
            
            <!-- Carousel Indicators (Visual aesthetic only) -->
            <div class="relative z-30 flex gap-2 w-full">
                <div class="w-8 h-1.5 rounded-full bg-accent"></div>
                <div class="w-2 h-1.5 rounded-full bg-white/30"></div>
                <div class="w-2 h-1.5 rounded-full bg-white/30"></div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="md:w-1/2 p-8 md:p-12 bg-white">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Đăng Nhập</h1>
                <p class="text-gray-500 text-sm mt-2">Vui lòng nhập thông tin để truy cập hệ thống</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out text-gray-700" 
                           type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="student@university.edu.vn" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                        <a href="#" class="text-xs text-primary hover:text-primary-dark hover:underline">Quên mật khẩu?</a>
                    </div>
                    <input id="password" class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out text-gray-700"
                           type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>

                <div class="block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary shadow-sm h-4 w-4" name="remember">
                        <span class="ml-2 text-sm text-gray-600">Ghi nhớ đăng nhập</span>
                    </label>
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    ĐĂNG NHẬP
                </button>
            </form>

            <!-- Social Login Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Hoặc đăng nhập với</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <a href="{{ route('login.google') }}" class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84z"/>
                            <path fill="#EA4335" d="M12 4.61c1.61 0 3.09.56 4.23 1.64l3.18-3.18C17.45 1.19 14.97 0 12 0 7.7 0 3.99 2.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Google
                    </a>

                    <a href="{{ route('login.facebook') }}" class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm bg-[#1877F2] text-sm font-medium text-white hover:bg-[#166fe5] transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>
                </div>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Chưa có tài khoản? 
                    <a href="{{ route('register') }}" class="font-semibold text-accent hover:text-orange-600 hover:underline">
                        Đăng ký ngay
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
