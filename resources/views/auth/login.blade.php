@extends('layouts.app')

@section('title', 'Login - LelangPro')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="w-full max-w-lg">
        <!-- Logo & Brand -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 group mb-6">
                <div class="gradient-primary text-white p-3 rounded-xl shadow-lg transition-transform duration-300 group-hover:scale-110">
                    <i class="fas fa-gavel text-xl"></i>
                </div>
                <div class="text-left">
                    <span class="brand-font text-3xl font-bold text-gray-900">LELANG</span>
                    <span class="brand-font text-3xl font-bold gradient-primary bg-clip-text text-transparent">PRO</span>
                </div>
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h1>
            <p class="text-gray-500">Masuk ke akun Anda untuk melanjutkan ke platform lelang premium</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            <!-- Card Header -->
            <div class="gradient-primary p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">Masuk ke Akun</h2>
                        <p class="text-blue-100 text-sm mt-1">Akses penuh ke semua fitur LelangPro</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                        <i class="fas fa-lock text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Login Form -->
            <div class="p-8">
                @if(session('error'))
                    <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <div>
                                <p class="font-medium">Login Gagal</p>
                                <p>{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <div>
                                <p class="font-medium">Sukses!</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="nama@email.com"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 
                                          @error('email') border-red-500 focus:ring-red-500 @enderror"
                                   required
                                   autocomplete="email"
                                   autofocus>
                            @error('email')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                            @enderror
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-lock text-gray-400 mr-2 text-sm"></i>
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   name="password" 
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                          @error('password') border-red-500 focus:ring-red-500 @enderror"
                                   required
                                   autocomplete="current-password">
                            <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                    id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="absolute inset-y-0 right-0 pr-12 flex items-center pointer-events-none">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                            @enderror
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-8">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="loginButton"
                            class="w-full gradient-primary text-white py-3.5 rounded-xl font-semibold hover:shadow-xl transition-all duration-300 hover:scale-[1.02] flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        <span>Masuk ke Akun</span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Atau lanjutkan dengan</span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-3 mb-8">
                    <a href="#" 
                       class="flex items-center justify-center gap-2 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        <i class="fab fa-google text-red-500"></i>
                        <span class="text-sm font-medium">Google</span>
                    </a>
                    <a href="#" 
                       class="flex items-center justify-center gap-2 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        <i class="fab fa-facebook text-blue-600"></i>
                        <span class="text-sm font-medium">Facebook</span>
                    </a>
                </div>

                <!-- Register Link -->
                <div class="text-center pt-6 border-t border-gray-100">
                    <p class="text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" 
                           class="gradient-primary bg-clip-text text-transparent font-semibold hover:underline inline-flex items-center">
                            Daftar Sekarang Gratis
                            <i class="fas fa-arrow-right ml-1 text-sm"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
            <div class="p-4 bg-blue-50 rounded-xl">
                <i class="fas fa-shield-alt text-blue-600 text-lg mb-2"></i>
                <p class="text-xs font-medium text-gray-700">Aman & Terpercaya</p>
            </div>
            <div class="p-4 bg-green-50 rounded-xl">
                <i class="fas fa-bolt text-green-600 text-lg mb-2"></i>
                <p class="text-xs font-medium text-gray-700">Cepat & Mudah</p>
            </div>
            <div class="p-4 bg-purple-50 rounded-xl">
                <i class="fas fa-headset text-purple-600 text-lg mb-2"></i>
                <p class="text-xs font-medium text-gray-700">24/7 Support</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Toggle password visibility
  const toggle = document.getElementById('togglePassword');
  const password = document.querySelector('input[name="password"]');

  if (toggle && password) {
    toggle.addEventListener('click', () => {
      const isPassword = password.type === 'password';
      password.type = isPassword ? 'text' : 'password';
      toggle.querySelector('i').className =
        isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
  }

});
</script>
@endpush
@endsection