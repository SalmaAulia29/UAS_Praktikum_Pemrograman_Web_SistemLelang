<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalBarangAktif = Barang::where('status', 'aktif')->count();
        $totalBarangSelesai = Barang::where('status', 'selesai')->count();
        $totalBarangTidakLaku = Barang::where('status', 'tidak_laku')->count();
        $totalBids = Bid::count();
        
        // Revenue potensial (total dari semua bid tertinggi barang yang selesai)
        $revenue = Barang::where('status', 'selesai')
            ->with('highestBid')
            ->get()
            ->sum(function($barang) {
                return $barang->highestBid ? $barang->highestBid->harga_bid : 0;
            });

        // Barang terbaru
        $latestBarangs = Barang::with(['user', 'bids'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // User teraktif (paling banyak bid)
        $activeUsers = User::where('role', 'user')
            ->withCount('bids')
            ->orderBy('bids_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalBarangAktif',
            'totalBarangSelesai',
            'totalBarangTidakLaku',
            'totalBids',
            'revenue',
            'latestBarangs',
            'activeUsers'
        ));
    }

    // Manajemen User
    public function users(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');
        
        $users = User::query()
            ->when($search, function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($role, function($query, $role) {
                $query->where('role', $role);
            })
            ->withCount(['barangs', 'bids'])
            ->withCount(['barangs', 'bids']);

        // Sorting Logic
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'name_asc':
                $users->orderBy('name', 'asc');
                break;
            case 'items_count':
                $users->orderBy('barangs_count', 'desc');
                break;
            case 'newest':
            default:
                $users->orderBy('created_at', 'desc');
                break;
        }

        $users = $users->paginate(20);

        // Statistik
        $totalUsers = User::count();
        $regularUsers = User::where('role', 'user')->count();
        $adminUsers = User::where('role', 'admin')->count();
        $totalBarangs = Barang::count();
        $totalBids = Bid::count();

        return view('admin.users', compact(
            'users', 
            'search',
            'role',
            'totalUsers',
            'regularUsers',
            'adminUsers',
            'totalBarangs',
            'totalBids'
        ));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Tidak bisa hapus admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak bisa menghapus user admin!');
        }

        // Hapus semua foto barang user
        foreach ($user->barangs as $barang) {
            Storage::disk('public')->delete($barang->foto);
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }

    public function toggleRole($id)
    {
        $user = User::findOrFail($id);

        // Tidak bisa ubah role sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role sendiri!');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return back()->with('success', "Role user berhasil diubah menjadi {$user->role}!");
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:15',
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Data user berhasil diperbarui!');
    }

    // Manajemen Barang
    public function barangs(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $kategori = $request->get('kategori');

        $barangs = Barang::with(['user', 'bids'])
            ->when($search, function($query, $search) {
                $query->where('nama_barang', 'like', "%{$search}%");
            })
            ->when($status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($kategori, function($query, $kategori) {
                $query->where('kategori', $kategori);
            })
            ->withCount('bids');

        // Sorting Logic
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'highest_price':
                $barangs->orderBy('harga_awal', 'desc');
                break;
            case 'most_bids':
                $barangs->orderBy('bids_count', 'desc');
                break;
            case 'newest':
            default:
                $barangs->orderBy('created_at', 'desc');
                break;
        }

        $barangs = $barangs->paginate(20);

        // Statistik
        $totalBarangs = Barang::count();
        $activeBarangs = Barang::where('status', 'aktif')->count();
        $soldBarangs = Barang::where('status', 'selesai')->count();
        $unsoldBarangs = Barang::where('status', 'tidak_laku')->count();
        $completedBarangs = Barang::whereIn('status', ['selesai', 'tidak_laku'])->count();

        return view('admin.barangs', compact(
            'barangs', 
            'search', 
            'status',
            'totalBarangs',
            'activeBarangs',
            'soldBarangs',
            'unsoldBarangs',
            'completedBarangs'
        ));
    }

    public function deleteBarang($id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus semua bid terkait terlebih dahulu
        $barang->bids()->delete();

        // Gunakan helper dari model untuk menghapus foto dengan benar
        $barang->deleteFoto(false);
        
        // Hapus data barang
        $barang->delete();

        return back()->with('success', 'Barang berhasil dihapus!');
    }

    public function updateStatusBarang(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'status' => 'required|in:aktif,selesai,tidak_laku',
        ]);

        $barang->status = $request->status;
        $barang->save();

        return back()->with('success', 'Status barang berhasil diubah!');
    }

    // Manajemen Bid
    public function bids(Request $request)
    {
        $search = $request->get('search');

        $bids = Bid::with(['user', 'barang.user'])
            ->when($search, function($query, $search) {
                $query->whereHas('barang', function($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.bids', compact('bids', 'search'));
    }

    public function deleteBid($id)
    {
        $bid = Bid::findOrFail($id);
        $bid->delete();

        return back()->with('success', 'Bid berhasil dihapus!');
    }

    // Laporan
    public function reports(Request $request)
    {
        // Filter Barang
        $status = $request->get('status');
        
        // Barang terlaris (paling banyak bid)
        $topBarangs = Barang::withCount('bids')
            ->when($status, function($query, $status) {
                 if($status != 'Semua Status') {
                    $query->where('status', strtolower($status));
                 }
            })
            ->with('user')
            ->orderBy('bids_count', 'desc')
            ->take(10)
            ->get();

        // User paling aktif bid
        $topBidders = User::where('role', 'user')
            ->withCount('bids')
            ->orderBy('bids_count', 'desc')
            ->take(10)
            ->get();

        // User paling banyak jual
        $topSellers = User::where('role', 'user')
            ->withCount('barangs')
            ->orderBy('barangs_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports', compact('topBarangs', 'topBidders', 'topSellers'));
    }

    // ================ FITUR DOWNLOAD LAPORAN ================

    /**
     * Download PDF Laporan
     */
    /**
     * Download All Reports in One PDF
     */
    public function downloadAll()
    {
        try {
            $topBarangs = Barang::withCount('bids')
                ->with('user')
                ->orderBy('bids_count', 'desc')
                ->take(10)
                ->get();
                
            $topBidders = User::where('role', 'user')
                ->withCount('bids')
                ->withMax('bids', 'created_at')
                ->orderBy('bids_count', 'desc')
                ->take(10)
                ->get();
                
            $topSellers = User::where('role', 'user')
                ->withCount('barangs')
                ->orderBy('barangs_count', 'desc')
                ->take(10)
                ->get();
            
            $pdf = Pdf::loadView('admin.exports.pdf', [
                'title' => 'Laporan Lengkap Sistem Lelang',
                'type' => 'all',
                'data' => [], // Unused for 'all' but keeping structure
                'barangs' => $topBarangs,
                'bidders' => $topBidders,
                'sellers' => $topSellers,
                'date' => now()->format('d F Y'),
                'period' => 'Januari - Desember ' . now()->format('Y')
            ]);
            
            return $pdf->download('Laporan-Lengkap-' . now()->format('Ymd') . '.pdf');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Download PDF Laporan (Updated for compatibility)
     */
    public function downloadPDF($type)
    {
        try {
            $title = '';
            $data = [];
            $barangs = [];
            $bidders = [];
            $sellers = [];
            
            switch ($type) {
                case 'barang':
                    $title = 'Laporan Top 10 Barang Terlaris';
                    $barangs = Barang::withCount('bids')
                        ->with('user')
                        ->orderBy('bids_count', 'desc')
                        ->take(10)
                        ->get();
                    $data = $barangs; // For backward compatibility if needed within view logic loop
                    break;
                    
                case 'bidder':
                    $title = 'Laporan Top 10 Bidder Teraktif';
                    $bidders = User::where('role', 'user')
                        ->withCount('bids')
                        ->withMax('bids', 'created_at')
                        ->orderBy('bids_count', 'desc')
                        ->take(10)
                        ->get();
                    $data = $bidders;
                    break;
                    
                case 'seller':
                    $title = 'Laporan Top 10 Seller Terbanyak';
                    $sellers = User::where('role', 'user')
                        ->withCount('barangs')
                        ->orderBy('barangs_count', 'desc')
                        ->take(10)
                        ->get();
                    $data = $sellers;
                    break;
                    
                default:
                    return back()->with('error', 'Tipe laporan tidak valid');
            }
            
            // Generate PDF
            $pdf = Pdf::loadView('admin.exports.pdf', [
                'title' => $title,
                'type' => $type,
                'data' => $data,
                'barangs' => $barangs,
                'bidders' => $bidders,
                'sellers' => $sellers,
                'date' => now()->format('d F Y'),
                'period' => 'Januari - Desember ' . now()->format('Y')
            ]);
            
            $filename = str_replace(' ', '-', $title) . '-' . now()->format('Ymd') . '.pdf';
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Download CSV Laporan
     */
    public function downloadCSV($type)
    {
        try {
            $filename = '';
            $data = [];
            $headers = [];
            
            switch ($type) {
                case 'barang':
                    $filename = 'Top-Barang-Terlaris-' . now()->format('Ymd') . '.csv';
                    $headers = [
                        'Rank',
                        'Nama Barang',
                        'Penjual',
                        'Harga Awal',
                        'Total Bid',
                        'Status',
                        'Kategori',
                        'Tanggal Dibuat',
                        'Tanggal Berakhir'
                    ];
                    
                    $data = Barang::withCount('bids')
                        ->with('user')
                        ->orderBy('bids_count', 'desc')
                        ->take(10)
                        ->get()
                        ->map(function($item, $index) {
                            return [
                                $index + 1,
                                $item->nama_barang,
                                $item->user->name,
                                'Rp ' . number_format($item->harga_awal, 0, ',', '.'),
                                $item->bids_count,
                                ucfirst($item->status),
                                $item->kategori ?? '-',
                                $item->created_at->format('d/m/Y'),
                                $item->waktu_selesai->format('d/m/Y')
                            ];
                        });
                    break;
                    
                case 'bidder':
                    $filename = 'Top-Bidder-Teraktif-' . now()->format('Ymd') . '.csv';
                    $headers = [
                        'Rank',
                        'Nama',
                        'Email',
                        'Total Bid',
                        'Tanggal Bergabung',
                        'Role'
                    ];
                    
                    $data = User::where('role', 'user')
                        ->withCount('bids')
                        ->orderBy('bids_count', 'desc')
                        ->take(10)
                        ->get()
                        ->map(function($item, $index) {
                            return [
                                $index + 1,
                                $item->name,
                                $item->email,
                                $item->bids_count,
                                $item->created_at->format('d/m/Y'),
                                $item->role
                            ];
                        });
                    break;
                    
                case 'seller':
                    $filename = 'Top-Seller-Terbanyak-' . now()->format('Ymd') . '.csv';
                    $headers = [
                        'Rank',
                        'Nama',
                        'Email',
                        'Total Barang',
                        'Tanggal Bergabung',
                        'Role'
                    ];
                    
                    $data = User::where('role', 'user')
                        ->withCount('barangs')
                        ->orderBy('barangs_count', 'desc')
                        ->take(10)
                        ->get()
                        ->map(function($item, $index) {
                            return [
                                $index + 1,
                                $item->name,
                                $item->email,
                                $item->barangs_count,
                                $item->created_at->format('d/m/Y'),
                                $item->role
                            ];
                        });
                    break;
                    
                default:
                    return back()->with('error', 'Tipe laporan tidak valid');
            }
            
            // Generate CSV
            $callback = function() use ($headers, $data) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $headers);
                
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
                
                fclose($file);
            };
            
            return Response::stream($callback, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate CSV: ' . $e->getMessage());
        }
    }

    /**
     * Download Excel Laporan
     * Note: Butuh package maatwebsite/excel
     * Instalasi: composer require maatwebsite/excel
     */
    public function downloadExcel($type)
    {
        try {
            $filename = '';
            $data = [];
            $headers = [];
            
            // Sama seperti CSV karena butuh package khusus untuk Excel
            // Sementara redirect ke CSV
            return $this->downloadCSV($type);
            
            // Jika sudah install package maatwebsite/excel:
            /*
            switch ($type) {
                case 'barang':
                    return Excel::download(new BarangExport(), 'Top-Barang-Terlaris-' . now()->format('Ymd') . '.xlsx');
                    
                case 'bidder':
                    return Excel::download(new BidderExport(), 'Top-Bidder-Teraktif-' . now()->format('Ymd') . '.xlsx');
                    
                case 'seller':
                    return Excel::download(new SellerExport(), 'Top-Seller-Terbanyak-' . now()->format('Ymd') . '.xlsx');
                    
                default:
                    return back()->with('error', 'Tipe laporan tidak valid');
            }
            */
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export Excel: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk generate CSV
     */
    private function generateCSV($data, $type)
    {
        $output = fopen('php://temp', 'w');
        
        switch ($type) {
            case 'barang':
                fputcsv($output, ['Rank', 'Nama Barang', 'Penjual', 'Harga Awal', 'Total Bid', 'Status', 'Kategori']);
                foreach ($data as $index => $item) {
                    fputcsv($output, [
                        $index + 1,
                        $item->nama_barang,
                        $item->user->name,
                        'Rp ' . number_format($item->harga_awal, 0, ',', '.'),
                        $item->bids_count,
                        ucfirst($item->status),
                        $item->kategori ?? '-'
                    ]);
                }
                break;
                
            case 'bidder':
                fputcsv($output, ['Rank', 'Nama', 'Email', 'Total Bid', 'Tanggal Bergabung']);
                foreach ($data as $index => $item) {
                    fputcsv($output, [
                        $index + 1,
                        $item->name,
                        $item->email,
                        $item->bids_count,
                        $item->created_at->format('d/m/Y')
                    ]);
                }
                break;
                
            case 'seller':
                fputcsv($output, ['Rank', 'Nama', 'Email', 'Total Barang', 'Tanggal Bergabung']);
                foreach ($data as $index => $item) {
                    fputcsv($output, [
                        $index + 1,
                        $item->name,
                        $item->email,
                        $item->barangs_count,
                        $item->created_at->format('d/m/Y')
                    ]);
                }
                break;
        }
        
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        
        return $csv;
    }
}