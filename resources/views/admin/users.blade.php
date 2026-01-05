@extends('layouts.app')

@section('title', 'Manajemen User - Admin Panel')

@section('content')
<div class="mb-10">
    <!-- Hero Header -->
    <div class="gradient-primary rounded-3xl p-8 text-white mb-8 shadow-2xl overflow-hidden relative">
        <!-- Background Pattern -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="brand-font text-3xl md:text-4xl font-bold mb-2">Manajemen Pengguna</h1>
                    <p class="text-blue-100 text-lg">Kelola semua pengguna dan akses di platform LelangPro</p>
                </div>
                
                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl min-w-[200px]">
                    <div class="text-4xl font-bold mb-1">{{ $totalUsers ?? '0' }}</div>
                    <div class="text-sm text-blue-100">Total Pengguna</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $regularUsers ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Pengguna Biasa</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Pengguna dengan role "user"</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-purple-100 text-purple-600">
                    <i class="fas fa-user-shield text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $adminUsers ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Administrator</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Pengguna dengan akses admin</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-green-100 text-green-600">
                    <i class="fas fa-box text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $totalBarangs ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Total Barang</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Barang dilelang oleh semua user</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-yellow-100 text-yellow-600">
                    <i class="fas fa-gavel text-xl"></i>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-gray-900">{{ $totalBids ?? '0' }}</div>
                    <div class="text-sm text-gray-500">Total Bid</div>
                </div>
            </div>
            <p class="text-sm text-gray-600">Penawaran dari semua user</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Filter & Pencarian</h2>
                <p class="text-gray-500 text-sm">Temukan dan filter pengguna berdasarkan kriteria</p>
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
                        placeholder="Cari nama, email, atau no. HP..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    >
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-filter text-gray-400"></i>
                    </div>
                    <select name="role" 
                            class="pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <option value="">Semua Role</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="gradient-primary text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105 flex items-center gap-2">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                    
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.users') }}" 
                           class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:border-gray-400 hover:text-gray-900 transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-redo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-8">
        <!-- Table Header -->
        <div class="border-b border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Daftar Pengguna</h2>
                    <p class="text-gray-500 text-sm mt-1">
                        Menampilkan {{ $users->firstItem() ?? '0' }} - {{ $users->lastItem() ?? '0' }} dari {{ $users->total() }} pengguna
                    </p>
                </div>
                
                <div class="flex items-center gap-2">
                    <form method="GET" class="flex items-center gap-2">
                        <!-- Pertahankan filter pencarian & role saat sorting -->
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif

                        <span class="text-sm text-gray-600">Urutkan:</span>
                        <select name="sort" onchange="this.form.submit()" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="items_count" {{ request('sort') == 'items_count' ? 'selected' : '' }}>Jumlah Barang</option>
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
                                <i class="fas fa-user text-gray-400"></i>
                                Pengguna
                            </div>
                        </th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-chart-bar text-gray-400"></i>
                                Aktivitas
                            </div>
                        </th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-shield-alt text-gray-400"></i>
                                Role
                            </div>
                        </th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-700 uppercase border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar text-gray-400"></i>
                                Bergabung
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
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- User Info -->
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 {{ $user->role === 'admin' ? 'gradient-primary' : 'bg-gray-200' }} rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $user->no_hp ?? 'No HP belum diisi' }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Activity Stats -->
                            <td class="p-4">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Barang</span>
                                        <span class="font-semibold text-gray-900">{{ $user->barangs_count }}</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Bid</span>
                                        <span class="font-semibold text-gray-900">{{ $user->bids_count }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Role & Status -->
                            <td class="p-4">
                                <div class="space-y-2">
                                    <div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                            @if($user->role === 'admin')
                                                <i class="fas fa-user-shield mr-1"></i>ADMIN
                                            @else
                                                <i class="fas fa-user mr-1"></i>USER
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        @if($user->id === auth()->id())
                                            <i class="fas fa-circle text-green-500 mr-1"></i>Anda
                                        @else
                                            <i class="fas fa-circle text-gray-300 mr-1"></i>Aktif
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Registration Date -->
                            <td class="p-4">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                                    <div class="text-gray-500 text-xs">{{ $user->created_at->diffForHumans() }}</div>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="p-4">
                                <div class="flex flex-wrap gap-2">
                                    @if($user->id !== auth()->id())
                                        <!-- Edit User -->
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-yellow-50 text-yellow-600 text-xs font-medium rounded-lg hover:bg-yellow-100 transition-colors duration-300">
                                            <i class="fas fa-edit text-xs"></i>
                                            Edit
                                        </a>

                                        <!-- Toggle Role -->
                                        <form action="{{ route('admin.users.toggle-role', $user->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirmToggleRole(event, '{{ $user->name }}', '{{ $user->role }}')">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 text-xs font-medium rounded-lg hover:bg-blue-100 transition-colors duration-300">
                                                <i class="fas fa-exchange-alt text-xs"></i>
                                                {{ $user->role === 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}
                                            </button>
                                        </form>

                                        <!-- Delete User -->
                                        @if($user->role !== 'admin')
                                            <form action="{{ route('admin.users.delete', $user->id) }}"
                                                  method="POST"
                                                  class="inline"
                                                  onsubmit="return confirmDeleteUser(event, '{{ $user->name }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-600 text-xs font-medium rounded-lg hover:bg-red-100 transition-colors duration-300">
                                                    <i class="fas fa-trash text-xs"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-400 text-xs font-medium rounded-lg cursor-not-allowed">
                                            <i class="fas fa-user text-xs"></i>
                                            Anda
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-users text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">
                                    @if(request('search') || request('role'))
                                        Tidak ada pengguna yang sesuai
                                    @else
                                        Belum ada pengguna terdaftar
                                    @endif
                                </h3>
                                <p class="text-gray-500 mb-6">
                                    @if(request('search'))
                                        Tidak ditemukan pengguna dengan pencarian "{{ request('search') }}"
                                    @else
                                        Mulai dengan mendaftarkan pengguna pertama
                                    @endif
                                </p>
                                @if(request('search') || request('role'))
                                    <a href="{{ route('admin.users') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                        <i class="fas fa-redo"></i>
                                        Tampilkan Semua Pengguna
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
    @if($users->hasPages())
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-gray-500">
                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
            </div>
            <div class="flex items-center gap-2">
                @if($users->onFirstPage())
                    <span class="px-4 py-2 rounded-xl bg-gray-100 text-gray-400 cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                    </span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" 
                       class="px-4 py-2 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chevron-left mr-2"></i>Sebelumnya
                    </a>
                @endif
                
                <div class="flex items-center gap-1">
                    @php
                        $currentPage = $users->currentPage();
                        $lastPage = $users->lastPage();
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($lastPage, $currentPage + 2);
                    @endphp
                    
                    @if($startPage > 1)
                        <a href="{{ $users->url(1) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100">
                            1
                        </a>
                        @if($startPage > 2)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                    @endif
                    
                    @for($page = $startPage; $page <= $endPage; $page++)
                        <a href="{{ $users->url($page) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl {{ $currentPage === $page ? 'gradient-primary text-white' : 'bg-gray-50 text-gray-700 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    @endfor
                    
                    @if($endPage < $lastPage)
                        @if($endPage < $lastPage - 1)
                            <span class="px-2 text-gray-500">...</span>
                        @endif
                        <a href="{{ $users->url($lastPage) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100">
                            {{ $lastPage }}
                        </a>
                    @endif
                </div>
                
                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" 
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

        // Confirm toggle role
        function confirmToggleRole(event, userName, currentRole) {
            event.preventDefault();
            
            const newRole = currentRole === 'admin' ? 'user' : 'admin';
            const form = event.target;
            
            Swal.fire({
                title: 'Ubah Role Pengguna?',
                html: `Anda akan mengubah role <strong>${userName}</strong> dari <strong>${currentRole}</strong> menjadi <strong>${newRole}</strong>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#d33',
                confirmButtonText: `Ya, Ubah ke ${newRole}`,
                cancelButtonText: 'Batal',
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            
            return false;
        }

        // Confirm delete user
        function confirmDeleteUser(event, userName) {
            event.preventDefault();
            
            const form = event.target;
            
            Swal.fire({
                title: 'Hapus Pengguna?',
                html: `Anda akan menghapus pengguna <strong>${userName}</strong> secara permanen.<br><br>
                       <span class="text-sm text-red-600">
                           <i class="fas fa-exclamation-triangle mr-1"></i>
                           Semua barang dan bid milik pengguna ini juga akan dihapus!
                       </span>`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Selamanya',
                cancelButtonText: 'Batal',
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            
            return false;
        }

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