<?php

namespace App\Console\Commands;

use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateBarangStatus extends Command
{
    protected $signature = 'barang:update-status';
    protected $description = 'Update status barang yang sudah melewati waktu lelang';

    public function handle()
    {
        $barangs = Barang::where('status', 'aktif')
            ->where('waktu_selesai', '<', Carbon::now())
            ->get();

        foreach ($barangs as $barang) {
            if ($barang->bids()->count() > 0) {
                $barang->status = 'selesai';
            } else {
                $barang->status = 'tidak_laku';
            }
            $barang->save();
            
            $this->info("Updated: {$barang->nama_barang} -> {$barang->status}");
        }

        $this->info("Total updated: " . $barangs->count());
        return 0;
    }
}