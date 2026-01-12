@extends('layouts.app')

@section('title', 'Profil Saya - LelangPro')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
        <p class="text-gray-600">Kelola informasi akun dan keamanan Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Sidebar Menu -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                <div class="p-6 text-center border-b border-gray-100 bg-gradient-to-br from-blue-50 to-purple-50">
                    <div class="mb-4 relative inline-block">
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                 class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md mx-auto relative z-10"
                                 alt="Profile Photo">
                        @else
                            <div class="w-24 h-24 gradient-secondary rounded-full flex items-center justify-center text-4xl text-white shadow-md border-4 border-white mx-auto relative z-10">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-md -z-0 transform scale-110"></div>
                    </div>
                    <h3 class="font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    <div class="mt-2">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wide">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
                
                <nav class="p-2 space-y-1">
                    <button onclick="switchTab('overview')" id="btn-overview" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 bg-blue-50 text-blue-600 font-medium tab-btn">
                        <i class="fas fa-id-card w-6 text-center"></i>
                        Ringkasan
                    </button>
                    <button onclick="switchTab('edit')" id="btn-edit" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 tab-btn">
                        <i class="fas fa-user-edit w-6 text-center"></i>
                        Edit Profil
                    </button>
                    <button onclick="switchTab('password')" id="btn-password" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 tab-btn">
                        <i class="fas fa-lock w-6 text-center"></i>
                        Ganti Password
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-xl flex items-center gap-3 transition-all duration-200 text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt w-6 text-center"></i>
                            Keluar
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- Content Area -->
        <div class="lg:col-span-9">
            <!-- Tab: Overview -->
            <div id="tab-overview" class="tab-content">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        Informasi Akun
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Lengkap</label>
                            <p class="text-lg font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Email</label>
                            <p class="text-lg font-medium text-gray-900">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nomor Handphone</label>
                            <p class="text-lg font-medium text-gray-900">{{ auth()->user()->no_hp }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Bergabung Sejak</label>
                            <p class="text-lg font-medium text-gray-900">{{ auth()->user()->created_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-8">
                        <h3 class="font-bold text-gray-900 mb-4">Statistik Saya</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">Barang Dilelang</span>
                                </div>
                                <span class="text-2xl font-bold text-blue-600">{{ auth()->user()->barangs->count() }}</span>
                            </div>
                            
                            <div class="p-4 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                                        <i class="fas fa-gavel"></i>
                                    </div>
                                    <span class="text-gray-700 font-medium">Total Bid</span>
                                </div>
                                <span class="text-2xl font-bold text-purple-600">{{ auth()->user()->bids->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab: Edit -->
            <div id="tab-edit" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-user-edit text-blue-500"></i>
                        Edit Data Diri
                    </h2>

                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Photo Upload -->
                            <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div class="relative group cursor-pointer w-20 h-20">
                                    @if(auth()->user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                             class="w-full h-full rounded-full object-cover border-2 border-white shadow-sm" id="preview-photo">
                                    @else
                                        <div class="w-full h-full gradient-secondary rounded-full flex items-center justify-center text-2xl text-white shadow-sm border-2 border-white" id="preview-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-camera text-white"></i>
                                    </div>
                                    <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this)">
                                </div>
                                <div>
                                    <label class="block font-medium text-gray-900">Foto Profil</label>
                                    <p class="text-sm text-gray-500">Klik foto untuk mengganti. Max 1MB (JPG/PNG)</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ auth()->user()->name }}" 
                                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" value="{{ auth()->user()->email }}" disabled
                                           class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 text-gray-500 cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Handphone</label>
                                    <input type="text" name="no_hp" value="{{ auth()->user()->no_hp }}" 
                                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                                </div>
                            </div>
                            
                            <div class="pt-4 flex justify-end">
                                <button type="submit" class="gradient-primary text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tab: Password -->
            <div id="tab-password" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-lock text-red-500"></i>
                        Ganti Password
                    </h2>

                    <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl mb-6 flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle mt-1"></i>
                        <p class="text-sm">Pastikan Anda menggunakan password yang kuat dan unik untuk menjaga keamanan akun Anda. Simpan password baru Anda dengan aman.</p>
                    </div>

                    <form action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        <div class="space-y-5 max-w-lg">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                                <div class="relative">
                                    <input type="password" name="current_password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                                    <i class="fas fa-key absolute right-4 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            
                            <div class="pt-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <div class="relative">
                                    <input type="password" name="new_password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                                    <i class="fas fa-lock absolute right-4 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <div class="relative">
                                    <input type="password" name="new_password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none">
                                    <i class="fas fa-check absolute right-4 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="gradient-accent text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-shield-alt mr-2"></i> Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tabId) {
        // Toggle Buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-blue-50', 'text-blue-600', 'font-medium');
            btn.classList.add('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
        });
        
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.classList.remove('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
        activeBtn.classList.add('bg-blue-50', 'text-blue-600', 'font-medium');

        // Toggle Content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        document.getElementById('tab-' + tabId).classList.remove('hidden');
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const placeholder = document.getElementById('preview-placeholder');
                if(placeholder) placeholder.style.display = 'none';

                let img = document.getElementById('preview-photo');
                if (!img) {
                    // If no image exists yet, recreate the tag inside the parent
                    img = document.createElement('img');
                    img.id = 'preview-photo';
                    img.className = 'w-full h-full rounded-full object-cover border-2 border-white shadow-sm';
                    input.parentElement.insertBefore(img, input.parentElement.firstChild);
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
