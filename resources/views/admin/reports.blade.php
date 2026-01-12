@extends('layouts.app')

@section('title', 'Laporan Sistem - Admin Panel')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Hero Header -->
        <div class="gradient-primary rounded-3xl p-8 text-white mb-8 shadow-2xl overflow-hidden relative">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
            
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h1 class="brand-font text-3xl md:text-4xl font-bold mb-2">Laporan Sistem Lelang</h1>
                        <p class="text-blue-100 text-lg">Analisis data dan statistik platform LelangPro</p>
                    </div>
                    
                    <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[200px]">
                        <div class="text-sm text-blue-100 mb-2">Periode Laporan</div>
                        <div class="text-2xl font-bold">{{ now()->translatedFormat('F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Options -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Ekspor Laporan</h2>
                    <p class="text-gray-500 text-sm">Download data dalam berbagai format</p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <!-- PDF Download Button -->
                    <a href="{{ route('reports.download-all') }}" 
                    class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300 nav-link">
                        <i class="fas fa-file-pdf"></i>
                        Export All PDF
                    </a>
                    
                    <!-- CSV Download Button -->
                    <a href="{{ route('reports.csv', 'barang') }}" 
                    class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-500 to-cyan-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300 nav-link">
                        <i class="fas fa-file-csv"></i>
                        Export CSV (Barang)
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-indigo-100 text-indigo-600">
                        <i class="fas fa-crown text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">{{ $topBarangs->count() }}</div>
                        <div class="text-sm text-gray-500">Top Barang</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Berdasarkan jumlah bid</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-emerald-100 text-emerald-600">
                        <i class="fas fa-gavel text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">{{ $topBidders->count() }}</div>
                        <div class="text-sm text-gray-500">Top Bidder</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Bidder teraktif</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-amber-100 text-amber-600">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">{{ $topSellers->count() }}</div>
                        <div class="text-sm text-gray-500">Top Seller</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Penjual terbanyak</p>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-blue-100 text-blue-600">
                        <i class="fas fa-chart-bar text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">
                            {{ $topBarangs->sum('bids_count') + $topBidders->sum('bids_count') }}
                        </div>
                        <div class="text-sm text-gray-500">Total Bid</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Dalam periode ini</p>
            </div>
        </div>

        <!-- Top 10 Barang Terlaris -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-8 card-hover">
            <!-- Table Header -->
            <div class="border-b border-gray-100 p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Top 10 Barang Terlaris</h2>
                        <p class="text-gray-500 text-sm mt-1">Barang dengan jumlah bid terbanyak</p>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <form method="GET" action="{{ route('admin.reports') }}" class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">Status:</span>
                            <select name="status" onchange="this.form.submit()" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-medal text-gray-400"></i>
                                    Rank
                                </div>
                            </th>
                            <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-box text-gray-400"></i>
                                    Barang
                                </div>
                            </th>
                            <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    Penjual
                                </div>
                            </th>
                            <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-gavel text-gray-400"></i>
                                    Total Bid
                                </div>
                            </th>
                            <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-chart-line text-gray-400"></i>
                                    Status
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($topBarangs as $index => $barang)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Rank -->
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        @if($index === 0)
                                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center text-white font-bold">
                                                <i class="fas fa-crown"></i>
                                            </div>
                                            <span class="font-bold text-gray-900">🥇 Juara 1</span>
                                        @elseif($index === 1)
                                            <div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-600 rounded-xl flex items-center justify-center text-white font-bold">
                                                <i class="fas fa-medal"></i>
                                            </div>
                                            <span class="font-bold text-gray-900">🥈 Juara 2</span>
                                        @elseif($index === 2)
                                            <div class="w-10 h-10 bg-gradient-to-br from-amber-700 to-yellow-800 rounded-xl flex items-center justify-center text-white font-bold">
                                                <i class="fas fa-award"></i>
                                            </div>
                                            <span class="font-bold text-gray-900">🥉 Juara 3</span>
                                        @else
                                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-700 font-bold">
                                                {{ $index + 1 }}
                                            </div>
                                            <span class="font-medium text-gray-900">Peringkat {{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Barang Info -->
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100">
                                            <img src="{{ $barang->foto_url }}" 
                                                 alt="{{ $barang->nama_barang }}" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-gray-900 truncate">{{ $barang->nama_barang }}</div>
                                            <div class="text-sm text-gray-500 truncate mt-1">
                                                Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Seller Info -->
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-700 text-xs font-bold">
                                            {{ substr($barang->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $barang->user->name }}</div>
                                            <div class="text-xs text-gray-500">Penjual</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Total Bids -->
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-gavel text-blue-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">{{ $barang->bids_count }}</div>
                                            <div class="text-sm text-gray-500">bid</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="p-4">
                                    @if($barang->status === 'aktif')
                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-medium">
                                            <i class="fas fa-bolt"></i>
                                            AKTIF
                                        </span>
                                    @elseif($barang->status === 'selesai')
                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-50 text-yellow-700 rounded-xl text-sm font-medium">
                                            <i class="fas fa-trophy"></i>
                                            SELESAI
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-700 rounded-xl text-sm font-medium">
                                            <i class="fas fa-times"></i>
                                            TIDAK LAKU
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-chart-bar text-2xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada data laporan</h3>
                                    <p class="text-gray-500">Tidak ada barang dengan bid saat ini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bottom Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Top 10 Bidder Teraktif -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                <div class="border-b border-gray-100 p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Top 10 Bidder Teraktif</h2>
                            <p class="text-sm text-gray-500">User dengan bid terbanyak</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-sm font-medium text-gray-700">Live</span>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-ranking-star text-gray-400"></i>
                                        Rank
                                    </div>
                                </th>
                                <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user text-gray-400"></i>
                                        User
                                    </div>
                                </th>
                                <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-gavel text-gray-400"></i>
                                        Total Bid
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topBidders as $index => $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="p-4">
                                    @if($index < 3)
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold
                                            @if($index === 0) bg-gradient-to-br from-yellow-500 to-orange-500
                                            @elseif($index === 1) bg-gradient-to-br from-gray-400 to-gray-600
                                            @else bg-gradient-to-br from-amber-700 to-yellow-800 @endif">
                                            {{ $index + 1 }}
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-700 font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&bold=true" 
                                             alt="{{ $user->name }}">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 bg-gray-100 rounded-full h-2">
                                            @php
                                                $maxBids = $topBidders->max('bids_count') ?: 1;
                                                $percentage = min(100, ($user->bids_count / $maxBids) * 100);
                                            @endphp
                                            <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 h-2 rounded-full" 
                                                 style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xl font-bold text-gray-900">{{ $user->bids_count }}</div>
                                            <div class="text-sm text-gray-500">bid</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-users text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500">Belum ada data bidder</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top 10 Seller Terbanyak -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                <div class="border-b border-gray-100 p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Top 10 Seller Terbanyak</h2>
                            <p class="text-sm text-gray-500">Penjual dengan barang terbanyak</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-store text-gray-400"></i>
                            <span class="text-sm font-medium text-gray-700">Seller</span>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-ranking-star text-gray-400"></i>
                                        Rank
                                    </div>
                                </th>
                                <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user-tie text-gray-400"></i>
                                        Seller
                                    </div>
                                </th>
                                <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-box text-gray-400"></i>
                                        Total Barang
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topSellers as $index => $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="p-4">
                                    @if($index < 3)
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold
                                            @if($index === 0) bg-gradient-to-br from-blue-500 to-cyan-500
                                            @elseif($index === 1) bg-gradient-to-br from-indigo-500 to-purple-500
                                            @else bg-gradient-to-br from-purple-500 to-pink-500 @endif">
                                            {{ $index + 1 }}
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-700 font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full flex items-center justify-center text-blue-600 font-bold">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 bg-gray-100 rounded-full h-2">
                                            @php
                                                $maxBarangs = $topSellers->max('barangs_count') ?: 1;
                                                $percentage = min(100, ($user->barangs_count / $maxBarangs) * 100);
                                            @endphp
                                            <div class="bg-gradient-to-r from-blue-400 to-blue-500 h-2 rounded-full" 
                                                 style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xl font-bold text-gray-900">{{ $user->barangs_count }}</div>
                                            <div class="text-sm text-gray-500">barang</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-store text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500">Belum ada data seller</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@push('scripts')
<script src="{{ asset('js/reports.js') }}"></script>
@endpush
@endsection