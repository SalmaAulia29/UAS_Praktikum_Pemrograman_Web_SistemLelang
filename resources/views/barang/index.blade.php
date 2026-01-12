@extends('layouts.app')

@section('title', 'Beranda - LelangPro')

@section('content')
<div class="mb-10">
    <!-- Hero Section (Simple) -->
    <div class="gradient-primary rounded-3xl p-8 md:p-12 text-white mb-10 shadow-2xl overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 rounded-full translate-y-48 -translate-x-48"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto text-center">
            <h1 class="brand-font text-4xl md:text-5xl font-bold mb-6">
                Temukan Barang <span class="text-yellow-300">Lelang Premium</span>
            </h1>
            <p class="text-lg text-blue-100 mb-8 leading-relaxed max-w-2xl mx-auto">
                Jelajahi koleksi barang lelang eksklusif dari seluruh Indonesia.
                Dapatkan barang berkualitas dengan harga terbaik.
            </p>
            
            <div class="flex flex-wrap justify-center gap-6">
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[120px]">
                    <div class="text-2xl font-bold mb-1">{{ $totalBarangs ?? '0' }}</div>
                    <div class="text-xs text-blue-100 uppercase font-semibold">Barang</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[120px]">
                    <div class="text-2xl font-bold mb-1">{{ $activeBarangs ?? '0' }}</div>
                    <div class="text-xs text-blue-100 uppercase font-semibold">Live</div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[120px]">
                    <div class="text-2xl font-bold mb-1">{{ $totalUsers ?? '0' }}+</div>
                    <div class="text-xs text-blue-100 uppercase font-semibold">User</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar (Placed Before Index) -->
    <div class="bg-white rounded-2xl shadow-lg p-4 mb-10 border border-gray-100 sticky top-20 z-30">
        <form action="{{ route('home') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama barang..." 
                       class="w-full pl-12 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>

            <!-- Category -->
            <div class="w-full lg:w-48 relative">
                <i class="fas fa-filter absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <select name="kategori" class="w-full pl-10 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="elektronik" {{ request('kategori') == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                    <option value="kendaraan" {{ request('kategori') == 'kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                    <option value="properti" {{ request('kategori') == 'properti' ? 'selected' : '' }}>Properti</option>
                    <option value="koleksi" {{ request('kategori') == 'koleksi' ? 'selected' : '' }}>Koleksi</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            </div>

            <!-- Status Tabs (Visual) -->
            <div class="bg-gray-100 p-1 rounded-xl flex">
                <button type="submit" name="status" value="aktif" 
                       class="px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ $status === 'aktif' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">
                   Aktif
                </button>
                <button type="submit" name="status" value="selesai" 
                       class="px-4 py-2 rounded-lg text-sm font-semibold transition-all {{ $status === 'selesai' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">
                   Selesai
                </button>
            </div>
            
            <button type="submit" class="gradient-secondary text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all">
                Cari
            </button>
        </form>
    </div>
    
    <!-- Recent Auctions Header -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4">Barang Terbaru</h2>
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <span>{{ $barangs->total() }} barang ditemukan</span>
        </div>
    </div>

   
    @if($barangs->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-3xl border-2 border-dashed border-gray-200 p-16 text-center shadow-sm">
        <div class="w-24 h-24 gradient-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-search text-4xl gradient-primary bg-clip-text text-transparent"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">Tidak ada barang ditemukan</h3>
        <p class="text-gray-500 text-lg max-w-md mx-auto mb-8">
            Belum ada lelang dengan status <span class="font-semibold text-gray-900">"{{ ucfirst(str_replace('_', ' ', $status)) }}"</span> saat ini.
        </p>
        
        @if($status !== 'aktif')
            <a href="{{ route('home', ['status' => 'aktif']) }}" 
               class="gradient-primary text-white px-8 py-3 rounded-xl font-semibold inline-flex items-center gap-2 hover:shadow-lg transition-all duration-300 hover:scale-105">
                <i class="fas fa-bolt"></i>
                Lihat lelang yang aktif
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        @endif
        
        <div class="mt-10 pt-10 border-t border-gray-100">
            <p class="text-gray-500 mb-4">Atau coba:</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('barang.create') }}" 
                   class="gradient-accent text-white px-6 py-2.5 rounded-xl font-medium inline-flex items-center gap-2 hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-plus-circle"></i>
                    Mulai Lelang Baru
                </a>
                <a href="#" 
                   class="border-2 border-gray-300 text-gray-700 px-6 py-2.5 rounded-xl font-medium inline-flex items-center gap-2 hover:border-gray-400 hover:text-gray-900 transition-all duration-300">
                    <i class="fas fa-compass"></i>
                    Jelajahi Kategori
                </a>
            </div>
        </div>
    </div>

    @else
    <!-- Auction Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($barangs as $barang)
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col h-full border border-gray-100 card-hover">
                
                <!-- Image Section - FIXED -->
                <div class="relative h-56 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
                    
                    @php
                        // Cek path yang benar
                        $imageFound = false;
                        $imageUrl = '';
                        
                        // Coba storage/barang/
                        if ($barang->foto && file_exists(storage_path('app/public/barang/' . $barang->foto))) {
                            $imageFound = true;
                            $imageUrl = asset('storage/barang/' . $barang->foto);
                        }
                        // Coba foto_path
                        elseif ($barang->foto_path && file_exists(storage_path('app/public/' . $barang->foto_path))) {
                            $imageFound = true;
                            $imageUrl = asset('storage/' . $barang->foto_path);
                        }
                        // Coba langsung di storage
                        elseif ($barang->foto && file_exists(storage_path('app/public/' . $barang->foto))) {
                            $imageFound = true;
                            $imageUrl = asset('storage/' . $barang->foto);
                        }
                    @endphp
                    
                    @if($imageFound)
                        <img src="{{ $imageUrl }}" 
                             alt="{{ $barang->nama_barang }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                             loading="lazy">
                    @else
                        <!-- Placeholder jika gambar tidak ditemukan -->
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
                            <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-500 px-4 text-center">Gambar tidak tersedia</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $barang->foto }}</p>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 left-4 z-20">
                        @if($barang->status === 'aktif')
                            <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                LIVE NOW
                            </span>
                        @elseif($barang->status === 'selesai')
                            <span class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                SOLD
                            </span>
                        @else
                            <span class="bg-gradient-to-r from-gray-500 to-gray-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                CLOSED
                            </span>
                        @endif
                    </div>
                    
                    <!-- Favorite Button -->
                    <button class="absolute top-4 right-4 z-20 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-red-500 hover:bg-white transition-all duration-300 hover:scale-110">
                        <i class="far fa-heart text-sm"></i>
                    </button>
                    
                    <!-- Current Bid Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 z-20 p-4">
                        <div class="bg-gradient-to-r from-black/80 to-black/60 backdrop-blur-sm rounded-xl p-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-300 font-medium">Penawaran Saat Ini</p>
                                    <p class="text-lg font-bold text-white">
                                        Rp {{ number_format($barang->highestBid->harga_bid ?? $barang->harga_awal, 0, ',', '.') }}
                                    </p>
                                </div>
                                @if($barang->status === 'aktif')
                                    <div class="text-right">
                                        <p class="text-xs text-gray-300 font-medium">Berakhir dalam</p>
                                        <div class="text-sm font-bold text-white countdown" data-end="{{ $barang->waktu_selesai->toIso8601String() }}">
                                            ...
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-5 flex-1 flex flex-col">
                    <div class="mb-3">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold px-2 py-1 rounded bg-gray-100 text-gray-600">
                                {{ ucfirst($barang->kategori ?? 'Umum') }}
                            </span>
                            @if($barang->status === 'aktif')
                                <span class="text-xs text-green-600 font-medium flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    {{ $barang->bids->unique('user_id')->count() }} penawar
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-gray-900 line-clamp-1 mb-2 group-hover:text-blue-600 transition-colors text-lg">
                            {{ $barang->nama_barang }}
                        </h3>
                        
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">
                            {{ Str::limit($barang->deskripsi, 80) }}
                        </p>
                    </div>

                    <!-- Seller Info -->
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 gradient-primary rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr($barang->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Penjual</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $barang->user->name }}</p>
                                </div>
                            </div>
                            
                            <a href="{{ route('barang.show', $barang->id) }}" 
                               class="w-10 h-10 rounded-xl bg-gradient-to-r from-gray-50 to-gray-100 text-gray-600 flex items-center justify-center hover:gradient-primary hover:text-white transition-all duration-300 group/btn">
                                <i class="fas fa-arrow-right text-sm group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                        
                        <!-- View Details Button -->
                        <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ route('barang.show', $barang->id) }}" 
                               class="block w-full gradient-primary text-white py-2.5 rounded-xl text-sm font-semibold text-center hover:shadow-lg transition-all duration-300">
                                Lihat Detail & Tawar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($barangs->hasPages())
    <div class="mt-12 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-gray-500">
                Menampilkan {{ $barangs->firstItem() }} - {{ $barangs->lastItem() }} dari {{ $barangs->total() }} barang
            </div>
            <div class="flex items-center gap-2">
                @if($barangs->onFirstPage())
                    <span class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                    </span>
                @else
                    <a href="{{ $barangs->previousPageUrl() }}" 
                       class="px-4 py-2 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                    </a>
                @endif
                
                <div class="flex items-center gap-1">
                    @foreach(range(1, min(5, $barangs->lastPage())) as $page)
                        <a href="{{ $barangs->url($page) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl {{ $barangs->currentPage() === $page ? 'gradient-primary text-white' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    
                    @if($barangs->lastPage() > 5)
                        <span class="px-2 text-gray-500">...</span>
                        <a href="{{ $barangs->url($barangs->lastPage()) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100">
                            {{ $barangs->lastPage() }}
                        </a>
                    @endif
                </div>
                
                @if($barangs->hasMorePages())
                    <a href="{{ $barangs->nextPageUrl() }}" 
                       class="px-4 py-2 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 transition-colors">
                        Selanjutnya<i class="fas fa-chevron-right ml-2"></i>
                    </a>
                @else
                    <span class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed">
                        Selanjutnya<i class="fas fa-chevron-right ml-2"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endif

    @endif

    <!-- Featured Categories -->
    <div class="mt-16">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Kategori Unggulan</h2>
                <p class="text-gray-500">Temukan barang lelang berdasarkan kategori favorit</p>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2">
                Lihat semua <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('home', ['status' => 'aktif', 'kategori' => 'elektronik']) }}" 
               class="group bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 card-hover">
                <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-tv text-2xl text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Elektronik</h3>
                <p class="text-sm text-gray-500">Gadget & Peralatan</p>
                <div class="mt-4 text-xs text-blue-600 font-semibold">Lihat koleksi →</div>
            </a>
            
            <a href="{{ route('home', ['status' => 'aktif', 'kategori' => 'kendaraan']) }}" 
               class="group bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 card-hover">
                <div class="w-16 h-16 gradient-secondary rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-car text-2xl text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Kendaraan</h3>
                <p class="text-sm text-gray-500">Mobil & Motor</p>
                <div class="mt-4 text-xs text-green-600 font-semibold">Lihat koleksi →</div>
            </a>
            
            <a href="{{ route('home', ['status' => 'aktif', 'kategori' => 'properti']) }}" 
               class="group bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 card-hover">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-home text-2xl text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Properti</h3>
                <p class="text-sm text-gray-500">Rumah & Tanah</p>
                <div class="mt-4 text-xs text-purple-600 font-semibold">Lihat koleksi →</div>
            </a>
            
            <a href="{{ route('home', ['status' => 'aktif', 'kategori' => 'koleksi']) }}" 
               class="group bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-6 text-center hover:shadow-xl transition-all duration-300 card-hover">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-gem text-2xl text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-1">Koleksi</h3>
                <p class="text-sm text-gray-500">Barang Langka & Antik</p>
                <div class="mt-4 text-xs text-orange-600 font-semibold">Lihat koleksi →</div>
            </a>
        </div>
    </div>

    <!-- How It Works -->
    <div class="mt-16 bg-gradient-to-r from-gray-900 to-gray-800 rounded-3xl p-12 text-white overflow-hidden relative">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-48 translate-x-48"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="brand-font text-3xl font-bold mb-4">Cara Berlelang di LelangPro</h2>
                <p class="text-gray-300 text-lg">Ikuti 4 langkah mudah untuk mulai berlelang</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold">1</div>
                    <h3 class="font-bold text-xl mb-3">Daftar Akun</h3>
                    <p class="text-gray-300">Registrasi cepat dan verifikasi email Anda</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 gradient-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold">2</div>
                    <h3 class="font-bold text-xl mb-3">Jelajahi Barang</h3>
                    <p class="text-gray-300">Cari barang lelang sesuai keinginan Anda</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 gradient-accent rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold">3</div>
                    <h3 class="font-bold text-xl mb-3">Ajukan Penawaran</h3>
                    <p class="text-gray-300">Tawar harga yang kompetitif untuk barang pilihan</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold">4</div>
                    <h3 class="font-bold text-xl mb-3">Menang & Transaksi</h3>
                    <p class="text-gray-300">Selesaikan transaksi jika Anda memenangkan lelang</p>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('register') }}" 
                   class="gradient-primary text-white px-8 py-3 rounded-xl font-semibold inline-flex items-center gap-2 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang Gratis
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Countdown lelang
  const updateCountdowns = () => {
    document.querySelectorAll('.countdown').forEach(el => {
      const end = new Date(el.dataset.end).getTime();
      const diff = end - Date.now();

      if (diff <= 0) {
        el.textContent = 'Berakhir';
        el.classList.add('text-red-400');
        return;
      }

      const d = Math.floor(diff / 86400000);
      const h = Math.floor((diff % 86400000) / 3600000);
      const m = Math.floor((diff % 3600000) / 60000);

      el.textContent =
        d > 0 ? `${d} hari ${h} jam` :
        h > 0 ? `${h} jam ${m} menit` :
                `${m} menit`;

      if (diff < 3600000) el.classList.add('text-yellow-300');
    });
  };

  updateCountdowns();
  setInterval(updateCountdowns, 30000); // cukup 30 detik

});
</script>
@endpush
@endsection