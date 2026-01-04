@extends('layouts.app')

@section('title', 'Barang Saya - LelangPro')

@section('content')
<div class="mb-10">
    <!-- Hero Header -->
    <div class="gradient-primary rounded-3xl p-8 text-white mb-8 shadow-2xl overflow-hidden relative">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="brand-font text-3xl md:text-4xl font-bold mb-2">Kelola Barang Saya</h1>
                    <p class="text-blue-100 text-lg">Pantau dan kelola semua barang yang Anda lelang</p>
                </div>
                
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[200px]">
                    <div class="text-4xl font-bold mb-1">{{ $totalBarangs ?? '0' }}</div>
                    <div class="text-sm text-blue-100">Total Barang Dilelang</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-green-100 text-green-600">
                    <i class="fas fa-bolt text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $activeBarangs ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Sedang Aktif</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Barang dalam proses pelelangan</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-blue-100 text-blue-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $completedBarangs ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Selesai</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Lelang yang telah berakhir</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-yellow-100 text-yellow-600">
                    <i class="fas fa-trophy text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $soldBarangs ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Terjual</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Barang berhasil dilelang</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-purple-100 text-purple-600">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-500">Total Pendapatan</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Dari lelang yang berhasil</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Filter Status</h2>
                <p class="text-gray-500 text-sm">Lihat barang berdasarkan status lelang</p>
            </div>
            
            <div class="flex flex-col md:flex-row items-center gap-4 w-full md:w-auto">
                <!-- Search Form -->
                <form action="{{ route('barang.myitems') }}" method="GET" class="w-full md:w-64">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ $search ?? '' }}" 
                               placeholder="Cari barang..." 
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>

                <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-1.5 rounded-2xl shadow-inner flex items-center overflow-x-auto max-w-full">
                    <a href="{{ route('barang.myitems', ['search' => request('search')]) }}" 
                       class="px-4 md:px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 flex items-center gap-2 whitespace-nowrap
                              {{ !request('status') ? 'gradient-primary text-white shadow-lg' : 'text-gray-600 hover:bg-white hover:text-gray-900 hover:shadow' }}">
                       <i class="fas fa-list"></i>
                       Semua
                    </a>
                    <a href="{{ route('barang.myitems', array_merge(['status' => 'aktif'], request()->except('status', 'page'))) }}" 
                       class="px-4 md:px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 flex items-center gap-2 whitespace-nowrap
                              {{ request('status') == 'aktif' ? 'gradient-primary text-white shadow-lg' : 'text-gray-600 hover:bg-white hover:text-gray-900 hover:shadow' }}">
                       <i class="fas fa-bolt"></i>
                       Aktif
                    </a>
                    <a href="{{ route('barang.myitems', array_merge(['status' => 'selesai'], request()->except('status', 'page'))) }}" 
                       class="px-4 md:px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 flex items-center gap-2 whitespace-nowrap
                              {{ request('status') == 'selesai' ? 'gradient-primary text-white shadow-lg' : 'text-gray-600 hover:bg-white hover:text-gray-900 hover:shadow' }}">
                       <i class="fas fa-check-circle"></i>
                       Selesai
                    </a>
                    <a href="{{ route('barang.myitems', array_merge(['status' => 'tidak_laku'], request()->except('status', 'page'))) }}" 
                       class="px-4 md:px-6 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 flex items-center gap-2 whitespace-nowrap
                              {{ request('status') == 'tidak_laku' ? 'gradient-primary text-white shadow-lg' : 'text-gray-600 hover:bg-white hover:text-gray-900 hover:shadow' }}">
                       <i class="fas fa-times-circle"></i>
                       Tidak Laku
                    </a>
                </div>
                
                <a href="{{ route('barang.create') }}" 
                   class="gradient-primary text-white px-6 py-2.5 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center gap-2 whitespace-nowrap">
                    <i class="fas fa-plus"></i>
                    Baru
                </a>
            </div>
        </div>
    </div>

    @if($barangs->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-3xl border-2 border-dashed border-gray-200 p-16 text-center shadow-sm">
        <div class="w-24 h-24 gradient-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-box-open text-4xl gradient-primary bg-clip-text text-transparent"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Barang Dilelang</h3>
        <p class="text-gray-500 text-lg max-w-md mx-auto mb-8">
            Anda belum pernah melelang barang di platform LelangPro. 
            Mulailah jual barang Anda sekarang dan dapatkan keuntungan!
        </p>
        
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('barang.create') }}" 
               class="gradient-primary text-white px-8 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center gap-2">
                <i class="fas fa-gavel"></i>
                Mulai Lelang Pertama
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
            <a href="#" 
               class="border-2 border-gray-300 text-gray-700 px-8 py-3 rounded-xl font-semibold hover:border-gray-400 hover:text-gray-900 transition-all duration-300 flex items-center gap-2">
                <i class="fas fa-graduation-cap"></i>
                Panduan Penjual
            </a>
        </div>
    </div>

    @else
    <!-- Barang List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($barangs as $barang)
            @php 
                $winner = $barang->bids->sortByDesc('harga_bid')->first();
                $highestBid = $barang->bids->max('harga_bid') ?? 0;
                $feeAmount = $highestBid * 0.05;
                $netRevenue = $highestBid * 0.95;
                
                // Tentukan status pendapatan
                $pendapatanStatus = '';
                $pendapatanTitle = '';
                $pendapatanIcon = 'fa-money-bill-wave';
                $boxColor = 'from-blue-50 to-indigo-50 border-blue-200';
                $titleColor = 'text-blue-800';
                
                if ($barang->status === 'selesai' && $barang->bids->isNotEmpty()) {
                    $pendapatanStatus = 'selesai_terjual';
                    $pendapatanTitle = 'Pendapatan Akhir';
                    $pendapatanIcon = 'fa-trophy';
                    $boxColor = 'from-yellow-50 to-amber-50 border-yellow-200';
                    $titleColor = 'text-yellow-800';
                } elseif ($barang->status === 'selesai' && $barang->bids->isEmpty()) {
                    $pendapatanStatus = 'selesai_tidak_laku';
                    $pendapatanTitle = 'Tidak Terjual';
                    $pendapatanIcon = 'fa-times-circle';
                    $boxColor = 'from-gray-50 to-gray-100 border-gray-200';
                    $titleColor = 'text-gray-800';
                } elseif ($barang->status === 'aktif' && $barang->bids->isNotEmpty()) {
                    $pendapatanStatus = 'aktif_dengan_bid';
                    $pendapatanTitle = 'Potensi Pendapatan Saat Ini';
                    $pendapatanIcon = 'fa-chart-line';
                    $boxColor = 'from-green-50 to-emerald-50 border-green-200';
                    $titleColor = 'text-green-800';
                } elseif ($barang->status === 'aktif' && $barang->bids->isEmpty()) {
                    $pendapatanStatus = 'aktif_tanpa_bid';
                    $pendapatanTitle = 'Belum Ada Penawaran';
                    $pendapatanIcon = 'fa-hourglass-half';
                    $boxColor = 'from-purple-50 to-pink-50 border-purple-200';
                    $titleColor = 'text-purple-800';
                } else {
                    $pendapatanStatus = 'tidak_laku';
                    $pendapatanTitle = 'Tidak Laku';
                    $pendapatanIcon = 'fa-times';
                    $boxColor = 'from-red-50 to-rose-50 border-red-200';
                    $titleColor = 'text-red-800';
                }
            @endphp
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                <!-- Card Header -->
                <div class="border-b border-gray-100 p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ $barang->foto_url }}" 
                                     alt="{{ $barang->nama_barang }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ Str::limit($barang->nama_barang, 30) }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-tag mr-1"></i>{{ ucfirst($barang->kategori ?? 'Umum') }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        <i class="fas fa-calendar mr-1"></i>{{ $barang->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div>
                            @if($barang->status === 'aktif')
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-sm font-semibold px-3 py-1 rounded-full">
                                    <i class="fas fa-circle text-xs"></i>
                                    AKTIF
                                </span>
                            @elseif($barang->status === 'selesai')
                                @if($barang->bids->isNotEmpty())
                                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-sm font-semibold px-3 py-1 rounded-full">
                                        <i class="fas fa-trophy"></i>
                                        TERJUAL
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-sm font-semibold px-3 py-1 rounded-full">
                                        <i class="fas fa-flag-checkered"></i>
                                        SELESAI
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-sm font-semibold px-3 py-1 rounded-full">
                                    <i class="fas fa-times-circle"></i>
                                    TIDAK LAKU
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <p class="text-sm text-gray-600">{{ Str::limit($barang->deskripsi, 120) }}</p>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xs text-gray-500 mb-1">Harga Awal</div>
                            <div class="font-bold text-gray-900">
                                Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}
                            </div>
                        </div>
                        
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xs text-gray-500 mb-1">Bid Tertinggi</div>
                            <div class="font-bold {{ $barang->bids->isNotEmpty() ? 'text-green-600' : 'text-gray-400' }}">
                                @if($barang->bids->isNotEmpty())
                                    Rp {{ number_format($highestBid, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xs text-gray-500 mb-1">Total Bid</div>
                            <div class="font-bold text-gray-900">{{ $barang->bids->count() }}</div>
                        </div>
                        
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-xs text-gray-500 mb-1">Penawar</div>
                            <div class="font-bold text-gray-900">{{ $barang->bids->unique('user_id')->count() }}</div>
                        </div>
                    </div>

                    <!-- DETAIL PENDAPATAN BERSIH - SELALU TAMPIL -->
                    <div class="mb-6 bg-gradient-to-r {{ $boxColor }} rounded-xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-bold {{ $titleColor }} flex items-center gap-2">
                                <i class="fas {{ $pendapatanIcon }}"></i>
                                {{ $pendapatanTitle }}
                            </h4>
                            @if($barang->bids->isNotEmpty())
                                <span class="text-xs font-semibold {{ $titleColor }} bg-white/50 px-2 py-1 rounded-full">
                                    {{ $barang->bids->count() }} Bid
                                </span>
                            @endif
                        </div>
                        
                        <!-- Detail Pendapatan -->
                        <div class="space-y-3">
                            <!-- Baris 1: Harga Tertinggi -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">
                                    @if($barang->bids->isNotEmpty())
                                        @if($barang->status === 'selesai')
                                            Harga Final Lelang:
                                        @else
                                            Harga Tertinggi Saat Ini:
                                        @endif
                                    @else
                                        Harga Awal:
                                    @endif
                                </span>
                                <span class="font-medium {{ $barang->bids->isNotEmpty() ? 'text-gray-900' : 'text-gray-400' }}">
                                    @if($barang->bids->isNotEmpty())
                                        Rp {{ number_format($highestBid, 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Baris 2: Biaya Platform -->
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 flex items-center gap-1">
                                    <i class="fas fa-percentage text-xs"></i>
                                    Biaya Platform (5%):
                                </span>
                                <span class="font-medium text-red-600">
                                    @if($barang->bids->isNotEmpty())
                                        - Rp {{ number_format($feeAmount, 0, ',', '.') }}
                                    @else
                                        - Rp 0
                                    @endif
                                </span>
                            </div>
                            
                            <!-- Garis Pembatas -->
                            <div class="border-t border-gray-300 pt-2"></div>
                            
                            <!-- Baris 3: Pendapatan Bersih -->
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800">
                                    @if($barang->status === 'selesai' && $barang->bids->isNotEmpty())
                                        Pendapatan Bersih Anda:
                                    @elseif($barang->status === 'selesai' && $barang->bids->isEmpty())
                                        Barang Tidak Terjual:
                                    @elseif($barang->status === 'aktif' && $barang->bids->isNotEmpty())
                                        Potensi Pendapatan Bersih:
                                    @elseif($barang->status === 'aktif' && $barang->bids->isEmpty())
                                        Perkiraan Pendapatan:
                                    @else
                                        Status Barang:
                                    @endif
                                </span>
                                <span class="font-bold 
                                    @if($barang->status === 'selesai' && $barang->bids->isNotEmpty()) 
                                        text-green-600 
                                    @elseif($barang->status === 'aktif' && $barang->bids->isNotEmpty())
                                        text-blue-600
                                    @elseif($barang->status === 'aktif' && $barang->bids->isEmpty())
                                        text-purple-600
                                    @else
                                        text-gray-600
                                    @endif text-lg">
                                    @if($barang->status === 'selesai' && $barang->bids->isNotEmpty())
                                        Rp {{ number_format($netRevenue, 0, ',', '.') }}
                                    @elseif($barang->status === 'selesai' && $barang->bids->isEmpty())
                                        Rp 0
                                    @elseif($barang->status === 'aktif' && $barang->bids->isNotEmpty())
                                        Rp {{ number_format($netRevenue, 0, ',', '.') }}
                                    @elseif($barang->status === 'aktif' && $barang->bids->isEmpty())
                                        Rp {{ number_format($barang->harga_awal * 0.95, 0, ',', '.') }}
                                    @else
                                        Tidak Laku
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <!-- Info Tambahan -->
                        <div class="mt-3 text-xs {{ str_replace('text-', 'text-', $titleColor) }}">
                            <i class="fas fa-info-circle mr-1"></i>
                            @if($barang->status === 'selesai' && $barang->bids->isNotEmpty())
                                ✅ Lelang berhasil! Pendapatan akan diproses setelah konfirmasi
                            @elseif($barang->status === 'selesai' && $barang->bids->isEmpty())
                                ⏳ Lelang berakhir tanpa penawaran
                            @elseif($barang->status === 'aktif' && $barang->bids->isNotEmpty())
                                ⚡ Lelang masih berlangsung - jumlah dapat berubah
                            @elseif($barang->status === 'aktif' && $barang->bids->isEmpty())
                                🔍 Belum ada penawaran - bagikan untuk menarik minat
                            @else
                                ❌ Barang tidak laku terjual
                            @endif
                        </div>
                    </div>

                    <!-- Winner Info (if sold) -->
                    @if($barang->status === 'selesai' && $barang->bids->isNotEmpty())
                        <div class="mb-6 bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-yellow-800">🏆 Informasi Pemenang</h4>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Barang berhasil dijual kepada:
                                    </p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <div class="text-xs text-gray-600 mb-1">Nama Pemenang</div>
                                    <div class="font-medium text-gray-900">{{ $winner->user->name }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-600 mb-1">Kontak WhatsApp</div>
                                    <div class="font-medium text-gray-900">
                                        <a href="https://wa.me/{{ $winner->user->no_hp }}" 
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800">
                                            {{ $winner->user->no_hp }}
                                        </a>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-600 mb-1">Email</div>
                                    <div class="font-medium text-gray-900">{{ $winner->user->email }}</div>
                                </div>
                            </div>
                            
                            <div class="mt-3 text-xs text-gray-500">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Hubungi pembeli untuk mengatur pengiriman barang
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('barang.show', $barang->id) }}" 
                           class="gradient-primary text-white px-4 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </a>
                        
                        @if($barang->status === 'aktif')
                            <a href="{{ route('barang.show', $barang->id) }}#bids" 
                               class="border-2 border-blue-500 text-blue-600 px-4 py-2.5 rounded-xl font-medium hover:bg-blue-50 transition-all duration-300 flex items-center gap-2">
                                <i class="fas fa-gavel"></i>
                                Lihat Bid ({{ $barang->bids->count() }})
                            </a>
                            
                            @if($barang->bids->isNotEmpty())
                                <button onclick="copyPendapatanInfo(this)" 
                                        data-pendapatan="Rp {{ number_format($netRevenue, 0, ',', '.') }}"
                                        data-judul="{{ $barang->nama_barang }}"
                                        data-status="Potensi pendapatan saat ini"
                                        class="border-2 border-purple-500 text-purple-600 px-4 py-2.5 rounded-xl font-medium hover:bg-purple-50 transition-all duration-300 flex items-center gap-2">
                                    <i class="fas fa-copy"></i>
                                    Copy Info
                                </button>
                            @endif
                        @endif
                        
                        @if($barang->bids->isEmpty())
                            <form method="POST" action="{{ route('barang.destroy', $barang->id) }}" 
                                  class="inline"
                                  onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="border-2 border-red-500 text-red-600 px-4 py-2.5 rounded-xl font-medium hover:bg-red-50 transition-all duration-300 flex items-center gap-2">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        @endif
                        
                        @if($barang->status === 'selesai' && $barang->bids->isNotEmpty())
                            <button onclick="copyPendapatanInfo(this)" 
                                    data-pendapatan="Rp {{ number_format($netRevenue, 0, ',', '.') }}"
                                    data-judul="{{ $barang->nama_barang }}"
                                    data-status="Pendapatan akhir"
                                    class="border-2 border-green-500 text-green-600 px-4 py-2.5 rounded-xl font-medium hover:bg-green-50 transition-all duration-300 flex items-center gap-2">
                                <i class="fas fa-copy"></i>
                                Copy Pendapatan
                            </button>
                            
                            <a href="https://wa.me/{{ $winner->user->no_hp }}" 
                               target="_blank"
                               class="border-2 border-green-500 text-green-600 px-4 py-2.5 rounded-xl font-medium hover:bg-green-50 transition-all duration-300 flex items-center gap-2">
                                <i class="fab fa-whatsapp"></i>
                                Hubungi Pembeli
                            </a>
                        @endif
                    </div>

                    <!-- Time Info -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex justify-between items-center text-sm">
                            @if($barang->status === 'aktif')
                                <div class="text-gray-600">
                                    <i class="fas fa-clock mr-1"></i>
                                    Berakhir dalam:
                                </div>
                                <div class="font-medium text-red-600 countdown" 
                                     data-end="{{ $barang->waktu_selesai->toIso8601String() }}">
                                    ...
                                </div>
                            @else
                                <div class="text-gray-600">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $barang->status === 'selesai' ? 'Selesai' : 'Dibuat' }}:
                                </div>
                                <div class="font-medium text-gray-900">
                                    {{ $barang->updated_at->format('d M Y, H:i') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Summary Pendapatan -->
    <div class="mt-12 bg-gradient-to-r from-purple-50 to-pink-50 rounded-3xl p-8 border border-purple-200">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">📊 Ringkasan Pendapatan</h2>
                <p class="text-gray-600">Total pendapatan dari semua barang yang dilelang</p>
            </div>
            <div class="p-3 rounded-xl bg-white shadow-sm">
                <i class="fas fa-chart-pie text-3xl text-purple-600"></i>
            </div>
        </div>
        
        @php
            $totalBidTertinggi = 0;
            $totalFeePlatform = 0;
            $totalPendapatanBersih = 0;
            $totalBarangTerjual = 0;
            
            foreach($barangs as $barang) {
                if($barang->bids->isNotEmpty()) {
                    $maxBid = $barang->bids->max('harga_bid');
                    $totalBidTertinggi += $maxBid;
                    $totalFeePlatform += ($maxBid * 0.05);
                    $totalPendapatanBersih += ($maxBid * 0.95);
                    
                    if($barang->status === 'selesai') {
                        $totalBarangTerjual++;
                    }
                }
            }
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm card-hover">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-boxes text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Total Barang</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $barangs->count() }}</p>
                <p class="text-sm text-gray-500 mt-2">Barang yang dilelang</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm card-hover">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-trophy text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Barang Terjual</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $totalBarangTerjual }}</p>
                <p class="text-sm text-gray-500 mt-2">Lelang berhasil</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm card-hover">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-percentage text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Biaya Platform</h3>
                <p class="text-2xl font-bold text-red-600">
                    - Rp {{ number_format($totalFeePlatform, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500 mt-2">5% dari total nilai lelang</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm card-hover">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Pendapatan Bersih</h3>
                <p class="text-3xl font-bold text-green-600">
                    Rp {{ number_format($totalPendapatanBersih, 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500 mt-2">Setelah dipotong biaya</p>
            </div>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                <i class="fas fa-info-circle mr-1"></i>
                *Perhitungan berdasarkan barang yang memiliki penawaran
            </p>
        </div>
    </div>

    <!-- Pagination -->
    @if($barangs->hasPages())
    <div class="mt-8 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
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

    <!-- Tips Section -->
    <div class="mt-12 bg-gradient-to-r from-gray-50 to-blue-50 rounded-3xl p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Tips Jual Sukses</h2>
                <p class="text-gray-600">Cara meningkatkan penjualan di LelangPro</p>
            </div>
            <div class="p-3 rounded-xl bg-white shadow-sm">
                <i class="fas fa-chart-line text-3xl text-blue-600"></i>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm card-hover">
                <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-camera text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Foto Berkualitas</h3>
                <p class="text-sm text-gray-600">Gunakan foto jelas dari berbagai sudut dengan pencahayaan baik</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm card-hover">
                <div class="w-12 h-12 gradient-secondary rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-tags text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Harga Kompetitif</h3>
                <p class="text-sm text-gray-600">Tetapkan harga awal yang wajar sesuai harga pasar</p>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm card-hover">
                <div class="w-12 h-12 gradient-accent rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Durasi Optimal</h3>
                <p class="text-sm text-gray-600">Atur durasi 3-7 hari untuk hasil lelang terbaik</p>
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
        el.classList.add('text-red-500');
        return;
      }

      const d = Math.floor(diff / 86400000);
      const h = Math.floor((diff % 86400000) / 3600000);
      const m = Math.floor((diff % 3600000) / 60000);

      el.textContent =
        d > 0 ? `${d} hari ${h} jam` :
        h > 0 ? `${h} jam ${m} menit` :
                `${m} menit`;

      if (diff < 3600000) el.classList.add('text-red-600');
    });
  };

  updateCountdowns();
  setInterval(updateCountdowns, 30000);

  // Konfirmasi hapus
  window.confirmDelete = e => {
    e.preventDefault();
    if (confirm('Yakin ingin menghapus barang ini?')) {
      e.target.submit();
    }
  };

  // Copy info pendapatan
  window.copyPendapatanInfo = btn => {
    const text =
`💰 ${btn.dataset.status}
Barang: ${btn.dataset.judul}
Pendapatan: ${btn.dataset.pendapatan}
(Setelah potong 5%)`;

    navigator.clipboard.writeText(text);
    btn.innerHTML = '✔ Tersalin';
    setTimeout(() => location.reload(), 1500);
  };

});
</script>
@endpush
@endsection