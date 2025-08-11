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
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->longText('user_agent')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('platform')->nullable();
            $table->string('device')->nullable();
            $table->string('device_type')->nullable();
            $table->boolean('is_mobile')->default(false)->nullable();
            $table->boolean('is_tablet')->default(false)->nullable();
            $table->boolean('is_desktop')->default(false)->nullable();
            $table->boolean('is_robot')->default(false)->nullable();
            $table->string('halaman_dikunjungi');
            $table->string('referrer')->nullable();
            $table->string('negara')->nullable();
            $table->string('kota')->nullable();
            $table->json('data_lokasi')->nullable();
            $table->timestamp('waktu_kunjungan');
            $table->integer('durasi')->nullable();
            $table->timestamps();

            $table->index('ip_address');
            $table->index('waktu_kunjungan');
            $table->index('halaman_dikunjungi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengunjung');
    }
};
