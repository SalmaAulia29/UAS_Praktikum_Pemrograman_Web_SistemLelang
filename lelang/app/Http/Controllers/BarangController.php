<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'aktif');
        
        $query = Barang::with(['user', 'highestBid.user', 'bids'])
            ->where('status', $status);

        // Filter kategori jika ada
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter search jika ada
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        $barangs = $query->orderBy('created_at', 'desc')
            ->paginate(12);

        // Update status untuk semua barang
        foreach ($barangs as $barang) {
            $barang->updateStatus();
        }

        // Hitung stats untuk tampilan
        $totalBarangs = Barang::where('status', $status)->count();
        $activeBarangs = Barang::where('status', 'aktif')->count();
        $totalUsers = \App\Models\User::count();

        return view('barang.index', compact('barangs', 'status', 'totalBarangs', 'activeBarangs', 'totalUsers'));
    }

    /**
     * Menampilkan detail barang
     */
    public function show($id)
    {
        $barang = Barang::with(['user', 'bids.user'])->findOrFail($id);
        $barang->updateStatus();
        
        $highestBid = $barang->bids()->orderBy('harga_bid', 'desc')->first();
        $bidCount = $barang->bids()->distinct('user_id')->count('user_id');
        
        // Get related items (same category)
        $relatedItems = Barang::where('kategori', $barang->kategori)
            ->where('id', '!=', $barang->id)
            ->where('status', 'aktif')
            ->with(['highestBid'])
            ->latest()
            ->take(4)
            ->get();
        
        return view('barang.show', compact('barang', 'highestBid', 'bidCount', 'relatedItems'));
    }

    /**
     * Menampilkan form tambah barang
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Menyimpan barang baru (FIXED GAMBAR PROBLEM)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|in:elektronik,kendaraan,properti,fashion,koleksi,olahraga,lainnya',
            'kondisi' => 'required|string|in:baru,bekas,baik,cukup',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'harga_awal' => 'required|numeric|min:1000',
            'durasi' => 'required|integer|min:1|max:30',
            'durasi_type' => 'required|in:menit,jam,hari',
            'terms' => 'required|accepted',
        ]);

        // ==================== FIX UNTUK GAMBAR ====================
        $fotoName = null;
        $fotoPath = null;
        
        if ($request->hasFile('foto')) {
            try {
                $file = $request->file('foto');
                
                // 1. Generate nama file yang unik
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fotoName = time() . '_' . Str::slug($originalName) . '_' . uniqid() . '.' . $extension;
                
                // 2. Simpan ke folder yang terstruktur
                $year = date('Y');
                $month = date('m');
                $folderPath = "barang/{$year}/{$month}";
                
                // 3. Simpan dengan disk 'public' (otomatis ke storage/app/public)
                $fotoPath = $file->storeAs($folderPath, $fotoName, 'public');
                
                // Debug log
                \Log::info('Foto disimpan:', [
                    'nama_file' => $fotoName,
                    'path' => $fotoPath,
                    'full_path' => storage_path('app/public/' . $fotoPath),
                    'url_akses' => asset('storage/' . $fotoPath)
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Error menyimpan foto: ' . $e->getMessage());
                return back()->with('error', 'Gagal menyimpan gambar: ' . $e->getMessage())->withInput();
            }
        }
        // ==================== END FIX GAMBAR ====================

        // Hitung waktu selesai
        $durasi = (int) $request->durasi;
        $waktuMulai = Carbon::now();

        switch ($request->durasi_type) {
            case 'menit':
                $waktuSelesai = $waktuMulai->copy()->addMinutes($durasi);
                break;
            case 'jam':
                $waktuSelesai = $waktuMulai->copy()->addHours($durasi);
                break;
            case 'hari':
                $waktuSelesai = $waktuMulai->copy()->addDays($durasi);
                break;
            default:
                $waktuSelesai = $waktuMulai->copy()->addHours($durasi);
        }

        try {
            $barang = Barang::create([
                'user_id' => auth()->id(),
                'nama_barang' => $request->nama_barang,
                'deskripsi' => $request->deskripsi,
                'kategori' => $request->kategori,
                'kondisi' => $request->kondisi,
                'foto' => $fotoName,           // Simpan nama file saja
                'foto_path' => $fotoPath,      // Simpan path lengkap (folder/year/month/filename)
                'harga_awal' => $request->harga_awal,
                'waktu_mulai' => $waktuMulai,
                'waktu_selesai' => $waktuSelesai,
                'status' => 'aktif',
            ]);

            \Log::info('Barang berhasil dibuat:', [
                'id' => $barang->id,
                'nama' => $barang->nama_barang,
                'foto_url' => $barang->foto_url
            ]);

            return redirect()->route('barang.myitems')->with('success', 'Barang berhasil dilelang! Kini barang Anda dapat dilihat oleh semua pengguna.');

        } catch (\Exception $e) {
            \Log::error('Error membuat barang: ' . $e->getMessage());
            
            // Hapus foto jika barang gagal dibuat
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            
            return back()->with('error', 'Gagal menyimpan barang: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan barang milik user
     */
    public function myItems(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        
        $query = Barang::with(['bids.user'])
            ->where('user_id', auth()->id());

        // Filter search jika ada
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan status jika ada
        if ($status) {
            $query->where('status', $status);
        }

        $barangs = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        // Update status untuk semua barang
        foreach ($barangs as $barang) {
            $barang->updateStatus();
        }

        // Hitung stats untuk tampilan
        $totalBarangs = auth()->user()->barangs()->count();
        $activeBarangs = auth()->user()->barangs()->where('status', 'aktif')->count();
        $completedBarangs = auth()->user()->barangs()->where('status', 'selesai')->count();
        $soldBarangs = auth()->user()->barangs()
            ->where('status', 'selesai')
            ->whereHas('bids')
            ->count();
        
        // Hitung total revenue (hanya dari barang yang terjual)
        $totalRevenue = auth()->user()->barangs()
            ->where('status', 'selesai')
            ->whereHas('bids')
            ->with(['bids' => function($query) {
                $query->orderBy('harga_bid', 'desc')->limit(1);
            }])
            ->get()
            ->sum(function($barang) {
                if ($barang->bids->isNotEmpty()) {
                    return $barang->bids->first()->harga_bid * 0.95; // Minus 5% fee
                }
                return 0;
            });

        return view('barang.myitems', compact(
            'barangs', 
            'totalBarangs', 
            'activeBarangs', 
            'completedBarangs', 
            'soldBarangs', 
            'totalRevenue',
            'search'
        ));
    }

    /**
     * Hapus barang
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Authorization check
        if ($barang->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if barang has bids
        if ($barang->bids()->count() > 0) {
            return back()->with('error', 'Tidak bisa menghapus barang yang sudah ada penawaran!');
        }

        // Check if barang is active
        if ($barang->status === 'aktif') {
            return back()->with('error', 'Tidak bisa menghapus barang yang sedang aktif dilelang!');
        }

        try {
            // Delete foto jika ada
            if ($barang->foto_path && Storage::disk('public')->exists($barang->foto_path)) {
                Storage::disk('public')->delete($barang->foto_path);
            }
            
            // Delete barang
            $barang->delete();

            return redirect()->route('barang.myitems')->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error menghapus barang: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus barang: ' . $e->getMessage());
        }
    }

    /**
     * DEBUG: Test gambar barang
     */
    public function debugImage($id)
    {
        $barang = Barang::findOrFail($id);
        
        $data = [
            'barang_id' => $barang->id,
            'nama_barang' => $barang->nama_barang,
            'foto_field' => $barang->foto,
            'foto_path_field' => $barang->foto_path,
            'foto_url_method' => $barang->foto_url,
            'storage_exists' => $barang->foto_path ? 
                Storage::disk('public')->exists($barang->foto_path) : false,
            'asset_url' => $barang->foto_path ? asset('storage/' . $barang->foto_path) : null,
            'storage_url' => $barang->foto_path ? Storage::url($barang->foto_path) : null,
            'storage_full_path' => $barang->foto_path ? 
                storage_path('app/public/' . $barang->foto_path) : null,
        ];
        
        // Coba beberapa path alternatif
        $alternatives = [
            'barang/' . $barang->foto,
            'uploads/barang/' . $barang->foto,
            'images/barang/' . $barang->foto,
        ];
        
        foreach ($alternatives as $alt) {
            $data['alternative_' . $alt] = Storage::disk('public')->exists($alt);
        }
        
        return response()->json($data);
    }

    /**
     * FIX: Perbaiki path gambar yang sudah ada
     */
    public function fixImages()
    {
        $barangs = Barang::all();
        $fixed = 0;
        
        foreach ($barangs as $barang) {
            // Jika foto ada tapi foto_path kosong
            if ($barang->foto && !$barang->foto_path) {
                // Cari file di storage
                $possiblePaths = [
                    'barang/' . $barang->foto,
                    'uploads/barang/' . $barang->foto,
                    'barang/' . date('Y', strtotime($barang->created_at)) . '/' . date('m', strtotime($barang->created_at)) . '/' . $barang->foto,
                ];
                
                foreach ($possiblePaths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        $barang->foto_path = $path;
                        $barang->save();
                        $fixed++;
                        \Log::info("Fixed barang {$barang->id}: {$path}");
                        break;
                    }
                }
            }
        }
        
        return "Fixed {$fixed} barang records";
    }
}