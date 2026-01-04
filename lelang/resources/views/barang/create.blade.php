@extends('layouts.app')

@section('title', 'Jual Barang - LelangPro')

@section('content')
<div class="min-h-[80vh] py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="gradient-primary inline-flex p-4 rounded-2xl mb-6">
                <i class="fas fa-gavel text-3xl text-white"></i>
            </div>
            <h1 class="brand-font text-4xl font-bold text-gray-900 mb-3">Lelang Barang Baru</h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Jual barang Anda dengan mudah dan aman di LelangPro. 
                Isi informasi barang secara detail untuk menarik lebih banyak penawar.
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 gradient-primary rounded-full flex items-center justify-center text-white font-bold">1</div>
                    <span class="font-semibold text-gray-900">Informasi Barang</span>
                </div>
                <div class="h-1 flex-1 bg-gray-200 mx-4"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">2</div>
                    <span class="font-semibold text-gray-500">Harga & Durasi</span>
                </div>
                <div class="h-1 flex-1 bg-gray-200 mx-4"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">3</div>
                    <span class="font-semibold text-gray-500">Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Form Header -->
            <div class="gradient-primary p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">Detail Barang</h2>
                        <p class="text-blue-100 text-sm mt-1">Isi semua informasi dengan benar</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                        <i class="fas fa-box-open text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8">
                @if($errors->any())
                    <div class="mb-8 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <div>
                                <p class="font-medium">Terdapat kesalahan dalam pengisian form</p>
                                <ul class="list-disc list-inside text-sm mt-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-8 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <div>
                                <p class="font-medium">Berhasil!</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data" id="barangForm">
                    @csrf

                    <!-- Basic Information -->
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                            Informasi Dasar
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Barang -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-tag text-gray-400 mr-2 text-sm"></i>
                                    Nama Barang
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-box text-gray-400"></i>
                                    </div>
                                    <input type="text" 
                                           name="nama_barang" 
                                           value="{{ old('nama_barang') }}" 
                                           placeholder="Contoh: Laptop Gaming Asus ROG Strix"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                  @error('nama_barang') border-red-500 focus:ring-red-500 @enderror"
                                           required
                                           autofocus>
                                    @error('nama_barang')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('nama_barang')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Buat nama yang menarik dan deskriptif</p>
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-folder text-gray-400 mr-2 text-sm"></i>
                                    Kategori
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-list text-gray-400"></i>
                                    </div>
                                    <select name="kategori"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                   @error('kategori') border-red-500 focus:ring-red-500 @enderror"
                                            required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="elektronik" {{ old('kategori') == 'elektronik' ? 'selected' : '' }}>Elektronik</option>
                                        <option value="kendaraan" {{ old('kategori') == 'kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                        <option value="properti" {{ old('kategori') == 'properti' ? 'selected' : '' }}>Properti</option>
                                        <option value="fashion" {{ old('kategori') == 'fashion' ? 'selected' : '' }}>Fashion</option>
                                        <option value="koleksi" {{ old('kategori') == 'koleksi' ? 'selected' : '' }}>Koleksi</option>
                                        <option value="olahraga" {{ old('kategori') == 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('kategori')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('kategori')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-star text-gray-400 mr-2 text-sm"></i>
                                    Kondisi Barang
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-check-circle text-gray-400"></i>
                                    </div>
                                    <select name="kondisi"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                   @error('kondisi') border-red-500 focus:ring-red-500 @enderror"
                                            required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="baru" {{ old('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="bekas" {{ old('kondisi') == 'bekas' ? 'selected' : '' }}>Bekas (Seperti Baru)</option>
                                        <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Bekas (Baik)</option>
                                        <option value="cukup" {{ old('kondisi') == 'cukup' ? 'selected' : '' }}>Bekas (Cukup)</option>
                                    </select>
                                    @error('kondisi')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('kondisi')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                            Deskripsi Detail
                        </h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-align-left text-gray-400 mr-2 text-sm"></i>
                                Deskripsi Barang
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fas fa-edit text-gray-400"></i>
                                </div>
                                <textarea name="deskripsi" 
                                          rows="5"
                                          placeholder="Jelaskan detail barang, spesifikasi, kondisi, dan alasan menjual. Semakin detail semakin menarik untuk penawar."
                                          class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                 @error('deskripsi') border-red-500 focus:ring-red-500 @enderror"
                                          required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-exclamation-circle text-red-500"></i>
                                    </div>
                                @enderror
                            </div>
                            @error('deskripsi')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <div class="mt-2 text-xs text-gray-500">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Tip: Sertakan spesifikasi lengkap, alasan menjual, dan kondisi aktual
                            </div>
                        </div>
                    </div>


                    <!-- Foto Barang - VERSION FIXED -->
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                            Foto Barang
                        </h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-camera text-gray-400 mr-2 text-sm"></i>
                                Unggah Foto Barang
                            </label>
                            
                            <!-- SIMPLE VERSION - Tanpa drag & drop kompleks -->
                            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center bg-gray-50">
                                <div class="flex flex-col items-center justify-center">
                                    <!-- Icon simple -->
                                    <div class="mb-4">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-blue-500"></i>
                                    </div>
                                    
                                    <!-- Text simple -->
                                    <p class="text-gray-700 font-medium mb-2">Unggah Foto Barang</p>
                                    <p class="text-sm text-gray-500 mb-4">Format: JPG, PNG (max 5MB)</p>
                                    
                                    <!-- File input yang lebih reliable -->
                                    <div class="relative">
                                        <input type="file" 
                                            name="foto" 
                                            id="foto"
                                            accept="image/*"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            required
                                            onchange="simplePreviewImage(this)">
                                        <button type="button" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-upload mr-2"></i>Pilih File
                                        </button>
                                    </div>
                                    
                                    <p class="text-xs text-gray-500 mt-3">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Foto pertama akan menjadi foto utama
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Image Preview Simple -->
                            <div id="imagePreview" class="mt-4 hidden">
                                <div class="inline-block relative">
                                    <img id="previewImage" 
                                        class="w-48 h-48 object-cover rounded-lg border-2 border-green-500">
                                    <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                                        <i class="fas fa-check mr-1"></i>Uploaded
                                    </div>
                                </div>
                                <p class="text-sm text-green-600 mt-2">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Foto siap digunakan
                                </p>
                            </div>
                            
                            @error('foto')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>


                    <!-- Harga & Durasi -->
                    <div class="mb-10">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                            Harga & Durasi Lelang
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Harga Awal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-money-bill-wave text-gray-400 mr-2 text-sm"></i>
                                    Harga Awal Lelang
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500">Rp</span>
                                    </div>
                                    <input type="number" 
                                           name="harga_awal" 
                                           value="{{ old('harga_awal') }}" 
                                           min="1000"
                                           step="1000"
                                           placeholder="1000000"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                  @error('harga_awal') border-red-500 focus:ring-red-500 @enderror"
                                           required>
                                    @error('harga_awal')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('harga_awal')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="mt-2 text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Harga awal yang wajar akan menarik lebih banyak penawar
                                </div>
                            </div>

                            <!-- Durasi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-clock text-gray-400 mr-2 text-sm"></i>
                                    Durasi Lelang
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-hourglass text-gray-400"></i>
                                        </div>
                                        <input type="number" 
                                               name="durasi" 
                                               value="{{ old('durasi', 1) }}" 
                                               min="1"
                                               max="30"
                                               placeholder="Durasi"
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                      @error('durasi') border-red-500 focus:ring-red-500 @enderror"
                                               required>
                                    </div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-calendar text-gray-400"></i>
                                        </div>
                                        <select name="durasi_type"
                                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300
                                                       @error('durasi_type') border-red-500 focus:ring-red-500 @enderror"
                                                required>
                                            <option value="hari" {{ old('durasi_type') == 'hari' ? 'selected' : '' }}>Hari</option>
                                            <option value="jam" {{ old('durasi_type') == 'jam' ? 'selected' : '' }}>Jam</option>
                                            <option value="menit" {{ old('durasi_type') == 'menit' ? 'selected' : '' }}>Menit</option>
                                        </select>
                                    </div>
                                </div>
                                @error('durasi')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                @error('durasi_type')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <div class="mt-2 text-xs text-gray-500">
                                    <i class="fas fa-lightbulb mr-1"></i>
                                    Durasi optimal: 3-7 hari untuk hasil terbaik
                                </div>
                            </div>
                        </div>
                        
                        <!-- Estimated End Time -->
                        <div id="endTimeEstimation" class="mt-6 p-4 bg-blue-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-calendar-alt text-blue-600"></i>
                                <div>
                                    <p class="font-medium text-blue-800">Perkiraan Waktu Berakhir:</p>
                                    <p class="text-sm text-blue-600" id="estimatedEndTime">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Submit -->
                    <div class="mb-8">
                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-file-contract text-blue-600"></i>
                                Syarat & Ketentuan
                            </h4>
                            <div class="space-y-3 text-sm text-gray-600">
                                <p>Dengan mengajukan lelang ini, Anda setuju dengan:</p>
                                <ul class="list-disc list-inside space-y-1 pl-2">
                                    <li>Menyediakan barang sesuai deskripsi</li>
                                    <li>Merespon penawaran dalam 24 jam</li>
                                    <li>Melakukan transaksi jika lelang berhasil</li>
                                    <li>Membayar fee platform 5% dari harga akhir</li>
                                </ul>
                            </div>
                        </div>

                        <label class="flex items-start mb-6">
                            <input type="checkbox" 
                                   name="terms" 
                                   class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1"
                                   required>
                            <span class="ml-3 text-sm text-gray-700">
                                Saya setuju dengan 
                                <a href="#" class="text-blue-600 hover:underline font-medium">Syarat & Ketentuan</a> 
                                dan 
                                <a href="#" class="text-blue-600 hover:underline font-medium">Kebijakan LelangPro</a>
                            </span>
                        </label>

                        <!-- Submit Button -->
                        <button type="submit" 
                                id="submitButton"
                                class="w-full gradient-primary text-white py-4 rounded-xl font-semibold text-lg hover:shadow-xl transition-all duration-300 hover:scale-[1.02] flex items-center justify-center gap-3">
                            <i class="fas fa-gavel"></i>
                            <span>Mulai Lelang Sekarang</span>
                        </button>
                        
                        <p class="text-center text-sm text-gray-500 mt-4">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Transaksi Anda aman dan terjamin
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-12 bg-gradient-to-r from-gray-50 to-blue-50 rounded-3xl p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Tips Jual Sukses</h2>
                    <p class="text-gray-600">Cara meningkatkan peluang barang cepat laku</p>
                </div>
                <div class="p-3 rounded-xl bg-white shadow-sm">
                    <i class="fas fa-chart-line text-3xl text-blue-600"></i>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <div class="w-12 h-12 gradient-primary rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-camera text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Foto Berkualitas</h3>
                    <p class="text-sm text-gray-600">Gunakan foto jelas dengan pencahayaan baik dari berbagai sudut</p>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <div class="w-12 h-12 gradient-secondary rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Deskripsi Detail</h3>
                    <p class="text-sm text-gray-600">Jelaskan spesifikasi lengkap dan kondisi barang secara jujur</p>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <div class="w-12 h-12 gradient-accent rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-tags text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Harga Kompetitif</h3>
                    <p class="text-sm text-gray-600">Tetapkan harga awal yang wajar sesuai dengan harga pasar</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Preview gambar
  window.simplePreviewImage = input => {
    const file = input.files[0];
    if (!file) return;

    if (file.size > 5 * 1024 * 1024) {
      alert('Ukuran maksimal 5MB');
      input.value = '';
      return;
    }

    if (!file.type.startsWith('image/')) {
      alert('File harus berupa gambar');
      input.value = '';
      return;
    }

    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('previewImage').src = e.target.result;
      document.getElementById('imagePreview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  };

  // Hitung perkiraan waktu akhir lelang
  const updateEndTime = () => {
    const durasi = document.querySelector('[name=durasi]');
    const tipe = document.querySelector('[name=durasi_type]');
    const output = document.getElementById('estimatedEndTime');

    if (!durasi || !tipe || !output) return;

    const nilai = parseInt(durasi.value);
    if (!nilai) {
      output.textContent = '-';
      return;
    }

    const end = new Date();
    if (tipe.value === 'hari') end.setDate(end.getDate() + nilai);
    if (tipe.value === 'jam') end.setHours(end.getHours() + nilai);
    if (tipe.value === 'menit') end.setMinutes(end.getMinutes() + nilai);

    output.textContent = end.toLocaleString('id-ID', {
      dateStyle: 'full',
      timeStyle: 'short'
    });
  };

  document.querySelector('[name=durasi]')?.addEventListener('input', updateEndTime);
  document.querySelector('[name=durasi_type]')?.addEventListener('change', updateEndTime);
  updateEndTime();

});
</script>
@endpush
@endsection