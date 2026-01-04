@extends('layouts.app')

@section('title', 'Bid Saya - LelangPro')

@section('content')
<div class="mb-10">
    <!-- Header Section -->
    <div class="gradient-primary rounded-3xl p-8 text-white mb-8 shadow-2xl overflow-hidden relative">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="brand-font text-3xl md:text-4xl font-bold mb-2">Riwayat Bid Saya</h1>
                    <p class="text-blue-100 text-lg">Pantau semua aktivitas penawaran Anda di LelangPro</p>
                </div>
                
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[200px]">
                    <div class="text-4xl font-bold mb-1">{{ $bids->count() ?? '0' }}</div>
                    <div class="text-sm text-blue-100">Total Bid Dilakukan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @php
            // Hitung statistik
            $winningBids = 0;
            $activeBids = 0;
            $completedBids = 0;
            
            foreach($bids as $bid) {
                $barang = $bid->barang;
                if($barang) {
                    $isWinning = $barang->highestBid && $barang->highestBid->id == $bid->id;
                    
                    if($barang->status === 'selesai' && $isWinning) {
                        $winningBids++;
                    } elseif($barang->status === 'aktif') {
                        $activeBids++;
                    } elseif($barang->status === 'selesai') {
                        $completedBids++;
                    }
                }
            }
        @endphp
        
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-green-100 text-green-600">
                    <i class="fas fa-crown text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $winningBids }}</div>
                    <div class="text-sm text-gray-500">Bid Menang</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Bid yang sedang memimpin lelang</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-blue-100 text-blue-600">
                    <i class="fas fa-history text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $activeBids }}</div>
                    <div class="text-sm text-gray-500">Sedang Berjalan</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Lelang yang masih aktif</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-purple-100 text-purple-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $completedBids }}</div>
                    <div class="text-sm text-gray-500">Selesai</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Lelang yang telah berakhir</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Daftar Bid</h2>
                <p class="text-gray-500 text-sm">Cari berdasarkan nama barang</p>
            </div>
            
            <form action="{{ route('bid.mybids') }}" method="GET" class="w-full md:w-72">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ $search ?? '' }}" 
                           placeholder="Cari nama barang..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none shadow-sm">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </form>
        </div>
    </div>

    @if($bids->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-3xl border-2 border-dashed border-gray-200 p-16 text-center shadow-sm">
        <div class="w-24 h-24 gradient-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-gavel text-4xl gradient-primary bg-clip-text text-transparent"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Aktivitas Bid</h3>
        <p class="text-gray-500 text-lg max-w-md mx-auto mb-8">
            Anda belum pernah melakukan bid di platform LelangPro. 
            Mulailah menawar barang lelang favorit Anda!
        </p>
        
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('home') }}" 
               class="gradient-primary text-white px-8 py-3 rounded-xl font-semibold inline-flex items-center gap-2 hover:shadow-lg transition-all duration-300 hover:scale-105">
                <i class="fas fa-search"></i>
                Jelajahi Barang Lelang
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
            <a href="#" 
               class="border-2 border-gray-300 text-gray-700 px-8 py-3 rounded-xl font-semibold inline-flex items-center gap-2 hover:border-gray-400 hover:text-gray-900 transition-all duration-300">
                <i class="fas fa-graduation-cap"></i>
                Panduan Berlelang
            </a>
        </div>
    </div>

    @else
    <!-- Bid List -->
    <div class="space-y-6">
        @php
            // Group by barang_id untuk menghindari duplikat
            $groupedBids = $bids->groupBy('barang_id');
        @endphp
        
        @foreach($groupedBids as $barangId => $barangBids)
            @php 
                $barang = $barangBids->first()->barang;
                if(!$barang) continue; // Skip jika barang tidak ditemukan
                
                $myHighestBid = $barangBids->sortByDesc('harga_bid')->first();
                $overallHighestBid = $barang->highestBid;
                $isWinning = $overallHighestBid && $myHighestBid->harga_bid == $overallHighestBid->harga_bid;
            @endphp
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300
                        {{ $isWinning && $barang->status === 'aktif' ? 'border-l-4 border-green-500' : '' }}
                        {{ $barang->status === 'selesai' && $isWinning ? 'border-l-4 border-yellow-500' : '' }}
                        {{ $barang->status === 'selesai' && !$isWinning ? 'border-l-4 border-gray-300' : '' }}">
                
                <!-- Card Header -->
                <div class="{{ $barang->status === 'aktif' ? 'gradient-primary' : 'bg-gray-800' }} p-5 text-white">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                                    <i class="fas fa-gavel"></i>
                                </div>
                                <h3 class="text-xl font-bold line-clamp-1">{{ $barang->nama_barang }}</h3>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-sm text-blue-100">
                                    <i class="fas fa-tag mr-1"></i>{{ ucfirst($barang->kategori ?? 'Umum') }}
                                </span>
                                <span class="text-sm text-blue-100">
                                    <i class="fas fa-user mr-1"></i>{{ $barang->user->name }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="flex items-center gap-2">
                            @if($isWinning && $barang->status === 'aktif')
                                <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg flex items-center gap-2">
                                    <i class="fas fa-crown"></i>
                                    PEMENANG SAAT INI
                                </span>
                            @elseif($barang->status === 'selesai' && $isWinning)
                                <span class="bg-gradient-to-r from-yellow-500 to-amber-600 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg flex items-center gap-2">
                                    <i class="fas fa-trophy"></i>
                                    MENANG
                                </span>
                            @elseif($barang->status === 'selesai' && !$isWinning)
                                <span class="bg-gradient-to-r from-gray-500 to-gray-600 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg flex items-center gap-2">
                                    <i class="fas fa-times-circle"></i>
                                    KALAH
                                </span>
                            @else
                                <span class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg">
                                    {{ strtoupper($barang->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column - Item Info -->
                        <div class="lg:col-span-1">
                            <div class="relative h-64 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl overflow-hidden">
                                <img src="{{ $barang->foto_url }}" 
                                     alt="{{ $barang->nama_barang }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                                     loading="lazy">
                                
                                @if($barang->status === 'aktif')
                                    <div class="absolute top-4 left-4">
                                        <div class="bg-black/70 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                            LIVE
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Quick Stats -->
                            <div class="mt-4 grid grid-cols-3 gap-3">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="text-2xl font-bold text-blue-600">{{ $barangBids->count() }}</div>
                                    <div class="text-xs text-gray-500">Total Bid</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="text-2xl font-bold text-green-600">
                                        @if($overallHighestBid)
                                            {{ $overallHighestBid->harga_bid == $myHighestBid->harga_bid ? '1' : '0' }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">Posisi</div>
                                </div>
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <div class="text-sm font-bold text-gray-700">
                                        @if($barang->status === 'aktif')
                                            <div class="countdown text-xs" data-end="{{ $barang->waktu_selesai->toIso8601String() }}">
                                                ...
                                            </div>
                                        @else
                                            {{ $barang->waktu_selesai->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Selesai
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Middle Column - Bid Info -->
                        <div class="lg:col-span-2">
                            <!-- Status Message -->
                            @if($isWinning && $barang->status === 'aktif')
                                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                                            <i class="fas fa-crown text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-green-800 mb-1">Anda Memimpin Lelang!</h4>
                                            <p class="text-sm text-green-700">
                                                Selamat! Anda saat ini menjadi penawar tertinggi. 
                                                Tetap pantau lelang ini sampai waktu berakhir.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif(!$isWinning && $barang->status === 'aktif')
                                <div class="mb-6 bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                                            <i class="fas fa-exclamation-triangle text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-yellow-800 mb-1">Anda Telah Diatas!</h4>
                                            <p class="text-sm text-yellow-700 mb-2">
                                                Bid Anda telah dilewati oleh penawar lain. 
                                                Tawar lagi untuk kembali memimpin!
                                            </p>
                                            <div class="flex items-center gap-4 text-sm">
                                                <span class="text-gray-700">
                                                    <span class="font-bold">Bid Anda:</span> 
                                                    Rp {{ number_format($myHighestBid->harga_bid, 0, ',', '.') }}
                                                </span>
                                                <span class="text-gray-700">
                                                    <span class="font-bold">Bid Tertinggi:</span> 
                                                    Rp {{ number_format($overallHighestBid->harga_bid, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($barang->status === 'selesai')
                                @if($isWinning)
                                    <div class="mb-6 bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-4">
                                        <div class="flex items-start gap-3">
                                            <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                                                <i class="fas fa-trophy text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-yellow-800 mb-1">🎉 Selamat Anda Menang!</h4>
                                                <p class="text-sm text-yellow-700 mb-2">
                                                    Anda memenangkan lelang ini dengan harga final 
                                                    <span class="font-bold">Rp {{ number_format($myHighestBid->harga_bid, 0, ',', '.') }}</span>
                                                </p>
                                                <p class="text-xs text-gray-600">
                                                    Silakan hubungi penjual untuk melanjutkan transaksi
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-6 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-4">
                                        <div class="flex items-start gap-3">
                                            <div class="p-2 bg-gray-100 text-gray-600 rounded-lg">
                                                <i class="fas fa-times-circle text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-gray-800 mb-1">Lelang Telah Berakhir</h4>
                                                <p class="text-sm text-gray-700 mb-2">
                                                    Anda kalah dalam lelang ini. 
                                                    Bid Anda: <span class="font-bold">Rp {{ number_format($myHighestBid->harga_bid, 0, ',', '.') }}</span>
                                                </p>
                                                <p class="text-xs text-gray-600">
                                                    Coba lagi di lelang lainnya!
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <!-- Bid Details -->
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl">
                                    <div class="text-xs text-gray-600 mb-1">Bid Tertinggi Anda</div>
                                    <div class="text-xl font-bold text-blue-700">
                                        Rp {{ number_format($myHighestBid->harga_bid, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl">
                                    <div class="text-xs text-gray-600 mb-1">Harga Awal</div>
                                    <div class="text-xl font-bold text-green-700">
                                        Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl">
                                    <div class="text-xs text-gray-600 mb-1">Bid Terakhir</div>
                                    <div class="text-lg font-bold text-purple-700">
                                        {{ $myHighestBid->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                            <!-- Seller Info (if won) -->
                            @if($barang->status === 'selesai' && $isWinning)
                                <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4">
                                    <h4 class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                                        <i class="fas fa-user-tie"></i>
                                        Informasi Penjual
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-600 mb-1">Nama Penjual</div>
                                            <div class="font-medium text-gray-900">{{ $barang->user->name }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-600 mb-1">No. WhatsApp</div>
                                            <div class="font-medium text-gray-900">{{ $barang->user->no_hp }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-600 mb-1">Email</div>
                                            <div class="font-medium text-gray-900">{{ $barang->user->email }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-4 text-xs text-gray-500">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Hubungi penjual untuk mengatur pengiriman dan pembayaran
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('barang.show', $barang->id) }}" 
                                   class="gradient-primary text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center gap-2">
                                    <i class="fas fa-eye"></i>
                                    Lihat Detail Barang
                                </a>
                                
                                @if($barang->status === 'aktif')
                                    <a href="{{ route('barang.show', $barang->id) }}#bid-section" 
                                       class="border-2 border-blue-500 text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-300 flex items-center gap-2">
                                        <i class="fas fa-gavel"></i>
                                        Tawar Lagi
                                    </a>
                                @endif
                                
                                @if($barang->status === 'selesai' && $isWinning)
                                    <a href="https://wa.me/{{ $barang->user->no_hp }}" 
                                       target="_blank"
                                       class="border-2 border-green-500 text-green-600 px-6 py-3 rounded-xl font-semibold hover:bg-green-50 transition-all duration-300 flex items-center gap-2">
                                        <i class="fab fa-whatsapp"></i>
                                        Chat Penjual
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tips Section -->
    <div class="mt-16 bg-gradient-to-r from-gray-50 to-blue-50 rounded-3xl p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Tips Berlelang Sukses</h2>
                <p class="text-gray-600">Strategi untuk meningkatkan peluang menang lelang</p>
            </div>
            <div class="p-3 rounded-xl bg-white shadow-sm">
                <i class="fas fa-lightbulb text-3xl text-yellow-500"></i>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Tepat Waktu</h3>
                <p class="text-sm text-gray-600">Bid di akhir waktu lelang untuk mengurangi persaingan</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <div class="w-12 h-12 gradient-secondary rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Analisis Harga</h3>
                <p class="text-sm text-gray-600">Perhatikan harga pasar sebelum menentukan bid Anda</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <div class="w-12 h-12 gradient-accent rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-bell text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Aktifkan Notifikasi</h3>
                <p class="text-sm text-gray-600">Dapatkan pemberitahuan saat bid Anda dilewati</p>
            </div>
        </div>
    </div>
    
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const updateCountdowns = () => {
        document.querySelectorAll('.countdown').forEach(el => {
            const end = new Date(el.dataset.end).getTime();
            const now = Date.now();
            const diff = end - now;

            if (diff <= 0) {
                el.textContent = 'Berakhir';
                el.classList.add('text-red-500');
                return;
            }

            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);

            el.textContent =
                d > 0 ? `${d}h ${h}j` :
                h > 0 ? `${h}j ${m}m` :
                        `${m}m ${s}d`;

            if (diff < 3600000) el.classList.add('text-red-500');
        });
    };

    updateCountdowns();
    setInterval(updateCountdowns, 1000);

});
</script>
@endpush
@endsection     