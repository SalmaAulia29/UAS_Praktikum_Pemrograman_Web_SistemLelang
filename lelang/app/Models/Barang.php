<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Barang extends Model
{
    protected $fillable = [
        'user_id',
        'nama_barang',
        'deskripsi',
        'kategori',           // TAMBAHKAN INI
        'kondisi',            // TAMBAHKAN INI
        'foto',               // Nama file: foto123.jpg
        'foto_path',          // Path lengkap: barang/2024/12/foto123.jpg
        'harga_awal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    // ==================== ACCESSOR UNTUK FOTO ====================
    // Method 1: Accessor modern Laravel 9+
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Prioritas 1: Jika ada foto_path lengkap
                if ($this->foto_path && Storage::disk('public')->exists($this->foto_path)) {
                    return Storage::url($this->foto_path);
                }
                
                // Prioritas 2: Jika hanya ada nama file, coba berbagai format
                if ($this->foto) {
                    // Coba path berdasarkan tanggal dibuat
                    $createdAt = $this->created_at ?? now();
                    $year = $createdAt->format('Y');
                    $month = $createdAt->format('m');
                    
                    $possiblePaths = [
                        "barang/{$year}/{$month}/{$this->foto}",
                        "barang/{$this->foto}",
                        "uploads/barang/{$this->foto}",
                        "barang/" . date('Y', strtotime($createdAt)) . "/" . date('m', strtotime($createdAt)) . "/{$this->foto}",
                        "public/barang/{$this->foto}",
                    ];
                    
                    foreach ($possiblePaths as $path) {
                        if (Storage::disk('public')->exists($path)) {
                            return Storage::url($path);
                        }
                    }
                }
                
                // Prioritas 3: URL default/placeholder
                return $this->getDefaultImageUrl();
            }
        );
    }

    // Method 2: Accessor untuk path storage (backup)
    protected function fotoStoragePath(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->foto_path) {
                    return $this->foto_path;
                }
                
                if ($this->foto) {
                    $createdAt = $this->created_at ?? now();
                    $year = $createdAt->format('Y');
                    $month = $createdAt->format('m');
                    return "barang/{$year}/{$month}/{$this->foto}";
                }
                
                return null;
            }
        );
    }

    // Method 3: Accessor untuk thumbnail
    protected function fotoThumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->foto_url;
            }
        );
    }

    // Method 4: Cek apakah foto ada di storage
    public function fotoExists()
    {
        if ($this->foto_path) {
            return Storage::disk('public')->exists($this->foto_path);
        }
        
        if ($this->foto) {
            $possiblePaths = [
                $this->foto_storage_path,
                "barang/{$this->foto}",
                "uploads/barang/{$this->foto}",
            ];
            
            foreach ($possiblePaths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    return true;
                }
            }
        }
        
        return false;
    }

    // Method 5: Dapatkan URL untuk berbagai kebutuhan
    public function getImageUrl($type = 'full')
    {
        $baseUrl = $this->foto_url;
        
        if ($type === 'thumbnail') {
            return $baseUrl . '?size=thumbnail';
        } elseif ($type === 'medium') {
            return $baseUrl . '?size=medium';
        }
        
        return $baseUrl;
    }

    // ==================== HELPER METHODS ====================
    
    /**
     * Dapatkan URL gambar default
     */
    private function getDefaultImageUrl()
    {
        // Coba beberapa lokasi default image
        $defaultImages = [
            'images/default-product.jpg',
            'images/default.jpg',
            'storage/images/default-product.jpg',
        ];
        
        foreach ($defaultImages as $image) {
            if (file_exists(public_path($image))) {
                return asset($image);
            }
        }
        
        // Fallback ke placeholder online
        return 'https://via.placeholder.com/400x300?text=No+Image+Available';
    }
    
    /**
     * Hapus foto dari storage
     */
    public function deleteFoto($updateDatabase = true)
    {
        if ($this->foto_path && Storage::disk('public')->exists($this->foto_path)) {
            Storage::disk('public')->delete($this->foto_path);
        }
        
        // Juga coba hapus berdasarkan nama file
        if ($this->foto) {
            $possiblePaths = [
                "barang/{$this->foto}",
                "uploads/barang/{$this->foto}",
            ];
            
            foreach ($possiblePaths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
        
        if ($updateDatabase) {
            $this->foto = null;
            $this->foto_path = null;
            $this->save();
        }
        
        return true;
    }

    // ==================== RELATIONSHIPS ====================
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function highestBid()
    {
        //return $this->hasOne(Bid::class)->ofMany('harga_bid', 'max');
        return $this->hasOne(Bid::class)->latestOfMany('harga_bid');
    }

    // ==================== BUSINESS LOGIC ====================
    
    public function isActive()
    {
        return $this->status === 'aktif' && Carbon::now()->lessThan($this->waktu_selesai);
    }

    public function updateStatus()
    {
        if (Carbon::now()->greaterThan($this->waktu_selesai) && $this->status === 'aktif') {
            if ($this->bids()->count() > 0) {
                $this->status = 'selesai';
            } else {
                $this->status = 'tidak_laku';
            }
            $this->save();
        }
        
        return $this;
    }
    
    /**
     * Hitung sisa waktu lelang
     */
    public function getRemainingTime()
    {
        if (!$this->isActive()) {
            return 'Lelang telah berakhir';
        }
        
        $now = Carbon::now();
        $end = Carbon::parse($this->waktu_selesai);
        
        $diff = $now->diff($end);
        
        if ($diff->days > 0) {
            return $diff->days . ' hari ' . $diff->h . ' jam';
        } elseif ($diff->h > 0) {
            return $diff->h . ' jam ' . $diff->i . ' menit';
        } else {
            return $diff->i . ' menit ' . $diff->s . ' detik';
        }
    }
    
    /**
     * Format harga dengan pemisah ribuan
     */
    public function getFormattedHarga()
    {
        return 'Rp ' . number_format($this->harga_awal, 0, ',', '.');
    }
    
    /**
     * Dapatkan harga tertinggi saat ini
     */
    public function getCurrentHighestBid()
    {
        $highest = $this->bids()->orderBy('harga_bid', 'desc')->first();
        return $highest ? $highest->harga_bid : $this->harga_awal;
    }
    
    /**
     * Format harga tertinggi
     */
    public function getFormattedHighestBid()
    {
        $highest = $this->getCurrentHighestBid();
        return 'Rp ' . number_format($highest, 0, ',', '.');
    }
    
    /**
     * Hitung jumlah penawar unik
     */
    public function getUniqueBiddersCount()
    {
        return $this->bids()->distinct('user_id')->count('user_id');
    }
    
    /**
     * Cek apakah user sudah bid
     */
    public function hasUserBid($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->bids()->where('user_id', $userId)->exists();
    }
    
    /**
     * Scope untuk barang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif')
                    ->where('waktu_selesai', '>', Carbon::now());
    }
    
    /**
     * Scope untuk barang berdasarkan kategori
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }
    
    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('nama_barang', 'like', '%' . $keyword . '%')
              ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
        });
    }
    
    /**
     * Scope untuk barang milik user
     */
    public function scopeMyItems($query, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $query->where('user_id', $userId);
    }
}