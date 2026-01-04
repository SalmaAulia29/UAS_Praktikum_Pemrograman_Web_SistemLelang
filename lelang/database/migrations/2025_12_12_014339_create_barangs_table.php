<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_barang');
            $table->text('deskripsi');
            
            // TAMBAHAN YANG PERLU
            $table->string('kategori');  // elektronik, kendaraan, dll
            $table->string('kondisi');   // baru, bekas, baik, cukup
            
            $table->string('foto');           // nama file: foto123.jpg
            $table->string('foto_path')->nullable(); // path: barang/2024/12/foto123.jpg
            
            $table->decimal('harga_awal', 15, 2);
            $table->timestamp('waktu_mulai')->useCurrent();
            $table->timestamp('waktu_selesai');
            $table->enum('status', ['aktif', 'selesai', 'tidak_laku'])->default('aktif');
            
            // Stats cepat
            $table->integer('jumlah_bid')->default(0);
            $table->integer('jumlah_penawar')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};