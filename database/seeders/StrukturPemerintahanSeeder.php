<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrukturPemerintahanSeeder extends Seeder
{
    public function run()
    {
        DB::table('struktur_pemerintahan')->insert([
            'profil_desa_id' => 1, // Mengacu pada ID profil_desa
            'nama' => 'Budi Santoso',
            'jabatan' => 'Kepala Desa',
            'nip' => '123456789',
            'pendidikan_terakhir' => 'S1',
            'alamat' => 'Jl. Merdeka No.1',
            'no_telepon' => '08123456789',
            'foto' => 'budi_santoso.jpg',
            'status_aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
