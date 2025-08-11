<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wisata_budaya', function (Blueprint $table) {
            $table->id();
            $table->string('nama_wisata');
            $table->longText('deskripsi');
            $table->enum('kategori', ['wisata_alam', 'wisata_budaya', 'wisata_sejarah', 'wisata_kuliner']);
            $table->text('lokasi');
            $table->string('jam_operasional')->nullable();
            $table->decimal('harga_tiket', 10, 2)->nullable();
            $table->string('kontak_person')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisata_budaya');
    }
};
