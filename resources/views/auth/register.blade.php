@extends('layouts.app')

@section('title', 'Daftar - LelangPro')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-2xl">
        <!-- Hero Section -->
        <div class="text-center mb-10">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 group mb-6">
                <div class="gradient-primary text-white p-3 rounded-xl shadow-lg transition-transform duration-300 group-hover:scale-110">
                    <i class="fas fa-gavel text-xl"></i>
                </div>
                <div class="text-left">
                    <span class="brand-font text-3xl font-bold text-gray-900">LELANG</span>
                    <span class="brand-font text-3xl font-bold gradient-primary bg-clip-text text-transparent">PRO</span>
                </div>
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Bergabung dengan Komunitas Lelang Premium</h1>
            <p class="text-gray-500 max-w-xl mx-auto">
                Daftar sekarang dan dapatkan akses ke ribuan barang lelang eksklusif dari seluruh Indonesia
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Benefits Sidebar -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6">
                    <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-gem text-white text-lg"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Akses Eksklusif</h3>
                    <p class="text-sm text-gray-600">Dapatkan akses ke barang lelang premium yang tidak tersedia untuk umum</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6">
                    <div class="w-12 h-12 gradient-secondary rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-bolt text-white text-lg"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Bidding Real-time</h3>
                    <p class="text-sm text-gray-600">Tawar barang secara real-time dengan notifikasi langsung</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-white text-lg"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Keamanan Terjamin</h3>
                    <p class="text-sm text-gray-600">Transaksi aman dengan sistem escrow dan verifikasi penjual</p>
                </div>

                <!-- Stats -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                    <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                        Statistik Komunitas
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Anggota Aktif</span>
                            <span class="font-bold text-gray-900">10,000+</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Barang Terjual</span>
                            <span class="font-bold text-gray-900">50,000+</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Rating Pengguna</span>
                            <span class="font-bold text-gray-900">4.8/5.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                    <!-- Form Header -->
                    <div class="gradient-primary p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold">Buat Akun Baru</h2>
                                <p class="text-blue-100 text-sm mt-1">Isi data diri Anda untuk memulai</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <div class="p-8">
                        @if($errors->any())
                            <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium">Terdapat kesalahan</p>
                                        <ul class="list-disc list-inside text-sm mt-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium">Pendaftaran Berhasil!</p>
                                        <p>{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <!-- Two Column Grid for Name and Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Name Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-user text-gray-400 mr-2 text-sm"></i>
                                        Nama Lengkap
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-id-card text-gray-400"></i>
                                        </div>
                                        <input type="text" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               placeholder="Nama lengkap Anda"
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                      @error('name') border-red-500 focus:ring-red-500 @enderror"
                                               required
                                               autocomplete="name"
                                               autofocus>
                                        @error('name')
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class="fas fa-exclamation-circle text-red-500"></i>
                                            </div>
                                        @enderror
                                    </div>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-envelope text-gray-400 mr-2 text-sm"></i>
                                        Alamat Email
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-at text-gray-400"></i>
                                        </div>
                                        <input type="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               placeholder="nama@email.com"
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                      @error('email') border-red-500 focus:ring-red-500 @enderror"
                                               required
                                               autocomplete="email">
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
                            </div>

                            <!-- Phone Number Field -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-2 text-sm"></i>
                                    Nomor Telepon / WhatsApp
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-400">+62</span>
                                    </div>
                                    <input type="text" 
                                           name="no_hp" 
                                           value="{{ old('no_hp') }}" 
                                           placeholder="812 3456 7890"
                                           class="w-full pl-16 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                  @error('no_hp') border-red-500 focus:ring-red-500 @enderror"
                                           required
                                           autocomplete="tel">
                                    @error('no_hp')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: 08xx xxxx xxxx (tanpa spasi atau tanda khusus)</p>
                                @error('no_hp')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Two Column Grid for Passwords -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Password Field -->
                                <div>
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
                                               placeholder="Minimal 8 karakter"
                                               class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                      @error('password') border-red-500 focus:ring-red-500 @enderror"
                                               required
                                               autocomplete="new-password">
                                        <button type="button" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 toggle-password">
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

                                <!-- Confirm Password Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-lock text-gray-400 mr-2 text-sm"></i>
                                        Konfirmasi Kata Sandi
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-key text-gray-400"></i>
                                        </div>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               placeholder="Ulangi kata sandi"
                                               class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                               required
                                               autocomplete="new-password">
                                        <button type="button" 
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Requirements -->
                            <div class="mb-6 bg-gray-50 rounded-xl p-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Persyaratan Kata Sandi:</p>
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                        Minimal 8 karakter
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                        Mengandung huruf besar & kecil
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-xs"></i>
                                        Mengandung angka
                                    </li>
                                </ul>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-8">
                                <label class="flex items-start">
                                    <input type="checkbox" 
                                           name="terms" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1"
                                           required>
                                    <span class="ml-2 text-sm text-gray-600">
                                        Saya setuju dengan 
                                        <a href="#" class="text-blue-600 hover:underline font-medium">Syarat & Ketentuan</a> 
                                        dan 
                                        <a href="#" class="text-blue-600 hover:underline font-medium">Kebijakan Privasi</a> 
                                        LelangPro
                                    </span>
                                </label>
                                @error('terms')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    id="registerButton"
                                    class="w-full gradient-primary text-white py-3.5 rounded-xl font-semibold hover:shadow-xl transition-all duration-300 hover:scale-[1.02] flex items-center justify-center mb-6">
                                <i class="fas fa-user-plus mr-2"></i>
                                <span>Buat Akun Sekarang</span>
                            </button>

                            <!-- Login Link -->
                            <div class="text-center pt-6 border-t border-gray-100">
                                <p class="text-gray-600">
                                    Sudah punya akun? 
                                    <a href="{{ route('login') }}" 
                                       class="gradient-primary bg-clip-text text-transparent font-semibold hover:underline inline-flex items-center">
                                        Masuk ke akun Anda
                                        <i class="fas fa-arrow-right ml-1 text-sm"></i>
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-12 text-center">
            <p class="text-sm text-gray-500 mb-4">Dipercaya oleh ribuan pengguna di seluruh Indonesia</p>
            <div class="flex flex-wrap justify-center gap-8">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shield-alt text-green-500 text-xl"></i>
                    <span class="text-sm font-medium">SSL Secure</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-award text-yellow-500 text-xl"></i>
                    <span class="text-sm font-medium">Verified Platform</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-badge-check text-blue-500 text-xl"></i>
                    <span class="text-sm font-medium">Trusted Sellers</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Toggle password visibility
  document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.parentElement.querySelector('input');
      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
      btn.querySelector('i').className =
        isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
  });

  // Simple password confirmation check
  const form = document.getElementById('registerForm');
  form?.addEventListener('submit', e => {
    const pass = form.querySelector('[name=password]').value;
    const confirm = form.querySelector('[name=password_confirmation]').value;

    if (pass !== confirm) {
      e.preventDefault();
      alert('Kata sandi dan konfirmasi harus sama.');
    }
  });

});
</script>
@endpush
@endsection