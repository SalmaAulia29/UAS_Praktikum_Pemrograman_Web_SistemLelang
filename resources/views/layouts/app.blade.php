<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Sistem Lelang Online')</title>
    
    <!-- Preload resources untuk mencegah blank screen -->
    <link rel="preload" href="https://cdn.tailwindcss.com" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Tailwind CSS dengan CDN stabil -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Fix CSS untuk mencegah blank screen -->
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            important: false, // Hindari !important untuk performance
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                    }
                }
            },
            corePlugins: {
                preflight: true,
            }
        }
    </script>
</head>
<body>
    <!-- Error Boundary -->
    <div id="error-boundary" class="error-boundary">
        <div class="text-red-500 text-6xl mb-4">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h2 class="text-2xl font-bold mb-2">Terjadi Kesalahan</h2>
        <p class="text-gray-600 mb-4">Halaman mengalami masalah. Silakan refresh.</p>
        <button onclick="location.reload()" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
            <i class="fas fa-redo mr-2"></i>Refresh Halaman
        </button>
    </div>

    <!-- Loading Indicator -->
    <div id="content-loading"></div>

    <!-- Navbar Premium -->
    <nav class="navbar-shadow bg-white/95 backdrop-blur-sm sticky top-0 z-50">
        <div class="@hasSection('full-width') w-full px-6 @else max-w-7xl px-4 sm:px-6 lg:px-8 @endif mx-auto">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group" id="logo-link">
                        <div class="gradient-primary text-white p-2 rounded-xl shadow-lg transition-transform duration-300">
                            <i class="fas fa-gavel text-xl"></i>
                        </div>
                        <div>
                            <span class="brand-font text-2xl font-bold text-gray-900">LELANG</span>
                            <span class="brand-font text-2xl font-bold gradient-primary bg-clip-text text-transparent">PRO</span>
                            <div class="h-1 w-12 gradient-primary rounded-full mt-1"></div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8" id="desktop-menu">
                    <a href="{{ route('home') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 flex items-center space-x-2 group nav-link">
                        <div class="gradient-primary p-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <i class="fas fa-home text-white text-sm"></i>
                        </div>
                        <span class="relative">
                            Beranda
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 gradient-primary transition-all duration-300 group-hover:w-full"></span>
                        </span>
                    </a>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="gradient-secondary text-white px-5 py-2.5 rounded-xl font-semibold flex items-center space-x-3 shadow-lg hover:shadow-xl transition-all duration-300 nav-link">
                                <i class="fas fa-user-shield"></i>
                                <span>Admin</span>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>

                            <div class="relative group" id="admin-dropdown">
                                <button class="text-gray-700 hover:text-blue-600 font-medium flex items-center space-x-2 nav-button">
                                    <div class="p-2 rounded-lg bg-gradient-to-br from-blue-50 to-purple-50">
                                        <i class="fas fa-tools text-blue-600"></i>
                                    </div>
                                    <span>Aktivitas</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                                </button>

                                <div class="absolute left-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl hidden border border-gray-100 overflow-hidden group-hover:block">
                                    <div class="gradient-primary px-4 py-4 text-white">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-cogs text-xl"></i>
                                            <span class="font-semibold">Admin Panel</span>
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        <a href="{{ route('admin.barangs') }}"
                                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition nav-link">
                                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-3">
                                                <i class="fas fa-box"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Kelola Barang</p>
                                                <p class="text-xs text-gray-500">Tambah & edit lelang</p>
                                            </div>
                                        </a>

                                        <a href="{{ route('admin.users') }}"
                                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 rounded-lg transition nav-link">
                                            <div class="p-2 rounded-lg bg-purple-100 text-purple-600 mr-3">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Kelola User</p>
                                                <p class="text-xs text-gray-500">Manajemen akun</p>
                                            </div>
                                        </a>

                                        <a href="{{ route('admin.reports') }}"
                                        class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 rounded-lg transition nav-link">
                                            <div class="p-2 rounded-lg bg-green-100 text-green-600 mr-3">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium">Laporan</p>
                                                <p class="text-xs text-gray-500">PDF / Excel / CSV</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Menu Utama Pengguna -->
                            <div class="flex items-center space-x-8">
                                <a href="{{ route('barang.create') }}" 
                                   class="gradient-accent text-white px-5 py-2.5 rounded-xl font-semibold flex items-center space-x-3 shadow-lg hover:shadow-xl transition-all duration-300 pulse-animation nav-link">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Jual Barang</span>
                                    <i class="fas fa-rocket text-sm"></i>
                                </a>

                                <div class="relative group" id="activity-dropdown">
                                    <button class="text-gray-700 hover:text-blue-600 font-medium flex items-center space-x-2 nav-button">
                                        <div class="p-2 rounded-lg bg-gradient-to-br from-blue-50 to-purple-50">
                                            <i class="fas fa-box text-blue-600"></i>
                                        </div>
                                        <span>Aktivitas Saya</span>
                                        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                                    </button>
                                    <div class="absolute left-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl hidden border border-gray-100 overflow-hidden" id="activity-menu">
                                        <div class="gradient-primary px-4 py-4 text-white">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-chart-line text-xl"></i>
                                                <span class="font-semibold">Dashboard Aktivitas</span>
                                            </div>
                                        </div>
                                        <div class="p-2">
                                            <a href="{{ route('barang.myitems') }}" 
                                               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 rounded-lg transition-all duration-200 group/item nav-link">
                                                <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-3 transition-transform">
                                                    <i class="fas fa-list"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium">Barang Saya</p>
                                                    <p class="text-xs text-gray-500">Kelola lelang Anda</p>
                                                </div>
                                            </a>
                                            <a href="{{ route('bid.mybids') }}" 
                                               class="flex items-center px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 rounded-lg transition-all duration-200 group/item nav-link">
                                                <div class="p-2 rounded-lg bg-purple-100 text-purple-600 mr-3 transition-transform">
                                                    <i class="fas fa-gavel"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium">Tawaran Saya</p>
                                                    <p class="text-xs text-gray-500">Pantau penawaran</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- User Profile -->
                        <div class="relative group" id="user-dropdown">
                            <button class="flex items-center space-x-3 bg-gradient-to-r from-gray-50 to-white px-4 py-2 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 nav-button">
                                <div class="gradient-primary text-white p-2 rounded-full shadow-md">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-gray-900 text-sm">{{ Str::limit(auth()->user()->name, 12) }}</p>
                                    <p class="text-xs text-gray-500">Pengguna {{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>
                            <div class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl hidden border border-gray-100 overflow-hidden" id="user-menu">
                                <div class="gradient-primary p-5 text-white">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                                            <i class="fas fa-user-circle text-2xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-lg">{{ auth()->user()->name }}</p>
                                            <p class="text-blue-100 text-sm">{{ auth()->user()->email }}</p>
                                            <div class="flex items-center space-x-2 mt-2">
                                                <span class="bg-white/30 px-2 py-1 rounded-full text-xs">Member</span>
                                                <span class="text-xs">Bergabung {{ auth()->user()->created_at->format('M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-4">
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-3 rounded-xl text-center">
                                            <p class="text-2xl font-bold text-blue-600">{{ auth()->user()->barangs()->where('status', 'aktif')->count() }}</p>
                                            <p class="text-xs text-gray-600">Lelang Aktif</p>
                                        </div>
                                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-3 rounded-xl text-center">
                                            <p class="text-2xl font-bold text-purple-600">{{ auth()->user()->bids()->count() }}</p>
                                            <p class="text-xs text-gray-600">Tawaran</p>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-200 group/item nav-link">
                                            <i class="fas fa-cog text-gray-400 mr-3"></i>
                                            <span>Profil Saya</span>
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 group/item nav-button">
                                                <i class="fas fa-sign-out-alt mr-3"></i>
                                                <span>Keluar</span>
                                                <i class="fas fa-arrow-right ml-auto text-sm opacity-0 group-hover/item:opacity-100 transition-opacity"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Menu untuk Pengunjung -->
                        <div class="flex items-center space-x-6">
                            <a href="{{ route('login') }}" 
                               class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 flex items-center space-x-2 group nav-link">
                                <div class="p-2 rounded-lg bg-gradient-to-br from-blue-50 to-purple-50 transition-transform">
                                    <i class="fas fa-sign-in-alt text-blue-600"></i>
                                </div>
                                <span>Masuk</span>
                            </a>
                            <a href="{{ route('register') }}"
                               class="gradient-primary text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 group nav-link">
                                <span class="flex items-center space-x-2">
                                    <span>Daftar Gratis</span>
                                    <i class="fas fa-arrow-right text-sm transition-transform"></i>
                                </span>
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button id="mobile-menu-button" class="gradient-primary text-white p-2.5 rounded-xl shadow-md nav-button">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="lg:hidden hidden bg-white mt-3 rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="p-5">
                    @auth
                        <!-- User Info Mobile -->
                        <div class="gradient-primary p-4 rounded-xl text-white mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="bg-white/20 p-3 rounded-full">
                                    <i class="fas fa-user-circle text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold">{{ auth()->user()->name }}</p>
                                    <p class="text-blue-100 text-sm">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Menu Items -->
                    <div class="space-y-4">
                        <a href="{{ route('home') }}" 
                           class="flex items-center justify-between p-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200 nav-link">
                            <div class="flex items-center space-x-3">
                                <div class="gradient-primary p-2 rounded-lg">
                                    <i class="fas fa-home text-white text-sm"></i>
                                </div>
                                <span class="font-medium">Beranda</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                        </a>

                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="flex items-center justify-between p-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200 nav-link">
                                    <div class="flex items-center space-x-3">
                                        <div class="gradient-secondary p-2 rounded-lg">
                                            <i class="fas fa-user-shield text-white text-sm"></i>
                                        </div>
                                        <span class="font-medium">Admin Panel</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                </a>
                            @else
                                <a href="{{ route('barang.create') }}" 
                                   class="flex items-center justify-between p-3 rounded-xl gradient-accent text-white shadow-md nav-link">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-plus-circle"></i>
                                        <span class="font-medium">Jual Barang</span>
                                    </div>
                                    <i class="fas fa-rocket text-sm"></i>
                                </a>
                                
                                <a href="{{ route('barang.myitems') }}" 
                                   class="flex items-center justify-between p-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200 nav-link">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-blue-100 p-2 rounded-lg">
                                            <i class="fas fa-box text-blue-600"></i>
                                        </div>
                                        <span class="font-medium">Barang Saya</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                </a>
                                
                                <a href="{{ route('bid.mybids') }}" 
                                   class="flex items-center justify-between p-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200 nav-link">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-purple-100 p-2 rounded-lg">
                                            <i class="fas fa-gavel text-purple-600"></i>
                                        </div>
                                        <span class="font-medium">Tawaran Saya</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                </a>
                            @endif
                        @endif
                    </div>

                    @auth
                        <div class="border-t mt-6 pt-6">
                            <form method="POST" action="{{ route('logout') }}" id="mobile-logout-form">
                                @csrf
                                <button type="submit"
                                    class="flex items-center justify-center w-full p-3 rounded-xl bg-gradient-to-r from-red-50 to-red-100 text-red-600 hover:from-red-100 hover:to-red-200 transition-all duration-200 nav-button">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    <span class="font-medium">Keluar</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-3 mt-6">
                            <a href="{{ route('login') }}" 
                               class="p-3 rounded-xl border border-gray-200 text-center hover:border-blue-500 hover:text-blue-600 transition-all duration-200 nav-link">
                                <span class="font-medium">Masuk</span>
                            </a>
                            <a href="{{ route('register') }}"
                               class="gradient-primary text-white p-3 rounded-xl text-center shadow-md hover:shadow-lg transition-all duration-200 nav-link">
                                <span class="font-medium">Daftar</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 space-y-4" id="alerts-container">
        @if(session('success'))
            <div class="gradient-accent text-white p-4 rounded-2xl shadow-xl animate-slideIn alert-message">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 p-2 rounded-full">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-lg">Sukses!</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                    <button class="text-white/80 hover:text-white alert-close">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gradient-to-r from-red-500 to-pink-600 text-white p-4 rounded-2xl shadow-xl animate-slideIn alert-message">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 p-2 rounded-full">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-lg">Peringatan!</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                    <button class="text-white/80 hover:text-white alert-close">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- Content Area -->
    <main class="@hasSection('full-width') w-full px-6 @else max-w-7xl px-4 sm:px-6 lg:px-8 @endif mx-auto py-8 flex-1" id="main-content">
        <!-- Breadcrumb -->
        @hasSection('breadcrumb')
            <div class="mb-8">
                @yield('breadcrumb')
            </div>
        @endif
        
        <!-- Main Content -->
        <div class="@hasSection('sidebar') grid grid-cols-1 lg:grid-cols-4 gap-8 @endif">
            @hasSection('sidebar')
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24 border border-gray-100">
                        @yield('sidebar')
                    </div>
                </aside>
                <div class="lg:col-span-3">
                    @yield('content')
                </div>
            @else
                <div class="w-full">
                    @yield('content')
                </div>
            @endif
        </div>
    </main>

    <!-- Footer Premium -->
    <footer class="gradient-footer text-white mt-16">
        <div class="@hasSection('full-width') w-full px-6 @else max-w-7xl px-4 sm:px-6 lg:px-8 @endif mx-auto pt-16">
            <div class="bg-gradient-to-r from-blue-900/50 to-purple-900/50 rounded-3xl p-8 mb-12 shadow-2xl border border-white/10">
                <div class="max-w-3xl mx-auto text-center">
                    <div class="gradient-primary inline-flex p-3 rounded-2xl mb-4 float-animation">
                        <i class="fas fa-envelope-open-text text-2xl"></i>
                    </div>
                    <h2 class="brand-font text-3xl font-bold mb-4">Tetap Terinformasi</h2>
                    <p class="text-gray-300 mb-6 text-lg">Dapatkan notifikasi lelang eksklusif dan penawaran spesial langsung di inbox Anda.</p>
                    <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto" id="newsletter-form">
                        <input type="email" placeholder="Alamat email Anda" 
                               class="flex-1 px-6 py-4 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" 
                                class="gradient-secondary text-white px-8 py-4 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 nav-button">
                            <span class="flex items-center justify-center space-x-2">
                                <span>Berlangganan</span>
                                <i class="fas fa-paper-plane"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="@hasSection('full-width') w-full px-6 @else max-w-7xl px-4 sm:px-6 lg:px-8 @endif mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10 pb-12">
                <!-- Brand Column -->
                <div class="lg:col-span-1">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="gradient-primary text-white p-3 rounded-xl shadow-lg">
                            <i class="fas fa-gavel text-xl"></i>
                        </div>
                        <div>
                            <h2 class="brand-font text-2xl font-bold">LELANG<span class="text-blue-300">PRO</span></h2>
                            <p class="text-xs text-blue-300">Platform Lelang Premium</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Platform lelang online terdepan dengan keamanan terjamin dan pengalaman pengguna premium. 
                        Bergabunglah dengan komunitas pelelangan terbesar di Indonesia.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-white/10 p-3 rounded-xl hover:bg-white/20 transition-all duration-300 nav-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-white/10 p-3 rounded-xl hover:bg-white/20 transition-all duration-300 nav-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-white/10 p-3 rounded-xl hover:bg-white/20 transition-all duration-300 nav-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-white/10 p-3 rounded-xl hover:bg-white/20 transition-all duration-300 nav-link">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold mb-6 flex items-center">
                        <span class="h-1 w-8 gradient-primary rounded-full mr-3"></span>
                        Menu Utama
                    </h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-all duration-300 flex items-center group nav-link">
                                <i class="fas fa-chevron-right text-xs mr-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-all duration-300 flex items-center group nav-link">
                                <i class="fas fa-chevron-right text-xs mr-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Jelajahi Barang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('guide') }}" class="text-gray-300 hover:text-white transition-all duration-300 flex items-center group nav-link">
                                <i class="fas fa-chevron-right text-xs mr-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Cara Berlelang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('guide') }}" class="text-gray-300 hover:text-white transition-all duration-300 flex items-center group nav-link">
                                <i class="fas fa-chevron-right text-xs mr-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                Panduan Pengguna
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h3 class="text-xl font-bold mb-6 flex items-center">
                        <span class="h-1 w-8 gradient-secondary rounded-full mr-3"></span>
                        Kategori Populer
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="#" class="bg-white/5 p-4 rounded-xl hover:bg-white/10 transition-all duration-300 group nav-link">
                            <div class="flex items-center space-x-3">
                                <div class="gradient-primary p-2 rounded-lg">
                                    <i class="fas fa-tv text-sm"></i>
                                </div>
                                <span class="group-hover:text-white transition-colors">Elektronik</span>
                            </div>
                        </a>
                        <a href="#" class="bg-white/5 p-4 rounded-xl hover:bg-white/10 transition-all duration-300 group nav-link">
                            <div class="flex items-center space-x-3">
                                <div class="gradient-secondary p-2 rounded-lg">
                                    <i class="fas fa-car text-sm"></i>
                                </div>
                                <span class="group-hover:text-white transition-colors">Kendaraan</span>
                            </div>
                        </a>
                        <a href="#" class="bg-white/5 p-4 rounded-xl hover:bg-white/10 transition-all duration-300 group nav-link">
                            <div class="flex items-center space-x-3">
                                <div class="gradient-accent p-2 rounded-lg">
                                    <i class="fas fa-home text-sm"></i>
                                </div>
                                <span class="group-hover:text-white transition-colors">Properti</span>
                            </div>
                        </a>
                        <a href="#" class="bg-white/5 p-4 rounded-xl hover:bg-white/10 transition-all duration-300 group nav-link">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-2 rounded-lg">
                                    <i class="fas fa-gem text-sm"></i>
                                </div>
                                <span class="group-hover:text-white transition-colors">Koleksi</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-xl font-bold mb-6 flex items-center">
                        <span class="h-1 w-8 gradient-accent rounded-full mr-3"></span>
                        Hubungi Kami
                    </h3>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="gradient-primary p-3 rounded-xl">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium">Email Support</p>
                                <a href="mailto:support@lelangpro.com" class="text-blue-300 hover:text-white transition-colors nav-link">
                                    support@lelangpro.com
                                </a>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="gradient-secondary p-3 rounded-xl">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium">Telepon</p>
                                <a href="tel:+622112345678" class="text-blue-300 hover:text-white transition-colors nav-link">
                                    (021) 1234-5678
                                </a>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="gradient-accent p-3 rounded-xl">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium">Kantor Pusat</p>
                                <p class="text-gray-300">Gedung LelangPro, Jl. Jayaraga No. 123<br>Garut 44191, Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-white/10 pt-8 pb-8">
                <div class="flex flex-col lg:flex-row justify-between items-center space-y-6 lg:space-y-0">
                    <div>
                        <p class="text-gray-400 text-sm">
                            &copy; 2025 <span class="text-white font-semibold">LelangPro</span> - Platform Lelang Online Premium. 
                            Hak Cipta Dilindungi.
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap justify-center gap-6">
                        <a href="{{ route('guide') }}" class="text-gray-400 hover:text-white text-sm transition-colors nav-link">Kebijakan Privasi</a>
                        <a href="{{ route('guide') }}" class="text-gray-400 hover:text-white text-sm transition-colors nav-link">Syarat Layanan</a>
                        <a href="{{ route('guide') }}" class="text-gray-400 hover:text-white text-sm transition-colors nav-link">FAQ</a>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-400 text-sm">Dipercaya oleh:</span>
                        <div class="flex space-x-2">
                            <div class="bg-white/10 p-2 rounded-lg">
                                <i class="fas fa-shield-alt text-blue-300"></i>
                            </div>
                            <div class="bg-white/10 p-2 rounded-lg">
                                <i class="fas fa-lock text-green-300"></i>
                            </div>
                            <div class="bg-white/10 p-2 rounded-lg">
                                <i class="fas fa-award text-yellow-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Action Button -->
    @auth
        @if(auth()->user()->role !== 'admin')
            <a href="{{ route('barang.create') }}" 
               class="fixed bottom-8 right-8 gradient-primary text-white p-5 rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 z-40 card-hover float-animation group nav-link"
               id="fab-button">
                <i class="fas fa-plus text-2xl"></i>
                <span class="absolute right-16 bg-gray-900 text-white px-3 py-2 rounded-lg text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                    Jual Barang
                </span>
            </a>
        @endif
    @endauth


    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // Toggle mobile menu
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.onclick = () => menu.classList.toggle('hidden');
        }

        // Dropdowns
        ['user', 'activity'].forEach(name => {
            const wrap = document.getElementById(name + '-dropdown');
            const list = document.getElementById(name + '-menu');
            if (!wrap || !list) return;

            wrap.onclick = e => {
                e.stopPropagation();
                list.classList.toggle('hidden');
            };

            document.onclick = () => list.classList.add('hidden');
        });

        // Auto hide alert
        setTimeout(() => {
            document.querySelectorAll('.alert-message')
                .forEach(el => el.remove());
        }, 5000);

    });
    </script>

    @stack('scripts')
</body>
</html>