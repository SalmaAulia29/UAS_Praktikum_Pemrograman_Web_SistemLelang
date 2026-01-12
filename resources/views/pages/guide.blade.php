@extends('layouts.app')

@section('title', 'Panduan & Bantuan - LelangPro')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Pusat Bantuan</h1>
        <p class="text-xl text-gray-600">Panduan lengkap untuk memulai lelang di LelangPro</p>
    </div>

    <!-- Navigation to Auction Guide -->
    <div class="mb-12 text-center">
        <a href="{{ route('guide.bid') }}" class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 px-6 py-3 rounded-full font-medium hover:bg-blue-100 transition-colors">
            <i class="fas fa-gavel"></i>
            Ingin tahu cara membeli? Lihat <strong>Cara Berlelang</strong>
        </a>
    </div>

    <!-- Panduan Penjual -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8" id="panduan-penjual">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 gradient-accent rounded-xl flex items-center justify-center text-white text-2xl shadow-lg">
                <i class="fas fa-store"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Panduan Menjual</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-6 rounded-xl">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-camera text-blue-500"></i> Foto Produk
                </h3>
                <p class="text-sm text-gray-600">Gunakan foto asli, jelas, dan terang. Tampilkan detail barang dan kekurangan jika ada.</p>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-xl">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-tag text-green-500"></i> Harga Awal
                </h3>
                <p class="text-sm text-gray-600">Tentukan harga awal yang menarik. Jangan terlalu tinggi agar menarik banyak penawar.</p>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-xl">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-file-alt text-purple-500"></i> Deskripsi
                </h3>
                <p class="text-sm text-gray-600">Tulis deskripsi jujur dan lengkap. Jelaskan kondisi barang, spesifikasi, dan kelengkapannya.</p>
            </div>
            
            <div class="bg-gray-50 p-6 rounded-xl">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <i class="fas fa-handshake text-orange-500"></i> Transaksi
                </h3>
                <p class="text-sm text-gray-600">Segera respon pemenang lelang. Gunakan metode pembayaran yang aman dan disepakati.</p>
            </div>
        </div>
    </div>
    
    <div class="mt-8 text-center text-gray-500 text-sm">
        <p>Masih butuh bantuan? Hubungi <a href="mailto:support@lelangpro.com" class="text-blue-600 hover:underline">Support LelangPro</a></p>
    </div>
</div>
@endsection
