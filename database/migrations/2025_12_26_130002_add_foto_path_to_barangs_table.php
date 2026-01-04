<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Tambah kolom foto_path jika belum ada
            if (!Schema::hasColumn('barangs', 'foto_path')) {
                $table->string('foto_path')->nullable()->after('foto');
            }
            
            // Tambah kolom kategori jika belum ada
            if (!Schema::hasColumn('barangs', 'kategori')) {
                $table->string('kategori')->after('deskripsi');
            }
            
            // Tambah kolom kondisi jika belum ada
            if (!Schema::hasColumn('barangs', 'kondisi')) {
                $table->string('kondisi')->after('kategori');
            }
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn(['foto_path', 'kategori', 'kondisi']);
        });
    }
};