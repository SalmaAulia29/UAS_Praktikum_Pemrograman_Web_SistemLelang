// @extends('layouts.app')

@section('title', 'Dashboard Admin - LelangPro')

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
                        <h1 class="brand-font text-3xl md:text-4xl font-bold mb-2">Dashboard Admin</h1>
                        <p class="text-blue-100 text-lg">Selamat datang, {{ auth()->user()->name }}! 👋 Kelola sistem dengan mudah</p>
                    </div>
                    
                    <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[200px]">
                        <div class="text-4xl font-bold mb-1">{{ now()->format('d') }}</div>
                        <div class="text-sm text-blue-100">{{ now()->translatedFormat('F Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-indigo-100 text-indigo-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalUsers ?? '0' }}</div>
                        <div class="text-sm text-gray-500">Total Pengguna</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">{{ $totalAdmins ?? '0' }} Admin terdaftar</p>
            </div>

            <!-- Barang Aktif -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-emerald-100 text-emerald-600">
                        <i class="fas fa-bolt text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalBarangAktif ?? '0' }}</div>
                        <div class="text-sm text-gray-500">Aktif</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Sedang dalam proses lelang</p>
            </div>

            <!-- Total Bids -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-amber-100 text-amber-600">
                        <i class="fas fa-gavel text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-gray-900">{{ $totalBids ?? '0' }}</div>
                        <div class="text-sm text-gray-500">Total Bid</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">{{ $activeUsers->count() ?? '0' }} user aktif</p>
            </div>

            <!-- Estimasi Revenue -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-blue-100 text-blue-600">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($revenue ?? 0, 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-500">Estimasi Revenue</div>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Dari barang terjual</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            <!-- Left Column: Status Overview and Top Bidders -->
            <div class="space-y-6">
                <!-- Status Overview -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Statistik Barang Lelang</h2>
                        <div class="flex gap-2">
                            <button class="text-sm bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg hover:bg-gray-200 transition-colors">
                                Minggu ini
                            </button>
                            <button class="text-sm gradient-primary text-white px-3 py-1.5 rounded-lg hover:shadow-md transition-all">
                                Bulan ini
                            </button>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        @php
                            $totalBarang = ($totalBarangAktif ?? 0) + ($totalBarangSelesai ?? 0) + ($totalBarangTidakLaku ?? 0);
                        @endphp
                        
                        <!-- Aktif -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                <div>
                                    <p class="font-medium text-gray-700">Barang Aktif</p>
                                    <p class="text-sm text-gray-500">Sedang dalam lelang</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">{{ $totalBarangAktif ?? '0' }}</p>
                                <p class="text-sm text-gray-500">
                                    @if($totalBarang > 0)
                                        {{ round(($totalBarangAktif / $totalBarang) * 100) }}% dari total
                                    @else
                                        0% dari total
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Selesai -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                <div>
                                    <p class="font-medium text-gray-700">Barang Selesai</p>
                                    <p class="text-sm text-gray-500">Lelang berhasil</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">{{ $totalBarangSelesai ?? '0' }}</p>
                                <p class="text-sm text-gray-500">
                                    @if($totalBarang > 0)
                                        {{ round(($totalBarangSelesai / $totalBarang) * 100) }}% dari total
                                    @else
                                        0% dari total
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Tidak Laku -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                                <div>
                                    <p class="font-medium text-gray-700">Barang Tidak Laku</p>
                                    <p class="text-sm text-gray-500">Lelang gagal</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">{{ $totalBarangTidakLaku ?? '0' }}</p>
                                <p class="text-sm text-gray-500">
                                    @if($totalBarang > 0)
                                        {{ round(($totalBarangTidakLaku / $totalBarang) * 100) }}% dari total
                                    @else
                                        0% dari total
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Bidders -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                    <div class="border-b border-gray-100 p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Top Bidders</h2>
                                <p class="text-sm text-gray-500">User dengan aktivitas tertinggi</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-sm font-medium text-gray-700">Live</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($activeUsers as $index => $user)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <img class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&bold=true" 
                                             alt="{{ $user->name }}">
                                        @if($index < 3)
                                        <div class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-xs font-bold text-white">
                                            {{ $index + 1 }}
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-gray-900">{{ $user->bids_count }}</p>
                                    <p class="text-sm text-gray-500">penawaran</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <i class="fas fa-users text-3xl text-gray-300 mb-4"></i>
                            <p class="text-sm font-medium text-gray-900">Belum ada aktivitas</p>
                            <p class="text-sm text-gray-500">User belum melakukan penawaran</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Barang Lelang Terbaru -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                <div class="border-b border-gray-100 p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Barang Lelang Terbaru</h2>
                            <p class="text-sm text-gray-500">Update: {{ now()->format('H:i') }}</p>
                        </div>
                        <a href="{{ route('admin.barangs') }}" 
                           class="text-sm font-medium text-indigo-600 hover:text-indigo-500 flex items-center gap-2 nav-link">
                            Lihat Semua
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @forelse($latestBarangs as $barang)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden shrink-0">
                                    <img src="{{ $barang->foto_url }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ Str::limit($barang->nama_barang, 25) }}</p>
                                    <p class="text-sm text-gray-500">{{ $barang->user->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium 
                                    @if($barang->status === 'aktif') bg-emerald-100 text-emerald-700
                                    @elseif($barang->status === 'selesai') bg-blue-100 text-blue-700
                                    @else bg-rose-100 text-rose-700 @endif">
                                    {{ ucfirst($barang->status) }}
                                </span>
                                <p class="mt-2 text-sm font-bold text-gray-900">
                                    Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <i class="fas fa-box-open text-3xl text-gray-300 mb-4"></i>
                        <p class="text-sm font-medium text-gray-900">Belum ada barang lelang</p>
                        <p class="text-sm text-gray-500">Tambah barang lelang pertama</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    console.log('Dashboard admin loaded');

    // Auto-hide alert
    setTimeout(() => {
        document.querySelectorAll('[class*="bg-gradient-to-r"]')
            .forEach(el => el.style.display = 'none');
    }, 5000);
});
</script>
@endpush
@endsection