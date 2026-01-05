@extends('layouts.app')

@section('title', 'Manajemen Barang - Admin Panel')

@section('content')
<div class="mb-10">
    <!-- Hero Header -->
    <div class="gradient-primary rounded-3xl p-8 text-white mb-8 shadow-2xl overflow-hidden relative">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="brand-font text-3xl md:text-4xl font-bold mb-2">Manajemen Barang Lelang</h1>
                    <p class="text-blue-100 text-lg">Kelola semua barang lelang di platform LelangPro</p>
                </div>
                
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[200px]">
                    <div class="text-4xl font-bold mb-1">{{ $totalBarangs ?? '0' }}</div>
                    <div class="text-sm text-blue-100">Total Barang</div>
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
                    <div class="text-3xl font-bold text-gray-900">{{ $soldBarangs ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Terjual</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Lelang berhasil dengan penawar</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-yellow-100 text-yellow-600">
                    <i class="fas fa-trophy text-xl"></i>
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
                <div class="p-3 rounded-xl bg-gray-100 text-gray-600">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $unsoldBarangs ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Tidak Laku</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Lelang tanpa penawar</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Filter & Pencarian</h2>
                <p class="text-gray-500 text-sm">Temukan dan filter barang berdasarkan kriteria</p>
            </div>
            
            <form method="GET" class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau deskripsi barang..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    >
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-filter text-gray-400"></i>
                    </div>
                    <select name="status" 
                            class="pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="tidak_laku" {{ request('status') == 'tidak_laku' ? 'selected' : '' }}>Tidak Laku</option>
                    </select>
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select name="kategori" 
                            class="pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="">Semua Kategori</option>
                        <option value="elektronik" {{ request('kategori') == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="kendaraan" {{ request('kategori') == 'kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                        <option value="properti" {{ request('kategori') == 'properti' ? 'selected' : '' }}>Properti</option>
                        <option value="koleksi" {{ request('kategori') == 'koleksi' ? 'selected' : '' }}>Koleksi</option>
                        <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="gradient-primary text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    
                    @if(request('search') || request('status') || request('kategori'))
                        <a href="{{ route('admin.barangs') }}" 
                           class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:border-gray-400 hover:text-gray-900 transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-redo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Barangs Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-8">
        <!-- Table Header -->
        <div class="border-b border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Daftar Barang Lelang</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        Menampilkan {{ $barangs->firstItem() ?? '0' }} - {{ $barangs->lastItem() ?? '0' }} dari {{ $barangs->total() }} barang
                    </p>
                </div>
                
                <div class="flex items-center gap-2">
                    <form method="GET" class="flex items-center gap-2">
                        <!-- Pertahankan filter pencarian, status & kategori saat sorting -->
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                        @if(request('kategori')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif

                        <span class="text-sm text-gray-600">Urutkan:</span>
                        <select name="sort" onchange="this.form.submit()" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="highest_price" {{ request('sort') == 'highest_price' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="most_bids" {{ request('sort') == 'most_bids' ? 'selected' : '' }}>Bid Terbanyak</option>
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
                                <i class="fas fa-money-bill-wave text-gray-400"></i>
                                Harga & Bid
                            </div>
                        </th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-chart-line text-gray-400"></i>
                                Status & Kategori
                            </div>
                        </th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-gray-400"></i>
                                Waktu
                            </div>
                        </th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-cog text-gray-400"></i>
                                Aksi
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($barangs as $barang)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Barang Info -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 cursor-pointer group relative"
                                         onclick="showImage('{{ $barang->foto_url }}', '{{ $barang->nama_barang }}')">
                                        <img src="{{ $barang->foto_url }}" 
                                             alt="{{ $barang->nama_barang }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                            <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 truncate">{{ $barang->nama_barang }}</div>
                                        <div class="text-sm text-gray-500 truncate mt-1">{{ Str::limit($barang->deskripsi, 60) }}</div>
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
                                        <div class="text-xs text-gray-500">{{ $barang->user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Price & Bids -->
                            <td class="p-4">
                                <div class="space-y-2">
                                    <div class="text-sm">
                                        <div class="text-gray-600">Harga Awal</div>
                                        <div class="font-bold text-gray-900">Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="text-sm">
                                        <div class="text-gray-600">Total Bid</div>
                                        <div class="font-bold text-blue-600">{{ $barang->bids_count }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status & Category -->
                            <td class="p-4">
                                <div class="space-y-2">
                                    <div>
                                        @if($barang->status === 'aktif')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                <i class="fas fa-bolt mr-1"></i>AKTIF
                                            </span>
                                        @elseif($barang->status === 'selesai')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                                <i class="fas fa-trophy mr-1"></i>SELESAI
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                <i class="fas fa-times-circle mr-1"></i>TIDAK LAKU
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        @if($barang->kategori)
                                            <i class="fas fa-tag mr-1"></i>{{ ucfirst($barang->kategori) }}
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Time Info -->
                            <td class="p-4">
                                <div class="space-y-1 text-sm">
                                    <div>
                                        <div class="text-gray-600">Dibuat</div>
                                        <div class="font-medium text-gray-900">{{ $barang->created_at->format('d M Y') }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-600">Berakhir</div>
                                        <div class="font-medium text-gray-900">{{ $barang->waktu_selesai->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="p-4">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('barang.show', $barang->id) }}" 
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 text-xs font-medium rounded-lg hover:bg-blue-100 transition-colors duration-300">
                                        <i class="fas fa-eye text-xs"></i>
                                        Lihat
                                    </a>
                                    
                                    <form method="POST"
                                          action="{{ route('admin.barangs.delete', $barang->id) }}"
                                          class="inline delete-form"
                                          data-name="{{ $barang->nama_barang }}"
                                          data-image="{{ $barang->foto_url }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-600 text-xs font-medium rounded-lg hover:bg-red-100 transition-colors duration-300 w-full justify-center">
                                            <i class="fas fa-trash text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-box-open text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">
                                    @if(request('search') || request('status') || request('kategori'))
                                        Tidak ada barang yang sesuai
                                    @else
                                        Belum ada barang lelang
                                    @endif
                                </h3>
                                <p class="text-gray-500 mb-6">
                                    @if(request('search'))
                                        Tidak ditemukan barang dengan pencarian "{{ request('search') }}"
                                    @else
                                        Mulai dengan menambahkan barang lelang pertama
                                    @endif
                                </p>
                                @if(request('search') || request('status') || request('kategori'))
                                    <a href="{{ route('admin.barangs') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                        <i class="fas fa-redo"></i>
                                        Tampilkan Semua Barang
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($barangs->hasPages())
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
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
                    @php
                        $currentPage = $barangs->currentPage();
                        $lastPage = $barangs->lastPage();
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($lastPage, $currentPage + 2);
                    @endphp
                    
                    @if($startPage > 1)
                        <a href="{{ $barangs->url(1) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100">
                            1
                        </a>
                        @if($startPage > 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif
                    
                    @for($page = $startPage; $page <= $endPage; $page++)
                        <a href="{{ $barangs->url($page) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl {{ $currentPage === $page ? 'gradient-primary text-white' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    @endfor
                    
                    @if($endPage < $lastPage)
                        @if($endPage < $lastPage - 1)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ $barangs->url($lastPage) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100">
                            {{ $lastPage }}
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
</div>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Card hover effects
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
                this.style.boxShadow = '0 12px 24px rgba(0, 0, 0, 0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.05)';
            });
        });

        // Show Image Preview
        window.showImage = function(imageUrl, caption) {
            Swal.fire({
                imageUrl: imageUrl,
                imageAlt: caption,
                text: caption,
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    image: 'rounded-2xl shadow-xl max-h-[80vh] object-contain',
                    popup: 'rounded-3xl p-0 overflow-hidden'
                },
                backdrop: `rgba(0,0,0,0.8)`
            });
        }

        // Handle delete form submission
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.classList.contains('delete-form')) {
                e.preventDefault();
                
                const form = e.target;
                const barangName = form.getAttribute('data-name');
                const barangImage = form.getAttribute('data-image');
                
                Swal.fire({
                    title: 'Hapus Barang?',
                    html: `
                        <div class="mb-6 mt-2">
                            <div class="w-32 h-32 mx-auto rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                                <img src="${barangImage}" class="w-full h-full object-cover" alt="${barangName}">
                            </div>
                        </div>
                        Anda akan menghapus barang <strong>"${barangName}"</strong> secara permanen.<br><br>
                        <span class="text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Semua bid terkait barang ini juga akan dihapus!
                        </span>
                    `,
                    icon: null,
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus Selamanya',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl px-6 py-3 font-bold',
                        cancelButton: 'rounded-xl px-6 py-3 font-bold'
                    },
                    backdrop: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });

        // Search input focus
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-blue-200');
            });
            
            searchInput.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-blue-200');
            });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[class*="bg-gradient-to-r"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.style.display = 'none';
                    }
                }, 500);
            });
        }, 5000);
    });
</script>
@endpush
@endsection