<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturPemerintahan extends Model
{
    protected $table = 'struktur_pemerintahan';
    protected $fillable = [
        'profil_desa_id',
        'nama',
        'jabatan',
        'nip',
        'pendidikan_terakhir',
        'alamat',
        'no_telepon',
        'foto',
        'status_aktif'
    ];

    public function profilDesa()
    {
        return $this->belongsTo(ProfilDesa::class);
    }
}
