@extends('layouts.app')

@section('title', 'Cara Berlelang - LelangPro')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Cara Berlelang</h1>
        <p class="text-xl text-gray-600">Langkah mudah untuk mendapatkan barang impian</p>
    </div>

    <!-- Steps -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
        <div class="space-y-12 relative before:absolute before:left-6 before:top-6 before:bottom-6 before:w-0.5 before:bg-gray-200">
            
            <!-- Step 1 -->
            <div class="relative pl-20 transition-all duration-300 hover:transform hover:translate-x-2">
                <div class="absolute left-0 w-12 h-12 rounded-2xl gradient-primary text-white flex items-center justify-center font-bold text-xl z-10 shadow-lg">1</div>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-bold text-xl text-gray-900 mb-3 flex items-center gap-3">
                        <i class="fas fa-user-plus text-blue-500"></i> Daftar Akun
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Buat akun LelangPro secara gratis. Pastikan data diri Anda lengkap dan valid, terutama:
                    </p>
                    <ul class="list-disc list-inside text-gray-500 space-y-1 ml-4">
                        <li>Nomor Handphone (untuk notifikasi WhatsApp)</li>
                        <li>Alamat Email yang aktif</li>
                        <li>Alamat pengiriman yang jelas</li>
                    </ul>
                </div>
            </div>
            
            <!-- Step 2 -->
            <div class="relative pl-20 transition-all duration-300 hover:transform hover:translate-x-2">
                <div class="absolute left-0 w-12 h-12 rounded-2xl gradient-secondary text-white flex items-center justify-center font-bold text-xl z-10 shadow-lg">2</div>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-bold text-xl text-gray-900 mb-3 flex items-center gap-3">
                        <i class="fas fa-search text-purple-500"></i> Cari & Pilih Barang
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Jelajahi ribuan barang unik di katalog kami. Gunakan fitur pencarian dan filter kategori untuk menemukan barang yang Anda inginkan.
                        Perhatikan detail barang seperti:
                    </p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="bg-white px-3 py-1 rounded-full text-xs text-gray-600 border border-gray-200">Kondisi Barang</span>
                        <span class="bg-white px-3 py-1 rounded-full text-xs text-gray-600 border border-gray-200">Kelengkapan</span>
                        <span class="bg-white px-3 py-1 rounded-full text-xs text-gray-600 border border-gray-200">Lokasi Penjual</span>
                    </div>
                </div>
            </div>
            
            <!-- Step 3 -->
            <div class="relative pl-20 transition-all duration-300 hover:transform hover:translate-x-2">
                <div class="absolute left-0 w-12 h-12 rounded-2xl gradient-accent text-white flex items-center justify-center font-bold text-xl z-10 shadow-lg">3</div>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-bold text-xl text-gray-900 mb-3 flex items-center gap-3">
                        <i class="fas fa-gavel text-indigo-500"></i> Ajukan Penawaran (Bid)
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Masukkan nominal penawaran Anda. Ingat, setiap bid bersifat mengikat!
                    </p>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex gap-3 text-sm text-yellow-800">
                        <i class="fas fa-lightbulb mt-1"></i>
                        <div>
                            <strong>Tips Pro:</strong> Pantau lelang di menit-menit terakhir untuk meningkatkan peluang menang.
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step 4 -->
            <div class="relative pl-20 transition-all duration-300 hover:transform hover:translate-x-2">
                <div class="absolute left-0 w-12 h-12 rounded-2xl bg-gradient-to-r from-green-400 to-green-600 text-white flex items-center justify-center font-bold text-xl z-10 shadow-lg">4</div>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-bold text-xl text-gray-900 mb-3 flex items-center gap-3">
                        <i class="fas fa-trophy text-green-500"></i> Menangkan & Bayar
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Jika penawaran Anda tertinggi saat waktu habis, selamat! Anda pemenangnya.
                        Hubungi penjual melalui WhatsApp yang tersedia untuk menyelesaikan pembayaran dan pengiriman.
                    </p>
                </div>
            </div>

        </div>
    </div>
    
    <div class="text-center">
        <a href="{{ route('home') }}" class="gradient-primary text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 inline-flex items-center gap-2 transform hover:scale-105">
            <i class="fas fa-search"></i>
            Mulai Cari Barang Sekarang
        </a>
    </div>
</div>
@endsection
