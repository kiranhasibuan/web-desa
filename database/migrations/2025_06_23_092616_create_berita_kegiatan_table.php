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
        Schema::create('berita_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');
            $table->enum('kategori', ['berita', 'kegiatan', 'pengumuman']);
            $table->string('penulis');
            $table->timestamp('tanggal_publikasi');
            $table->enum('status_publikasi', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('jumlah_views')->default(0);
            $table->timestamps();

            $table->index(['status_publikasi', 'tanggal_publikasi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_kegiatan');
    }
};
