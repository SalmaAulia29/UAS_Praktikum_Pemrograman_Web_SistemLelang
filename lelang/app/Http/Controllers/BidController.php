<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bid;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BidController extends Controller
{
   // app/Http/Controllers/BidController.php
    public function store(Request $request)
    {
        // Validasi sederhana
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'harga_bid' => 'required|numeric|min:1000'
        ]);
        
        $barang = Barang::find($request->barang_id);
        
        // Cek minimal bid
        $minBid = ($barang->highestBid?->harga_bid ?? $barang->harga_awal) + 5000;
        
        if ($request->harga_bid < $minBid) {
            return back()->withErrors(['harga_bid' => 'Bid minimal adalah Rp ' . number_format($minBid, 0, ',', '.')]);
        }
        
        // Cek apakah barang milik sendiri
        if ($barang->user_id == auth()->id()) {
            return back()->withErrors(['error' => 'Tidak bisa bid barang sendiri']);
        }
        
        // Cek apakah lelang masih aktif
        if ($barang->status !== 'aktif') {
            return back()->withErrors(['error' => 'Lelang sudah berakhir']);
        }
        
        // Simpan bid
        Bid::create([
            'user_id' => auth()->id(),
            'barang_id' => $request->barang_id,
            'harga_bid' => $request->harga_bid,
            'status' => 'pending'
        ]);
        
        return redirect()->back()->with('success', 'Bid berhasil diajukan!');
    }

    public function myBids(Request $request)
    {
        $search = $request->get('search');

        $query = Bid::with(['barang.user', 'barang.highestBid'])
            ->where('user_id', auth()->id());

        if ($search) {
            $query->whereHas('barang', function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%');
            });
        }

        $bids = $query->orderBy('created_at', 'desc')
            ->get();

        foreach ($bids as $bid) {
            $bid->barang->updateStatus();
        }

        return view('bid.mybids', compact('bids', 'search'));
    }
}