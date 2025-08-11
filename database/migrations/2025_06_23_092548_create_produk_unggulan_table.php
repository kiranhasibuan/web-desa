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
        Schema::create('produk_unggulan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->longText('deskripsi');
            $table->enum('kategori', ['pertanian', 'peternakan', 'kerajinan', 'makanan', 'lainnya']);
            $table->decimal('harga_min', 12, 2)->nullable();
            $table->decimal('harga_max', 12, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->string('produsen');
            $table->string('kontak_produsen')->nullable();
            $table->boolean('status_tersedia')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_unggulan');
    }
};
