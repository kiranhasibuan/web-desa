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
        Schema::create('struktur_pemerintahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_desa_id')->constrained('profil_desa')->onDelete('cascade');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('nip')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_pemerintahan');
    }
};
