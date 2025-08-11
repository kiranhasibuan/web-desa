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
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa'); //Desa Karangguli
            $table->string('nama_kecamatan'); //Kecamatan Pulau-Pulau Aru
            $table->string('nama_kabupaten'); //Kabupaten Kepulauan Aru 
            $table->string('nama_provinsi'); //Provinsi Maluku
            $table->string('kode_pos', 10)->nullable(); //97232
            $table->longText('tentang_desa');
            $table->longText('visi');
            $table->longText('misi');
            $table->decimal('luas_wilayah', 10, 2)->nullable();
            $table->decimal('persen_luas_kec', 3, 2)->nullable(); //Persentase Terhadap Luas Kecamatan
            $table->integer('jarak_kec')->nullable(); //Jarak ke Ibukota Kecamatan
            $table->integer('jarak_kab')->nullable(); //Jarak ke Ibukota Kabupaten
            $table->string('batas_utara')->nullable();
            $table->string('batas_selatan')->nullable();
            $table->string('batas_timur')->nullable();
            $table->string('batas_barat')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('koordinat_polygon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_desa');
    }
};
