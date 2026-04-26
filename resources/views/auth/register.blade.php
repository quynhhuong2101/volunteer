@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden">
        
        <div class="bg-gradient-to-r from-primary to-[#165a96] p-6 text-center">
            <h2 class="text-2xl font-bold text-white">Đăng Ký Tài Khoản</h2>
            <p class="text-blue-100 text-sm mt-1">Dành cho Sinh viên & Tình nguyện viên</p>
        </div>

        <div class="p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ và Tên</label>
                    <input id="name" class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 text-gray-700" 
                           type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nguyễn Văn A" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Trường (Ưu tiên)</label>
                    <input id="email" class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 text-gray-700" 
                           type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="sv.nguyenvana@university.edu.vn" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                    <input id="password" class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 text-gray-700" 
                           type="password" name="password" required autocomplete="new-password" placeholder="Tối thiểu 8 ký tự" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận Mật khẩu</label>
                    <input id="password_confirmation" class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 text-gray-700" 
                           type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Nhập lại mật khẩu" />
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" required>
                    </div>
                    <div class="ml-2 text-sm">
                        <label for="terms" class="font-medium text-gray-700">Tôi đồng ý với <a href="#" class="text-primary hover:underline">Điều khoản sử dụng</a></label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-accent hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition duration-150 transform hover:-translate-y-0.5">
                        ĐĂNG KÝ NGAY
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Đã có tài khoản? 
                        <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary-dark hover:underline">
                            Đăng nhập
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
