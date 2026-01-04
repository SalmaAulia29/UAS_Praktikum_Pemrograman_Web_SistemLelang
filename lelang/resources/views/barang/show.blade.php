@extends('layouts.app')

@section('title', $barang->nama_barang . ' - LelangPro')

@section('content')
<div class="mb-10">
    <!-- Breadcrumb -->
    <div class="mb-8">
        <nav class="flex bg-white/80 backdrop-blur-sm p-4 rounded-2xl shadow-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 md:space-x-4">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                        <div class="gradient-primary p-2 rounded-lg mr-2">
                            <i class="fas fa-home text-white text-sm"></i>
                        </div>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                        <a href="{{ route('home', ['kategori' => $barang->kategori]) }}" 
                           class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                            {{ ucfirst($barang->kategori ?? 'Semua') }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2 text-sm"></i>
                        <span class="text-sm font-medium text-gray-500 truncate max-w-xs">
                            {{ $barang->nama_barang }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column - Image & Seller Info -->
        <div class="space-y-6">
            <!-- Image Gallery -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="relative h-96 bg-gradient-to-br from-gray-50 to-gray-100">
                    <img src="{{ $barang->foto_url }}" 
                         alt="{{ $barang->nama_barang }}" 
                         class="w-full h-full object-contain p-4"
                         id="mainImage"
                         loading="lazy">
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 left-4">
                        @if($barang->status === 'aktif')
                            <span class="gradient-primary text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                LIVE NOW
                            </span>
                        @elseif($barang->status === 'selesai')
                            <span class="bg-gradient-to-r from-yellow-500 to-amber-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                <i class="fas fa-trophy mr-1"></i>SOLD
                            </span>
                        @else
                            <span class="bg-gradient-to-r from-gray-500 to-gray-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                <i class="fas fa-times-circle mr-1"></i>CLOSED
                            </span>
                        @endif
                    </div>
                    
                    <!-- Favorite Button -->
                    <button class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:text-red-500 hover:bg-white transition-all duration-300 hover:scale-110">
                        <i class="far fa-heart text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Seller Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-tie text-blue-600"></i>
                    Informasi Penjual
                </h3>
                
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 gradient-primary rounded-xl flex items-center justify-center text-white text-xl font-bold">
                        {{ substr($barang->user->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 text-lg">{{ $barang->user->name }}</h4>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-phone text-gray-400 text-sm"></i>
                                <span class="text-gray-700">{{ $barang->user->no_hp }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                <span class="text-gray-700">{{ $barang->user->email }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-star text-yellow-400 text-sm"></i>
                                <span class="text-gray-700">Rating: 4.8/5.0 (120 reviews)</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <button onclick="window.open('https://wa.me/{{ $barang->user->no_hp }}', '_blank')"
                            class="w-full gradient-primary text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp text-xl"></i>
                        Hubungi via WhatsApp
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column - Product Info & Bidding -->
        <div class="space-y-6">
            <!-- Product Header -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold px-2 py-1 rounded bg-gray-100 text-gray-600">
                                {{ ucfirst($barang->kategori ?? 'Umum') }}
                            </span>
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-box mr-1"></i>{{ ucfirst($barang->kondisi) }}
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $barang->nama_barang }}</h1>
                        <p class="text-gray-600">{{ Str::limit($barang->deskripsi, 150) }}</p>
                    </div>
                </div>

                <!-- Price & Stats -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl">
                        <div class="text-xs text-gray-600 mb-1">Harga Awal</div>
                        <div class="text-2xl font-bold text-blue-700">
                            Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl">
                        <div class="text-xs text-gray-600 mb-1">Bid Tertinggi</div>
                        <div class="text-2xl font-bold text-green-700">
                            @if($highestBid)
                                Rp {{ number_format($highestBid->harga_bid, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-bold text-gray-900">{{ $bidCount }}</div>
                        <div class="text-xs text-gray-500">Penawar</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-lg font-bold text-gray-900">{{ $barang->bids->count() }}</div>
                        <div class="text-xs text-gray-500">Total Bid</div>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-sm font-bold text-gray-900">
                            @if($barang->status === 'aktif')
                                <div class="countdown text-xs" data-end="{{ $barang->waktu_selesai->toIso8601String() }}">
                                    ...
                                </div>
                            @else
                                {{ $barang->waktu_selesai->format('d M Y') }}
                            @endif
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $barang->status === 'aktif' ? 'Berakhir' : 'Selesai' }}
                        </div>
                    </div>
                </div>

                <!-- Status Message -->
                @if($barang->status === 'aktif')
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                                <i class="fas fa-bolt text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-green-800 mb-1">Lelang Sedang Berlangsung!</h4>
                                <p class="text-sm text-green-700">
                                    Buruan ajukan penawaran terbaik Anda sebelum waktu habis
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($barang->status === 'selesai')
                    @if($highestBid)
                        <div class="mb-6 bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                                    <i class="fas fa-trophy text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-yellow-800 mb-1">Lelang Telah Berakhir</h4>
                                    <p class="text-sm text-yellow-700">
                                        Dimenangkan oleh <span class="font-bold">{{ $highestBid->user->name }}</span> 
                                        seharga <span class="font-bold">Rp {{ number_format($highestBid->harga_bid, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>


            <!-- Bidding Section -->
            @auth
                @if($barang->status === 'aktif' && $barang->user_id !== auth()->id())
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100" id="bid-section">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-gavel text-blue-600"></i>
                            Ajukan Penawaran
                        </h3>
                        
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Bid Minimal Saat Ini</span>
                                <span class="font-bold text-blue-600">
                                    Rp {{ number_format(($highestBid ? $highestBid->harga_bid : $barang->harga_awal) + 5000, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-full" 
                                    style="width: {{ min(100, (($highestBid ? $highestBid->harga_bid : $barang->harga_awal) / ($barang->harga_awal * 2)) * 100) }}%">
                                </div>
                            </div>
                        </div>

                        <!-- FORM SEDERHANA TANPA AJAX -->
                        <form method="POST" action="{{ route('bid.store', ['barang_id' => $barang->id]) }}">
                            @csrf
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Masukkan Penawaran Anda (minimal Rp {{ number_format(($highestBid ? $highestBid->harga_bid : $barang->harga_awal) + 5000, 0, ',', '.') }})
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">Rp</span>
                                    </div>
                                    <input type="number"
                                        name="harga_bid"
                                        min="{{ ($highestBid ? $highestBid->harga_bid : $barang->harga_awal) + 5000 }}"
                                        step="1000"
                                        value="{{ ($highestBid ? $highestBid->harga_bid : $barang->harga_awal) + 5000 }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl text-lg font-bold focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">* Kenaikan minimal Rp 5.000 dari bid tertinggi</p>
                            </div>

                            <!-- Quick Bid Buttons -->
                            <div class="mb-6">
                                <p class="text-sm text-gray-600 mb-2">Bid Cepat:</p>
                                <div class="grid grid-cols-3 gap-2">
                                    @php
                                        $currentMin = ($highestBid ? $highestBid->harga_bid : $barang->harga_awal) + 5000;
                                        $increments = [10000, 50000, 100000];
                                    @endphp
                                    @foreach($increments as $inc)
                                        <button type="button" 
                                                onclick="document.querySelector('[name=harga_bid]').value = parseInt(document.querySelector('[name=harga_bid]').value) + {{ $inc }}"
                                                class="py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                                            +{{ number_format($inc, 0, ',', '.') }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tampilkan pesan error/success jika ada -->
                            @if(session('success'))
                                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl">
                                    ✅ {{ session('success') }}
                                </div>
                            @endif
                            
                            @if($errors->any())
                                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
                                    ❌ {{ $errors->first() }}
                                </div>
                            @endif

                            <button type="submit"
                                    class="w-full gradient-primary text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="fas fa-gavel"></i>
                                Ajukan Penawaran
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        

            <!-- Related Items -->
            @if(isset($relatedItems) && $relatedItems->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Barang Serupa</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($relatedItems as $related)
                            <a href="{{ route('barang.show', $related->id) }}" 
                               class="group block">
                                <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden mb-2">
                                    <img src="{{ $related->foto_url }}" 
                                         alt="{{ $related->nama_barang }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-1 group-hover:text-blue-600">{{ $related->nama_barang }}</h4>
                                    <p class="text-sm font-bold text-blue-600">
                                        Rp {{ number_format($related->highestBid?->harga_bid ?? $related->harga_awal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Tabs Section -->
    <div class="mt-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Tab Headers -->
            <div class="border-b border-gray-100">
                <nav class="flex" id="tabButtons">
                    <button class="tab-button flex-1 py-4 px-6 text-sm font-semibold text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-blue-500 transition-all duration-300 active"
                            data-tab="description">
                        <i class="fas fa-align-left mr-2"></i>Deskripsi Lengkap
                    </button>
                    <button class="tab-button flex-1 py-4 px-6 text-sm font-semibold text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-blue-500 transition-all duration-300"
                            data-tab="specifications">
                        <i class="fas fa-list-alt mr-2"></i>Spesifikasi
                    </button>
                    <button class="tab-button flex-1 py-4 px-6 text-sm font-semibold text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-blue-500 transition-all duration-300"
                            data-tab="bids">
                        <i class="fas fa-history mr-2"></i>Riwayat Bid
                        <span class="ml-2 bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $barang->bids->count() }}</span>
                    </button>
                </nav>
            </div>

            <!-- Tab Contents -->
            <div class="p-6">
                <!-- Description Tab -->
                <div id="descriptionTab" class="tab-content">
                    <div class="prose max-w-none">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Deskripsi Detail</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $barang->deskripsi }}</p>
                        
                        @if($barang->kondisi)
                            <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                                <h4 class="font-bold text-gray-900 mb-2 flex items-center gap-2">
                                    <i class="fas fa-clipboard-check text-blue-600"></i>
                                    Kondisi Barang
                                </h4>
                                <p class="text-gray-700">{{ ucfirst($barang->kondisi) }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div id="specificationsTab" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Informasi Umum</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Kategori</dt>
                                    <dd class="font-medium text-gray-900">{{ ucfirst($barang->kategori ?? 'Tidak disebutkan') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Kondisi</dt>
                                    <dd class="font-medium text-gray-900">{{ ucfirst($barang->kondisi ?? 'Tidak disebutkan') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Mulai Lelang</dt>
                                    <dd class="font-medium text-gray-900">{{ $barang->waktu_mulai->format('d M Y, H:i') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Selesai Lelang</dt>
                                    <dd class="font-medium text-gray-900">{{ $barang->waktu_selesai->format('d M Y, H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">Statistik Lelang</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Status</dt>
                                    <dd class="font-medium {{ $barang->status === 'aktif' ? 'text-green-600' : ($barang->status === 'selesai' ? 'text-yellow-600' : 'text-gray-600') }}">
                                        {{ strtoupper($barang->status) }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Total Penawar</dt>
                                    <dd class="font-medium text-gray-900">{{ $bidCount }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Total Bid</dt>
                                    <dd class="font-medium text-gray-900">{{ $barang->bids->count() }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Harga Tertinggi</dt>
                                    <dd class="font-medium text-green-600">
                                        @if($highestBid)
                                            Rp {{ number_format($highestBid->harga_bid, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Bids Tab -->
                <div id="bidsTab" class="tab-content hidden">
                    @if($barang->bids->isEmpty())
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clipboard-list text-2xl text-gray-400"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Penawaran</h4>
                            <p class="text-gray-600">Jadilah yang pertama mengajukan penawaran untuk barang ini!</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($barang->bids->sortByDesc('harga_bid') as $index => $bid)
                                <div class="flex items-center justify-between p-4 rounded-xl {{ $index === 0 ? 'bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200' : 'bg-gray-50' }}">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 {{ $index === 0 ? 'gradient-primary' : 'bg-gray-200' }} rounded-full flex items-center justify-center text-white font-bold">
                                            {{ substr($bid->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-gray-900">{{ $bid->user->name }}</h5>
                                            <p class="text-sm text-gray-500">{{ $bid->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="text-xl font-bold {{ $index === 0 ? 'text-green-600' : 'text-gray-900' }}">
                                            Rp {{ number_format($bid->harga_bid, 0, ',', '.') }}
                                        </div>
                                        @if($index === 0)
                                            <div class="text-xs font-semibold text-green-600 flex items-center gap-1 mt-1">
                                                <i class="fas fa-crown"></i> PENAWAR TERTINGGI
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Countdown lelang
  const updateCountdown = () => {
    document.querySelectorAll('.countdown').forEach(el => {
      const end = new Date(el.dataset.end).getTime();
      const diff = end - Date.now();

      if (diff <= 0) {
        el.textContent = 'Berakhir';
        el.classList.add('text-red-500');
        return;
      }

      const h = Math.floor(diff / 3600000);
      const m = Math.floor((diff % 3600000) / 60000);
      const s = Math.floor((diff % 60000) / 1000);

      el.textContent = `${h}j ${m}m ${s}d`;
    });
  };
  updateCountdown();
  setInterval(updateCountdown, 1000);

  // Tab switching
  document.querySelectorAll('.tab-button').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-button').forEach(b => {
        b.classList.remove('border-blue-500', 'text-gray-900');
        b.classList.add('text-gray-600');
      });

      btn.classList.add('border-blue-500', 'text-gray-900');
      btn.classList.remove('text-gray-600');

      document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
      document.getElementById(btn.dataset.tab + 'Tab').classList.remove('hidden');
    });
  });

  // Quick bid button
  window.tambahBid = nominal => {
    const input = document.querySelector('[name=harga_bid]');
    input.value = parseInt(input.value) + nominal;
  };

});
</script>
@endpush
@endsection